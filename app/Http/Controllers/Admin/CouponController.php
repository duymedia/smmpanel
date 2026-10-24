<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    /**
     * GET /admin/coupons
     */
    public function index(Request $request)
    {
        $keyword = trim((string) $request->input('keyword', ''));

        $coupons = Coupon::query()
            ->where('domain', getDomain())
            ->when($keyword !== '', fn ($q) => $q->where('code', 'like', "%{$keyword}%"))
            ->orderByDesc('id')
            ->paginate((int) $request->input('per_page', 50))
            ->withQueryString();

        return view('admin.coupons.index', compact('coupons', 'keyword'));
    }

    /**
     * POST /admin/coupons
     */
    public function store(Request $request)
    {
        $validated = $this->validatedData($request);

        $coupon = Coupon::create(array_merge($validated, [
            'domain'     => getDomain(),
            'used_count' => 0,
        ]));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => adminMessage('add'),
                'coupon'  => $coupon,
            ]);
        }

        return redirect()->route('admin.coupons.index')->with('success', adminMessage('add'));
    }

    /**
     * GET /admin/coupons/{coupon} — fetch single coupon (used by edit modal).
     */
    public function show(Coupon $coupon)
    {
        abort_if($coupon->domain !== getDomain(), 404);

        return response()->json([
            'success' => true,
            'coupon'  => [
                'id'                => $coupon->id,
                'code'              => $coupon->code,
                'discount_type'     => $coupon->discount_type,
                'discount_value'    => $coupon->discount_value,
                'usage_limit'       => $coupon->usage_limit,
                'usage_per_account' => $coupon->usage_per_account,
                'used_count'        => $coupon->used_count,
                'start_date'        => optional($coupon->start_date)->format('Y-m-d\TH:i'),
                'end_date'          => optional($coupon->end_date)->format('Y-m-d\TH:i'),
                'account_role'      => $coupon->account_role ?? [],
                'item_type'         => $coupon->item_type,
                'min_order'         => $coupon->min_order,
                'note'              => $coupon->note,
                'status'            => (bool) $coupon->status,
            ],
        ]);
    }

    /**
     * PUT /admin/coupons/{coupon}
     */
    public function update(Request $request, Coupon $coupon)
    {
        abort_if($coupon->domain !== getDomain(), 404);

        $validated = $this->validatedData($request, $coupon->id);

        $coupon->update($validated);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => adminMessage('update'),
                'coupon'  => $coupon->fresh(),
            ]);
        }

        return redirect()->route('admin.coupons.index')->with('success', adminMessage('update'));
    }

    /**
     * DELETE /admin/coupons/{coupon}
     */
    public function destroy(Request $request, Coupon $coupon)
    {
        abort_if($coupon->domain !== getDomain(), 404);

        $coupon->delete();

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => adminMessage('delete'),
            ]);
        }

        return redirect()->route('admin.coupons.index')->with('success', adminMessage('delete'));
    }

    /**
     * GET /admin/coupons/usage
     */
    public function usage(Request $request)
    {
        $filters = [
            'coupon_id'  => $request->input('coupon_id', ''),
            'account_id' => $request->input('account_id', ''),
            'item_type'  => $request->input('item_type', ''),
            'item_value' => trim((string) $request->input('item_value', '')),
        ];

        $domain = getDomain();

        $coupons = Coupon::select('id', 'code')
            ->where('domain', $domain)
            ->orderBy('code')
            ->get();

        $accounts = User::select('id', 'username')
            ->where('domain', $domain)
            ->orderBy('username')
            ->get();

        $usages = CouponUsage::query()
            ->with(['coupon:id,code', 'account:id,username'])
            ->where('domain', $domain)
            ->when($filters['coupon_id'] !== '', fn ($q) => $q->where('coupon_id', $filters['coupon_id']))
            ->when($filters['account_id'] !== '', fn ($q) => $q->where('user_id', $filters['account_id']))
            ->when($filters['item_type'] !== '', fn ($q) => $q->where('item_type', $filters['item_type']))
            ->when($filters['item_value'] !== '', fn ($q) => $q->where('item_id', $filters['item_value']))
            ->orderByDesc('id')
            ->paginate((int) $request->input('per_page', 50))
            ->withQueryString();

        return view('admin.coupons.usage', compact('filters', 'coupons', 'accounts', 'usages'));
    }

    /**
     * Shared validation for store / update.
     */
    private function validatedData(Request $request, ?int $ignoreId = null): array
    {
        $codeRule = [
            'required',
            'string',
            'max:50',
            'regex:/^[A-Za-z0-9]+$/',
            Rule::unique('coupons', 'code')
                ->where(fn ($q) => $q->where('domain', getDomain()))
                ->ignore($ignoreId),
        ];

        $validated = $request->validate([
            'code'              => $codeRule,
            'discount_type'     => 'required|in:percent,fixed',
            'discount_value'    => 'required|numeric|min:0',
            'usage_limit'       => 'nullable|integer|min:0',
            'usage_per_account' => 'nullable|integer|min:0',
            'start_date'        => 'required|date',
            'end_date'          => 'required|date|after_or_equal:start_date',
            'account_role'      => 'nullable|array',
            'account_role.*'    => 'string|max:50',
            'item_type'         => 'nullable|in:service,product',
            'min_order'         => 'nullable|numeric|min:0',
            'note'              => 'nullable|string|max:1000',
            'status'            => 'nullable|boolean',
        ]);

        $validated['code']         = strtoupper($validated['code']);
        $validated['status']       = $request->boolean('status');
        $validated['item_type']    = $validated['item_type'] ?? null;
        $validated['account_role'] = $validated['account_role'] ?? null;

        return $validated;
    }
}
