<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\ActivityLog;
use App\Models\Transaction;
use App\Models\Currency;
use App\Models\CustomRate;
use App\Models\UserCustomRate;
use App\Models\Service;
use App\Models\Affiliate;
use App\Models\Config;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     * Handles search, filter, and bulk operations
     */
    public function index(Request $request)
    {
        // Handle bulk operations
        if ($request->has('bulk_action') && $request->has('user_ids')) {
            return $this->handleBulkAction($request);
        }

        // Build query with search and filters
        $query = User::where('domain', $request->getHost());

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by level
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Select only needed columns for better performance
        $users = $query
            ->select('id', 'name', 'email', 'username', 'phone', 'is_active', 'role', 'level', 'balance', 'created_at')
            ->paginate(15);

        // Load bonus amount for each user
        if (class_exists('App\Models\Transaction')) {
            foreach ($users as $user) {
                $user->bonus_amount = Transaction::where('user_id', $user->id)
                    ->where('type', 'bonus')
                    ->sum('amount');
            }
        }

        // Calculate total deposit and bonus from payments table
        $totalDeposit = 0;
        $totalBonus = 0;

        try {
            if (class_exists('App\Models\Payment')) {
                // Get total deposit amount from payments table where status is completed
                $totalDeposit = Payment::where('status', 'completed')->sum('amount');
                // Get total bonus amount from payments table where status is completed
                $totalBonus = Payment::where('status', 'completed')->sum('bonus_amount');
            }
        } catch (\Exception $e) {
            // If payment table doesn't exist, use default values
            $totalDeposit = 0;
            $totalBonus = 0;
        }

        return $request->expectsJson()
            ? response()->json(['success' => true, 'data' => $users])
            : view('adminpanel.accounts.index', compact('users', 'totalDeposit', 'totalBonus'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'nullable|string|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'level' => 'nullable|in:retail,agent,distributor',
            'balance' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['username'] = $validated['username'] ?? str_replace(' ', '_', strtolower($validated['name']));
        $validated['is_active'] = $request->boolean('is_active');
        $validated['domain'] = $request->getHost();

        $user = User::create($validated);

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => 'Tạo thành viên thành công!', 'user' => $user])
            : redirect()->route('admin.users.index')->with('success', 'Tạo thành viên thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function payment(Request $request, $username)
    {
        $accounts = User::where('id', $username)->orWhere('username', $username)->firstOrFail();

        // Build query with filter - get payment history from payments table
        $query = Payment::where('user_id', $accounts->id)
            ->with('paymentMethod');

        // Date range filter - use default if not provided
        $dateFrom = $request->date_from ?? now()->startOfMonth()->format('Y/m/d');
        $dateTo = $request->date_to ?? now()->endOfMonth()->format('Y/m/d');

        $query->where('created_at', '>=', $dateFrom . ' 00:00:00');
        $query->where('created_at', '<=', $dateTo . ' 23:59:59');

        $trans = $query->latest('created_at')->paginate(10);

        // If AJAX request, return JSON
        if ($request->expectsJson()) {
            // Return clean data instead of HTML
            $paymentData = $trans->map(function ($pay) {
                return [
                    'created_at' => $pay->created_at?->format('Y-m-d H:i:s') ?? '',
                    'amount' => $pay->amount,
                    'amount_formatted' => formatCharge($pay->amount),
                    'payment_method' => $pay->paymentMethod?->name ?? 'N/A',
                    'note' => $pay->note ?? '',
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $paymentData,
                'pagination' => [
                    'current_page' => $trans->currentPage(),
                    'last_page' => $trans->lastPage(),
                    'total' => $trans->total(),
                    'per_page' => $trans->perPage(),
                ]
            ]);
        }

        // For non-AJAX requests, don't load data initially - let JavaScript load it
        $trans = collect();

        $stats = [
            'totalDeposit' => Payment::where('user_id', $accounts->id)
                ->where('status', 'completed')
                ->sum('total_amount'),
            'totalSpent' => $accounts->transactions()->where('type', 'spent')->sum('amount') ?? 0,
            'totalBonus' => Payment::where('user_id', $accounts->id)
                ->where('status', 'completed')
                ->sum('bonus_amount'),
            'canRefund' => (float) $accounts->balance,
        ];

        $lastLogin = ActivityLog::where('user_id', $accounts->id)
            ->where('type', 'login')
            ->latest('created_at')
            ->first();

        // Get VND exchange rate from currency table
        $vndRate = 25000; // Default rate
        try {
            // Try to get from currency table if it exists
            if (class_exists('App\Models\Currency')) {
                $currency = Currency::where('code', 'VND')->first();
                if ($currency && isset($currency->exchange_rate)) {
                    // Format rate to remove trailing zeros
                    $vndRate = (int) $currency->exchange_rate;
                }
            }
        } catch (\Exception $e) {
            // If currency table doesn't exist or error occurs, use default
            $vndRate = 25000;
        }

        // Store search params for view
        $searchParams = [
            'date_from' => $request->date_from ?? now()->startOfMonth()->format('Y/m/d'),
            'date_to' => $request->date_to ?? now()->endOfMonth()->format('Y/m/d'),
        ];

        // Get active payment methods for dropdown and display
        $payments = PaymentMethod::where('status', true)
            ->ordered()
            ->get()
            ->map(function ($method) {
                // Add exchange rate from Currency table if currency is VND
                if ($method->currency === 'VND') {
                    try {
                        if (class_exists('App\Models\Currency')) {
                            $currency = Currency::where('code', 'VND')->first();
                            if ($currency && isset($currency->exchange_rate)) {
                                $method->exchange_rate = (float) $currency->exchange_rate;
                            } else {
                                $method->exchange_rate = 25000; // Default rate
                            }
                        } else {
                            $method->exchange_rate = 25000;
                        }
                    } catch (\Exception $e) {
                        $method->exchange_rate = 25000;
                    }
                } else {
                    $method->exchange_rate = 1; // Default rate for other currencies
                }
                return $method;
            });

        // Build payment options array for view
        $paymentOptions = [
            [
                'value' => 'bonus',
                'icon' => 'https://cdn-icons-png.flaticon.com/512/5622/5622939.png',
                'currency' => 'USD',
                'rate' => 1,
                'name' => 'Bonus',
                'lang_key' => 'Bonus'
            ]
        ];

        // Add payment methods to options
        foreach ($payments as $payment) {
            $paymentOptions[] = [
                'value' => $payment->id,
                'icon' => $payment->image,
                'currency' => $payment->currency,
                'rate' => $payment->exchange_rate ?? 1,
                'name' => $payment->name,
                'lang_key' => $payment->name
            ];
        }

        return view('adminpanel.accounts.payment', [
            'accounts' => $accounts,
            'trans' => $trans,
            'lastLogin' => $lastLogin,
            'searchParams' => $searchParams,
            'vndRate' => $vndRate,
            'payments' => $payments,
            'paymentOptions' => $paymentOptions,
            'totalDeposit' => $stats['totalDeposit'],
            'totalSpent' => $stats['totalSpent'],
            'totalBonus' => $stats['totalBonus'],
            'canRefund' => $stats['canRefund'],
        ]);
    }

    /**
     * Display the specified resource (generic show)
     */
    public function show(Request $request, $username)
    {
        return $this->payment($request, $username);
    }

    /**
     * Display custom rates for an account
     */
    public function customRates(Request $request, $username)
    {
        $account   = User::where('username', $username)->firstOrFail();
        $lastLogin = ActivityLog::where('user_id', $account->id)->where('type', 'login')->latest('created_at')->first();
        $services  = Service::where('status', true)->where('domain', getDomain())->get();

        return view('adminpanel.accounts.customrates', compact('account', 'lastLogin', 'services'));
    }

    /**
     * List custom rates (AJAX)
     */
    public function customRatesList(Request $request, $username)
    {
        $account = User::where('username', $username)->firstOrFail();

        $rates = UserCustomRate::where('user_id', $account->id)
            ->where('domain', getDomain())
            ->where('service_id', '!=', -1)
            ->with('service')
            ->get()
            ->map(function ($r) {
                $name = $r->service_id == -1
                    ? 'All active services'
                    : ($r->service ? (is_array($r->service->name) ? ($r->service->name['en'] ?? reset($r->service->name)) : $r->service->name) : '#' . $r->service_id);

                return [
                    'id'         => $r->id,
                    'service_id' => $r->service_id,
                    'name'       => $name,
                    'rate'       => $r->rate,
                    'percent'    => $r->percent,
                    'orate'      => $r->service?->rate_retail ?? null,
                ];
            });

        return response()->json(['success' => true, 'data' => $rates]);
    }

    /**
     * Store / update a custom rate (AJAX)
     */
    public function customRatesStore(Request $request, $username)
    {
        $account = User::where('username', $username)->firstOrFail();

        $request->validate([
            'service_id' => 'required|integer',
            'mode'       => 'required|in:1,2',
            'rate'       => 'nullable|numeric|min:0',
            'percent'    => 'nullable|numeric|min:1|max:999',
        ]);

        $serviceId = (int) $request->service_id;
        $domain    = getDomain();
        $rateVal   = $request->mode == 1 ? $request->rate   : null;
        $pctVal    = $request->mode == 2 ? $request->percent : null;

        if ($serviceId == -1) {
            // Apply to all active services
            Service::where('status', true)->where('domain', $domain)->pluck('id')->each(function ($sid) use ($account, $domain, $rateVal, $pctVal) {
                UserCustomRate::updateOrCreate(
                    ['user_id' => $account->id, 'service_id' => $sid, 'domain' => $domain],
                    ['rate' => $rateVal, 'percent' => $pctVal]
                );
            });
            // Store -1 record as reference
            UserCustomRate::updateOrCreate(
                ['user_id' => $account->id, 'service_id' => -1, 'domain' => $domain],
                ['rate' => $rateVal, 'percent' => $pctVal]
            );
        } else {
            UserCustomRate::updateOrCreate(
                ['user_id' => $account->id, 'service_id' => $serviceId, 'domain' => $domain],
                ['rate' => $rateVal, 'percent' => $pctVal]
            );
        }

        return response()->json(['success' => true, 'message' => 'Custom rate created']);
    }

    /**
     * Delete custom rate(s) (AJAX)
     */
    public function customRatesDestroy(Request $request, $username)
    {
        $account = User::where('username', $username)->firstOrFail();

        $request->validate([
            'ids'   => 'sometimes|array',
            'ids.*' => 'integer',
            'all'   => 'sometimes|boolean',
        ]);

        $query = UserCustomRate::where('user_id', $account->id)->where('domain', getDomain());

        if ($request->boolean('all')) {
            $query->delete();
        } elseif ($request->filled('ids')) {
            $query->whereIn('id', $request->ids)->delete();
        }

        return response()->json(['success' => true, 'message' => 'Deleted custom success']);
    }

    /**
     * Display sign-in history for an account
     */
    public function signInHistory(Request $request, $username)
    {
        $account = User::where('username', $username)->firstOrFail();
        $lastLogin = ActivityLog::where('user_id', $account->id)
            ->where('type', 'login')
            ->latest('created_at')
            ->first();

        // Get login history
        $loginHistory = ActivityLog::where('user_id', $account->id)
            ->where('type', 'login')
            ->latest('created_at')
            ->paginate(20)
            ->map(function ($log) {
                // Parse activity JSON if it's a string
                if (is_string($log->activity)) {
                    $log->activity = json_decode($log->activity, true);
                }
                return $log;
            });

        return view('adminpanel.accounts.signinhistory', [
            'account' => $account,
            'loginHistory' => $loginHistory,
            'lastLogin' => $lastLogin,
        ]);
    }

    /**
     * Display transactions for an account
     */
    public function transactions(Request $request, $username)
    {
        $account = User::where('username', $username)->firstOrFail();
        $lastLogin = ActivityLog::where('user_id', $account->id)
            ->where('type', 'login')
            ->latest('created_at')
            ->first();

        // Build query with filters
        $query = $account->transactions();

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from . ' 00:00:00');
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        $transactions = $query->latest('created_at')->paginate(20);

        // Calculate totals
        $totals = [
            'deposit' => $account->transactions()->where('type', 'deposit')->sum('amount'),
            'withdraw' => $account->transactions()->where('type', 'withdraw')->sum('amount'),
            'spent' => $account->transactions()->where('type', 'spent')->sum('amount'),
            'bonus' => $account->transactions()->where('type', 'bonus')->sum('amount'),
        ];

        return view('adminpanel.accounts.transactions', [
            'account' => $account,
            'transactions' => $transactions,
            'totals' => $totals,
            'lastLogin' => $lastLogin,
        ]);
    }

    /**
     * Display affiliates for an account
     */
    public function affiliates(Request $request, $username)
    {
        $account = User::where('username', $username)->firstOrFail();
        $lastLogin = ActivityLog::where('user_id', $account->id)
            ->where('type', 'login')
            ->latest('created_at')
            ->first();

        // Get affiliates from the affiliates table where this user is the referrer
        $affiliates = Affiliate::where('referrer_id', $account->id)
            ->with('referred')
            ->latest('created_at')
            ->paginate(20);

        // Calculate affiliate stats
        $stats = [
            'total_affiliates' => Affiliate::where('referrer_id', $account->id)->count(),
            'active_affiliates' => Affiliate::where('referrer_id', $account->id)
                ->where('status', 'active')
                ->count(),
            'total_affiliate_earnings' => Affiliate::where('referrer_id', $account->id)
                ->sum('total_earned'),
        ];

        return view('adminpanel.accounts.affiliates', [
            'account' => $account,
            'affiliates' => $affiliates,
            'stats' => $stats,
            'lastLogin' => $lastLogin,
        ]);
    }

    /**
    /**
     * Update the specified resource in storage.
     * Handles status toggle, quick updates, bulk operations, and form updates
     */
    public function update(Request $request, $accounts = null)
    {
        // Handle bulk operations
        if ($request->has('bulk_action') && $request->has('user_ids')) {
            return $this->handleBulkAction($request);
        }

        // Find user by username or ID
        $user = null;
        if ($accounts) {
            $user = User::where('username', $accounts)
                ->orWhere('id', $accounts)
                ->first();
        }

        // Handle status toggle (from status-switch component)
        if ($request->has('toggle_status')) {
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy thành viên!'], 404);
            }

            $status = (bool) $request->input('status', 0);
            $entityId = $request->input('entity_id', $user->id);

            // Ensure entityId is not null or empty
            if (empty($entityId)) {
                $entityId = $user->id;
            }

            if ($user->is_active !== $status) {
                $user->update(['is_active' => $status]);
                $message = $status
                    ? "Kích hoạt thành viên ID #{$entityId} thành công!"
                    : "Vô hiệu hóa thành viên ID #{$entityId} thành công!";

                // \Log::info('User status toggled', [
                //     'user_id' => $user->id,
                //     'entity_id' => $entityId,
                //     'old_status' => !$status,
                //     'new_status' => $status
                // ]);
            } else {
                $message = "Trạng thái thành viên ID #{$entityId} không thay đổi!";
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $status,
                'entity_id' => $entityId,
                'user' => $user->fresh()
            ]);
        }

        // Handle quick field update (from quick-edit component)
        if ($request->has('field')) {
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy thành viên!'], 404);
            }

            $field = $request->input('field');
            $value = $request->input('value');

            // Define allowed fields for quick update
            $allowedFields = [
                'is_active' => 'boolean',
                'role' => ['user', 'admin'],
                'level' => ['retail', 'agent', 'distributor', null],
                'balance' => 'numeric'
            ];

            if (!array_key_exists($field, $allowedFields)) {
                return response()->json(['success' => false, 'message' => 'Trường không được phép cập nhật!'], 400);
            }

            $oldValue = $user->{$field};

            try {
                switch ($field) {
                    case 'is_active':
                        $value = (bool) $value;
                        break;
                    case 'role':
                        if (!in_array($value, $allowedFields[$field])) {
                            throw new \InvalidArgumentException('Role không hợp lệ!');
                        }
                        break;
                    case 'level':
                        if ($value !== null && !in_array($value, $allowedFields[$field])) {
                            throw new \InvalidArgumentException('Level không hợp lệ!');
                        }
                        break;
                    case 'balance':
                        $value = (float) $value;
                        if ($value < 0) {
                            throw new \InvalidArgumentException('Số dư không được âm!');
                        }
                        break;
                }

                if ($oldValue != $value) {
                    $user->update([$field => $value]);

                    // \Log::info('User field updated', [
                    //     'user_id' => $user->id,
                    //     'field' => $field,
                    //     'old_value' => $oldValue,
                    //     'new_value' => $value
                    // ]);

                    $message = 'Cập nhật thành công!';
                } else {
                    $message = 'Giá trị không thay đổi!';
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'field' => $field,
                    'old_value' => $oldValue,
                    'new_value' => $value,
                    'user' => $user->fresh()
                ]);
            } catch (\InvalidArgumentException $e) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            } catch (\Exception $e) {
                // \Log::error('Quick update failed', [
                //     'user_id' => $user->id,
                //     'field' => $field,
                //     'value' => $value,
                //     'error' => $e->getMessage()
                // ]);

                return response()->json(['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật!'], 500);
            }
        }

        // Handle regular form update
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy thành viên!'], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'username' => 'sometimes|nullable|string|max:255|unique:users,username,' . $user->id,
            'phone' => 'sometimes|nullable|string|max:20',
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'role' => 'sometimes|required|in:user,admin',
            'level' => 'sometimes|nullable|in:retail,agent,distributor',
            'balance' => 'sometimes|nullable|numeric|min:0',
            'is_active' => 'sometimes|boolean',
            'bonus_percent' => 'sometimes|nullable|numeric|min:0|max:100',
        ]);

        // Prepare data for update - only include changed fields
        $updateData = [];
        $originalUser = $user->getOriginal();

        foreach ($validated as $field => $value) {
            if ($field === 'password') {
                if ($request->filled('password')) {
                    $updateData['password'] = bcrypt($value);
                }
                continue;
            }

            if ($field === 'is_active') {
                $value = $request->boolean('is_active');
            }

            // Check if field exists in original user data before comparing
            if (!array_key_exists($field, $originalUser) || $originalUser[$field] != $value) {
                $updateData[$field] = $value;
            }
        }

        if (!empty($updateData)) {
            $user->update($updateData);
            $message = 'Cập nhật thành viên thành công!';

            // \Log::info('User updated', [
            //     'user_id' => $user->id,
            //     'updated_fields' => array_keys($updateData),
            //     'changes' => $updateData
            // ]);
        } else {
            $message = 'Không có thay đổi nào để cập nhật!';
        }

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => $message, 'user' => $user->fresh(), 'updated_fields' => array_keys($updateData ?? [])])
            : redirect()->route('admin.users.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     * Handles single and bulk delete
     */
    public function destroy(Request $request, User $user = null)
    {
        // Handle bulk delete
        if ($request->has('bulk_action') && $request->has('user_ids')) {
            return $this->handleBulkAction($request);
        }

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Không tìm thấy thành viên!'], 404);
        }

        $userName = $user->name;
        $user->delete();

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => "Đã xóa thành viên {$userName} thành công!"])
            : redirect()->route('admin.users.index')->with('success', "Đã xóa thành viên {$userName} thành công!");
    }

    /**
     * Update user balance
     */
    public function updateBalance(Request $request, $accounts)
    {
        // Get user by ID or username
        $user = User::where('id', $accounts)->orWhere('username', $accounts)->firstOrFail();

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:deposit,withdraw,bonus',
            'payment_method' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'payment_id' => 'nullable|exists:payment_methods,id'
        ]);

        $oldBalance = $user->balance;
        $amount = abs($validated['amount']);

        if ($validated['type'] === 'deposit' || $validated['type'] === 'bonus') {
            $user->balance += $amount;
            $transactionType = $validated['type'];
        } else {
            if ($user->balance < $amount) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số dư không đủ để rút!'
                ], 400);
            }
            $user->balance -= $amount;
            $transactionType = 'withdraw';
        }

        $user->save();

        $transactionId = 'ADMIN-' . time() . '-' . $user->id;

        // Create payment record in payments table
        try {
            if (class_exists('App\Models\Payment') && class_exists('App\Models\PaymentMethod')) {
                // Xác định payment method
                $paymentMethodId = null;

                if ($validated['payment_id']) {
                    // Nếu user chọn payment method cụ thể
                    $paymentMethodId = $validated['payment_id'];
                } else {
                    // Tìm hoặc tạo payment method cho admin action
                    $adminMethod = PaymentMethod::where('name', 'Bonus')
                        ->where('type', 'other')
                        ->first();

                    if (!$adminMethod) {
                        $adminMethod = PaymentMethod::create([
                            'name' => 'Bonus',
                            'type' => 'other',
                            'image' => null,
                            'position' => PaymentMethod::getNextPosition(),
                            'status' => true,
                            'domain' => getDomain()
                        ]);
                    }

                    $paymentMethodId = $adminMethod->id;
                }

                // Chuẩn bị dữ liệu payment
                $paymentData = [
                    'user_id' => $user->id,
                    'payment_method_id' => $paymentMethodId,
                    'transaction_id' => $transactionId,
                    'amount' => $transactionType === 'bonus' ? 0 : $amount,
                    'bonus_amount' => $transactionType === 'bonus' ? $amount : 0,
                    'total_amount' => $amount,
                    'currency' => 'USD',
                    'exchange_rate' => 1,
                    'status' => 'completed',
                    'note' => $validated['description'] ?? "Admin {$transactionType} action",
                    'payment_info' => [
                        'method' => $validated['payment_method'] ?? 'Bonus',
                        'type' => $transactionType,
                        'admin_action' => true,
                        'admin_note' => $validated['description'] ?? null
                    ],
                    'domain' => getDomain()
                ];

                Payment::create($paymentData);
            }
        } catch (\Exception $e) {
            // \Log::error('Failed to create payment record', [
            //     'user_id' => $user->id,
            //     'error' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString()
            // ]);
        }

        // Log update balance
        // \Log::info('=== ADMIN UPDATE BALANCE ===', [
        //     'admin'            => auth()->user()?->username ?? 'system',
        //     'target_user'      => ['id' => $user->id, 'username' => $user->username],
        //     'type'             => $transactionType,
        //     'amount'           => $amount,
        //     'old_balance'      => $oldBalance,
        //     'new_balance'      => $user->balance,
        //     'transaction_id'   => $transactionId,
        //     'description'      => $validated['description'] ?? null,
        // ]);

        // Xử lý affiliate commission khi deposit hoặc bonus
        if ($transactionType === 'deposit' || $transactionType === 'bonus') {
            \App\Services\AffiliateService::handleDeposit($user->id, $amount, $transactionId);
        }

        $typeLabel = $transactionType === 'bonus' ? 'Thưởng' : ($transactionType === 'deposit' ? 'Nạp' : 'Rút');

        return response()->json([
            'success'     => true,
            'message'     => "{$typeLabel} \${$amount} thành công!",
            'old_balance' => $oldBalance,
            'new_balance' => $user->balance,
            'user'        => $user->fresh(),
        ]);
    }

    /**
     * Handle bulk actions (private method)
     */
    private function handleBulkAction(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'bulk_action' => 'required|string|in:activate,deactivate,delete,update_role,update_level',
            'bulk_data' => 'sometimes|array'
        ]);

        $userIds = $validated['user_ids'];
        $action = $validated['bulk_action'];
        $bulkData = $validated['bulk_data'] ?? [];

        try {
            $updatedCount = 0;
            $processedIds = [];

            switch ($action) {
                case 'activate':
                    // Get users that actually need to be updated (not already active)
                    $usersToUpdate = User::whereIn('id', $userIds)->where('is_active', false)->pluck('id')->toArray();
                    if (!empty($usersToUpdate)) {
                        $updatedCount = User::whereIn('id', $usersToUpdate)->update(['is_active' => true]);
                        $processedIds = $usersToUpdate;
                    }
                    $idsText = !empty($processedIds) ? ' (ID: ' . implode(', ', $processedIds) . ')' : '';
                    $message = "Đã kích hoạt {$updatedCount} thành viên{$idsText}";
                    break;

                case 'deactivate':
                    // Get users that actually need to be updated (not already inactive)
                    $usersToUpdate = User::whereIn('id', $userIds)->where('is_active', true)->pluck('id')->toArray();
                    if (!empty($usersToUpdate)) {
                        $updatedCount = User::whereIn('id', $usersToUpdate)->update(['is_active' => false]);
                        $processedIds = $usersToUpdate;
                    }
                    $idsText = !empty($processedIds) ? ' (ID: ' . implode(', ', $processedIds) . ')' : '';
                    $message = "Đã vô hiệu hóa {$updatedCount} thành viên{$idsText}";
                    break;

                case 'delete':
                    $processedIds = $userIds;  // All selected IDs will be deleted
                    $updatedCount = User::whereIn('id', $userIds)->delete();
                    $idsText = !empty($processedIds) ? ' (ID: ' . implode(', ', $processedIds) . ')' : '';
                    $message = "Đã xóa {$updatedCount} thành viên{$idsText}";
                    break;

                case 'update_role':
                    if (!isset($bulkData['role']) || !in_array($bulkData['role'], ['user', 'admin'])) {
                        throw new \Exception('Role không hợp lệ');
                    }
                    // Get users that actually need role update
                    $usersToUpdate = User::whereIn('id', $userIds)->where('role', '!=', $bulkData['role'])->pluck('id')->toArray();
                    if (!empty($usersToUpdate)) {
                        $updatedCount = User::whereIn('id', $usersToUpdate)->update(['role' => $bulkData['role']]);
                        $processedIds = $usersToUpdate;
                    }
                    $idsText = !empty($processedIds) ? ' (ID: ' . implode(', ', $processedIds) . ')' : '';
                    $message = "Đã cập nhật role cho {$updatedCount} thành viên{$idsText}";
                    break;

                case 'update_level':
                    if (!isset($bulkData['level']) || !in_array($bulkData['level'], ['retail', 'agent', 'distributor'])) {
                        throw new \Exception('Level không hợp lệ');
                    }
                    // Get users that actually need level update
                    $usersToUpdate = User::whereIn('id', $userIds)->where('level', '!=', $bulkData['level'])->pluck('id')->toArray();
                    if (!empty($usersToUpdate)) {
                        $updatedCount = User::whereIn('id', $usersToUpdate)->update(['level' => $bulkData['level']]);
                        $processedIds = $usersToUpdate;
                    }
                    $idsText = !empty($processedIds) ? ' (ID: ' . implode(', ', $processedIds) . ')' : '';
                    $message = "Đã cập nhật level cho {$updatedCount} thành viên{$idsText}";
                    break;

                default:
                    throw new \Exception('Hành động không hợp lệ');
            }

            // Log the bulk action with detailed information
            // \Log::info('User bulk action completed', [
            //     'action' => $action,
            //     'requested_ids' => $userIds,
            //     'processed_ids' => $processedIds,
            //     'updated_count' => $updatedCount,
            //     'bulk_data' => $bulkData
            // ]);

            return $request->expectsJson()
                ? response()->json([
                    'success' => true,
                    'message' => $message,
                    'updated_count' => $updatedCount,
                    'processed_ids' => $processedIds
                ])
                : redirect()->route('admin.users.index')->with('success', $message);
        } catch (\Exception $e) {
            // \Log::error('User bulk action failed', [
            //     'action' => $action,
            //     'user_ids' => $userIds,
            //     'error' => $e->getMessage()
            // ]);

            return $request->expectsJson()
                ? response()->json(['success' => false, 'message' => $e->getMessage()], 500)
                : redirect()->route('admin.users.index')->with('error', $e->getMessage());
        }
    }
    
}
