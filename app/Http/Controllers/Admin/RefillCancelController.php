<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RefillCancelController extends Controller
{
    // Map path segment → DB value
    private function mapRefillStatus(string $slug): ?string
    {
        return match(strtolower($slug)) {
            'awaiting'   => 'pending',
            'failed'     => 'rejected',
            'pending'    => 'pending',
            'inprogress' => 'pending',
            'completed'  => 'completed',
            'rejected'   => 'rejected',
            default      => null,
        };
    }

    private function mapCancelStatus(string $slug): ?string
    {
        return match(strtolower($slug)) {
            'pending'   => 'pending',
            'completed' => 'completed',
            default     => null,
        };
    }

    private function mapRefillProductStatus(string $slug): ?string
    {
        return match(strtolower($slug)) {
            'pending'    => 'Pending',
            'inprogress' => 'In progress',
            'completed'  => 'Completed',
            'rejected'   => 'Rejected',
            default      => null,
        };
    }

    public function refillServices(Request $request, ?string $status = null)
    {
        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.refill', true)
            ->whereNotNull('orders.refill_status')
            ->select('orders.id', 'orders.refill_status as status', 'orders.provider_name', 'orders.orders_api', 'orders.created_at', 'users.username')
            ->orderBy('orders.id', 'desc');

        if ($status) {
            $dbVal = $this->mapRefillStatus($status);
            if ($dbVal) $query->where('orders.refill_status', $dbVal);
        }
        if ($request->filled('refill_id')) $query->where('orders.id', $request->refill_id);
        if ($request->filled('order_id'))  $query->where('orders.id', $request->order_id);

        $items = $query->paginate(50);

        if ($request->ajax()) return response()->json(['data' => $items]);

        return view('adminpanel.refill_services.index', compact('items', 'status'));
    }

    public function cancelServices(Request $request, ?string $status = null)
    {
        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.cancel', true)
            ->whereNotNull('orders.cancel_status')
            ->select('orders.id', 'orders.cancel_status as status', 'orders.provider_name', 'orders.orders_api', 'orders.created_at', 'users.username')
            ->orderBy('orders.id', 'desc');

        if ($status) {
            $dbVal = $this->mapCancelStatus($status);
            if ($dbVal) $query->where('orders.cancel_status', $dbVal);
        }
        if ($request->filled('order_id')) $query->where('orders.id', $request->order_id);

        $items = $query->paginate(50);

        if ($request->ajax()) return response()->json(['data' => $items]);

        return view('adminpanel.cancel_services.index', compact('items', 'status'));
    }

    public function refillProducts(Request $request, ?string $status = null)
    {
        $query = DB::table('product_orders')
            ->join('users', 'product_orders.user_id', '=', 'users.id')
            ->where('product_orders.refill', true)
            ->select('product_orders.id', 'product_orders.refill_status', 'product_orders.quantity', 'product_orders.created_at', 'product_orders.updated_at', 'users.username')
            ->orderBy('product_orders.id', 'desc');

        if ($status) {
            $dbVal = $this->mapRefillProductStatus($status);
            if ($dbVal) $query->where('product_orders.refill_status', $dbVal);
        }
        if ($request->filled('refill_id')) $query->where('product_orders.id', $request->refill_id);
        if ($request->filled('order_id'))  $query->where('product_orders.id', $request->order_id);

        $items = $query->paginate(50);

        if ($request->ajax()) return response()->json(['data' => $items]);

        return view('adminpanel.refill_products.index', compact('items', 'status'));
    }

    public function updateRefillStatus(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'status' => 'required|in:pending,completed,rejected']);
        DB::table('orders')->whereIn('id', $request->ids)->update(['refill_status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function updateCancelStatus(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'status' => 'required|in:pending,completed']);
        DB::table('orders')->whereIn('id', $request->ids)->update(['cancel_status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function updateRefillProductStatus(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'status' => 'required|in:Pending,In progress,Completed,Rejected']);
        DB::table('product_orders')->whereIn('id', $request->ids)->update(['refill_status' => $request->status, 'updated_at' => now()]);
        return response()->json(['success' => true]);
    }
}
