<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class ApiAdminV1Controller extends Controller
{
    public function orderQuery(): Builder
    {
        return Order::with(['user', 'service'])->where('domain', getDomain());
    }

    public function formatOrder(Order $o): array
    {
        $data = [
            'id'       => $o->id,
            'link'     => $o->link,
            'quantity' => $o->quantity,
            'status'   => orderStatusToDisplay($o->status),
            'rate'     => $o->service ? getUserServiceRate($o->user, $o->service) : 0,
        ];

        // Chỉ thêm comment nếu có giá trị
        if (!empty($o->comment)) {
            $decoded = json_decode($o->comment, true);
            $data['comment'] = $decoded ?? $o->comment;
        }

        return $data;
    }

    public function handleAction(Request $request): JsonResponse
    {
        $key = $request->input('key', $request->input('api_key'));
        $user = $key ? User::where([
            'api_key' => $key,
            'role' => User::ROLE_ADMIN,
            'domain' => getDomain(),
        ])->first() : null;
        if (!$user) {
            return response()->json(['error' => 'Incorrect request']);
        }

        $request->merge(['key' => $key, 'api_key' => $key]);
        $request->attributes->set('api_user', $user);
        $request->setUserResolver(fn () => $user);

        return match ($request->input('action')) {
            'getOrder' => $this->getOrder($request),
            'getOrders' => $this->getOrders($request),
            'updateOrders' => $this->updateOrders($request),
            'setStatus' => $this->setStatus($request),
            'setStartCount' => $this->setStartCount($request),
            'setRemains' => $this->setRemains($request),
            'addFund' => $this->addFund($request),
            default         => response()->json(['error' => 'Incorrect request']),
        };
    }

    public function getOrder(Request $request): JsonResponse
    {
        try {
            $query = $this->orderQuery()->where('status', orderStatusToDatabase($request->input('status', 'pending')));
            if ($request->filled('type')) $query->where('service_id', (int) $request->type);

            $order = $query->oldest()->first();
            if (!$order) return response()->json(['error' => 'No order found']);

            return response()->json($this->formatOrder($order));
        } catch (Exception $e) {
            Log::error('AdminAPI getOrder: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request']);
        }
    }

    public function getOrders(Request $request): JsonResponse
    {
        try {
            $query = $this->orderQuery()->where('status', orderStatusToDatabase($request->input('status', 'pending')));
            if ($request->filled('type')) $query->where('service_id', (int) $request->type);

            $orders = $query->oldest()->limit(100)->get()->map(fn($o) => $this->formatOrder($o));
            return response()->json($orders);
        } catch (Exception $e) {
            Log::error('AdminAPI getOrders: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request']);
        }
    }

    public function updateOrders(Request $request): JsonResponse
    {
        try {
            $items = json_decode($request->input('orders', '[]'), true);
            if (!is_array($items) || empty($items)) {
                return response()->json(['error' => 'Invalid orders data']);
            }

            $results = [];
            foreach ($items as $item) {
                $id = $item['id'] ?? null;
                if (!$id) continue;

                $order = $this->orderQuery()->where('id', $id)->first();
                if (!$order) {
                    $results[(string) $id] = ['error' => 'Invalid order id'];
                    continue;
                }

                $update = [];
                if (isset($item['status'])) {
                    $dbStatus         = orderStatusToDatabase($item['status']);
                    $update['status'] = $dbStatus;
                    if ($dbStatus === 'completed') $update['remains'] = 0;
                }
                if (isset($item['start_count'])) $update['start_count'] = (int) $item['start_count'];
                if (isset($item['remains']))      $update['remains']     = (int) $item['remains'];

                $order->update($update);
                $results[(string) $id] = ['status' => $item['status'] ?? orderStatusToDisplay($order->status)];
            }

            return response()->json($results);
        } catch (Exception $e) {
            Log::error('AdminAPI updateOrders: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request']);
        }
    }

    public function setStatus(Request $request): JsonResponse
    {
        try {
            if (!$request->filled('id') || !$request->filled('status')) {
                return response()->json(['error' => 'Incorrect request']);
            }

            $order = $this->orderQuery()->where('id', $request->id)->first();
            if (!$order) return response()->json(['error' => 'Order not found']);

            $dbStatus = orderStatusToDatabase($request->status);
            $update   = ['status' => $dbStatus];
            if ($dbStatus === 'completed') $update['remains'] = 0;
            if ($dbStatus === 'partial' && $request->filled('remains')) $update['remains'] = (int) $request->remains;

            $order->update($update);
            return response()->json(['success' => $order->id]);
        } catch (Exception $e) {
            Log::error('AdminAPI setStatus: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request']);
        }
    }

    public function setStartCount(Request $request): JsonResponse
    {
        try {
            if (!$request->filled('id') || !$request->has('start_count')) {
                return response()->json(['error' => 'Incorrect request']);
            }

            $order = $this->orderQuery()->where('id', $request->id)->first();
            if (!$order) return response()->json(['error' => 'Order not found']);

            $order->update(['start_count' => (int) $request->start_count]);
            return response()->json(['success' => $order->id]);
        } catch (Exception $e) {
            Log::error('AdminAPI setStartCount: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request']);
        }
    }

    public function setRemains(Request $request): JsonResponse
    {
        try {
            if (!$request->filled('id') || !$request->has('remains')) {
                return response()->json(['error' => 'Incorrect request']);
            }

            $order = $this->orderQuery()->where('id', $request->id)->first();
            if (!$order) return response()->json(['error' => 'Order not found']);

            $order->update(['remains' => (int) $request->remains]);
            return response()->json(['success' => $order->id]);
        } catch (Exception $e) {
            Log::error('AdminAPI setRemains: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request']);
        }
    }

    public function addFund(Request $request): JsonResponse
    {
        try {
            if (!$request->filled('amount') || !$request->filled('user')) {
                return response()->json(['error' => 'Incorrect request']);
            }

            $user = User::where('username', $request->user)
                ->where('domain', getDomain())
                ->first();
            if (!$user) return response()->json(['error' => 'User not found']);

            $amount = (float) $request->amount;
            if ($amount <= 0) return response()->json(['error' => 'Invalid amount']);

            if ($request->filled('details')) {
                $exists = Payment::where('note', $request->details)
                    ->where('domain', getDomain())
                    ->exists();
                if ($exists) return response()->json(['error' => 'Duplicate transaction']);
            }

            Payment::create([
                'user_id'           => $user->id,
                'payment_method_id' => $request->filled('pm_id') ? (int) $request->pm_id : null,
                'transaction_id'    => 'ADMIN-' . Str::random(16),
                'amount'            => $amount,
                'bonus_amount'      => 0,
                'total_amount'      => $amount,
                'currency'          => 'USD',
                'exchange_rate'     => 1,
                'status'            => 'completed',
                'note'              => $request->input('details', 'Admin addFund'),
                'domain'            => getDomain(),
            ]);

            $user->increment('balance', $amount);

            // Affiliate commission
            \App\Services\AffiliateService::handleDeposit($user->id, $amount, 'ADMIN-FUND-' . $user->id . '-' . time());

            return response()->json(['success' => 'Added']);
        } catch (Exception $e) {
            Log::error('AdminAPI addFund: ' . $e->getMessage());
            return response()->json(['error' => 'Incorrect request']);
        }
    }
}
