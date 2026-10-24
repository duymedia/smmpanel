<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Affiliate;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\UserCustomRate;
use App\Models\Transaction;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AccountController extends Controller
{
    public const ROLE_RETAIL      = User::ROLE_RETAIL;
    public const ROLE_ADMIN       = User::ROLE_ADMIN;
    public const ROLE_CHILD_PANEL = User::ROLE_AGENT;
    public const ROLE_RESELLER    = User::ROLE_DISTRIBUTOR;
    public const ROLE_STAFF       = User::ROLE_STAFF;

    public const ORDER_COLUMNS = [
        'account_id'         => 'users.id',
        'account_last_login' => 'users.updated_at',
        'account_fund'       => 'users.balance',
    ];

    public const CACHE_TTL = 3600;
    public const MAX_PAGE_SIZE = 200;

    public function index(): View
    {
        $domain = getDomain();
        $cacheKey = "account_stats_{$domain}";
        $stats = Cache::remember($cacheKey, self::CACHE_TTL, fn () => $this->buildStatistics($domain));

        // The accounts table is rendered client-side by the _accounts DataTable
        // (admin.js -> Admin-Account-listAccount). The summary cards on this page
        // are populated from the cached statistics instead.
        $totalDeposit = (float) ($stats['total_deposit'] ?? 0);
        $totalBonus = (float) ($stats['total_bonus'] ?? 0);

        return view('admin.accounts.index', compact('stats', 'totalDeposit', 'totalBonus'));
    }

    public function show(string $username): View|RedirectResponse
    {
        // The standalone profile page has been removed. Keep the old URL
        // working by sending account links to the first available tab.
        User::where('username', $username)
            ->where('domain', getDomain())
            ->firstOrFail();

        return redirect()->route('admin.accounts.payment', ['username' => $username]);
    }

    public function payment(Request $request, string $username): View|JsonResponse
    {
        $domain = getDomain();
        $accounts = User::where('username', $username)
            ->where('domain', $domain)
            ->firstOrFail();

        $completedPayments = Payment::where('user_id', $accounts->id)
            ->where('domain', $domain)
            ->where('status', 'completed');
        $totalDeposit = (float) (clone $completedPayments)->sum('amount');
        $totalBonus = (float) (clone $completedPayments)->sum('bonus_amount');
        $totalSpent = (float) $accounts->spent;
        $currencyRates = Currency::where(function (Builder $query) use ($domain) {
                $query->where('domain', $domain)->orWhereNull('domain');
            })
            ->where('status', true)
            ->pluck('exchange_rate', 'code');
        $vndExchangeRate = (float) ($currencyRates['VND'] ?? 1);
        $paymentOptions = PaymentMethod::where('domain', $domain)
            ->where('status', true)
            ->ordered()
            ->get()
            ->map(function (PaymentMethod $method) use ($currencyRates): array {
                $currency = strtoupper($method->currency ?? 'USD');

                return [
                    'value' => $method->id,
                    'name' => $method->name,
                    'icon' => $method->image_url,
                    'currency' => $currency,
                    'rate' => (float) ($currencyRates[$currency] ?? 1),
                    'lang_key' => $method->name,
                ];
            });
        $canRefund = max(0, $totalDeposit + $totalBonus - $totalSpent);
        $lastLogin = ActivityLog::where('user_id', $accounts->id)
            ->where('domain', $domain)
            ->where('type', 'login')
            ->latest('created_at')
            ->first();

        return view('admin.accounts.payment', compact(
            'accounts',
            'paymentOptions',
            'vndExchangeRate',
            'totalDeposit',
            'totalBonus',
            'totalSpent',
            'canRefund',
            'lastLogin'
        ));
    }

    public function signInHistory(string $username): View
    {
        $domain = getDomain();
        $accounts = User::where('username', $username)
            ->where('domain', $domain)
            ->firstOrFail();

        $loginHistory = ActivityLog::where('user_id', $accounts->id)
            ->where('domain', $domain)
            ->where('type', 'login')
            ->latest('created_at')
            ->get(['activity', 'created_at'])
            ->map(function (ActivityLog $log): array {
                $activity = $log->activity ?? [];

                if (!is_array($activity)) {
                    $activity = json_decode($activity, true) ?: [];
                }

                return [
                    'created_at' => $log->created_at,
                    'ip_address' => $activity['ip_address'] ?? '—',
                    'user_agent' => $activity['user_agent'] ?? '—',
                ];
            });

        $lastLogin = $loginHistory->first();

        return view('admin.accounts.signinhistory', compact('accounts', 'loginHistory', 'lastLogin'));
    }

    public function transactions(string $username): View
    {
        $domain = getDomain();
        $accounts = User::where('username', $username)
            ->where('domain', $domain)
            ->firstOrFail();

        $lastLogin = ActivityLog::where('user_id', $accounts->id)
            ->where('domain', $domain)
            ->where('type', 'login')
            ->latest('created_at')
            ->first();

        return view('admin.accounts.transactions', compact('accounts', 'lastLogin'));
    }

    public function transactionsData(Request $request): JsonResponse
    {
        $columns = $request->input('columns', []);
        $columnSearch = is_array($columns) ? data_get($columns, '0.search.value') : null;
        $userId = (int) ($request->input('account_id')
            ?: $request->input('user_id')
            ?: $columnSearch
            ?: $request->input('search.value'));
        $isOldHistory = $request->input('action') === 'Admin-Transaction-listTransactionOld';
        $query = Transaction::where('domain', getDomain());
        if (!$isOldHistory) {
            $query->where('created_at', '>=', now()->subMonths(3));
        }
        if ($userId) $query->where('user_id', $userId);

        $total = (clone $query)->count();
        $length = min(max((int) $request->input('length', 20), 1), 100);
        $rows = $query->latest('created_at')->skip((int) $request->input('start', 0))
            ->take($length)->get();

        return response()->json([
            'draw' => (int) $request->input('draw', 1),
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $rows->map(function (Transaction $t): array {
                $description = strtolower((string) $t->description);
                $action = match (strtolower((string) $t->type)) {
                    'order' => 'Add order',
                    'refund', 'refund_reversal' => str_contains($description, 'canceled') || $t->amount < 0
                        ? 'Canceled' : 'Partial',
                    'deposit' => 'Deposit',
                    default => ucfirst((string) $t->type),
                };
                return [
                    'account_id' => $t->user_id,
                    'id' => $t->order_id ?: $t->id,
                    // admin.js renders the visible ID from the legacy
                    // `order_id` column name.
                    'order_id' => $t->order_id ?: $t->id,
                    'type' => $t->type,
                    'action' => $action,
                    'change' => (float) $t->amount,
                    'amount' => (float) $t->amount,
                    'pm_id' => $t->payment_method,
                    'balance' => (float) ($t->balance_after ?? 0),
                    'created' => $t->created_at?->toIso8601String(),
                    'created_at' => $t->created_at?->toIso8601String(),
                ];
            })->values(),
        ]);
    }

    public function affiliates(string $username): View
    {
        $domain = getDomain();
        $accounts = User::where('username', $username)
            ->where('domain', $domain)
            ->firstOrFail();

        $lastLogin = ActivityLog::where('user_id', $accounts->id)
            ->where('domain', $domain)
            ->where('type', 'login')
            ->latest('created_at')
            ->first();

        $affiliateRows = Affiliate::with('referred:id,username')
            ->where('domain', $domain)
            ->where('referrer_id', $accounts->id)
            ->latest('id')
            ->get();

        $affiliateTotal = (float) $affiliateRows->sum('total_earned');
        $affiliatePaid = (float) $affiliateRows
            ->where('status', 'active')
            ->sum('total_earned');

        return view('admin.accounts.affiliates', compact(
            'accounts',
            'lastLogin',
            'affiliateRows',
            'affiliateTotal',
            'affiliatePaid'
        ));
    }

    public function customRates(string $username): View
    {
        $domain = getDomain();
        $accounts = User::where('username', $username)
            ->where('domain', $domain)
            ->firstOrFail();

        $services = Service::where('domain', $domain)
            ->where('status', true)
            ->orderBy('position')
            ->orderBy('id')
            ->get(['id', 'name', 'rate_retail']);

        $lastLogin = ActivityLog::where('user_id', $accounts->id)
            ->where('domain', $domain)
            ->where('type', 'login')
            ->latest('created_at')
            ->first();

        return view('admin.accounts.customrates', compact('accounts', 'services', 'lastLogin'));
    }

    public function customRatesList(Request $request, string $username): JsonResponse
    {
        $account = $this->customRateAccountByUsername($username);

        return response()->json($this->customRateRows($account));
    }

    public function customRatesStore(Request $request, string $username): JsonResponse
    {
        $account = $this->customRateAccountByUsername($username);

        return $this->storeCustomRate($request, $account);
    }

    public function customRatesDestroy(Request $request, string $username): JsonResponse
    {
        $account = $this->customRateAccountByUsername($username);
        $services = $request->input('services', []);

        if (!is_array($services) || $services === []) {
            UserCustomRate::where('user_id', $account->id)
                ->where('domain', getDomain())
                ->delete();
        } else {
            UserCustomRate::where('user_id', $account->id)
                ->where('domain', getDomain())
                ->whereIn('service_id', array_map('intval', $services))
                ->delete();
        }

        return response()->json(['success' => $this->customRateDeletedMessage()]);
    }

    public function customRatesLegacy(string $method, Request $request): JsonResponse
    {
        $account = $this->customRateAccountById($request->integer('id'));

        return match ($method) {
            'list' => response()->json($this->customRateRows($account)),
            'add' => $this->storeCustomRate($request, $account),
            'addAll' => $this->storeAllCustomRates($request, $account),
            'delete' => $this->deleteCustomRates($request, $account),
            'deleteAll' => $this->deleteAllCustomRates($account),
            'copy' => $this->copyCustomRates($request),
            default => response()->json(['error' => "Unsupported custom rate action: {$method}"], 404),
        };
    }

    private function customRateAccountByUsername(string $username): User
    {
        return User::where('username', $username)
            ->where('domain', getDomain())
            ->firstOrFail();
    }

    private function customRateAccountById(int $id): User
    {
        return User::whereKey($id)
            ->where('domain', getDomain())
            ->firstOrFail();
    }

    private function customRateRows(User $account): array
    {
        return UserCustomRate::where('user_id', $account->id)
            ->where('domain', getDomain())
            ->orderBy('service_id')
            ->get()
            ->mapWithKeys(fn (UserCustomRate $rate) => [
                (string) $rate->service_id => [
                    // Legacy admin.js expects numeric values and checks `p > 0`.
                    // Do not expose nullable database values to the page.
                    'r' => (float) ($rate->rate ?? 0),
                    'p' => (float) ($rate->percent ?? 0),
                ],
            ])
            ->all();
    }

    private function storeCustomRate(Request $request, User $account): JsonResponse
    {
        $data = $request->validate([
            'service' => ['required', 'integer', 'min:1'],
            'rate' => ['nullable', 'numeric', 'min:0'],
            'percent' => ['nullable', 'numeric', 'min:0'],
        ]);

        $service = Service::whereKey($data['service'])
            ->where('domain', getDomain())
            ->where('status', true)
            ->firstOrFail();

        // admin.js sends 0 for the input that is hidden by the selected mode.
        // A positive rate means fixed-price mode; otherwise use percent mode.
        $rate = (float) ($data['rate'] ?? 0);
        $percent = (float) ($data['percent'] ?? 0);

        if ($rate > 0) {
            $percent = null;
        } else {
            $rate = null;
        }

        UserCustomRate::updateOrCreate(
            ['user_id' => $account->id, 'service_id' => $service->id, 'domain' => getDomain()],
            ['rate' => $rate, 'percent' => $percent]
        );

        return response()->json(['success' => $this->customRateSuccessMessage()]);
    }

    private function storeAllCustomRates(Request $request, User $account): JsonResponse
    {
        $data = $request->validate(['percent' => ['required', 'numeric', 'min:0']]);

        UserCustomRate::updateOrCreate(
            ['user_id' => $account->id, 'service_id' => -1, 'domain' => getDomain()],
            ['rate' => null, 'percent' => (float) $data['percent']]
        );

        return response()->json(['success' => $this->customRateSuccessMessage()]);
    }

    private function deleteCustomRates(Request $request, User $account): JsonResponse
    {
        $data = $request->validate(['services' => ['required', 'array', 'min:1'], 'services.*' => ['integer']]);

        UserCustomRate::where('user_id', $account->id)
            ->where('domain', getDomain())
            ->whereIn('service_id', $data['services'])
            ->delete();

        return response()->json(['success' => $this->customRateDeletedMessage()]);
    }

    private function deleteAllCustomRates(User $account): JsonResponse
    {
        UserCustomRate::where('user_id', $account->id)
            ->where('domain', getDomain())
            ->delete();

        return response()->json(['success' => $this->customRateDeletedMessage()]);
    }

    private function copyCustomRates(Request $request): JsonResponse
    {
        $data = $request->validate(['from_account' => ['required'], 'to_account' => ['required']]);
        $domain = getDomain();
        $from = User::where('domain', $domain)
            ->where(fn (Builder $query) => $query->whereKey($data['from_account'])->orWhere('username', $data['from_account']))
            ->firstOrFail();
        $to = User::where('domain', $domain)
            ->where(fn (Builder $query) => $query->whereKey($data['to_account'])->orWhere('username', $data['to_account']))
            ->firstOrFail();

        DB::transaction(function () use ($from, $to, $domain) {
            UserCustomRate::where('user_id', $to->id)->where('domain', $domain)->delete();
            UserCustomRate::where('user_id', $from->id)->where('domain', $domain)->get()
                ->each(fn (UserCustomRate $rate) => UserCustomRate::create([
                    'user_id' => $to->id, 'service_id' => $rate->service_id,
                    'rate' => $rate->rate, 'percent' => $rate->percent, 'domain' => $domain,
                ]));
        });

        return response()->json(['success' => $this->customRateSuccessMessage()]);
    }

    private function customRateSuccessMessage(): string
    {
        return Auth::user()?->lang === 'vi'
            ? 'Cập nhật thành công.'
            : 'Updated successfully.';
    }

    private function customRateDeletedMessage(): string
    {
        return Auth::user()?->lang === 'vi'
            ? 'Xóa thành công.'
            : 'Deleted successfully.';
    }

    public function statsFund(Request $request): JsonResponse
    {
        $account = User::whereKey($request->integer('id'))
            ->where('domain', getDomain())
            ->firstOrFail();
        $completedPayments = Payment::where('user_id', $account->id)
            ->where('domain', getDomain())
            ->where('status', 'completed');

        $deposit = (float) (clone $completedPayments)->sum('amount');
        $bonus = (float) (clone $completedPayments)->sum('bonus_amount');
        $spent = (float) $account->spent;

        return response()->json([
            // _accounts.fn.stats() reads `current`, not `fund`.
            'current' => (float) $account->balance,
            'fund' => (float) $account->balance,
            'deposit' => $deposit,
            'bonus' => $bonus,
            'spent' => $spent,
            'can_refund' => max(0, $deposit + $bonus - $spent),
        ]);
    }

    /**
     * Update an account from the legacy `_accounts.on.click.updateAccount()` request.
     * Legacy role values: 0 retail, 1 admin, 4 agent, 5 distributor.
     * Legacy status values: 0 active, 1 disabled.
     */
    public function updateAccount(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'username' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'name_postfix' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:30',
            'password' => 'nullable|string|min:8|max:255',
            'percent' => 'nullable|integer|min:0|max:100',
            'role' => 'required|integer|in:0,1,4,5,6',
            'status' => 'required|integer|in:0,1',
        ]);

        $account = User::whereKey($validated['id'])
            ->where('domain', getDomain())
            ->firstOrFail();

        $usernameTaken = User::where('username', $validated['username'])
            ->whereKeyNot($account->id)
            ->exists();
        $emailTaken = User::where('email', $validated['email'])
            ->whereKeyNot($account->id)
            ->exists();

        if ($usernameTaken) {
            return response()->json(['error' => 'Tên tài khoản đã được sử dụng.'], 200);
        }

        if ($emailTaken) {
            return response()->json(['error' => 'Email đã được sử dụng.'], 200);
        }

        $name = trim(implode(' ', array_filter([
            $validated['name'] ?? null,
            $validated['name_postfix'] ?? null,
        ], fn ($value) => filled($value))));

        $attributes = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?: null,
            'percent_bonus' => (int) ($validated['percent'] ?? 0),
            'role' => (int) $validated['role'],
            'is_active' => (int) $validated['status'] === 0,
        ];

        if ($name !== '') {
            $attributes['name'] = $name;
        }

        if (filled($validated['password'] ?? null)) {
            $attributes['password'] = Hash::make($validated['password']);
        }

        $account->update($attributes);

        return response()->json(['success' => adminMessage('update')]);
    }

    public function addFunds(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'pm_id' => 'required|integer',
            'amount' => 'required|numeric|gt:0',
            'details' => 'nullable|string|max:2000',
        ]);

        $domain = getDomain();
        $account = User::whereKey($validated['id'])->where('domain', $domain)->firstOrFail();
        $paymentMethod = PaymentMethod::whereKey($validated['pm_id'])
            ->where('domain', $domain)
            ->where('status', true)
            ->firstOrFail();
        $amount = round((float) $validated['amount'], 8);
        $bonus = $this->calculatePaymentMethodBonus($amount, $paymentMethod->bonus);
        $totalAmount = round($amount + $bonus['amount'], 8);

        DB::transaction(function () use ($account, $paymentMethod, $amount, $bonus, $totalAmount, $validated, $domain) {
            Payment::create([
                'user_id' => $account->id,
                'payment_method_id' => $paymentMethod->id,
                'transaction_id' => 'ADMIN-' . now()->format('YmdHis') . '-' . strtoupper(str()->random(8)),
                'amount' => $amount,
                'bonus_amount' => $bonus['amount'],
                'total_amount' => $totalAmount,
                'currency' => $paymentMethod->currency ?? 'USD',
                'exchange_rate' => 1,
                'status' => 'completed',
                'note' => $validated['details'] ?: 'Admin add funds',
                'payment_info' => [
                    'source' => 'admin',
                    'bonus_percent' => $bonus['percent'],
                ],
                'domain' => $domain,
            ]);

            $account->increment('balance', $totalAmount);
        });

        return response()->json([
            'success' => adminMessage('add'),
            'amount' => $amount,
            'bonus_amount' => $bonus['amount'],
            'total_amount' => $totalAmount,
        ]);
    }

    private function calculatePaymentMethodBonus(float $amount, mixed $bonusData): array
    {
        if (is_string($bonusData)) {
            $bonusData = json_decode($bonusData, true);
        }

        if (!is_array($bonusData)) {
            return ['amount' => 0.0, 'percent' => 0.0];
        }

        $percent = collect($bonusData)
            ->map(function ($tier): array {
                return [
                    'min' => (float) ($tier['min'] ?? $tier['quantity'] ?? $tier['q'] ?? 0),
                    'percent' => (float) ($tier['percent'] ?? $tier['p'] ?? 0),
                ];
            })
            ->filter(fn (array $tier) => $tier['min'] > 0 && $tier['percent'] > 0 && $tier['percent'] <= 100)
            ->sortBy('min')
            ->filter(fn (array $tier) => $amount >= $tier['min'])
            ->last()['percent'] ?? 0.0;

        return [
            'amount' => round($amount * $percent / 100, 8),
            'percent' => $percent,
        ];
    }

    public function buildStatistics(string $domain): array
    {
        $userStats = DB::table('users')
            ->where('domain', $domain)
            ->selectRaw(
                'COUNT(*) as total, ' .
                'SUM(CASE WHEN role = ? THEN 1 ELSE 0 END) as admins, ' .
                'SUM(CASE WHEN role = ? THEN 1 ELSE 0 END) as retail, ' .
                'SUM(CASE WHEN role = ? THEN 1 ELSE 0 END) as agents, ' .
                'SUM(CASE WHEN role = ? THEN 1 ELSE 0 END) as distributors, ' .
                'SUM(CASE WHEN role = ? THEN 1 ELSE 0 END) as staff, ' .
                'COALESCE(SUM(balance), 0) as balance',
                [self::ROLE_ADMIN, self::ROLE_RETAIL, self::ROLE_CHILD_PANEL, self::ROLE_RESELLER, self::ROLE_STAFF]
            )
            ->first();

        $payStats = DB::table('payments')
            ->where('status', 'completed')
            ->selectRaw(
                'COALESCE(SUM(amount), 0) as deposits, ' .
                'COALESCE(SUM(bonus_amount), 0) as bonuses'
            )
            ->first();

        return [
            'total_accounts'    => (int) $userStats->total,
            'admin_count'       => (int) $userStats->admins,
            'user_count'        => (int) $userStats->retail,
            'reseller_count'    => (int) $userStats->agents,
            'distributor_count' => (int) $userStats->distributors,
            'staff_count'       => (int) $userStats->staff,
            'total_balance'     => round((float) $userStats->balance, 2),
            'total_deposit'     => round((float) $payStats->deposits, 2),
            'total_bonus'       => round((float) $payStats->bonuses, 2),
        ];
    }

    public function sanitizeSearchQuery(string $query): string
    {
        return trim(preg_replace('/[^a-zA-Z0-9._@\-\s]/u', '', $query));
    }

    public function applyKeywordSearch(Builder &$query, string $keyword): void
    {
        $query->where(function (Builder $q) use ($keyword) {
            $q->where('username', 'like', "%{$keyword}%")
              ->orWhere('email', 'like', "%{$keyword}%");
        });
    }

    public function applyAccountTypeFilter(Builder &$query, string $type): void
    {
        if (empty($type)) {
            return;
        }

        $role = match ($type) {
            'admin' => self::ROLE_ADMIN, 'agent' => self::ROLE_CHILD_PANEL,
            'distributor' => self::ROLE_RESELLER, 'staff' => self::ROLE_STAFF,
            'retail' => self::ROLE_RETAIL, default => null,
        };
        if ($role !== null) {
            $query->where('role', $role);
        }
    }

    public function applyDataTableFilters(Builder &$query, Request $request): void
    {
        $columns = (array) $request->input('columns', []);

        foreach ($columns as $col) {
            $name  = $col['name'] ?? '';
            $value = trim((string) ($col['search']['value'] ?? ''));

            if (empty($name) || empty($value)) {
                continue;
            }

            if ($name === 'account_role' && !empty($value)) {
                $this->applyAccountTypeFilter($query, (string) $value);
                continue;
            }

            match ($name) {
                'account_id'   => $query->where('id', (int) $value),
                'account_user' => $this->applyKeywordSearch($query, $value),
                'account_type' => $this->applyAccountTypeFilter($query, (string) $value),
                default        => null,
            };
        }

        if ($search = trim((string) $request->input('search.value', ''))) {
            $this->applyKeywordSearch($query, $search);
        }
    }

    public function resolveDataTableOrder(Request $request): array
    {
        $dir   = strtolower((string) $request->input('order.0.dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        $index = (int) $request->input('order.0.column', 0);
        $data  = (string) $request->input("columns.{$index}.data", 'account_id');
        $orderCol = self::ORDER_COLUMNS[$data] ?? 'users.id';

        return [$orderCol, $dir];
    }

    public function resolveDataTablePaging(Request $request): array
    {
        $start  = max(0, (int) $request->input('start', 0));
        $length = (int) $request->input('length', 20);
        $length = ($length < 1 || $length > self::MAX_PAGE_SIZE) ? self::MAX_PAGE_SIZE : $length;

        return [$start, $length];
    }

    public function formatAccountRow(User $user): array
    {
        return [
            'account_id'         => (int) $user->id,
            'account_user'       => (string) $user->username,
            'account_email'      => (string) $user->email,
            'account_role'       => $this->getAccountRole($user),
            'account_fund'       => (float) round($user->balance, 2),
            'account_percent'    => (int) ($user->percent_bonus ?? 0),
            'account_status'     => ($user->is_active ?? 1) ? 0 : 1,
            'account_verified'   => 1,
            'account_last_login' => $user->updated_at?->format('Y-m-d H:i:s') ?? null,
        ];
    }

    public function getAccountRole(User $user): int
    {
        return (int) $user->role;
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $domain = getDomain();
            $baseQuery = User::where('domain', $domain);
            $total = $baseQuery->count();

            $this->applyDataTableFilters($baseQuery, $request);
            $filtered = (clone $baseQuery)->count();
            [$orderCol, $orderDir] = $this->resolveDataTableOrder($request);
            [$start, $length] = $this->resolveDataTablePaging($request);

            $rows = $baseQuery
                ->select(['id', 'username', 'email', 'role', 'balance', 'percent_bonus', 'updated_at', 'is_active'])
                ->orderBy($orderCol, $orderDir)
                ->skip($start)
                ->take($length)
                ->get()
                ->map(fn (User $u) => $this->formatAccountRow($u))
                ->values();

            return response()->json([
                'draw'            => (int) $request->input('draw', 1),
                'recordsTotal'    => $total,
                'recordsFiltered' => $filtered,
                'data'            => $rows,
            ]);
        } catch (\Throwable $e) {
            Log::error('ListAccount error: ' . $e->getMessage());

            return response()->json([
                'draw'            => (int) $request->input('draw', 1),
                'recordsTotal'    => 0,
                'recordsFiltered' => 0,
                'data'            => [],
            ]);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->input('data', []);
            if (is_array($data) && !empty($data)) {
                $request->merge($data);
            }

            $request->merge([
                'percent_bonus' => (int) ($request->input('percent') ?? 0),
                'is_active'     => (int) $request->input('status', 1) === 1,
                'domain'        => getDomain(),
            ]);

            $validated = $request->validateWithBag('default', [
                'email'          => 'required|email|unique:users,email',
                'username'       => 'nullable|string|max:255|unique:users,username',
                'password'       => 'required|string|min:8',
                'role'           => 'required|integer|in:0,1,4,5,6',
                'percent_bonus'  => 'nullable|integer|min:0|max:100',
                'is_active'      => 'nullable|boolean',
                'domain'         => 'required|string',
            ]);

            return DB::transaction(function () use ($validated) {
                $base = $validated['username'] ?? strstr($validated['email'], '@', true);
                $validated['username'] = $validated['username'] ?? str_replace(' ', '_', strtolower($base));
                $validated['password'] = bcrypt($validated['password']);
                $user = User::create($validated);

                return response()->json([
                    'success' => adminMessage('add'),
                    'user'    => $user,
                ], 200);
            });

        } catch (ValidationException $e) {
            $messages = array_map(fn ($errs) => implode(', ', $errs), $e->errors());
            return response()->json(['error' => implode(' | ', $messages)], 200);
        } catch (\Throwable $e) {
            Log::error('Store account error: ' . $e->getMessage());
            return response()->json(['error' => 'Lỗi khi tạo tài khoản: ' . $e->getMessage()], 200);
        }
    }

    /**
     * Delete a customer account owned by the current panel domain.
     * The route has existed since the accounts module was introduced; keeping
     * the domain and self-account checks here prevents an administrator from
     * accidentally deleting an account from another panel or their own login.
     */
    public function destroy(int $accounts): JsonResponse
    {
        $account = User::whereKey($accounts)
            ->where('domain', getDomain())
            ->firstOrFail();

        if (Auth::id() === $account->id) {
            return response()->json(['error' => 'Không thể xóa tài khoản đang đăng nhập.'], 422);
        }

        $account->delete();

        return response()->json(['success' => adminMessage('delete')]);
    }

    public function searchUsers(Request $request): JsonResponse
    {
        $withEmail = str_contains((string) $request->input('action', ''), 'ForEmailUsername');
        $keyword = $this->sanitizeSearchQuery($request->input('keyword', ''));

        $results = User::where('domain', getDomain())
            ->select(['id', 'username', 'email'])
            ->when($keyword, fn (Builder $q) => $q->where(function (Builder $qq) use ($keyword, $withEmail) {
                $qq->where('username', 'like', "%{$keyword}%");
                if ($withEmail) {
                    $qq->orWhere('email', 'like', "%{$keyword}%");
                }
            }))
            ->orderBy('username')
            ->limit(30)
            ->get()
            ->map(fn (User $u) => [
                'id'   => $u->id,
                'text' => $withEmail ? "{$u->username} ({$u->email})" : $u->username,
            ]);

        return response()->json(['results' => $results]);
    }
}
