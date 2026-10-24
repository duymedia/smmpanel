<?php

namespace App\Http\Controllers\Crons;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Order;
use App\Models\ApiProvider;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\User;
use App\Smm\Smm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Jobs\UpdateOrdersStatusJob;

class CronStatusController extends Controller
{
    public function updateOrdersStatus(Request $request)
    {
        $providerId = (int) $request->query('provider');
        if (!$providerId) {
            return response()->json(['status' => 'error', 'message' => 'Provider ID is required'], 400);
        }

        if (!ApiProvider::whereKey($providerId)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Provider not found'], 404);
        }

        try {
            UpdateOrdersStatusJob::dispatch($providerId);
        } catch (\Throwable $e) {
            Log::error('Unable to dispatch order status job; running synchronously', [
                'provider_id' => $providerId,
                'error' => $e->getMessage(),
                'exception' => get_class($e),
            ]);

            UpdateOrdersStatusJob::dispatchSync($providerId);
        }

        return response()->json([
            'status' => 'queued',
            'provider' => $providerId,
        ]);
    }

    public function processOrdersStatus(Request $request)
    {
        $providerId = (int) $request->input('provider');
        if (!$providerId) {
            return response()->json(['status' => 'error', 'message' => 'Provider ID is required'], 400);
        }

        $provider = ApiProvider::whereKey($providerId)
            ->where('domain', getDomain())
            ->first();
        if (!$provider) {
            return response()->json(['status' => 'error', 'message' => 'Provider not found'], 404);
        }

        $orders = Order::where('provider_id', $providerId)
            ->whereNotIn('status', ['completed', 'canceled', 'failed'])
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

                    // Map status từ API sang giá trị DB (normalize các biến thể)
                    $statusMap = [
                        'pending'     => 'pending',
                        'processing'  => 'processing',
                        'in progress' => 'in progress',
                        'inprogress'  => 'in progress',
                        'in_progress' => 'in progress',
                        'completed'   => 'completed',
                        'partial'     => 'partial',
                        'canceled'    => 'canceled',
                        'cancelled'   => 'canceled',
                        'refunded'    => 'canceled',
                        'failed'      => 'failed',
                    ];
                    $status = $statusMap[strtolower(trim($raw))] ?? strtolower(trim($raw));

                    $prevStatus = $order->getOriginal('status');
                    $order->status      = $status;
                    if (in_array($status, ['partial', 'canceled'], true) && filled($order->cancel_status)) {
                        $order->cancel_status = 'completed';
                    }
                    $order->start_count = $data['start_count'] ?? $order->start_count;
                    $order->remains     = $data['remains']     ?? $order->remains;

                    // Khi chuyển sang completed, ghi nhận success_time = now()
                    if ($status === 'completed' && $prevStatus !== 'completed') {
                        $order->success_time = now();
                    }

                    // Hoàn balance — chỉ 1 lần khi chuyển sang partial/canceled
                    $needRefund = in_array($status, ['partial', 'canceled'])
                        && !in_array($prevStatus, ['partial', 'canceled']);

                    $total = (float) ($order->total ?? $order->charge ?? 0);
                    if ($needRefund && $total > 0) {
                        $refund = $total;
                        if ($status === 'partial') {
                            $quantity = (float) $order->quantity;
                            $remains = min(max(0.0, (float) ($data['remains'] ?? 0)), $quantity);
                            $refund = $quantity > 0 ? round($total * $remains / $quantity, 8) : 0.0;
                        }

                    if ($refund > 0 && $order->user_id) {
                        DB::transaction(function () use ($order, $refund, $status): void {
                            $user = User::whereKey($order->user_id)->lockForUpdate()->first();
                            if (!$user) return;

                            $user->increment('balance', $refund);
                            $user->refresh();
                            Transaction::create([
                                'user_id' => $user->id,
                                'order_id' => $order->id,
                                'amount' => $refund,
                                'type' => 'refund',
                                'status' => 'completed',
                                'payment_method' => null,
                                'transaction_id' => strtoupper($status) . '-REFUND-ORDER-' . $order->id . '-' . uniqid(),
                                'description' => ($status === 'partial' ? 'Partial' : 'Canceled') . ' refund for order #' . $order->id,
                                'balance_after' => $user->balance,
                                'domain' => getDomain(),
                            ]);
                        });
                    }

                    if ($status === 'partial' && $prevStatus !== 'partial') {
                        $order->charge = max(0, $total - $refund);
                    } elseif ($prevStatus === 'partial') {
                        $returned = max(0, $total - (float) $order->charge);
                        if ($returned > 0 && $order->user_id) {
                            DB::transaction(function () use ($order, $returned): void {
                                $user = User::whereKey($order->user_id)->lockForUpdate()->first();
                                if (!$user) return;

                                $user->decrement('balance', $returned);
                                $user->refresh();
                                Transaction::create([
                                    'user_id' => $user->id,
                                    'order_id' => $order->id,
                                    'amount' => -$returned,
                                    'type' => 'refund_reversal',
                                    'status' => 'completed',
                                    'payment_method' => null,
                                    'transaction_id' => 'REVERSE-REFUND-ORDER-' . $order->id . '-' . uniqid(),
                                    'description' => 'Reversal of partial refund for order #' . $order->id,
                                    'balance_after' => $user->balance,
                                    'domain' => getDomain(),
                                ]);
                            });
                        }
                        $order->charge = $total;
                        $order->remains = $order->quantity;
                        if ($status === 'canceled' && $total > 0 && $order->user_id && $prevStatus === 'partial') {
                            DB::transaction(function () use ($order, $total): void {
                                $user = User::whereKey($order->user_id)->lockForUpdate()->first();
                                if (!$user) return;

                                $user->increment('balance', $total);
                                $user->refresh();
                                Transaction::create([
                                    'user_id' => $user->id,
                                    'order_id' => $order->id,
                                    'amount' => $total,
                                    'type' => 'refund',
                                    'status' => 'completed',
                                    'payment_method' => null,
                                    'transaction_id' => 'REFUND-CANCELED-ORDER-' . $order->id . '-' . uniqid(),
                                    'description' => 'Canceled order refund #' . $order->id,
                                    'balance_after' => $user->balance,
                                    'domain' => getDomain(),
                                ]);
                            });
                            $order->charge = 0;
                        }
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
                        if ($parentOrder->quantity) $apiData['quantity'] = $this->providerQuantity($parentOrder->quantity, $service);
                        break;
                    case 'Package':
                        $apiData['link'] = $parentOrder->link;
                        break;
                    case 'Subscriptions':
                        $apiData['username'] = $parentOrderData['username'] ?? '';
                        $apiData['min']      = $this->providerQuantity($parentOrderData['min'] ?? $service->min, $service);
                        $apiData['max']      = $this->providerQuantity($parentOrderData['max'] ?? $service->max, $service);
                        $apiData['delay']    = $parentOrderData['delay'] ?? 0;
                        if (!empty($parentOrderData['posts']))     $apiData['posts']     = $parentOrderData['posts'];
                        if (!empty($parentOrderData['old_posts'])) $apiData['old_posts'] = $parentOrderData['old_posts'];
                        if (!empty($parentOrderData['expiry']))    $apiData['expiry']    = $parentOrderData['expiry'];
                        break;
                    default:
                        $apiData['link']     = $parentOrder->link;
                        $apiData['quantity'] = $this->providerQuantity($parentOrder->quantity, $service);
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
                    'domain'         => getDomain(),
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
                        if ($order->quantity) $apiData['quantity'] = $this->providerQuantity($order->quantity, $service);
                        break;
                    case 'Package':
                        $apiData['link'] = $order->link;
                        break;
                    case 'Subscriptions':
                        $apiData['username'] = $orderData['username'] ?? '';
                        $apiData['min']      = $this->providerQuantity($orderData['min'] ?? ($service->min ?? 0), $service);
                        $apiData['max']      = $this->providerQuantity($orderData['max'] ?? ($service->max ?? 0), $service);
                        $apiData['delay']    = $orderData['delay'] ?? 0;
                        if (!empty($orderData['posts']))     $apiData['posts']     = $orderData['posts'];
                        if (!empty($orderData['old_posts'])) $apiData['old_posts'] = $orderData['old_posts'];
                        if (!empty($orderData['expiry']))    $apiData['expiry']    = $orderData['expiry'];
                        break;
                    default:
                        $apiData['link']     = $order->link;
                        $apiData['quantity'] = $this->providerQuantity($order->quantity, $service);
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

    public function processStagedOrders(Request $request)
    {
        $stagingDir = storage_path('app/orders');
        if (!is_dir($stagingDir)) {
            return response()->json(['status' => 'success', 'message' => 'No staging directory', 'processed' => 0]);
        }

        $requestedOrderId = (int) $request->input('order_id', 0);
        $ignoreDelay = $request->boolean('ignore_delay');
        $files = glob($stagingDir . DIRECTORY_SEPARATOR . '*.json') ?: [];
        $eligible = array_values(array_filter($files, function ($file) use ($requestedOrderId, $ignoreDelay) {
            if ($requestedOrderId && basename($file) !== $requestedOrderId . '.json') return false;
            return $ignoreDelay || filemtime($file) <= time() - 3;
        }));
        usort($eligible, fn($a, $b) => filemtime($a) <=> filemtime($b));
        $batch = array_slice($eligible, 0, 10);

        $processed = 0;
        $failed    = 0;
        $results   = [];

        foreach ($batch as $file) {
            $lockPath = preg_replace('/\.json$/', '.processing', $file);
            if (!@rename($file, $lockPath)) {
                continue; // another worker grabbed it first
            }

            try {
                $staged  = json_decode(@file_get_contents($lockPath), true) ?: [];
                $orderId = $staged['order_id'] ?? null;
                $order   = $orderId ? Order::find($orderId) : null;

                if (!$order) {
                    Log::warning('Staged order invalid', ['file' => $lockPath, 'order_id' => $orderId]);
                    @unlink($lockPath);
                    continue;
                }

                $service  = Service::find($staged['service_id'] ?? $order->service_id);
                $provider = $service ? $service->provider : null;

                if (!$service || !$provider || !$provider->status) {
                    $order->update(['status' => 'pending']);
                    @unlink($lockPath);
                    $processed++;
                    $results[] = ['order_id' => $orderId, 'status' => 'pending', 'note' => 'No provider'];
                    continue;
                }

                $serviceType = $staged['service_type'] ?? ($service->type_service ?? 'Default');
                $detail = is_string($staged['order_data'] ?? null)
                    ? (json_decode($staged['order_data'], true) ?: [])
                    : ($staged['order_data'] ?? []);

                $apiData = ['service' => $service->service_api];
                if ($service->reaction) {
                    $apiData['reaction'] = $service->reaction;
                }
                switch ($serviceType) {
                    case 'Custom Comments':
                        $apiData['link'] = $detail['link'] ?? $order->link;
                        if (!empty($detail['comments'])) {
                            $apiData['comments'] = str_replace(["\r\n", "\r"], "\n", $detail['comments']);
                        }
                        if (!empty($detail['quantity'])) {
                            $apiData['quantity'] = $this->providerQuantity($detail['quantity'], $service);
                        }
                        break;

                    case 'Package':
                        $apiData['link'] = $detail['link'] ?? $order->link;
                        break;

                    case 'Subscriptions':
                        $apiData['username'] = $detail['username'] ?? '';
                        $apiData['min']      = $this->providerQuantity($detail['min'] ?? ($service->min ?? 0), $service);
                        $apiData['max']      = $this->providerQuantity($detail['max'] ?? ($service->max ?? 0), $service);
                        $apiData['delay']    = $detail['delay'] ?? 0;
                        if (!empty($detail['posts']))     $apiData['posts']     = $detail['posts'];
                        if (!empty($detail['old_posts'])) $apiData['old_posts'] = $detail['old_posts'];
                        if (!empty($detail['expiry'])) {
                            $apiData['expiry'] = strtotime($detail['expiry'])
                                ? date('d/m/Y', strtotime($detail['expiry']))
                                : $detail['expiry'];
                        }
                        break;

                    case 'Default':
                    default:
                        $apiData['link']     = $detail['link'] ?? $order->link;
                        $apiData['quantity'] = $this->providerQuantity($detail['quantity'] ?? $order->quantity, $service);
                        if (!empty($detail['dripfeed'])) {
                            if (!empty($detail['loop_quantity'])) $apiData['runs']     = $detail['loop_quantity'];
                            if (!empty($detail['loop_spacing']))  $apiData['interval'] = $detail['loop_spacing'];
                        }
                        break;
                }

                $smm = new Smm();
                $smm->api_url = $provider->link;
                $smm->api_key = $provider->api_key;
                $response = $smm->order($apiData);

                $apiError = null;
                if (is_object($response) && isset($response->error)) {
                    $apiError = $response->error;
                } elseif (is_array($response) && isset($response['error'])) {
                    $apiError = $response['error'];
                }

                $isErrorKept = $apiError ? $this->isStagedErrorInKeepOrders($apiError) : false;

                if (!$apiError) {
                    // Success: promote to pending with Smm data
                    $order->update([
                        'provider_id'   => $provider->id,
                        'provider_name' => $provider->name,
                        'response_data' => json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                        'orders_api'    => is_object($response) ? ($response->order ?? null) : ($response['order'] ?? null),
                        'status'        => 'pending',
                    ]);
                    $processed++;
                    $results[] = ['order_id' => $orderId, 'status' => 'pending', 'orders_api' => $order->orders_api];
                } elseif ($isErrorKept) {
                    // Keep on error: status=failed, balance stays deducted (admin handles manually)
                    $oda = is_string($order->order_data)
                        ? (json_decode($order->order_data, true) ?? [])
                        : ($order->order_data ?? []);
                    $oda['api_error']    = $apiError;
                    $oda['error_status'] = 'kept_error';
                    $oda['api_response'] = (array)$response;
                    $oda['failed_at']    = now()->toIso8601String();

                    $order->update([
                        'status'        => 'failed',
                        'provider_id'   => $provider->id,
                        'provider_name' => $provider->name,
                        'response_data' => json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                        'order_data'    => json_encode($oda, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                        'service_api'   => $service->service_api ?? null,
                    ]);
                    Log::warning('Staged order kept on error', ['order_id' => $orderId, 'error' => $apiError]);
                    $failed++;
                    $results[] = ['order_id' => $orderId, 'status' => 'failed', 'kept' => true, 'error' => $apiError];
                } else {
                    // No keep: cancel order + refund balance
                    $refund = (float) $order->charge;
                    $user   = User::find($order->user_id);
                    if ($user && $refund > 0) {
                        $user->increment('balance', $refund);

                        $balanceStr   = number_format((float)$user->fresh()->balance, 9, '.', '');
                        Transaction::create([
                            'user_id'        => $user->id,
                            'order_id'       => $order->id,
                            'amount'         => $refund,
                            'type'           => 'refund',
                            'status'         => 'completed',
                            'payment_method' => null,
                            'transaction_id' => 'REFUND-ORDER-' . $order->id,
                            'description'    => 'Refund for canceled Order #' . $order->id . ' — Smm error: ' . $apiError,
                            'balance_after'  => $balanceStr,
                            'domain'         => getDomain(),
                        ]);
                    }

                    $oda = is_string($order->order_data)
                        ? (json_decode($order->order_data, true) ?? [])
                        : ($order->order_data ?? []);
                    $oda['api_error']    = $apiError;
                    $oda['error_status'] = 'canceled';
                    $oda['api_response'] = (array)$response;
                    $oda['canceled_at']  = now()->toIso8601String();
                    $oda['refund']       = $refund;

                    $order->update([
                        'status'        => 'canceled',
                        'response_data' => json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                        'order_data'    => json_encode($oda, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                    ]);
                    Log::info('Staged order canceled + refunded', ['order_id' => $orderId, 'error' => $apiError, 'refund' => $refund]);
                    $failed++;
                    $results[] = ['order_id' => $orderId, 'status' => 'canceled', 'refund' => $refund, 'error' => $apiError];
                }

                @unlink($lockPath);
            } catch (\Throwable $e) {
                $failed++;
                Log::error('Staged order processing exception', ['file' => $lockPath, 'error' => $e->getMessage()]);
                // Leave .processing file behind for manual inspection
                $results[] = ['file' => basename($lockPath), 'error' => $e->getMessage()];
            }
        }

        return response()->json([
            'status'    => 'success',
            'eligible'  => count($eligible),
            'batch'     => count($batch),
            'processed' => $processed,
            'failed'    => $failed,
            'results'   => $results,
        ]);
    }

    public function updateAverageTime(Request $request)
    {
        // Lấy tất cả service_id có đơn completed với success_time
        $serviceIds = Order::where('status', 'completed')
            ->whereNotNull('success_time')
            ->distinct()
            ->pluck('service_id');

        if ($serviceIds->isEmpty()) {
            return response()->json(['status' => 'success', 'message' => 'No completed orders found', 'updated' => 0]);
        }

        $updated = 0;
        $errors = 0;
        $results = [];

        foreach ($serviceIds as $serviceId) {
            try {
                // Lấy 1000 đơn completed gần nhất của service này
                $orders = Order::where('service_id', $serviceId)
                    ->where('status', 'completed')
                    ->whereNotNull('success_time')
                    ->orderByDesc('id')
                    ->limit(1000)
                    ->get(['created_at', 'success_time']);

                if ($orders->isEmpty()) continue;

                // Tính trung bình thời gian hoàn thành: created_at -> success_time (tính bằng phút)
                $totalMinutes = 0;
                $validCount = 0;

                foreach ($orders as $order) {
                    $created = $order->created_at;
                    $completed = $order->success_time;

                    if ($completed->gt($created)) {
                        $totalMinutes += $created->diffInMinutes($completed);
                        $validCount++;
                    }
                }

                if ($validCount === 0) continue;

                $averageMinutes = (int) round($totalMinutes / $validCount);

                // Format thời gian trung bình thành chuỗi dễ đọc
                if ($averageMinutes < 60) {
                    $averageTime = $averageMinutes . ' minutes';
                } elseif ($averageMinutes < 1440) {
                    $hours = floor($averageMinutes / 60);
                    $mins = $averageMinutes % 60;
                    $averageTime = $hours . ' hours' . ($mins > 0 ? ' ' . $mins . ' minutes' : '');
                } else {
                    $days = floor($averageMinutes / 1440);
                    $remainingMins = $averageMinutes % 1440;
                    $hours = floor($remainingMins / 60);
                    $averageTime = $days . ' days' . ($hours > 0 ? ' ' . $hours . ' hours' : '');
                }

                // Update average_time cho service
                Service::where('id', $serviceId)->update(['average_time' => $averageTime]);

                $updated++;
                $results[] = [
                    'service_id' => $serviceId,
                    'orders_count' => $validCount,
                    'average_minutes' => $averageMinutes,
                    'average_time' => $averageTime,
                ];
            } catch (\Exception $e) {
                $errors++;
                Log::error('Error updating average time', [
                    'service_id' => $serviceId,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Average time updated',
            'updated' => $updated,
            'errors' => $errors,
            'results' => $results,
        ]);
    }

    private function isStagedErrorInKeepOrders($apiError): bool
    {
        $config = Config::where('domain', getDomain())->first();
        if (!$config || !$config->keep_orders_status) return false;
        $keepOrders = $config->getKeepOrders();
        if (empty($keepOrders)) return false;
        foreach ($keepOrders as $keepError) {
            if (stripos($apiError, $keepError) !== false) return true;
        }
        return false;
    }

    private function providerQuantity($quantity, ?Service $service): int
    {
        $quantity = max(1, (int) round((float) $quantity));
        $overflow = (int) ($service?->overflow ?? 0);

        return max(1, (int) round($quantity * (1 + $overflow / 100)));
    }
}
