<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodGroup;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentMethodController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('PUT')) {
            return $this->handleBulkOperations($request);
        }

        $query = PaymentMethod::query()->withCount('payments')->where('domain', getDomain());

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $paymentMethods = $query->ordered()->get()->map(function ($method) {
            $config = $method->config ? json_decode($method->config) : null;
            $method->currency = $config->currency ?? 'USD';
            $method->bonus = $method->bonus ? json_decode($method->bonus, true) : [];
            $method->config_name = $config->name ?? null;
            $method->account = $config->account ?? null;
            $method->account_name = $config->account_name ?? null;
            return $method;
        });

        $paymentMethodGroups = PaymentMethodGroup::where('domain', getDomain())
            ->orderBy('position')->get();
        $paymentMethodTemplates = PaymentMethod::templates();

        $config = Config::where('domain', getDomain())->first() ?? new Config();

        return view('admin.payment-methods.index', compact('paymentMethods', 'paymentMethodGroups', 'paymentMethodTemplates', 'config'));
    }

    public function create(): View
    {
        return view('admin.payment-methods.create');
    }

    public function history(Request $request): View
    {
        $paymentMethods = PaymentMethod::where('status', 1)->where('domain', getDomain())->get();

        // _payments.historyFunds trong admin.js tải dữ liệu ngày hiện tại bằng AJAX.
        // Không render dữ liệu trước để tránh trang hiển thị hai lần.
        $payments = collect();
        $total = 0;

        return view('admin.payment-methods.history', compact('paymentMethods', 'payments', 'total'));
    }

    public function historyData(Request $request): JsonResponse
    {
        try {
            $startDate = $request->input('start_date', $request->input('start'));
            $endDate = $request->input('end_date', $request->input('end'));
            $methodId = $request->input('method_id', $request->input('pm_id'));

            if ($request->has('draw')) {
                $accountId = $request->input('columns.0.search.value');
                $query = \App\Models\Payment::with(['user:id,username', 'paymentMethod:id,name'])
                    ->where('domain', getDomain())
                    ->latest('created_at');

                if ($accountId !== null && $accountId !== '') {
                    $query->where('user_id', (int) $accountId);
                }
                if ($methodId !== null && $methodId !== '') {
                    $query->where('payment_method_id', (int) $methodId);
                }
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [
                        \Carbon\Carbon::parse($startDate)->startOfDay(),
                        \Carbon\Carbon::parse($endDate)->endOfDay(),
                    ]);
                }

                $recordsFiltered = (clone $query)->count();
                $start = max(0, (int) $request->input('start', 0));
                $length = (int) $request->input('length', 10);
                $length = $length > 0 ? min($length, 100) : 10;
                $payments = $query->skip($start)->take($length)->get();
                $rows = $payments->flatMap(fn ($payment) => $this->historyRows($payment))->values();

                return response()->json([
                    'draw' => (int) $request->input('draw'),
                    'recordsTotal' => $recordsFiltered,
                    'recordsFiltered' => $recordsFiltered,
                    'data' => $rows,
                ]);
            }

            $payments = $this->historyQuery($request, $startDate, $endDate, $methodId)
                ->get()->flatMap(fn ($payment) => $this->historyRows($payment))->values();

            $total = $payments->sum('fund_amount');

            return response()->json([
                'success' => true,
                'list' => $payments,
                'data' => $payments,
                'total' => $total
            ]);
        } catch (\Throwable $e) {
            Log::error('Payment history data fetch failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 400);
        }
    }

    private function historyQuery(Request $request, $startDate = null, $endDate = null, $methodId = null)
    {
        $query = \App\Models\Payment::with(['user:id,username', 'paymentMethod:id,name,domain'])
            ->whereHas('paymentMethod', fn ($q) => $q->where('domain', getDomain()))
            ->latest('created_at');

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [
                \Carbon\Carbon::parse($startDate)->startOfDay(),
                \Carbon\Carbon::parse($endDate)->endOfDay(),
            ]);
        }
        if ($methodId !== null && $methodId !== '') {
            $query->where('payment_method_id', (int) $methodId);
        }
        return $query;
    }

    private function historyRow($payment): array
    {
        return [
            'account_user' => optional($payment->user)->username ?? '—',
            'fund_amount' => (float) ($payment->amount ?? 0),
            'pm_id' => $payment->payment_method_id,
            'pm_name' => optional($payment->paymentMethod)->name ?? '—',
            'fund_created_1' => optional($payment->created_at)->format('Y-m-d H:i:s') ?? '—',
            'fund_details' => $payment->note ?? ($payment->transaction_id ?? ''),
        ];
    }

    private function historyRows($payment): array
    {
        $deposit = [
            'account_id' => $payment->user_id,
            'fund_id' => $payment->id,
            ...$this->historyRow($payment),
        ];

        if ((float) $payment->bonus_amount <= 0) {
            return [$deposit];
        }

        return [
            $deposit,
            [
                'account_id' => $payment->user_id,
                'fund_id' => null,
                'account_user' => optional($payment->user)->username ?? '—',
                'fund_amount' => (float) $payment->bonus_amount,
                // admin.js renders rows with pm_id = 1 using the warning (yellow) amount color.
                'pm_id' => 1,
                'pm_name' => 'Bonus',
                'fund_created_1' => optional($payment->created_at)->format('Y-m-d H:i:s') ?? '—',
                'fund_details' => $payment->note ?? ($payment->transaction_id ?? ''),
            ],
        ];
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $this->normalizeMethodRequest($request);
            // Debug: Log request data
            Log::info('Payment method store request', [
                'all' => $request->all(),
                'has_name' => $request->has('name'),
                'name_value' => $request->input('name')
            ]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'nullable|string|in:bank_vn,binance,payeer,other',
                'method_payment_id' => 'nullable|integer|min:0|max:45',
                'image' => 'nullable|string',
                'min' => 'nullable|integer|min:0',
                'max' => 'nullable|integer|min:0',
                'max_transactions' => 'nullable|integer|min:0',
                'max_total_funds' => 'nullable|numeric|min:0',
                'details' => 'nullable|string',
                'config' => 'nullable|string',
                'bonus' => 'nullable|string'
            ]);

            $paymentMethod = new PaymentMethod();
            $paymentMethod->method_payment_id = $validated['method_payment_id'] ?? null;
            $paymentMethod->name = $validated['name'];
            $paymentMethod->type = $validated['type'] ?? 'other';
            $paymentMethod->image = $validated['image'] ?? null;
            $paymentMethod->min = (int)($validated['min'] ?? 0);
            $paymentMethod->max = (int)($validated['max'] ?? 0);
            $paymentMethod->max_transactions = (int)($validated['max_transactions'] ?? 0);
            $paymentMethod->max_total_funds = (float)($validated['max_total_funds'] ?? 0);
            $paymentMethod->details = $validated['details'] ?? null;
            $paymentMethod->domain = getDomain();
            $paymentMethod->status = 1;
            $paymentMethod->position = (PaymentMethod::where('domain', getDomain())->max('position') ?? 0) + 1;

            // Xử lý config - lưu dưới dạng JSON
            if (!empty($validated['config'])) {
                $configData = is_string($validated['config'])
                    ? json_decode($validated['config'], true)
                    : $validated['config'];

                if (is_array($configData)) {
                    $paymentMethod->config = json_encode($configData, JSON_UNESCAPED_UNICODE);
                } else {
                    $paymentMethod->config = $validated['config'];
                }
            }

            // Xử lý bonus - lưu dưới dạng JSON
            if (!empty($validated['bonus'])) {
                $bonusData = is_string($validated['bonus'])
                    ? json_decode($validated['bonus'], true)
                    : $validated['bonus'];

                if (is_array($bonusData)) {
                    // Chuyển đổi format từ {quantity, percent} sang {min, percent}
                    $formattedBonus = [];
                    foreach ($bonusData as $bonus) {
                        $formattedBonus[] = [
                            'min' => $bonus['quantity'] ?? $bonus['min'] ?? 0,
                            'percent' => $bonus['percent'] ?? 0
                        ];
                    }
                    $paymentMethod->bonus = json_encode($formattedBonus, JSON_UNESCAPED_UNICODE);
                }
            }

            $paymentMethod->save();

            return response()->json([
                'success' => $this->paymentMethodSuccessMessage('created'),
                'message' => $this->paymentMethodSuccessMessage('created'),
                'id' => $paymentMethod->id,
                'data' => $paymentMethod
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Payment method validation failed', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . implode(', ', $e->errors()['name'] ?? ['The name field is required.']),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment method creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 400);
        }
    }

    public function show(PaymentMethod $paymentMethod): JsonResponse
    {
        $paymentMethod->load('payments');

        // Parse bonus từ JSON
        if ($paymentMethod->bonus) {
            try {
                $paymentMethod->bonus = json_decode($paymentMethod->bonus, true);
            } catch (\Exception $e) {
                $paymentMethod->bonus = [];
            }
        }

        // Parse config từ JSON
        if ($paymentMethod->config) {
            try {
                $paymentMethod->config = json_decode($paymentMethod->config, true);
            } catch (\Exception $e) {
                $paymentMethod->config = [];
            }
        }

        return response()->json($paymentMethod);
    }

    /**
     * Adapters for the legacy /request dispatcher used by admin.js.
     */
    public function getMethod(Request $request): JsonResponse
    {
        $paymentMethod = PaymentMethod::findOrFail($request->integer('id'));
        $paymentMethod->load('payments');

        $config = $paymentMethod->parsed_config;
        $bonus = $paymentMethod->bonus;
        if (is_string($bonus)) {
            $bonus = json_decode($bonus, true) ?: [];
        }
        $bonus = collect($bonus)->map(fn ($item) => [
            'q' => $item['q'] ?? $item['quantity'] ?? $item['min'] ?? 0,
            'p' => $item['p'] ?? $item['percent'] ?? 0,
        ])->values()->all();

        // Keep the response compatible with the legacy payment form in admin.js.
        return response()->json(array_merge($paymentMethod->toArray(), [
            'pma_id' => $paymentMethod->method_payment_id,
            'pm_id' => $paymentMethod->id,
            'pm_name' => $paymentMethod->name,
            'pm_icon' => $paymentMethod->image,
            'pm_type' => $paymentMethod->method_payment_id,
            'pm_options' => json_encode($config, JSON_UNESCAPED_UNICODE),
            'pm_options_hide' => json_encode($config['options_hide'] ?? [], JSON_UNESCAPED_UNICODE),
            'pm_bonus' => $bonus ? 1 : 0,
            'pm_bonus_data' => json_encode($bonus, JSON_UNESCAPED_UNICODE),
            'pm_details' => $paymentMethod->details ?? '',
            'pm_rate_usd' => $config['rate_usd'] ?? 1,
            'pm_min' => (int) $paymentMethod->min,
            'pm_max' => (int) $paymentMethod->max,
            'pm_max_transactions_per_day' => (int) ($paymentMethod->max_transactions ?: 0),
            'pm_max_funds_per_day' => (int) ($paymentMethod->max_total_funds ?: 0),
            'min' => (int) $paymentMethod->min,
            'max' => (int) $paymentMethod->max,
            'max_transactions' => (int) $paymentMethod->max_transactions,
            'max_total_funds' => (int) $paymentMethod->max_total_funds,
        ]));
    }

    public function updateFromRequest(Request $request): JsonResponse
    {
        $paymentMethod = PaymentMethod::findOrFail($request->integer('id'));

        return $this->update($request, $paymentMethod);
    }

    public function normalizeMethodRequest(Request $request): void
    {
        if (!$request->has('pma_id')) {
            return;
        }

        $options = json_decode((string) $request->input('options'), true) ?: [];
        $optionsHide = json_decode((string) $request->input('options_hide'), true) ?: [];
        $bonus = collect($request->input('bonus_data', []))->map(fn ($item) => [
            'min' => $item['min'] ?? $item['q'] ?? $item['quantity'] ?? 0,
            'percent' => $item['percent'] ?? $item['p'] ?? 0,
        ])->values()->all();

        $options['options_hide'] = $optionsHide;
        $options['rate_usd'] = (int) $request->input('rate_usd', 1);
        $qrImage = trim((string) $request->input('qr_image', $options['qr_image'] ?? ''));
        if ($qrImage !== '') {
            $options['qr_image'] = $qrImage;
        }
        $template = PaymentMethod::template($request->integer('pma_id'));
        $options['currency'] = $template['currency'] ?? $request->input('currency', 'USD');
        $templateCode = strtolower((string) ($template['code'] ?? ''));
        $type = str_contains($templateCode, 'binance')
            ? PaymentMethod::TYPE_BINANCE
            : (str_contains($templateCode, 'bank') || str_contains($templateCode, 'sieuthicode')
                ? PaymentMethod::TYPE_BANK_VN
                : ($request->input('type') ?: PaymentMethod::TYPE_OTHER));

        $request->merge([
            'method_payment_id' => $request->integer('pma_id'),
            'type' => $type,
            'image' => $request->input('icon'),
            'currency' => $template['currency'] ?? 'USD',
            'config' => json_encode($options, JSON_UNESCAPED_UNICODE),
            'bonus' => json_encode($bonus, JSON_UNESCAPED_UNICODE),
        ]);
    }

    public function destroyFromRequest(Request $request): JsonResponse
    {
        $paymentMethod = PaymentMethod::findOrFail($request->integer('id'));

        return $this->destroy($paymentMethod);
    }

    public function toggleStatusFromRequest(Request $request): JsonResponse
    {
        $paymentMethod = PaymentMethod::findOrFail($request->integer('id'));

        if ($request->has('status')) {
            $paymentMethod->status = (bool) $request->input('status');
            $paymentMethod->save();

            return response()->json([
                'success' => true,
                'status' => $paymentMethod->status ? 1 : 0,
                'message' => 'Payment method status updated successfully',
            ]);
        }

        return $this->toggleStatus($paymentMethod);
    }

    public function sortFromRequest(Request $request): JsonResponse
    {
        $items = $request->input('dataSort', $request->input('payment_methods', []));
        $items = collect($items)->map(function ($item, $position) {
            return [
                'id' => (int) (is_array($item) ? ($item['id'] ?? $item['i'] ?? 0) : $item),
                'position' => (int) (is_array($item) ? ($item['position'] ?? $item['s'] ?? $position + 1) : $position + 1),
            ];
        })->filter(fn ($item) => $item['id'] > 0)->values()->all();

        foreach ($items as $item) {
            PaymentMethod::where('id', $item['id'])
                ->where('domain', getDomain())
                ->update(['position' => $item['position']]);
        }

        return response()->json(['success' => true, 'message' => adminMessage('update')]);
    }

    public function getGroupFromRequest(Request $request): JsonResponse
    {
        return $this->showGroup($request->integer('id'));
    }

    public function storeGroupFromRequest(Request $request): JsonResponse
    {
        return $this->storeGroup($request);
    }

    public function updateGroupFromRequest(Request $request): JsonResponse
    {
        return $this->updateGroupMethods($request, $request->integer('id'));
    }

    public function deleteGroupFromRequest(Request $request): JsonResponse
    {
        return $this->deleteGroup($request->integer('id'));
    }

    public function update(Request $request, PaymentMethod $paymentMethod): JsonResponse
    {
        try {
            $this->normalizeMethodRequest($request);
            Log::info('Payment method update request', [
                'method_id' => $paymentMethod->id,
                'content_type' => $request->header('Content-Type'),
                'is_json' => $request->isJson(),
                'all' => $request->all()
            ]);

            // Validate dữ liệu
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'type' => 'nullable|string|in:bank_vn,binance,payeer,other',
                'method_payment_id' => 'nullable|integer|min:0|max:45',
                'image' => 'nullable|string',
                'min' => 'nullable|integer|min:0',
                'max' => 'nullable|integer|min:0',
                'max_transactions' => 'nullable|integer|min:0',
                'max_total_funds' => 'nullable|numeric|min:0',
                'details' => 'nullable|string',
                'config' => 'nullable|string',
                'bonus' => 'nullable|string'
            ]);

            // Cập nhật các field cơ bản
            $paymentMethod->name = $validated['name'];
            $paymentMethod->method_payment_id = $validated['method_payment_id'] ?? $paymentMethod->method_payment_id;
            // Chỉ cập nhật type nếu được gửi từ form, nếu không giữ type cũ
            if (!empty($validated['type'])) {
                $paymentMethod->type = $validated['type'];
            }
            $paymentMethod->image = $validated['image'] ?? $paymentMethod->image;
            $paymentMethod->min = (int)($validated['min'] ?? 0);
            $paymentMethod->max = (int)($validated['max'] ?? 0);
            $paymentMethod->max_transactions = (int)($validated['max_transactions'] ?? 0);
            $paymentMethod->max_total_funds = (float)($validated['max_total_funds'] ?? 0);
            $paymentMethod->details = $validated['details'] ?? null;

            // Xử lý config - merge với config cũ để không mất các key hiện có
            if (!empty($validated['config'])) {
                $newConfigData = is_string($validated['config'])
                    ? json_decode($validated['config'], true)
                    : $validated['config'];

                if (is_array($newConfigData)) {
                    $oldConfigData = [];
                    if ($paymentMethod->config) {
                        $decoded = is_string($paymentMethod->config)
                            ? json_decode($paymentMethod->config, true)
                            : $paymentMethod->config;
                        if (is_array($decoded)) {
                            $oldConfigData = $decoded;
                        }
                    }
                    // Giữ key cũ nếu key mới rỗng, ghi đè nếu key mới có giá trị
                    $mergedConfig = $oldConfigData;
                    foreach ($newConfigData as $key => $value) {
                        if ($value !== '' && $value !== null) {
                            $mergedConfig[$key] = $value;
                        } elseif (!isset($mergedConfig[$key])) {
                            $mergedConfig[$key] = $value;
                        }
                    }
                    $paymentMethod->config = json_encode($mergedConfig, JSON_UNESCAPED_UNICODE);
                } else {
                    $paymentMethod->config = $validated['config'];
                }
            }

            // Xử lý bonus - lưu dưới dạng JSON
            if (!empty($validated['bonus'])) {
                $bonusData = is_string($validated['bonus'])
                    ? json_decode($validated['bonus'], true)
                    : $validated['bonus'];

                if (is_array($bonusData)) {
                    // Chuyển đổi format từ {quantity, percent} sang {min, percent}
                    $formattedBonus = [];
                    foreach ($bonusData as $bonus) {
                        $formattedBonus[] = [
                            'min' => $bonus['quantity'] ?? $bonus['min'] ?? 0,
                            'percent' => $bonus['percent'] ?? 0
                        ];
                    }
                    $paymentMethod->bonus = json_encode($formattedBonus, JSON_UNESCAPED_UNICODE);
                }
            }

            $paymentMethod->save();

            return response()->json([
                'success' => $this->paymentMethodSuccessMessage('updated'),
                'message' => $this->paymentMethodSuccessMessage('updated'),
                'id' => $paymentMethod->id,
                'data' => $paymentMethod
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Payment method validation failed', [
                'method_id' => $paymentMethod->id,
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . implode(', ', $e->errors()['name'] ?? ['The name field is required.']),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Payment method update failed', [
                'method_id' => $paymentMethod->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Lỗi: ' . $e->getMessage()
            ], 400);
        }
    }

    private function paymentMethodSuccessMessage(string $action): string
    {
        if (Auth::user()?->lang === 'vi') {
            return $action === 'created'
                ? 'Thêm phương thức thanh toán thành công.'
                : 'Cập nhật phương thức thanh toán thành công.';
        }

        return $action === 'created'
            ? 'Payment method created successfully.'
            : 'Payment method updated successfully.';
    }

    public function destroy(PaymentMethod $paymentMethod): JsonResponse
    {
        if (!$paymentMethod->canDelete()) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa phương thức thanh toán này vì đang có thanh toán liên quan!'
            ], 400);
        }

        // Delete image
        if ($paymentMethod->image && !filter_var($paymentMethod->image, FILTER_VALIDATE_URL)) {
            Storage::disk('public')->delete('payment-methods/' . $paymentMethod->image);
        }

        $paymentMethod->delete();

        return response()->json([
            'success' => true,
            'message' => 'Phương thức thanh toán đã được xóa thành công!'
        ]);
    }

    public function toggleStatus(PaymentMethod $paymentMethod): JsonResponse
    {
        $paymentMethod->toggleStatus();

        return response()->json([
            'success' => true,
            'status' => $paymentMethod->status ? 1 : 0,
            'message' => 'Trạng thái đã được cập nhật thành công!'
        ]);
    }

    public function handleBulkOperations(Request $request): JsonResponse
    {
        try {
            if ($request->has('action') && $request->action === 'reorder') {
                $validated = $request->validate([
                    'payment_methods' => 'required|array',
                    'payment_methods.*.id' => 'required|exists:payment_methods,id',
                    'payment_methods.*.position' => 'required|integer|min:0'
                ]);

                foreach ($validated['payment_methods'] as $methodData) {
                    PaymentMethod::where('id', $methodData['id'])
                        ->where('domain', getDomain())
                        ->update(['position' => $methodData['position']]);
                }

                Log::info('Payment method positions updated', [
                    'payment_methods' => $validated['payment_methods']
                ]);

                return response()->json([
                    'success' => true,
                    'message' => adminMessage('update')
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi xử lý yêu cầu!'
            ], 400);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Reorder validation failed', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Reorder failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật vị trí: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateAnnouncement(Request $request)
    {
        try {
            $config = Config::where('domain', getDomain())->first() ?? Config::create(['domain' => getDomain()]);

            $validated = $request->validate([
                'announcement_content' => 'nullable|string',
                'announcement_status' => 'nullable|integer|in:0,1'
            ]);

            $updateData = [];

            // Update status if provided
            if ($request->has('announcement_status')) {
                $updateData['announcement_status'] = $validated['announcement_status'];
                Log::info('Updating announcement_status', [
                    'status' => $validated['announcement_status'],
                    'domain' => getDomain()
                ]);
            }

            // Update content if provided and not empty
            if ($request->has('announcement_content') && !empty($validated['announcement_content'])) {
                $updateData['announcement_content'] = $validated['announcement_content'];
                Log::info('Updating announcement_content', [
                    'content_length' => strlen($validated['announcement_content']),
                    'domain' => getDomain()
                ]);
            }

            // Only update if there's data to update
            if (!empty($updateData)) {
                $config->update($updateData);
            }

            return response()->json([
                'success' => true,
                'message' => 'Announcement updated successfully',
                'data' => $config,
                'updated_fields' => array_keys($updateData)
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Announcement validation failed', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . implode(', ', $e->errors()['announcement_status'] ?? ['Invalid data']),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error updating announcement', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error updating announcement: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateAddfundContent(Request $request)
    {
        try {
            $config = Config::where('domain', getDomain())->first() ?? Config::create(['domain' => getDomain()]);

            $validated = $request->validate([
                'addfund_content' => 'nullable|string'
            ]);

            $config->update([
                'addfund_content' => $validated['addfund_content'] ?? $config->addfund_content
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Add fund content updated successfully',
                'data' => $config
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating add fund content', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error updating add fund content: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==========================================
    // Payment Method Groups
    // ==========================================

    /**
     * Get group data by ID
     */
    public function showGroup($id): JsonResponse
    {
        $group = PaymentMethodGroup::where('domain', getDomain())->find($id);

        if (!$group) {
            return response()->json(['message' => 'Group not found'], 404);
        }

        $methods = $group->methods;
        if (is_string($methods)) {
            $methods = json_decode($methods, true) ?: [];
        }
        $methods = array_values(array_map('strval', (array) $methods));

        return response()->json([
            'id' => $group->id,
            'name' => $group->name,
            'methods' => $methods,
            'group_name' => $group->name,
            'pm' => $methods,
            'selected_methods' => $methods,
        ]);
    }

    /**
     * Store a new payment method group
     */
    public function storeGroup(Request $request): JsonResponse
    {
        try {
            $methods = $request->input('methods', $request->input('pm', []));
            $request->merge(['methods' => is_string($methods) ? (json_decode($methods, true) ?: []) : $methods]);
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'methods' => 'required|array|min:1',
                'methods.*' => 'integer|exists:payment_methods,id',
            ]);

            $group = PaymentMethodGroup::create([
                'name' => $validated['name'],
                'methods' => array_map('intval', $validated['methods']),
                'domain' => getDomain(),
            ]);

            return response()->json([
                'success' => 'Payment method group created successfully',
                'message' => 'Group created successfully',
                'data' => $group,
            ]);
        } catch (\Exception $e) {
            Log::error('Error creating payment method group', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a payment method group
     */
    public function updateGroupMethods(Request $request, $id): JsonResponse
    {
        try {
            $group = PaymentMethodGroup::where('domain', getDomain())->findOrFail($id);
            $methods = $request->input('methods', $request->input('pm', []));
            $request->merge(['methods' => is_string($methods) ? (json_decode($methods, true) ?: []) : $methods]);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'methods' => 'required|array|min:1',
                'methods.*' => 'integer|exists:payment_methods,id',
            ]);

            $group->update([
                'name' => $validated['name'],
                'methods' => array_map('intval', $validated['methods']),
            ]);

            return response()->json([
                'success' => 'Payment method group updated successfully',
                'message' => 'Group updated successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating payment method group', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a payment method group
     */
    public function deleteGroup($id): JsonResponse
    {
        try {
            $group = PaymentMethodGroup::where('domain', getDomain())->findOrFail($id);
            $group->delete();

            return response()->json([
                'success' => true,
                'message' => 'Group deleted successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting payment method group', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
