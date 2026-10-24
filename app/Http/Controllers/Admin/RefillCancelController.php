<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefillCancelController extends Controller
{
    private const REFILL = ['pending' => 'Pending', 'in progress' => 'In progress', 'completed' => 'Completed', 'rejected' => 'Rejected'];

    public function refillServices(Request $request, ?string $status = null) { return view('admin.refill_services.index', ['statusOrder' => $this->urlStatus($status, true)]); }
    public function refillProducts(Request $request, ?string $status = null) { return view('admin.refill_products.index', ['statusOrder' => $this->urlStatus($status)]); }
    public function cancelServices(Request $request, ?string $status = null)
    {
        return view('admin.cancel_services.index', ['statusOrder' => match (strtolower((string) $status)) {'pending' => 'Pending', 'completed' => 'Completed', default => ''}]);
    }

    public function refillList(Request $request): JsonResponse
    {
        $query = $this->orderQuery('refill')->whereNotNull('orders.refill_status');
        $columns = ['refill_status' => 'orders.refill_status', 'refill_id' => 'orders.id', 'order_id' => 'orders.id'];
        $this->filters($query, $request, $columns);
        return $this->table($query, $request, $columns, 'orders.id', fn ($row) => $this->refillRow($row), ['orders.*', 'users.username']);
    }

    public function refillGet(Request $request): JsonResponse
    {
        $row = $this->oneOrder($request, 'refill');
        return $row ? response()->json($this->refillRow($row)) : $this->missing();
    }

    public function refillChangeStatus(Request $request): JsonResponse
    {
        $status = $this->refillDb($request->input('new_status'));
        if (!$status) return response()->json(['error' => 'Invalid refill status'], 422);
        return $this->updated(DB::table('orders')->where('domain', getDomain())->where('refill', true)->where('id', (int) $request->input('id'))->update(['refill_status' => $status, 'updated_at' => now()]));
    }

    public function refillBulkChangeStatus(Request $request): JsonResponse { return $this->bulkOrder($request, 'refill', 'refill_status', false); }
    public function updateRefillStatus(Request $request): JsonResponse { return $this->refillBulkChangeStatus($request); }

    public function cancelList(Request $request): JsonResponse
    {
        $query = $this->orderQuery('cancel')->whereNotNull('orders.cancel_status');
        $columns = ['cancel_status' => 'orders.cancel_status', 'cancel_id' => 'orders.id', 'order_id' => 'orders.id'];
        $this->filters($query, $request, $columns, true);
        return $this->table($query, $request, $columns, 'orders.id', fn ($row) => $this->cancelRow($row), ['orders.*', 'users.username']);
    }

    public function cancelGet(Request $request): JsonResponse
    {
        $row = $this->oneOrder($request, 'cancel');
        return $row ? response()->json($this->cancelRow($row)) : $this->missing();
    }

    public function cancelChangeStatus(Request $request): JsonResponse
    {
        $status = (int) $request->input('new_status') === 1 ? 'completed' : 'pending';
        return $this->updated(DB::table('orders')->where('domain', getDomain())->where('cancel', true)->where('id', (int) $request->input('id'))->update(['cancel_status' => $status, 'updated_at' => now()]));
    }

    public function cancelBulkChangeStatus(Request $request): JsonResponse { return $this->bulkOrder($request, 'cancel', 'cancel_status', true); }
    public function updateCancelStatus(Request $request): JsonResponse { return $this->cancelBulkChangeStatus($request); }

    public function refillProductList(Request $request): JsonResponse
    {
        $query = DB::table('product_orders')->leftJoin('users', 'users.id', '=', 'product_orders.user_id')->where('product_orders.domain', getDomain())->where('product_orders.refill', true)->whereNotNull('product_orders.refill_status');
        $columns = ['product_refill_status' => 'product_orders.refill_status', 'product_refill_id' => 'product_orders.id', 'product_order_id' => 'product_orders.id'];
        $this->filters($query, $request, $columns);
        return $this->table($query, $request, $columns, 'product_orders.id', fn ($row) => $this->productRow($row), ['product_orders.*', 'users.username']);
    }

    public function refillProductGet(Request $request): JsonResponse
    {
        $row = DB::table('product_orders')->leftJoin('users', 'users.id', '=', 'product_orders.user_id')->where('product_orders.domain', getDomain())->where('product_orders.refill', true)->where('product_orders.id', (int) $request->input('id'))->select(['product_orders.*', 'users.username'])->first();
        return $row ? response()->json($this->productRow($row)) : $this->missing();
    }

    public function refillProductChangeStatus(Request $request): JsonResponse
    {
        $status = $this->productStatus($request->input('new_status'));
        if (!$status) return response()->json(['error' => 'Invalid product refill status'], 422);
        return $this->updated($this->productQuery()->where('id', (int) $request->input('id'))->update(['refill_status' => $status, 'updated_at' => now()]));
    }

    public function refillProductBulkChangeStatus(Request $request): JsonResponse
    {
        $status = $this->productStatus($request->input('status')); $ids = $this->ids($request);
        if (!$status || !$ids) return response()->json(['error' => 'Invalid request'], 422);
        $this->productQuery()->whereIn('id', $ids)->update(['refill_status' => $status, 'updated_at' => now()]);
        return response()->json(['success' => true]);
    }

    public function updateRefillProductStatus(Request $request): JsonResponse { return $this->refillProductBulkChangeStatus($request); }

    public function refillProductCompleted(Request $request): JsonResponse
    {
        $goods = array_values(array_filter(array_map('trim', (array) $request->input('goods', []))));
        if ((int) $request->input('type') === 0 && !$goods) return response()->json(['error' => 'Please input goods'], 422);
        $note = (int) $request->input('type') === 0 ? implode("\n", $goods) : 'Completed automatically';
        return $this->updated($this->productQuery()->where('id', (int) $request->input('id'))->update(['refill_status' => 'Completed', 'note' => $note, 'updated_at' => now()]));
    }

    public function refillProductGetResult(Request $request): JsonResponse
    {
        return response()->json(['result' => (string) $this->productQuery()->where('id', (int) $request->input('id'))->value('note')]);
    }

    private function table(Builder $query, Request $request, array $columns, string $default, callable $map, array $select): JsonResponse
    {
        $total = (clone $query)->count(); $filtered = (clone $query)->count();
        $index = (int) $request->input('order.0.column', -1); $name = (string) $request->input("columns.{$index}.name", '');
        $direction = strtolower((string) $request->input('order.0.dir')) === 'asc' ? 'asc' : 'desc';
        $length = min(max((int) $request->input('length', 10), 1), 100);
        $rows = $query->orderBy($columns[$name] ?? $default, $direction)->skip(max((int) $request->input('start', 0), 0))->take($length)->select($select)->get()->map($map)->values();
        return response()->json(['draw' => (int) $request->input('draw', 0), 'recordsTotal' => $total, 'recordsFiltered' => $filtered, 'data' => $rows]);
    }

    private function filters(Builder $query, Request $request, array $columns, bool $cancel = false): void
    {
        foreach ((array) $request->input('columns', []) as $column) {
            $name = (string) ($column['name'] ?? ''); $value = trim((string) ($column['search']['value'] ?? ''));
            if ($value === '' || !isset($columns[$name])) continue;
            if (str_contains($name, 'status')) $value = $cancel ? ($value === '1' ? 'completed' : 'pending') : strtolower($value);
            $query->where($columns[$name], $value);
        }
    }

    private function orderQuery(string $feature): Builder { return DB::table('orders')->leftJoin('users', 'users.id', '=', 'orders.user_id')->where('orders.domain', getDomain())->where("orders.{$feature}", true); }
    private function oneOrder(Request $request, string $feature): ?object { return $this->orderQuery($feature)->where('orders.id', (int) $request->input('id'))->select(['orders.*', 'users.username'])->first(); }
    private function productQuery(): Builder { return DB::table('product_orders')->where('domain', getDomain())->where('refill', true); }

    private function bulkOrder(Request $request, string $feature, string $column, bool $cancel): JsonResponse
    {
        $ids = $this->ids($request); $status = $cancel ? ((int) $request->input('status') === 1 ? 'completed' : 'pending') : $this->refillDb($request->input('status'));
        if (!$ids || !$status) return response()->json(['error' => 'Invalid request'], 422);
        DB::table('orders')->where('domain', getDomain())->where($feature, true)->whereIn('id', $ids)->update([$column => $status, 'updated_at' => now()]);
        return response()->json(['success' => true]);
    }

    private function refillRow(object $row): array { return ['refill_id' => $row->id, 'refill_status' => self::REFILL[strtolower((string) $row->refill_status)] ?? ucfirst((string) $row->refill_status), 'provider_name' => $row->provider_name ?: '-', 'provider_refill' => $row->orders_api ?: '-', 'account_user' => $row->username ?: '-', 'order_id' => $row->id, 'refill_created' => $this->date($row->created_at), 'refill_note' => $row->note ?: '']; }
    private function cancelRow(object $row): array { return ['cancel_id' => $row->id, 'cancel_status' => strtolower((string) $row->cancel_status) === 'completed' ? 1 : 0, 'provider_name' => $row->provider_name ?: '-', 'account_user' => $row->username ?: '-', 'order_id' => $row->id, 'cancel_created' => $this->date($row->created_at), 'cancel_note' => $row->note ?: '']; }
    private function productRow(object $row): array { return ['product_refill_id' => $row->id, 'product_refill_status' => self::REFILL[strtolower((string) $row->refill_status)] ?? ucfirst((string) $row->refill_status), 'account_user' => $row->username ?: '-', 'product_order_id' => $row->id, 'product_refill_quantity' => (int) $row->quantity, 'product_refill_created' => $this->date($row->created_at), 'product_refill_note' => $row->note ?: '', 'product_refill_result' => $row->note ?: '']; }
    private function ids(Request $request): array { return array_values(array_filter(array_map('intval', (array) $request->input('ids', [])))); }
    private function refillDb(mixed $status): ?string { $value = strtolower(trim((string) $status)); return isset(self::REFILL[$value]) ? $value : null; }
    private function productStatus(mixed $status): ?string { return self::REFILL[strtolower(trim((string) $status))] ?? null; }
    private function urlStatus(?string $status, bool $service = false): string { $value = strtolower(str_replace(['-', '_'], ' ', (string) $status)); return $service && in_array($value, ['awaiting', 'failed'], true) ? ucfirst($value) : (self::REFILL[$value] ?? ''); }
    private function date(mixed $value): string { return $value ? date('Y-m-d H:i:s', strtotime((string) $value)) : ''; }
    private function updated(int $count): JsonResponse { return $count ? response()->json(['success' => true]) : $this->missing(); }
    private function missing(): JsonResponse { return response()->json(['error' => 'Request not found'], 404); }
}
