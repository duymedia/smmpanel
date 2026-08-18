<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function index(Request $request)
    {
        // Trả về view nếu không phải AJAX
        if (!$request->ajax() && !$request->wantsJson()) {
            return view('adminpanel.affiliates.index');
        }

        $query = Affiliate::with(['referrer', 'referred']);

        // Filter domain — tương thích cả 127.0.0.1 và 127.0.0.1:8000
        $host = getDomain();
        $query->where(function($q) use ($host) {
            $q->where('domain', $host)
              ->orWhere('domain', parse_url('http://' . $host, PHP_URL_HOST))
              ->orWhereNull('domain');
        });

        if ($request->filled('referrer_id')) $query->where('referrer_id', $request->referrer_id);
        if ($request->filled('referred_id')) $query->where('referred_id', $request->referred_id);
        if ($request->filled('status'))      $query->where('status', $request->status);
        if ($request->filled('referrer')) {
            $query->whereHas('referrer', fn($q) => $q->where('username', 'like', '%' . $request->referrer . '%'));
        }

        // Aggregate stats trước khi paginate
        $statsQuery = clone $query;
        $stats = [
            'total'        => $statsQuery->count(),
            'total_earned' => $statsQuery->sum('total_earned'),
            'total_orders' => $statsQuery->sum('total_orders'),
            'active_count' => (clone $query)->where('status', 'active')->count(),
        ];

        $paginated = $query->latest()->paginate($request->per_page ?? 15);

        return response()->json(array_merge($paginated->toArray(), $stats));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'referrer_id' => 'required|exists:users,id',
            'referred_id' => 'required|exists:users,id|different:referrer_id',
            'referral_code' => 'nullable|string|max:255',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'status' => 'required|in:active,inactive,suspended',
            'note' => 'nullable|string'
        ]);
        $validated['domain'] = $request->getHost();

        return response()->json(Affiliate::create($validated), 201);
    }

    public function show(Request $request, $id)
    {
        $affiliate = Affiliate::where('domain', $request->getHost())->findOrFail($id);
        return response()->json($affiliate->load(['referrer', 'referred']));
    }

    public function update(Request $request, $id)
    {
        $affiliate = Affiliate::where('domain', $request->getHost())->findOrFail($id);
        
        $validated = $request->validate([
            'referral_code' => 'nullable|string|max:255',
            'commission_rate' => 'sometimes|numeric|min:0|max:100',
            'status' => 'sometimes|in:active,inactive,suspended',
            'note' => 'nullable|string'
        ]);

        $affiliate->update($validated);
        return response()->json($affiliate);
    }

    public function destroy(Request $request, $id)
    {
        $affiliate = Affiliate::where('domain', $request->getHost())->findOrFail($id);
        $affiliate->delete();
        return response()->json(['message' => 'Affiliate deleted successfully']);
    }
}