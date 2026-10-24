<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.affiliates.index');
    }

    public function list(Request $request)
    {
        $filters = $request->validate([
            'referrer' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:active,inactive,suspended,pending'],
            'length' => ['nullable', 'integer', 'min:10', 'max:100'],
            'start' => ['nullable', 'integer', 'min:0'],
            'draw' => ['nullable', 'integer', 'min:0'],
        ]);
        $query = Affiliate::with(['referrer', 'referred'])->where('domain', getDomain());

        if (!empty($filters['referrer'])) {
            $keyword = trim($filters['referrer']);
            $query->whereHas('referrer', fn ($user) => $user->where('username', 'like', "%{$keyword}%"));
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Aggregates are calculated in one database round-trip. The previous
        // implementation executed four separate count/sum queries.
        $statsQuery = Affiliate::query()->where('domain', getDomain());
        if (!empty($filters['referrer'])) {
            $statsQuery->whereHas('referrer', fn ($user) => $user->where('username', 'like', "%{$keyword}%"));
        }
        if (!empty($filters['status'])) {
            $statsQuery->where('status', $filters['status']);
        }
        $stats = [
            'total' => 0,
            'active_count' => 0,
            'total_earned' => 0.0,
            'total_orders' => 0.0,
        ];
        $aggregate = $statsQuery->selectRaw('COUNT(*) total, SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) active_count, COALESCE(SUM(total_earned), 0) total_earned, COALESCE(SUM(total_orders), 0) total_orders', ['active'])->first();
        if ($aggregate) {
            $stats = ['total' => (int) $aggregate->total, 'active_count' => (int) $aggregate->active_count, 'total_earned' => (float) $aggregate->total_earned, 'total_orders' => (float) $aggregate->total_orders];
        }
        $recordsTotal = Affiliate::where('domain', getDomain())->count();
        $recordsFiltered = (clone $query)->count();
        $length = $filters['length'] ?? 20;
        $start = $filters['start'] ?? 0;
        $rows = $query->latest()->skip($start)->take($length)->get()->map(fn ($affiliate) => [
            'id' => $affiliate->id,
            'created_at' => $affiliate->created_at?->format('Y-m-d H:i'),
            'referrer_id' => $affiliate->referrer_id,
            'referrer' => $affiliate->referrer?->username,
            'referred_id' => $affiliate->referred_id,
            'referred' => $affiliate->referred?->username,
            'referral_code' => $affiliate->referral_code,
            'commission_rate' => (float) $affiliate->commission_rate,
            'total_earned' => (float) $affiliate->total_earned,
            'total_orders' => (float) $affiliate->total_orders,
            'orders_count' => (int) $affiliate->orders_count,
            'status' => $affiliate->status,
        ])->values();

        return response()->json([
            'draw' => $filters['draw'] ?? 0,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $rows,
            'stats' => $stats,
        ]);
    }

    public function approve(Request $request)
    {
        $data = $request->validate(['id' => ['required', 'integer']]);
        $affiliate = Affiliate::where('domain', getDomain())->findOrFail($data['id']);
        $affiliate->update(['status' => 'active']);

        return response()->json(['success' => true]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'referrer_id' => ['required', 'exists:users,id'],
            'referred_id' => ['required', 'exists:users,id', 'different:referrer_id'],
            'referral_code' => ['nullable', 'string', 'max:255'],
            'commission_rate' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'in:active,inactive,suspended'],
            'note' => ['nullable', 'string'],
        ]);
        $data['domain'] = getDomain();

        return response()->json(Affiliate::create($data), 201);
    }

    public function show(Request $request, $id)
    {
        return response()->json(Affiliate::where('domain', getDomain())->findOrFail($id)->load(['referrer', 'referred']));
    }

    public function update(Request $request, $id)
    {
        $affiliate = Affiliate::where('domain', getDomain())->findOrFail($id);
        $affiliate->update($request->validate([
            'referral_code' => ['nullable', 'string', 'max:255'],
            'commission_rate' => ['sometimes', 'numeric', 'min:0', 'max:100'],
            'status' => ['sometimes', 'in:active,inactive,suspended'],
            'note' => ['nullable', 'string'],
        ]));

        return response()->json($affiliate);
    }

    public function destroy(Request $request, $id)
    {
        Affiliate::where('domain', getDomain())->findOrFail($id)->delete();

        return response()->json(['message' => 'Affiliate deleted successfully']);
    }
}
