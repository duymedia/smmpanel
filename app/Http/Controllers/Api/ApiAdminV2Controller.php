<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class ApiAdminV2Controller extends Controller
{
    public function formatOrder(Order $o): array
    {
        return [
            'id'          => $o->id,
            'status'      => orderStatusToDisplay($o->status),
            'link'        => $o->link,
            'quantity'    => (int) $o->quantity,
            'start_count' => (int) ($o->start_count ?? 0),
            'remains'     => (int) ($o->remains ?? 0),
            'service_id'  => $o->service_id,
            'user'        => $o->user?->username,
            'rate'        => $o->service ? getUserServiceRate($o->user, $o->service) : 0,
            'created_at'  => $o->created_at?->toIso8601String(),
        ];
    }

    // Orders
    public function pullOrders(Request $request): JsonResponse
    {
        try {
            $limit = min((int)($request->input('limit', 100)), 100);
            $sids  = $request->filled('service_ids') ? array_map('intval', explode(',', $request->service_ids)) : null;

            $q = Order::with(['user', 'service'])->where('domain', getDomain())->where('status', 'pending')->where('mode', 'manual')
                ->where('created_at', '>=', now()->subDays(90))->oldest()->limit($limit);
            if ($sids) $q->whereIn('service_id', $sids);

            $orders = $q->get();
            Order::whereIn('id', $orders->pluck('id'))->update(['status' => 'processing']);
            return response()->json($orders->map(fn($o) => $this->formatOrder($o)));
        } catch (Exception $e) {
            Log::error('AdminV2 pullOrders: ' . $e->getMessage());
            return response()->json(['error_message' => 'Incorrect request', 'error_code' => 400], 400);
        }
    }

    public function getOrders(Request $request): JsonResponse
    {
        try {
            $q = Order::with(['user', 'service'])->where('domain', getDomain());
            if ($request->filled('ids')) {
                $q->whereIn('id', array_map('intval', explode(',', $request->ids)));
            } else {
                $from = $request->filled('created_from') ? \Carbon\Carbon::createFromTimestamp($request->created_from) : now()->subDays(90);
                $to   = $request->filled('created_to')   ? \Carbon\Carbon::createFromTimestamp($request->created_to)   : now();
                $q->whereBetween('created_at', [$from, $to]);
            }
            if ($request->filled('order_status')) $q->where('status', orderStatusToDatabase($request->order_status));
            if ($request->filled('mode'))         $q->where('mode', $request->mode);
            if ($request->filled('service_ids'))  $q->whereIn('service_id', array_map('intval', explode(',', $request->service_ids)));
            if ($request->filled('user'))         $q->whereHas('user', fn($u) => $u->where('username', $request->user));
            if ($request->filled('link'))         $q->where('link', 'like', '%' . $request->link . '%');

            $q->orderBy('created_at', $request->input('sort') === 'date-asc' ? 'asc' : 'desc');
            $orders = $q->offset((int)$request->input('offset', 0))->limit(min((int)$request->input('limit', 100), 1000))->get();
            return response()->json($orders->map(fn($o) => $this->formatOrder($o)));
        } catch (Exception $e) {
            return response()->json(['error_message' => 'Incorrect request', 'error_code' => 400], 400);
        }
    }

    public function getOrder(Request $request, int $orderId): JsonResponse
    {
        $order = Order::with(['user', 'service'])->where('domain', getDomain())->find($orderId);
        if (!$order) return response()->json(['error_message' => 'Order not found', 'error_code' => 404], 404);
        return response()->json($this->formatOrder($order));
    }

    public function updateOrders(Request $request): JsonResponse
    {
        try {
            $items = $request->input('orders', []);
            if (!is_array($items) || empty($items)) return response()->json(['error_message' => 'Invalid orders data', 'error_code' => 400], 400);
            $results = [];
            foreach (array_slice($items, 0, 100) as $item) {
                $id = $item['id'] ?? null;
                if (!$id) continue;
                $order = Order::with(['user', 'service'])->where('domain', getDomain())->find($id);
                if (!$order) {
                    $results[(string)$id] = ['error_message' => 'Order not found', 'error_code' => 404];
                    continue;
                }
                $upd = [];
                if (isset($item['status'])) {
                    $db = orderStatusToDatabase($item['status']);
                    $upd['status'] = $db;
                    if ($db === 'completed') $upd['remains'] = 0;
                }
                if (isset($item['start_count']))  $upd['start_count'] = (int)$item['start_count'];
                if (isset($item['remains']))      $upd['remains']     = (int)$item['remains'];
                if (isset($item['cancel_reason'])) $upd['note']       = $item['cancel_reason'];
                $order->update($upd);
                $results[(string)$id] = ['status' => $item['status'] ?? orderStatusToDisplay($order->status)];
            }
            return response()->json($results);
        } catch (Exception $e) {
            return response()->json(['error_message' => 'Incorrect request', 'error_code' => 400], 400);
        }
    }

    public function editOrderLink(Request $request, int $orderId): JsonResponse
    {
        if (!$request->filled('link')) return response()->json(['error_message' => 'link is required', 'error_code' => 400], 400);
        $order = Order::with(['user', 'service'])->where('domain', getDomain())->find($orderId);
        if (!$order) return response()->json(['error_message' => 'Order not found', 'error_code' => 404], 404);
        $order->update(['link' => $request->link]);
        return response()->json(['success' => true]);
    }

    public function resendOrders(Request $request): JsonResponse
    {
        if (!$request->filled('ids')) return response()->json(['error_message' => 'ids is required', 'error_code' => 400], 400);
        $ids = array_slice(array_map('intval', explode(',', $request->ids)), 0, 100);
        Order::whereIn('id', $ids)->where('domain', getDomain())->whereIn('status', ['failed', 'canceled'])->update(['status' => 'pending']);
        return response()->json(['success' => true]);
    }

    public function changeStatus(Request $request): JsonResponse
    {
        if (!$request->filled('ids') || !$request->filled('status')) return response()->json(['error_message' => 'ids and status are required', 'error_code' => 400], 400);
        $ids = array_slice(array_map('intval', explode(',', $request->ids)), 0, 100);
        $db  = orderStatusToDatabase($request->status);
        $upd = ['status' => $db];
        if ($db === 'completed') $upd['remains'] = 0;
        Order::whereIn('id', $ids)->where('domain', getDomain())->update($upd);
        return response()->json(['success' => true]);
    }

    public function setPartial(Request $request, int $orderId): JsonResponse
    {
        if (!$request->has('remains')) return response()->json(['error_message' => 'remains is required', 'error_code' => 400], 400);
        $order = Order::with(['user', 'service'])->where('domain', getDomain())->find($orderId);
        if (!$order) return response()->json(['error_message' => 'Order not found', 'error_code' => 404], 404);
        $order->update(['status' => 'partial', 'remains' => (int)$request->remains]);
        return response()->json(['success' => true]);
    }

    public function requestCancel(Request $request): JsonResponse
    {
        if (!$request->filled('ids')) return response()->json(['error_message' => 'ids is required', 'error_code' => 400], 400);
        $ids = array_slice(array_map('intval', explode(',', $request->ids)), 0, 100);
        Order::whereIn('id', $ids)->where('domain', getDomain())->update(['status' => 'canceled']);
        return response()->json(['success' => true]);
    }

    public function cancelOrders(Request $request): JsonResponse
    {
        if (!$request->filled('ids')) return response()->json(['error_message' => 'ids is required', 'error_code' => 400], 400);
        $ids    = array_slice(array_map('intval', explode(',', $request->ids)), 0, 100);
        $upd    = ['status' => 'canceled'];
        if ($request->filled('cancel_reason')) $upd['note'] = $request->cancel_reason;
        $orders = Order::whereIn('id', $ids)->where('domain', getDomain())->get();
        foreach ($orders as $order) {
            $order->update($upd);
            if (($order->charge ?? 0) > 0) $order->user?->increment('balance', $order->charge);
        }
        return response()->json(['success' => true]);
    }

    // Cancel tasks
    public function pullCancelTasks(Request $request): JsonResponse
    {
        try {
            $limit = min((int)($request->input('limit', 100)), 100);
            $sids  = $request->filled('service_ids') ? array_map('intval', explode(',', $request->service_ids)) : null;
            $q = Ticket::where('domain', getDomain())->where('type', 'cancel')->where('status', 'pending')
                ->where('created_at', '>=', now()->subDays(90))->oldest()->limit($limit);
            if ($sids) $q->whereHas('order', fn($u) => $u->whereIn('service_id', $sids));
            $tasks = $q->get();
            Ticket::whereIn('id', $tasks->pluck('id'))->update(['status' => 'awaiting']);
            return response()->json($tasks->map(fn($t) => ['id' => $t->id, 'order_id' => $t->order_id, 'status' => $t->status]));
        } catch (Exception $e) {
            return response()->json(['error_message' => 'Incorrect request', 'error_code' => 400], 400);
        }
    }

    public function rejectCancelTasks(Request $request): JsonResponse
    {
        if (!$request->filled('ids')) return response()->json(['error_message' => 'ids is required', 'error_code' => 400], 400);
        Ticket::whereIn('id', array_map('intval', explode(',', $request->ids)))->where('domain', getDomain())->update(['status' => 'rejected']);
        return response()->json(['success' => true]);
    }

    // Refill tasks
    public function pullRefillTasks(Request $request): JsonResponse
    {
        try {
            $limit = min((int)($request->input('limit', 100)), 100);
            $sids  = $request->filled('service_ids') ? array_map('intval', explode(',', $request->service_ids)) : null;
            $q = Ticket::where('domain', getDomain())->where('type', 'refill')->where('status', 'pending')
                ->where('created_at', '>=', now()->subDays(90))->oldest()->limit($limit);
            if ($sids) $q->whereHas('order', fn($u) => $u->whereIn('service_id', $sids));
            $tasks = $q->get();
            Ticket::whereIn('id', $tasks->pluck('id'))->update(['status' => 'awaiting']);
            return response()->json($tasks->map(fn($t) => ['id' => $t->id, 'order_id' => $t->order_id, 'status' => $t->status]));
        } catch (Exception $e) {
            return response()->json(['error_message' => 'Incorrect request', 'error_code' => 400], 400);
        }
    }

    // Payments
    public function getPayments(Request $request): JsonResponse
    {
        try {
            $q = Payment::with('user')->where('domain', getDomain());
            if ($request->filled('ids'))            $q->whereIn('id', array_map('intval', explode(',', $request->ids)));
            if ($request->filled('username'))       $q->whereHas('user', fn($u) => $u->where('username', $request->username));
            if ($request->filled('user_id'))        $q->whereHas('user', fn($u) => $u->where('id', (int)$request->user_id));
            if ($request->filled('user_email'))     $q->whereHas('user', fn($u) => $u->where('email', $request->user_email));
            if ($request->filled('payment_status')) $q->where('status', $request->payment_status);
            if ($request->filled('memo'))           $q->where('note', 'like', '%' . $request->memo . '%');
            if ($request->filled('created_from'))   $q->where('created_at', '>=', \Carbon\Carbon::createFromTimestamp($request->created_from));
            if ($request->filled('created_to'))     $q->where('created_at', '<=', \Carbon\Carbon::createFromTimestamp($request->created_to));

            [$col, $dir] = match ($request->input('sort', 'created-at-desc')) {
                'created-at-asc'  => ['created_at', 'asc'],
                'updated-at-desc' => ['updated_at', 'desc'],
                'updated-at-asc'  => ['updated_at', 'asc'],
                default           => ['created_at', 'desc'],
            };
            $items = $q->orderBy($col, $dir)->offset((int)$request->input('offset', 0))->limit(min((int)$request->input('limit', 100), 1000))->get();
            return response()->json($items->map(fn($p) => [
                'id' => $p->id,
                'user' => $p->user?->username,
                'amount' => (float)$p->amount,
                'method' => $p->paymentMethod?->name ?? 'Manual',
                'status' => $p->status,
                'memo' => $p->note,
                'created_at' => $p->created_at?->toIso8601String(),
            ]));
        } catch (Exception $e) {
            return response()->json(['error_message' => 'Incorrect request', 'error_code' => 400], 400);
        }
    }

    public function addPayment(Request $request): JsonResponse
    {
        try {
            if (!$request->filled('amount') || !$request->filled('method')) return response()->json(['error_message' => 'amount and method are required', 'error_code' => 400], 400);
            $user = null;
            if ($request->filled('username'))    $user = User::where('username', $request->username)->where('domain', getDomain())->first();
            elseif ($request->filled('user_id')) $user = User::where('id', (int)$request->user_id)->where('domain', getDomain())->first();
            elseif ($request->filled('user_email')) $user = User::where('email', $request->user_email)->where('domain', getDomain())->first();
            if (!$user) return response()->json(['error_message' => 'User not found', 'error_code' => 404], 404);

            $amount = (float)$request->amount;
            if ($amount <= 0) return response()->json(['error_message' => 'Invalid amount', 'error_code' => 400], 400);
            $memo = $request->input('memo', 'Added via Admin API v2');
            if (Payment::where('note', $memo)->where('domain', getDomain())->exists()) return response()->json(['error_message' => 'Duplicate transaction', 'error_code' => 400], 400);

            Payment::create([
                'user_id' => $user->id,
                'transaction_id' => 'ADMINV2-' . Str::random(16),
                'amount' => $amount,
                'bonus_amount' => 0,
                'total_amount' => $amount,
                'currency' => 'USD',
                'exchange_rate' => 1,
                'status' => 'completed',
                'note' => $memo,
                'domain' => getDomain(),
            ]);
            $user->increment('balance', $amount);
            if ($request->boolean('affiliate_commission')) {
                \App\Services\AffiliateService::handleDeposit($user->id, $amount, 'ADMINV2-' . $user->id . '-' . time());
            }
            return response()->json(['success' => true, 'user' => $user->username, 'amount' => $amount]);
        } catch (Exception $e) {
            Log::error('AdminV2 addPayment: ' . $e->getMessage());
            return response()->json(['error_message' => 'Incorrect request', 'error_code' => 400], 400);
        }
    }

    // Users
    public function addUser(Request $request): JsonResponse
    {
        try {
            if (!$request->filled('username') || !$request->filled('email') || !$request->filled('password')) {
                return response()->json(['error_message' => 'username, email and password are required', 'error_code' => 400], 400);
            }
            if (User::where('username', $request->username)->where('domain', getDomain())->exists()) return response()->json(['error_message' => 'Username already exists', 'error_code' => 400], 400);
            if (User::where('email', $request->email)->where('domain', getDomain())->exists()) return response()->json(['error_message' => 'Email already exists', 'error_code' => 400], 400);

            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'first_name' => $request->input('first_name', ''),
                'last_name' => $request->input('last_name', ''),
                'phone' => $request->input('phone', ''),
                'role' => 'user',
                'status' => true,
                'domain' => getDomain(),
                'api_key' => Str::random(32),
            ]);
            return response()->json(['success' => true, 'user_id' => $user->id, 'username' => $user->username]);
        } catch (Exception $e) {
            Log::error('AdminV2 addUser: ' . $e->getMessage());
            return response()->json(['error_message' => 'Incorrect request', 'error_code' => 400], 400);
        }
    }
}
