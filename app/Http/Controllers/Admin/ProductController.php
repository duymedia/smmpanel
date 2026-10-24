<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductGroup;
use App\Models\ProductWarehouse;
use App\Models\ProductGoods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::where('domain', getDomain())
            ->orderBy('position')
            ->with(['products' => function ($q) {
                $q->with('group')->orderBy('position');
            }])
            ->get();

        return view('admin.products.index', compact('categories'));
    }

    public function product_orders(Request $request, $status = null)
    {
        // Map URL path status to DB status
        $statusMap = [
            'manual'      => 'Manual',
            'awaiting'    => 'Awaiting',
            'failed'      => 'Failed',
            'pending'     => 'Pending',
            'inprogress'  => 'In progress',
            'completed'   => 'Completed',
            'partial'     => 'Partial',
            'canceled'    => 'Canceled',
        ];

        $dbStatus = $status ? ($statusMap[$status] ?? null) : null;

        $query = \App\Models\ProductOrder::with(['user', 'product'])
            ->where('domain', getDomain());

        if ($dbStatus) {
            $query->where('status', $dbStatus);
        }

        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('provider_id')) {
            $query->where('provider_product_order_id', $request->provider_id);
        }

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(50);

        $products = Product::where('domain', getDomain())
            ->orderBy('name')
            ->get(['id', 'name']);

        $stats = [
            'total'       => \App\Models\ProductOrder::where('domain', getDomain())->count(),
            'awaiting'    => \App\Models\ProductOrder::where('domain', getDomain())->where('status', 'Awaiting')->count(),
            'in_progress' => \App\Models\ProductOrder::where('domain', getDomain())->where('status', 'In progress')->count(),
            'completed'   => \App\Models\ProductOrder::where('domain', getDomain())->where('status', 'Completed')->count(),
        ];

        $statusOrder = $dbStatus ?? '';

        return view('admin.product_orders.index', compact('orders', 'products', 'stats', 'status', 'statusOrder'));
    }

    public function productOrderList(Request $request)
    {
        $query = \App\Models\ProductOrder::query()
            ->join('users', 'users.id', '=', 'product_orders.user_id')
            ->leftJoin('products', 'products.id', '=', 'product_orders.product_id')
            ->where('product_orders.domain', getDomain());

        $columns = (array) $request->input('columns', []);
        $searchable = [
            'product_order_status' => 'product_orders.status',
            'product_order_id' => 'product_orders.id',
            'provider_product_order_id' => 'product_orders.provider_product_order_id',
            'product_id' => 'product_orders.product_id',
        ];
        foreach ($columns as $column) {
            $name = (string) ($column['name'] ?? '');
            $value = trim((string) ($column['search']['value'] ?? ''));
            if ($value !== '' && isset($searchable[$name])) {
                $field = $searchable[$name];
                str_contains($value, ',')
                    ? $query->whereIn($field, array_filter(array_map('trim', explode(',', $value))))
                    : $query->where($field, $value);
            }
        }

        $total = \App\Models\ProductOrder::where('product_orders.domain', getDomain())
            ->join('users', 'users.id', '=', 'product_orders.user_id')
            ->count();
        $filtered = (clone $query)->count();
        $length = min(max((int) $request->input('length', 50), 1), 1000);
        $rows = $query->select([
            'product_orders.*', 'users.username as account_user', 'products.name as product_name',
            'products.type as product_add_type', 'products.api_provider_id as provider_id',
            'products.process_type as product_type',
        ])->orderByDesc('product_orders.id')->skip(max((int) $request->input('start', 0), 0))->take($length)->get();

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $rows->map(fn ($order) => $this->productOrderRow($order))->values(),
        ]);
    }

    public function productOrderGet(Request $request)
    {
        $order = $this->findProductOrder($request)->load(['user', 'product']);
        $row = (object) array_merge($order->toArray(), [
            'account_user' => $order->user?->username,
            'product_name' => $order->product?->name,
            'product_add_type' => $order->product?->type,
            'provider_id' => $order->product?->api_provider_id,
            'product_type' => $order->product?->process_type,
        ]);

        return response()->json($this->productOrderRow($row));
    }

    public function productOrderChangeStatus(Request $request)
    {
        $request->merge(['status' => $request->input('new_status'), 'quantity' => $request->input('remains')]);
        $response = $this->updateOrderStatus($request, $this->findProductOrder($request)->id);
        if ($request->filled('result')) {
            $this->findProductOrder($request)->update(['note' => $request->input('result')]);
        }

        return $response;
    }

    public function productOrderAddNote(Request $request)
    {
        $data = $request->validate(['note' => ['nullable', 'string', 'max:255']]);
        $this->findProductOrder($request)->update(['note' => $data['note'] ?? null]);

        return response()->json(['success' => true]);
    }

    public function productOrderGetResult(Request $request)
    {
        $order = $this->findProductOrder($request);
        $type = $order->product?->process_type ?? '';

        return response()->json(['success' => ['result' => $order->note ?? '', 'type' => $type]]);
    }

    public function productOrderGetRequire(Request $request)
    {
        $order = $this->findProductOrder($request);
        $result = json_decode((string) $order->note, true);

        return response()->json(['success' => ['result' => is_array($result) ? $result : []]]);
    }

    public function productOrderSubOrder(Request $request)
    {
        return response()->json(['success' => ['service' => []]]);
    }

    public function productOrderExport(Request $request)
    {
        return response()->json(['error' => 'Chức năng xuất dữ liệu chưa được cấu hình.']);
    }

    public function productOrderUnsupported(Request $request)
    {
        return response()->json(['error' => 'Sản phẩm này không hỗ trợ thao tác API hoặc combo.']);
    }

    private function findProductOrder(Request $request): \App\Models\ProductOrder
    {
        return \App\Models\ProductOrder::where('domain', getDomain())->with('product')->findOrFail((int) $request->input('id'));
    }

    private function productOrderRow(object $order): array
    {
        $quantity = max((int) ($order->quantity ?? 1), 1);

        return [
            'product_order_more' => '', 'product_order_status' => $order->status ?? 'Pending',
            'product_order_id' => (int) $order->id, 'product_order_charge' => (float) $order->charge,
            'product_order_discount' => 0, 'product_order_price' => (float) $order->amount / $quantity,
            'product_order_quantity' => $quantity, 'product_order_refund' => max((float) $order->charge - (float) $order->amount, 0),
            'product_id' => (int) $order->product_id, 'product_name' => $order->product_name ?? 'N/A',
            'account_user' => (string) $order->account_user, 'account_level' => 0,
            'provider_id' => (int) ($order->provider_id ?? 0),
            'provider_product_order_id' => (string) ($order->provider_product_order_id ?? ''),
            'product_add_type' => $order->product_add_type ?? 'Manual', 'product_type' => $order->product_type ?? '',
            'product_order_require' => '{}', 'product_order_note' => (string) ($order->note ?? ''),
            'product_order_error' => (string) ($order->note ?? ''),
            'product_order_created' => (string) $order->created_at, 'product_order_updated' => (string) $order->updated_at,
        ];
    }

    public function warehouse()
    {
        $warehouses = ProductWarehouse::where('domain', getDomain())
            ->withCount(['goods', 'availableGoods'])
            ->orderBy('position')
            ->get();

        return view('admin.products.warehouse', compact('warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateProductPayload($request);

        $validated['domain'] = getDomain();
        $validated['position'] = (int) Product::where('domain', getDomain())
            ->where('product_category_id', $validated['product_category_id'])
            ->max('position') + 1;

        $product = Product::create($validated);

        return response()->json([
            'success' => 'Product added successfully',
            'id' => $product->id,
        ]);
    }

    private function validateProductPayload(Request $request): array
    {
        $payload = $this->normalizeProductPayload($request->all());
        $validator = Validator::make($payload, [
            'name'                => 'required|string|max:255',
            'slug'                => 'nullable|string|max:255',
            'type'                => 'required|in:Manual,Api',
            'status'              => 'required|in:In stock,Out of stock,Inactive',
            'product_category_id' => 'required|exists:product_categories,id',
            'product_group_id'    => 'nullable|exists:product_groups,id',
            'group_tag'           => 'nullable|string|max:100',
            'thumbnail'           => 'nullable|string|max:500',
            'cost_price'          => 'nullable|numeric|min:0',
            'price'               => 'required|numeric|min:0',
            'price_1'             => 'required|numeric|min:0',
            'price_2'             => 'required|numeric|min:0',
            'price_percent'       => 'nullable|numeric',
            'price_1_percent'     => 'nullable|numeric',
            'price_2_percent'     => 'nullable|numeric',
            'min'                 => 'required|integer|min:1',
            'max'                 => 'required|integer|min:1',
            'sync'                => 'nullable|boolean',
            'api_provider_id'     => 'nullable|exists:api_providers,id',
            'api_service_id'      => 'nullable|string|max:100',
            'process_type'        => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            throw new HttpResponseException(
                response()->json(['error' => $validator->errors()->first()], 422)
            );
        }

        $validated = $validator->validated();
        $validated['slug']             = $validated['slug'] ?: Str::slug($validated['name']);
        $validated['sync']             = filter_var($validated['sync'] ?? false, FILTER_VALIDATE_BOOLEAN);
        $validated['product_group_id'] = ($validated['product_group_id'] ?? 0) > 0 ? $validated['product_group_id'] : null;

        return $validated;
    }

    private function normalizeProductPayload(array $data): array
    {
        $map = [
            'add_type' => 'type',
            'cat_id' => 'product_category_id',
            'group' => 'product_group_id',
            'provider_id' => 'api_provider_id',
            'provider_pid' => 'api_service_id',
            'details' => 'description',
            'percent_inc' => 'price_percent',
            'percent_inc_1' => 'price_1_percent',
            'percent_inc_2' => 'price_2_percent',
        ];
        $legacyProcessType = $data['type'] ?? null;
        foreach ($map as $source => $target) {
            if (array_key_exists($source, $data)) {
                $data[$target] = $data[$source];
            }
        }
        if (array_key_exists('add_type', $data)) {
            $data['process_type'] = $legacyProcessType;
        }
        if (($data['type'] ?? 'Manual') === 'Manual') {
            $data['api_provider_id'] = null;
            $data['api_service_id'] = null;
        }

        return $data;
    }

    public function edit(Request $request)
    {
        $product = \App\Models\Product::where('domain', getDomain())
            ->findOrFail($request->query('id'));

        $categories = ProductCategory::where('domain', getDomain())->where('status', true)->orderBy('position')->get();
        $groups     = ProductGroup::where('domain', getDomain())->orderBy('position')->get();
        $warehouses = ProductWarehouse::where('domain', getDomain())->orderBy('position')->get();
        $providers  = \App\Models\ApiProvider::where('domain', getDomain())->where('status', true)->orderBy('name')->get();
        $languages  = \App\Models\Language::where('domain', getDomain())->where('status', true)->orderBy('code')->get();
        $productInfo = [
            'id' => $product->id,
            'add_type' => $product->type,
            'provider_id' => $product->api_provider_id ?: 0,
            'provider_pid' => $product->api_service_id ?: 0,
            'cat_id' => $product->product_category_id,
            'type' => $product->process_type ?: 'Manual',
            'name' => $product->name,
            'slug' => $product->slug,
            'thumbnail' => $product->thumbnail,
            'warehouse' => 0,
            'cost_price' => $product->cost_price,
            'price' => $product->price,
            'price_1' => $product->price_1,
            'price_2' => $product->price_2,
            'min' => $product->min,
            'max' => $product->max,
            'sync' => $product->sync ? 1 : 0,
            'percent_inc' => $product->price_percent,
            'percent_inc_1' => $product->price_1_percent,
            'percent_inc_2' => $product->price_2_percent,
            'params' => [],
            'group' => $product->product_group_id ?: 0,
            'group_tag' => $product->group_tag,
            'details' => $product->description ?: '',
            'warranty_policy' => $product->warranty_policy ?: '',
            'combo' => [],
            'status' => $product->status,
        ];

        return view('admin.products.edit', compact('product', 'categories', 'groups', 'warehouses', 'providers', 'languages', 'productInfo'));
    }

    public function update(Request $request, $id)
    {
        $product = \App\Models\Product::where('domain', getDomain())->findOrFail($id);

        $validated = $request->validate([
            'name'                => 'required|string|max:255',
            'slug'                => 'nullable|string|max:255',
            'type'                => 'required|in:Manual,Api',
            'status'              => 'required|in:In stock,Out of stock,Inactive',
            'product_category_id' => 'required|exists:product_categories,id',
            'product_group_id'    => 'nullable|integer',
            'group_tag'           => 'nullable|string|max:100',
            'thumbnail'           => 'nullable|string|max:500',
            'description'         => 'nullable|string',
            'warranty_policy'     => 'nullable|string',
            'cost_price'          => 'nullable|numeric|min:0',
            'price'               => 'required|numeric|min:0',
            'price_1'             => 'required|numeric|min:0',
            'price_2'             => 'required|numeric|min:0',
            'price_percent'       => 'nullable|numeric',
            'price_1_percent'     => 'nullable|numeric',
            'price_2_percent'     => 'nullable|numeric',
            'min'                 => 'required|integer|min:1',
            'max'                 => 'required|integer|min:1',
            'sync'                => 'nullable|boolean',
            'api_provider_id'     => 'nullable|exists:api_providers,id',
            'api_service_id'      => 'nullable|string|max:100',
            'process_type'        => 'nullable|string|max:50',
        ]);

        $validated['slug']             = $validated['slug'] ?: \Str::slug($validated['name']);
        $validated['sync']             = $request->boolean('sync');
        $validated['product_group_id'] = ($validated['product_group_id'] ?? 0) > 0 ? $validated['product_group_id'] : null;

        $product->update($validated);

        return response()->json(['success' => true]);
    }

    public function updateFromRequest(Request $request)
    {
        $product = Product::where('domain', getDomain())->find($request->input('id'));
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $product->update($this->validateProductPayload($request));

        return response()->json(['success' => 'Product updated successfully']);
    }

    public function storeGroup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = ProductGroup::create([
            'name'     => $validated['name'],
            'domain'   => getDomain(),
            'position' => ProductGroup::where('domain', getDomain())->max('position') + 1,
        ]);

        return response()->json(['success' => true, 'id' => $group->id, 'name' => $group->name]);
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $category = ProductCategory::create([
            'name'     => $validated['name'],
            'status'   => $request->boolean('status', true),
            'domain'   => getDomain(),
            'position' => ProductCategory::where('domain', getDomain())->max('position') + 1,
        ]);

        return response()->json(['success' => true, 'id' => $category->id, 'name' => $category->name]);
    }

    public function updateCategory(Request $request)
    {
        $category = ProductCategory::where('domain', getDomain())->find($request->input('id'));
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $category->update([
            'name' => trim((string) $request->input('name')),
            'status' => $request->boolean('status'),
        ]);

        return response()->json(['success' => 'Category updated successfully']);
    }

    public function copyProduct(Request $request)
    {
        $source = Product::where('domain', getDomain())->find($request->input('id'));
        if (!$source) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $copy = $source->replicate();
        $copy->name = $source->name . ' - Copy';
        $copy->slug = $this->uniqueSlug(Str::slug($copy->name));
        $copy->position = (int) Product::where('domain', getDomain())
            ->where('product_category_id', $source->product_category_id)
            ->max('position') + 1;
        $copy->save();

        return response()->json(['success' => $copy->id]);
    }

    private function uniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $base = $slug !== '' ? $slug : 'product';
        $candidate = $base;
        $suffix = 2;
        while (Product::where('domain', getDomain())
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->where('slug', $candidate)->exists()) {
            $candidate = $base . '-' . $suffix++;
        }
        return $candidate;
    }

    public function sortCategory(Request $request)
    {
        return $this->sortIds(ProductCategory::class, (array) $request->input('dataSort', []));
    }

    public function sortProduct(Request $request)
    {
        return $this->sortIds(Product::class, (array) $request->input('dataSort', []));
    }

    private function sortIds(string $model, array $ids)
    {
        DB::transaction(function () use ($model, $ids) {
            foreach (array_values($ids) as $position => $id) {
                $model::where('domain', getDomain())->whereKey($id)->update(['position' => $position + 1]);
            }
        });
        return response()->json(['success' => true]);
    }

    public function storeWarehouse(Request $request)
    {
        $validator = Validator::make($request->all(), ['name' => 'required|string|max:255']);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }
        $warehouse = ProductWarehouse::create([
            'domain' => getDomain(),
            'name' => trim((string) $request->input('name')),
            'position' => (int) ProductWarehouse::where('domain', getDomain())->max('position') + 1,
        ]);
        return response()->json(['success' => true, 'id' => $warehouse->id]);
    }

    public function sortWarehouse(Request $request)
    {
        DB::transaction(function () use ($request) {
            foreach ((array) $request->input('dataSort', []) as $item) {
                ProductWarehouse::where('domain', getDomain())
                    ->whereKey($item['i'] ?? 0)
                    ->update(['position' => (int) ($item['s'] ?? 0)]);
            }
        });
        return response()->json(['success' => true]);
    }

    public function addGoods(Request $request)
    {
        $warehouse = ProductWarehouse::where('domain', getDomain())->find($request->input('id'));
        if (!$warehouse) {
            return response()->json(['error' => 'Warehouse not found'], 404);
        }
        $goods = $request->input('goods', []);
        if (is_string($goods)) {
            $goods = preg_split('/\R/', $goods);
        }
        $goods = array_values(array_unique(array_filter(array_map('trim', (array) $goods))));
        if (!$goods) {
            return response()->json(['error' => 'Goods cannot be blank'], 422);
        }
        if (count($goods) > 4500) {
            return response()->json(['error' => 'Maximum 4500 lines can be added at one time'], 422);
        }
        foreach ($goods as $content) {
            ProductGoods::firstOrCreate(['warehouse_id' => $warehouse->id, 'content' => $content], ['used' => false]);
        }
        return response()->json(['success' => true]);
    }

    public function downloadGoods(Request $request)
    {
        $warehouse = ProductWarehouse::where('domain', getDomain())->find($request->input('id'));
        if (!$warehouse) {
            return response()->json(['error' => 'Warehouse not found'], 404);
        }
        return response($warehouse->availableGoods()->pluck('content')->implode("\r\n"), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    public function deleteGoods(Request $request)
    {
        $warehouse = ProductWarehouse::where('domain', getDomain())->find($request->input('id'));
        if (!$warehouse) {
            return response()->json(['error' => 'Warehouse not found'], 404);
        }
        $warehouse->goods()->delete();
        return response()->json(['success' => true]);
    }

    public function syncFor1dg()
    {
        return response()->json(['error' => 'Product synchronization is not configured'], 422);
    }

    public function reorder(Request $request)
    {
        $type  = $request->input('type', 'product');
        $items = $request->input('items', []);

        foreach ($items as $item) {
            if ($type === 'category') {
                \App\Models\ProductCategory::where('id', $item['id'])
                    ->where('domain', getDomain())
                    ->update(['position' => $item['position']]);
            } else {
                \App\Models\Product::where('id', $item['id'])
                    ->where('domain', getDomain())
                    ->update(['position' => $item['position']]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Awaiting,Manual,Pending,In progress,Completed,Partial,Canceled,Failed',
        ]);

        $order = \App\Models\ProductOrder::where('domain', getDomain())->findOrFail($id);
        $newStatus = $request->input('status');

        // Hoàn tiền một phần: validate và trả lại tiền
        if ($newStatus === 'Partial') {
            $remainsInput = $request->input('quantity');
            $remains = ($remainsInput !== null && $remainsInput !== '') ? (int)$remainsInput : null;

            if ($remains === null) {
                return response()->json(['success' => false, 'message' => 'Please input quantity remains'], 422);
            }

            if ($remains < 0 || $remains > (int)$order->quantity) {
                return response()->json(['success' => false, 'message' => 'Invalid quantity remains'], 422);
            }

            // Chỉ hoàn tiền nếu chưa Partial
            if ($order->status !== 'Partial') {
                $refund = (float)$order->charge - (float)$order->amount;
                if ($refund > 0) {
                    $order->user->increment('balance', $refund);
                }
            }
            $order->amount = $remains;
        }

        $order->status = $newStatus;
        $order->save();

        return response()->json(['success' => true]);
    }

    public function updateOrderResult(Request $request, $id)
    {
        $order = \App\Models\ProductOrder::where('domain', getDomain())->findOrFail($id);
        $order->note = $request->input('result', '');
        $order->save();
        return response()->json(['success' => true]);
    }

    public function add()
    {
        $categories = ProductCategory::where('domain', getDomain())
            ->where('status', true)
            ->orderBy('position')
            ->get();

        $groups = ProductGroup::where('domain', getDomain())
            ->orderBy('position')
            ->get();

        $providers = \App\Models\ApiProvider::where('domain', getDomain())
            ->where('status', true)
            ->orderBy('name')
            ->get();

        $warehouses = ProductWarehouse::where('domain', getDomain())->orderBy('position')->get();
        $languages = \App\Models\Language::where('domain', getDomain())
            ->where('status', true)->orderBy('code')->get();

        return view('admin.products.add', compact('categories', 'groups', 'providers', 'warehouses', 'languages'));
    }
}
