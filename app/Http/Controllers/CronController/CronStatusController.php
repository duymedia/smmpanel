<?php

namespace App\Http\Controllers\CronController;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ApiProvider;
use App\Models\Service;
use App\Smm\Smm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CronStatusController extends Controller
{
    public function updateOrdersStatus(Request $request)
    {
        $providerId = $request->query('provider');
        if (!$providerId) {
            return response()->json(['status' => 'error', 'message' => 'Provider ID is required'], 400);
        }

        $provider = ApiProvider::find($providerId);
        if (!$provider) {
            return response()->json(['status' => 'error', 'message' => 'Provider not found'], 404);
        }

        $orders = Order::where('provider_id', $providerId)
            ->whereNotIn('status', ['completed', 'canceled', 'failed', 'partial'])
            ->whereNotNull('orders_api')
            ->where('orders_api', '!=', '')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['status' => 'success', 'message' => 'No orders to update']);
        }

        $smm          = new Smm();
        $smm->api_url = $provider->link;
        $smm->api_key = $provider->api_key;

        $updated = $errors = 0;

        try {
            $response = $smm->multiStatus($orders->pluck('orders_api')->toArray());

            // Normalize response to array
            $responseData = is_object($response) ? json_decode(json_encode($response), true) : (is_array($response) ? $response : []);

            if (isset($responseData['error'])) {
                Log::error('Smm multiStatus error', ['provider_id' => $providerId, 'error' => $responseData['error']]);
                return response()->json(['status' => 'error', 'message' => $responseData['error']], 500);
            }

            foreach ($orders as $order) {
                $key = $order->orders_api;
                if (!isset($responseData[$key])) continue;

                try {
                    $data = is_array($responseData[$key]) ? $responseData[$key] : (array) $responseData[$key];
                    $raw  = $data['status'] ?? $order->status;

                    // Map status từ API sang giá trị DB
                    $statusMap = [
                        'pending'     => 'pending',
                        'processing'  => 'processing',
                        'in progress' => 'in_progress',
                        'inprogress'  => 'in_progress',
                        'in_progress' => 'in_progress',
                        'completed'   => 'completed',
                        'partial'     => 'partial',
                        'canceled'    => 'canceled',
                        'cancelled'   => 'canceled',
                        'failed'      => 'failed',
                    ];
                    $status = $statusMap[strtolower($raw)] ?? strtolower($raw);

                    $order->status      = $status;
                    $order->start_count = $data['start_count'] ?? $order->start_count;
                    $order->remains     = $data['remains']     ?? $order->remains;

                    // Hoàn balance — chỉ 1 lần khi chuyển sang partial/canceled
                    $prevStatus = $order->getOriginal('status');
                    $needRefund = in_array($status, ['partial', 'canceled'])
                        && !in_array($prevStatus, ['partial', 'canceled']);

                    if ($needRefund && $total = (float) ($order->total ?? 0)) {
                        $remains  = (int) ($data['remains'] ?? 0);
                        $quantity = (int) ($order->quantity ?? 0);

                        if ($status === 'canceled') {
                            // canceled => hoàn toàn bộ total
                            $refund = $total;
                        } else {
                            // partial => hoàn total * (remains / quantity)
                            // Ví dụ: total=0.21, quantity=100, remains=50 => refund=0.105
                            $refund = ($remains > 0 && $quantity > 0)
                                ? round($total * ($remains / $quantity), 8)
                                : 0;
                        }

                        if ($refund > 0 && $user = $order->user) {
                            $user->increment('balance', $refund);
                        }
                    }

                    $order->response_data = array_merge(
                        is_array($order->response_data) ? $order->response_data : [],
                        ['last_status_check' => now()->toDateTimeString(), 'status_response' => $data]
                    );
                    $order->save();
                    $updated++;

                } catch (\Exception $e) {
                    $errors++;
                    Log::error('Error updating order', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Status updated', 'updated' => $updated, 'errors' => $errors]);

        } catch (\Exception $e) {
            Log::error('Cron status update failed', ['provider_id' => $providerId, 'error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    
    public function statusLoopOrders(Request $request)
    {
        // Lấy tất cả orders là loop (dripfeed=true), còn vòng lặp chưa hoàn thành
        // và là order gốc (loop_parent_id = null)
        $loopOrders = Order::where('dripfeed', true)
            ->whereNotNull('loop_quantity')
            ->whereNotNull('loop_spacing')
            ->whereRaw('loop_current < loop_quantity')
            ->whereNull('loop_parent_id')
            ->whereNotIn('status', ['canceled', 'failed'])
            ->get();

        if ($loopOrders->isEmpty()) {
            return response()->json(['status' => 'success', 'message' => 'No loop orders to process', 'processed' => 0]);
        }

        $processed = 0;
        $skipped = 0;
        $errors = 0;
        $results = [];

        foreach ($loopOrders as $parentOrder) {
            try {
                $lastOrder = Order::where(function ($q) use ($parentOrder) {
                    $q->where('id', $parentOrder->id)->orWhere('loop_parent_id', $parentOrder->id);
                })->orderByDesc('id')->first();

                if (!$lastOrder->isCompleted()) {
                    $skipped++;
                    $results[] = ['parent_order_id' => $parentOrder->id, 'last_order_id' => $lastOrder->id, 'skipped_reason' => 'Last order not completed (status: ' . $lastOrder->status . ')'];
                    continue;
                }

                if (!$parentOrder->isLoopSpacingReached()) {
                    $skipped++;
                    $nextRun = $parentOrder->loop_last_run->addMinutes($parentOrder->loop_spacing);
                    $results[] = ['parent_order_id' => $parentOrder->id, 'skipped_reason' => 'Loop spacing not reached. Next run at: ' . $nextRun->toDateTimeString()];
                    continue;
                }

                $provider = ApiProvider::find($parentOrder->provider_id);
                if (!$provider || !$provider->status) {
                    $errors++;
                    $results[] = ['parent_order_id' => $parentOrder->id, 'error' => 'Provider not found or inactive'];
                    continue;
                }

                $service = Service::find($parentOrder->service_id);
                if (!$service) {
                    $errors++;
                    $results[] = ['parent_order_id' => $parentOrder->id, 'error' => 'Service not found'];
                    continue;
                }

                $smm = new Smm();
                $smm->api_url = $provider->link;
                $smm->api_key = $provider->api_key;

                $apiData = ['service' => $parentOrder->service_api];
                if ($parentOrder->reaction) $apiData['reaction'] = $parentOrder->reaction;

                $serviceType = $service->type_service ?? 'Default';
                $parentOrderData = is_array($parentOrder->order_data) ? $parentOrder->order_data : [];

                switch ($serviceType) {
                    case 'Custom Comments':
                        $apiData['link'] = $parentOrder->link;
                        if ($parentOrder->comment) $apiData['comments'] = str_replace(["\r\n", "\r"], "\n", $parentOrder->comment);
                        if ($parentOrder->quantity) $apiData['quantity'] = $parentOrder->quantity;
                        break;
                    case 'Package':
                        $apiData['link'] = $parentOrder->link;
                        break;
                    case 'Subscriptions':
                        $apiData['username'] = $parentOrderData['username'] ?? '';
                        $apiData['min']      = $parentOrderData['min'] ?? $service->min;
                        $apiData['max']      = $parentOrderData['max'] ?? $service->max;
                        $apiData['delay']    = $parentOrderData['delay'] ?? 0;
                        if (!empty($parentOrderData['posts']))     $apiData['posts']     = $parentOrderData['posts'];
                        if (!empty($parentOrderData['old_posts'])) $apiData['old_posts'] = $parentOrderData['old_posts'];
                        if (!empty($parentOrderData['expiry']))    $apiData['expiry']    = $parentOrderData['expiry'];
                        break;
                    default:
                        $apiData['link']     = $parentOrder->link;
                        $apiData['quantity'] = $parentOrder->quantity;
                        break;
                }

                $response = $smm->order($apiData);
                $apiError = is_object($response) && isset($response->error) ? $response->error
                    : (is_array($response) && isset($response['error']) ? $response['error'] : null);

                if ($apiError) {
                    $errors++;
                    Log::error('Loop order API error', ['parent_order_id' => $parentOrder->id, 'error' => $apiError]);
                    $results[] = ['parent_order_id' => $parentOrder->id, 'error' => $apiError];
                    continue;
                }

                $newLoopCurrent = $parentOrder->loop_current + 1;

                $newOrder = Order::create([
                    'user_id'        => $parentOrder->user_id,
                    'service_id'     => $parentOrder->service_id,
                    'link'           => $parentOrder->link,
                    'comment'        => $parentOrder->comment,
                    'quantity'       => $parentOrder->quantity,
                    'rate'           => $parentOrder->rate,
                    'charge'         => $parentOrder->charge,
                    'total'          => $parentOrder->total,
                    'start_count'    => 0,
                    'remains'        => $parentOrder->quantity,
                    'status'         => 'pending',
                    'currency'       => $parentOrder->currency,
                    'domain'         => $parentOrder->domain,
                    'type'           => $parentOrder->type,
                    'service_api'    => $parentOrder->service_api,
                    'provider_id'    => $parentOrder->provider_id,
                    'provider_name'  => $parentOrder->provider_name,
                    'refill'         => $parentOrder->refill,
                    'cancel'         => $parentOrder->cancel,
                    'dripfeed'       => false,
                    'reaction'       => $parentOrder->reaction,
                    'orders_api'     => $response->order ?? null,
                    'response_data'  => ['api_response' => (array)$response, 'created_at' => now()->toIso8601String()],
                    'order_data'     => $parentOrder->order_data,
                    'loop_parent_id' => $parentOrder->id,
                    'loop_current'   => $newLoopCurrent,
                ]);

                $parentOrder->loop_current  = $newLoopCurrent;
                $parentOrder->loop_last_run = now();
                $parentOrder->save();

                $processed++;
                $results[] = ['parent_order_id' => $parentOrder->id, 'new_order_id' => $newOrder->id, 'loop_current' => $newLoopCurrent, 'loop_quantity' => $parentOrder->loop_quantity, 'orders_api' => $newOrder->orders_api];

                Log::info('Loop order created', ['parent_order_id' => $parentOrder->id, 'new_order_id' => $newOrder->id, 'loop_current' => $newLoopCurrent]);

            } catch (\Exception $e) {
                $errors++;
                Log::error('Loop order processing failed', ['parent_order_id' => $parentOrder->id, 'error' => $e->getMessage()]);
                $results[] = ['parent_order_id' => $parentOrder->id, 'error' => $e->getMessage()];
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Loop orders processed', 'processed' => $processed, 'skipped' => $skipped, 'errors' => $errors, 'results' => $results]);
    }

    public function processScheduledOrders(Request $request)
    {
        // Lấy tất cả orders awaiting có schedule_time <= now
        $orders = Order::where('status', 'awaiting')
            ->whereNotNull('schedule_time')
            ->where('schedule_time', '<=', now())
            ->get();

        if ($orders->isEmpty()) {
            return response()->json(['status' => 'success', 'message' => 'No scheduled orders to process', 'processed' => 0]);
        }

        $processed = 0;
        $errors = 0;
        $results = [];

        foreach ($orders as $order) {
            try {
                $provider = ApiProvider::find($order->provider_id);

                // Không có provider hoặc provider inactive → chỉ set pending, không gọi API
                if (!$provider || !$provider->status) {
                    $order->status = 'pending';
                    $order->start_time = now();
                    $order->save();
                    $processed++;
                    $results[] = ['order_id' => $order->id, 'status' => 'pending', 'note' => 'No provider'];
                    continue;
                }

                $service = Service::find($order->service_id);
                $serviceType = $service->type_service ?? 'Default';
                $orderData = is_array($order->order_data) ? $order->order_data : [];

                $smm = new Smm();
                $smm->api_url = $provider->link;
                $smm->api_key = $provider->api_key;

                $apiData = ['service' => $order->service_api];
                if ($order->reaction) $apiData['reaction'] = $order->reaction;

                switch ($serviceType) {
                    case 'Custom Comments':
                        $apiData['link'] = $order->link;
                        if ($order->comment) $apiData['comments'] = str_replace(["\r\n", "\r"], "\n", $order->comment);
                        if ($order->quantity) $apiData['quantity'] = $order->quantity;
                        break;
                    case 'Package':
                        $apiData['link'] = $order->link;
                        break;
                    case 'Subscriptions':
                        $apiData['username'] = $orderData['username'] ?? '';
                        $apiData['min']      = $orderData['min'] ?? ($service->min ?? 0);
                        $apiData['max']      = $orderData['max'] ?? ($service->max ?? 0);
                        $apiData['delay']    = $orderData['delay'] ?? 0;
                        if (!empty($orderData['posts']))     $apiData['posts']     = $orderData['posts'];
                        if (!empty($orderData['old_posts'])) $apiData['old_posts'] = $orderData['old_posts'];
                        if (!empty($orderData['expiry']))    $apiData['expiry']    = $orderData['expiry'];
                        break;
                    default:
                        $apiData['link']     = $order->link;
                        $apiData['quantity'] = $order->quantity;
                        break;
                }

                $response = $smm->order($apiData);
                $apiError = is_object($response) && isset($response->error) ? $response->error
                    : (is_array($response) && isset($response['error']) ? $response['error'] : null);

                if ($apiError) {
                    $errors++;
                    Log::error('Scheduled order API error', ['order_id' => $order->id, 'error' => $apiError]);
                    $results[] = ['order_id' => $order->id, 'error' => $apiError];
                    continue;
                }

                $order->status     = 'pending';
                $order->start_time = now();
                $order->orders_api = $response->order ?? null;
                $order->response_data = array_merge(
                    is_array($order->response_data) ? $order->response_data : [],
                    ['scheduled_dispatch' => now()->toIso8601String(), 'api_response' => (array)$response]
                );
                $order->save();

                $processed++;
                $results[] = ['order_id' => $order->id, 'orders_api' => $order->orders_api, 'status' => 'pending'];

                Log::info('Scheduled order dispatched', ['order_id' => $order->id, 'orders_api' => $order->orders_api]);

            } catch (\Exception $e) {
                $errors++;
                Log::error('Scheduled order processing failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                $results[] = ['order_id' => $order->id, 'error' => $e->getMessage()];
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Scheduled orders processed', 'processed' => $processed, 'errors' => $errors, 'results' => $results]);
    }
}
