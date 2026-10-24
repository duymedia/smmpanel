<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiProvider;
use App\Models\Order;
use App\Models\User;
use App\Models\Transaction;
use App\Smm\Smm;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private const TICKET_TO_TAG = [
        'canceled' => 'Cancel', 'refill' => 'Refill', 'speedup' => 'Speedup',
    ];

    private const TAG_TO_TICKET = [
        'Cancel' => 'canceled', 'Refill' => 'refill', 'Speedup' => 'speedup', '' => null,
    ];

    // ── Page view ────────────────────────────────────────────────────────────

    public function index(Request $request, $status = null)
    {
        $domain = getDomain();
        $statusOrder = orderStatusFromUrl($status);

        return view('admin.orders.index', [
            'statusOrder'  => $statusOrder,
            'manualCount'  => $this->cacheCount('manual',   fn() => Order::domain($domain)->where('status','pending')->emptyApi()->count()),
            'failedCount'  => $this->cacheCount('failed',   fn() => Order::domain($domain)->where('status','failed')->count()),
            'providers'    => $this->cacheData('providers', fn() => ApiProvider::select('id','name')->where('status',true)->orderBy('name')->get()),
            'services'     => $this->cacheData('services',  fn() => \App\Models\Service::select('id','name')->where('status',true)->where('domain',$domain)->orderBy('id')->get()->map(fn($s) => ['id' => $s->id, 'name' => $this->resolveName($s->name)])),
            'searchParams' => [
                'order_id'    => $request->input('id', $request->input('order_id', '')),
                'user_id'     => $request->input('user_id', '0'),
                'service_id'  => $request->input('service_id', ''),
                'provider_id' => $request->input('provider_id', ''),
            ],
        ]);
    }

    // ── AJAX: DataTables ─────────────────────────────────────────────────────

    public function list(Request $request): JsonResponse
    {
        return $this->dataTablesResponse($request,
            Order::with(['user:id,username', 'service:id,name,type,refill,cancel'])->domain(getDomain())
        );
    }

    public function listOld(Request $request): JsonResponse
    {
        return $this->dataTablesResponse($request,
            Order::with(['user:id,username', 'service:id,name,type,refill,cancel'])
                ->domain(getDomain())->where('status','completed')->where('created_at','<',now()->subMonths(3))
        );
    }

    // ── AJAX: Single order actions ───────────────────────────────────────────

    public function get(Request $request): JsonResponse
    {
        $order = Order::with(['user:id,username','service:id,name,type,refill,cancel'])
            ->domain(getDomain())->find($request->input('data.id'));

        return $order
            ? response()->json($this->mapOrderRow($order))
            : response()->json(['error' => 'Order not found'], 404);
    }

    public function changeStatus(Request $request): JsonResponse
    {
        $d = $request->input('data', []);
        $order = $this->findOrder($d['id'] ?? null);
        if (!$order) return $this->notFound();

        $dbStatus = orderStatusToDatabase($d['new_status'] ?? '');
        $update   = ['status' => $dbStatus];

        $this->completeCancelRequest($order, $dbStatus, $update);

        $this->applyStatusFinancials($order, $dbStatus, $d['remains'] ?? null, $update);

        $order->update($update);
        return $this->ok();
    }

    public function bulkChangeStatus(Request $request): JsonResponse
    {
        $d    = $request->input('data', []);
        $ids  = (array)($d['ids'] ?? []);
        $dbStatus = orderStatusToDatabase($d['data'] ?? '');
        Order::domain(getDomain())->whereIn('id', $ids)->update(['status' => $dbStatus]);
        if (in_array($dbStatus, ['partial', 'canceled'], true)) {
            Order::domain(getDomain())->whereIn('id', $ids)
                ->whereNotNull('cancel_status')->where('cancel_status', '!=', '')
                ->update(['cancel_status' => 'completed']);
        }

        return response()->json(['success' => adminMessage('update'), 'count' => count($ids)]);
    }

    public function addTag(Request $request): JsonResponse
    {
        $d = $request->input('data', []);
        $order = $this->findOrder($d['id'] ?? null);
        if (!$order) return $this->notFound();

        $order->update(['ticket' => self::TAG_TO_TICKET[$d['tag'] ?? ''] ?? null]);
        return $this->ok();
    }

    public function addNote(Request $request): JsonResponse
    {
        $d = $request->input('data', []);
        $order = $this->findOrder($d['id'] ?? null);
        if (!$order) return $this->notFound();

        $order->update(['note' => substr((string)($d['note'] ?? ''), 0, 20)]);
        return $this->ok();
    }

    public function addStartCount(Request $request): JsonResponse
    {
        $d = $request->input('data', []);
        $order = $this->findOrder($d['id'] ?? null);
        if (!$order) return $this->notFound();

        $order->update(['start_count' => (int)($d['start'] ?? 0)]);
        return $this->ok();
    }

    public function addProviderOrderID(Request $request): JsonResponse
    {
        $d = $request->input('data', []);
        $order = $this->findOrder($d['id'] ?? null);
        if (!$order) return $this->notFound();

        $order->update(['orders_api' => $d['provider_oid'] ?? '', 'status' => 'pending']);
        return response()->json(['success' => adminMessage('update')]);
    }

    public function sendOrder(Request $request): JsonResponse
    {
        $d     = $request->input('data', []);
        $order = Order::with('service')->domain(getDomain())->find($d['id'] ?? null);
        if (!$order) return $this->notFound();
        if (!$order->provider_id) return response()->json(['error' => 'No provider assigned'], 400);

        try {
            [$smm] = $this->buildSmm($order->provider_id);
            $res = (array) json_decode(json_encode($smm->order([
                'link' => $order->link, 'service' => $order->service_api, 'quantity' => $order->quantity,
            ])), true);

            if (!empty($res['order'])) {
                $order->update(['orders_api' => $res['order'], 'status' => 'pending']);
                return response()->json(['success' => 'Order sent']);
            }
            return response()->json(['error' => $res['error'] ?? 'Provider error'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function changeStatusFromApi(Request $request): JsonResponse
    {
        $d     = $request->input('data', []);
        $order = $this->findOrder($d['id'] ?? null);
        if (!$order) return $this->notFound();
        if (!$order->provider_id || !$order->orders_api)
            return response()->json(['error' => 'No provider order ID'], 400);

        try {
            [$smm] = $this->buildSmm($order->provider_id);
            $res   = (object)(is_array($r = $smm->status($order->orders_api)) ? $r : (array)$r);

            if (empty($res->status))
                return response()->json(['success' => true, 'message' => $res->error ?? 'No status', 'provider_error' => true]);

            $newStatus = orderStatusToDatabase($res->status);
            if (!$newStatus) return response()->json(['error' => 'Unknown status: ' . $res->status], 400);

            $update = ['status' => $newStatus];
            $this->completeCancelRequest($order, $newStatus, $update);

            // API status responses include start_count. Keep it even when it
            // is 0 so the value shown in the orders table matches the provider.
            if (property_exists($res, 'start_count') && is_numeric($res->start_count)) {
                $update['start_count'] = (int) $res->start_count;
            }

            if ($newStatus === 'completed') {
                $update['remains'] = 0;
            } elseif ($newStatus === 'partial') {
                if (!property_exists($res, 'remains') || !is_numeric($res->remains)) {
                    return response()->json(['error' => 'Provider did not return a valid remaining quantity'], 422);
                }

                $remains = max(0, min((int) $res->remains, (int) $order->quantity));
                if (!in_array($order->status, ['partial', 'canceled'], true)) {
                    $this->applyPartialRefund($order, $remains, $update);
                } else {
                    $update['remains'] = $remains;
                }
            }

            $order->update($update);

            return response()->json(['success' => adminMessage('status'), 'status' => $newStatus]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function statsOrder(Request $request): JsonResponse
    {
        $orders = Order::domain(getDomain());

        return response()->json([
            [
                'order_status' => 'Manual',
                'total' => (clone $orders)->where('status', 'pending')->emptyApi()->count(),
            ],
            [
                'order_status' => 'Failed',
                'total' => (clone $orders)->where('status', 'failed')->count(),
            ],
        ]);
    }

    public function editOrderOld(Request $request): JsonResponse
    {
        return $this->ok();
    }

    public function exportOrders(Request $request): JsonResponse
    {
        return response()->json(['error' => 'Export not implemented'], 501);
    }

    // ── Non-AJAX CRUD ────────────────────────────────────────────────────────

    public function show(Request $request, $id)
    {
        $order = Order::with(['user','service'])->domain(getDomain())->findOrFail($id);
        return $request->expectsJson()
            ? response()->json(['success' => true, 'order' => $order])
            : abort(404);
    }

    public function update(Request $request, $id = null)
    {
        $order = Order::domain(getDomain())->findOrFail($id);

        if ($request->has('toggle_status')) {
            $dbStatus = orderStatusToDatabase($request->input('status'));
            $changed  = $order->status !== $dbStatus;
            if ($changed) {
                $upd = ['status' => $dbStatus];
                if ($dbStatus === 'canceled') $this->refundAndZero($order, $upd);
                $order->update($upd);
            }
            return response()->json(['success' => true, 'message' => $changed ? 'Updated' : 'No change', 'order' => $order->fresh()]);
        }

        if ($request->has('quick_status')) {
            $dbStatus = orderStatusToDatabase($request->input('quick_status'));
            $upd = ['status' => $dbStatus];
            if ($dbStatus === 'canceled') $this->refundAndZero($order, $upd);
            $order->update($upd);
            return response()->json(['success' => true, 'order_id' => $order->id]);
        }

        if ($request->has('add_start_count')) {
            $order->update(['start_count' => (int)$request->input('start_count', 0)]);
            return response()->json(['success' => true]);
        }

        if ($request->has('note')) {
            $order->update(['note' => $request->input('note')]);
            return response()->json(['success' => true]);
        }

        if ($request->has('orders_api')) {
            $order->update(['orders_api' => $request->input('orders_api'), 'status' => 'pending']);
            return response()->json(['success' => true]);
        }

        if ($request->has('ticket')) {
            $t = strtolower(trim((string)$request->input('ticket')));
            $map = ['cancel' => 'canceled', 'refill' => 'refill', 'speedup' => 'speedup', '' => null];
            if (!array_key_exists($t, $map)) return response()->json(['error' => 'Invalid ticket'], 400);
            $order->update(['ticket' => $map[$t]]);
            return response()->json(['success' => true]);
        }

        $v = $request->validate([
            'status'      => 'sometimes|in:pending,processing,in progress,completed,partial,canceled,awaiting,failed',
            'start_count' => 'sometimes|nullable|integer|min:0',
            'remains'     => 'sometimes|nullable|integer|min:0',
        ]);
        $diff = array_filter($v, fn($val, $k) => $order->getAttribute($k) != $val, ARRAY_FILTER_USE_BOTH);
        if ($diff) $order->update($diff);

        return $request->expectsJson()
            ? response()->json(['success' => adminMessage('update')])
            : redirect()->back()->with('success', adminMessage('update'));
    }

    public function destroy(Request $request, $id = null)
    {
        $order = Order::domain(getDomain())->findOrFail($id);
        $order->delete();

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => adminMessage('delete')])
            : redirect()->back()->with('success', adminMessage('delete'));
    }

    public function updateOrderStatus(Request $request, $id): JsonResponse
    {
        try {
            $order    = Order::domain(getDomain())->findOrFail($id);
            $dbStatus = orderStatusToDatabase($request->input('status'));
            if (!$dbStatus) return response()->json(['error' => 'Unknown status'], 400);

            $update = ['status' => $dbStatus];
            if ($dbStatus === 'completed') {
                $update += ['remains' => 0, 'success_time' => $order->success_time ?? now()];
            } elseif (in_array($dbStatus, ['in progress', 'processing'], true)) {
                $update['remains'] = $order->quantity;
            } elseif ($dbStatus === 'partial') {
                $this->applyPartialRefund($order, (int) $request->input('remains', 0), $update);
            } elseif ($dbStatus === 'canceled') {
                $this->applyStatusFinancials($order, $newStatus, $remains ?? null, $update);
            }

            $order->update($update);
            return response()->json(['success' => adminMessage('update')]);
        } catch (\Exception $e) {
            Log::error('updateOrderStatus', ['id' => $id, 'err' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function resendOrder(Request $request, $id): JsonResponse
    {
        try {
            $order = Order::with('service')->domain(getDomain())->findOrFail($id);
            if ($order->status !== 'failed')    return response()->json(['error' => "Only 'failed' orders can be resent"], 400);
            if (!$order->provider_id)           return response()->json(['error' => 'No provider assigned'], 400);

            [$smm] = $this->buildSmm($order->provider_id);
            $res   = (array) json_decode(json_encode($smm->order([
                'link' => $order->link, 'service' => $order->service_api, 'quantity' => $order->quantity,
            ])), true);

            if (isset($res['order'])) {
                $order->update(['orders_api' => $res['order'], 'status' => 'pending', 'order_data' => json_encode($res)]);
                return response()->json(['success' => true, 'message' => 'Resent']);
            }
            $order->update(['order_data' => json_encode(['error' => $res['error'] ?? ''])]);
            return response()->json(['error' => $res['error'] ?? 'Provider error'], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ── Private helpers ──────────────────────────────────────────────────────

    private function dataTablesResponse(Request $request, $base): JsonResponse
    {
        $hasFilter   = false;
        $searchTypes = (array)$request->input('searchTypes', []);

        foreach ((array)$request->input('columns', []) as $col) {
            $name  = $col['name'] ?? '';
            $value = trim((string)($col['search']['value'] ?? ''));
            if (!$name || !$value) continue;

            $hasFilter = true;

            switch ($name) {
                case 'order_status':
                    $base->whereIn('status', array_map('orderStatusToDatabase', array_filter(array_map('trim', explode(',', $value)))));
                    break;
                case 'order_tag':
                    $tags = array_filter(array_map('trim', explode(',', $value)));
                    $tickets = array_filter(array_map(fn($t) => self::TAG_TO_TICKET[$t] ?? null, $tags));
                    in_array('Partial', $tags)
                        ? $base->where(fn($q) => $q->whereIn('ticket', $tickets)->orWhere('status','partial'))
                        : $base->whereIn('ticket', $tickets);
                    break;
                case 'order_type':
                    match (strtoupper($value)) {
                        'MANUAL' => $base->where(fn($q) => $q->whereNull('orders_api')->orWhere('orders_api','')),
                        'API'    => $base->where(fn($q) => $q->whereNotNull('orders_api')->where('orders_api','!=',' ')),
                        default  => null,
                    };
                    break;
                case 'order_id':
                    $ids = array_values(array_filter(array_map('trim', explode(',', $value))));
                    count($ids) === 1 ? $base->where('id',$ids[0]) : $base->whereIn('id',$ids);
                    break;
                case 'order_link':
                    ($searchTypes['order_link'] ?? 'contain') === 'exact'
                        ? $base->where('link', $value)
                        : $base->where('link', 'like', "%{$value}%");
                    break;
                case 'account_id':   $base->where('user_id', (int)$value);                          break;
                case 'service_id':   $base->where('service_id', (int)$value);                       break;
                case 'provider_oid': $base->where('orders_api', 'like', "%{$value}%");              break;
                case 'provider_id':  $this->applyProviderFilter($base, $value);                     break;
                case 'order_created':
                    $parts = array_map('trim', explode('|', $value));
                    if (!empty($parts[0])) $base->where('created_at', '>=', $parts[0]);
                    if (!empty($parts[1])) $base->where('created_at', '<=', $parts[1]);
                    break;
            }
        }

        $domain      = getDomain();
        $total       = $this->cacheCount('total', fn() => Order::domain($domain)->count());
        $filtered    = $hasFilter ? (clone $base)->count() : $total;
        $dir         = strtolower($request->input('order.0.dir','desc')) === 'asc' ? 'asc' : 'desc';
        $start       = max(0, (int)$request->input('start', 0));
        $length      = (int)$request->input('length', 50);

        if ($length > 0) $base->skip($start)->take($length);
        $base->orderBy('id', $dir);

        return response()->json([
            'draw'            => (int)$request->input('draw', 0),
            'recordsTotal'    => $total,
            'recordsFiltered' => $filtered,
            'data'            => $base->get()->map(fn(Order $o) => $this->mapOrderRow($o))->all(),
        ]);
    }

    private function mapOrderRow(Order $o): array
    {
        $provider = (string)($o->provider_name ?? '');
        $isManual = $provider === '' || strtolower($provider) === 'manual';
        $features = [];
        if ($o->service) {
            if ($o->service->refill) $features[] = 'Refill';
            if ($o->service->cancel) $features[] = 'Cancel';
        }

        return [
            'order_id'           => (int)$o->id,
            'account_id'         => (int)$o->user_id,
            'account_user'       => $o->user->username ?? '',
            'service_id'         => (int)($o->service_id ?? 0),
            'service_name'       => $o->service ? $this->resolveName($o->service->name) : '',
            'service_type'       => $o->service->type ?? 'Default',
            'service_feature'    => json_encode($features),
            'order_status'       => orderStatusToDisplay($o->status),
            'order_type'         => (!empty($o->orders_api) || !$isManual) ? 'Api' : 'Manual',
            // A client cancel request is tracked in cancel_status (and may not
            // have a ticket tag yet). Expose it as the existing Cancel tag so
            // admin.js renders the history link consistently.
            'order_tag'          => filled($o->cancel_status)
                ? 'Cancel'
                : (self::TICKET_TO_TAG[$o->ticket ?? ''] ?? ''),
            'provider_name'      => $provider,
            'provider_type'      => $isManual ? 'manual' : '',
            'provider_oid'       => $o->orders_api ?? 0,
            'provider_id'        => (int)($o->provider_id ?? 0),
            'order_charge'       => (float)($o->charge ?? 0),
            'order_price'        => (float)($o->rate ?? 0),
            'order_quantity'     => (int)($o->quantity ?? 0),
            'order_start'        => (int)($o->start_count ?? 0),
            'order_remains'      => (int)($o->remains ?? 0),
            'order_discount'     => 0,
            'coupon_id'          => 0,
            'order_link'         => (string)($o->link ?? ''),
            'order_comment'      => filled($o->comment) ? (string) $o->comment : null,
            'order_more'         => $o->order_data ? self::safeOrderMore($o->order_data) : '',
            'order_note'         => (string)($o->note ?? ''),
            'order_loop'         => (int)($o->loop_quantity ?? 0),
            'order_loop_spacing' => (int)($o->loop_spacing ?? 0),
            'order_schedule'     => $o->schedule_time ? 1 : 0,
            'order_created'      => optional($o->created_at)->format('Y-m-d H:i:s') ?? '',
            'order_changed'      => optional($o->updated_at)->format('Y-m-d H:i:s') ?? '',
            'order_from'         => 0,
        ];
    }

    /**
     * Encode order_more as a pure-ASCII JSON string so the browser's btoa()
     * never throws an InvalidCharacterError.
     *
     * btoa() only accepts Latin-1 characters. PHP's json_encode() without
     * JSON_UNESCAPED_UNICODE escapes every non-ASCII codepoint as \uXXXX,
     * producing a 100% ASCII string that btoa() handles safely. The JS side
     * calls atob() → JSON.parse(), which correctly decodes \uXXXX escapes.
     */
    private static function safeOrderMore(mixed $data): string
    {
        if (!$data) return '';

        if (is_string($data)) {
            $decoded = json_decode($data, true);
            $data    = $decoded ?? ['raw' => $data];
        }

        // JSON_UNESCAPED_SLASHES keeps URLs readable; non-ASCII → \uXXXX (btoa-safe)
        return json_encode($data, JSON_UNESCAPED_SLASHES) ?: '';
    }

    private function findOrder($id): ?Order
    {
        return $id ? Order::domain(getDomain())->find($id) : null;
    }

    private function completeCancelRequest(Order $order, string $status, array &$update): void
    {
        if (in_array($status, ['partial', 'canceled'], true) && filled($order->cancel_status)) {
            $update['cancel_status'] = 'completed';
        }
    }

    private function notFound(): JsonResponse
    {
        return response()->json(['error' => 'Order not found'], 404);
    }

    private function ok(string $msg = 'Success'): JsonResponse
    {
        return response()->json(['success' => $msg]);
    }

    private function refundAndZero(Order $order, array &$update): void
    {
        $update['remains'] = (int) $order->quantity;

        if ($order->charge > 0) {
            User::find($order->user_id)?->increment('balance', $order->charge);
            $update['charge'] = 0;
        }
    }

    private function applyStatusFinancials(Order $order, string $status, ?int $remains, array &$update): void
    {
        $previous = $order->status;
        $total = (float) ($order->total ?? $order->charge ?? 0);

        if ($status === 'completed') {
            $update['remains'] = 0;
        } elseif (in_array($status, ['processing', 'in progress', 'pending'], true)) {
            $update['remains'] = (int) $order->quantity;
        } elseif ($status === 'partial' && $remains !== null) {
            $update['remains'] = max(0, min($remains, (int) $order->quantity));
        } elseif ($status === 'canceled') {
            $this->refundAndZero($order, $update);
        }

        if ($previous === 'partial' && $status !== 'partial' && $total > (float) $order->charge) {
            $amount = $total - (float) $order->charge;
            DB::transaction(function () use ($order, $amount): void {
                $user = User::whereKey($order->user_id)->lockForUpdate()->first();
                if (!$user) return;
                $user->decrement('balance', $amount);
                $user->refresh();
                Transaction::create([
                    'user_id' => $user->id,
                    'order_id' => $order->id,
                    'amount' => -$amount,
                    'type' => 'refund_reversal',
                    'status' => 'completed',
                    'payment_method' => null,
                    'transaction_id' => 'REVERSE-REFUND-ORDER-' . $order->id . '-' . uniqid(),
                    'description' => 'Reversal of partial refund for order #' . $order->id,
                    'balance_after' => $user->balance,
                    'domain' => $order->domain,
                ]);
            });
            $update['charge'] = $total;
            $update['remains'] = (int) $order->quantity;
        }
    }

    private function applyPartialRefund(Order $order, int $remains, array &$update): void
    {
        $update['remains'] = $remains;
        if ($order->quantity <= 0 || ($order->total ?? 0) <= 0) return;

        $refund = round($remains * $order->total / $order->quantity, 8);
        $update['charge'] = max(0, $order->charge - $refund);
        if ($refund > 0) {
            DB::transaction(function () use ($order, $refund): void {
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
                    'transaction_id' => 'PARTIAL-REFUND-ORDER-' . $order->id . '-' . uniqid(),
                    'description' => 'Partial refund for order #' . $order->id,
                    'balance_after' => $user->balance,
                    'domain' => $order->domain,
                ]);
            });
        }
    }

    private function resolveName(mixed $name): string
    {
        if (is_string($name)) $name = json_decode($name, true) ?? $name;
        if (is_array($name))  return $name['en'] ?? $name['vi'] ?? (string)(reset($name) ?? '');
        return (string)($name ?? '');
    }

    private function applyProviderFilter($query, string $value): void
    {
        match (strtolower($value)) {
            'manual' => $query->where(fn($q) => $q->whereNull('provider_name')->orWhere('provider_name','')->orWhere('provider_name','manual')),
            'api', 'all_providers' => $query->whereNotNull('provider_name')->where('provider_name','!=','')->where('provider_name','!=','manual'),
            default => tap(ApiProvider::find($value), fn($p) => $p && $query->where('provider_name', $p->name)),
        };
    }

    private function buildSmm(int $providerId): array
    {
        $provider = ApiProvider::findOrFail($providerId);
        $smm      = new Smm();
        $smm->api_url = $provider->link;
        $smm->api_key = $provider->api_key;

        if (!empty($provider->note)) {
            try {
                $cfg = json_decode($provider->note, true);
                if (isset($cfg['headers'])) $smm->headers = array_map(fn($k,$v) => "$k: $v", array_keys($cfg['headers']), $cfg['headers']);
                if (isset($cfg['cookies'])) $smm->cookies = $cfg['cookies'];
            } catch (\Exception) {}
        }
        return [$smm, $provider];
    }

    private function cacheCount(string $key, \Closure $fn): int
    {
        return (int) Cache::remember("orders_{$key}_" . md5(getDomain()), 60, $fn);
    }

    private function cacheData(string $key, \Closure $fn, int $ttl = 300): mixed
    {
        return Cache::remember("orders_{$key}_" . md5(getDomain()), $ttl, $fn);
    }
}
