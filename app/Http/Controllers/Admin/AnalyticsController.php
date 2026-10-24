<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    private function resolveServiceName(?object $service): string
    {
        if (!$service) return 'N/A';
        $name = $service->name;
        if (is_array($name)) {
            return $service->id . ' - ' . ($name['en'] ?? $name['vi'] ?? reset($name) ?? 'N/A');
        }
        return $service->id . ' - ' . ($name ?: 'N/A');
    }

    private function mapServiceRows($collection, string $valueKey): array
    {
        return $collection->map(fn($item) => [
            'value'         => $item->{$valueKey},
            'service_label' => $this->resolveServiceName($item->service),
        ])->toArray();
    }

    public function index()
    {
        $fromDate = now()->format('Y/m/d');
        $toDate = now()->format('Y/m/d');
        $year = now()->year;

        return view('admin.analytics.index', compact('fromDate', 'toDate', 'year'));
    }

    public function account()
    {
        $year = now()->year;
        $newAccounts = User::where('domain', getDomain())->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupByRaw('MONTH(created_at)')->pluck('total', 'month');
        $activeAccounts = Order::where('domain', getDomain())->whereYear('created_at', $year)
            ->selectRaw('MONTH(created_at) as month, COUNT(DISTINCT user_id) as total')
            ->groupByRaw('MONTH(created_at)')->pluck('total', 'month');

        return response()->json([
            'new' => collect(range(1, 12))->map(fn ($month) => [
                'new_account' => (int) $newAccounts->get($month, 0),
            ])->values(),
            'active' => collect(range(1, 12))->map(fn ($month) => [
                'active_account' => (int) $activeAccounts->get($month, 0),
            ])->values(),
        ]);
    }

    public function order()
    {
        $rows = Order::where('domain', getDomain())
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->whereIn('status', ['Completed', 'Partial', 'Canceled'])
            ->selectRaw('DATE(created_at) as order_date, status as order_status, COUNT(*) as total')
            ->groupByRaw('DATE(created_at), status')->orderByDesc('order_date')->get()
            ->groupBy('order_date')
            ->map(fn ($items) => $items->map(fn ($item) => [
                'order_status' => $item->order_status,
                'total' => (int) $item->total,
            ])->values());

        return response()->json($rows);
    }

    public function service()
    {
        $month = now()->format('Y-m');
        $base = Order::where('domain', getDomain())
            ->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month);
        $count = (clone $base)->selectRaw('service_id, COUNT(*) as total')
            ->groupBy('service_id')->orderByDesc('total')->limit(20)
            ->with('service:id,name')->get();
        $charge = (clone $base)->selectRaw('service_id, SUM(charge) as total')
            ->groupBy('service_id')->orderByDesc('total')->limit(20)
            ->with('service:id,name')->get();

        return response()->json([$month => [
            'count' => $this->serviceRows($count),
            'charge' => $this->serviceRows($charge),
        ]]);
    }

    public function top10Services(Request $request)
    {
        [$from, $to] = $this->dateRange($request);
        $rows = Order::where('domain', getDomain())->whereBetween('created_at', [$from, $to])
            ->selectRaw('service_id, SUM(charge) as total')
            ->groupBy('service_id')->orderByDesc('total')->limit(10)
            ->with(['service:id,name,image,category_id', 'service.category:id,platform_id', 'service.category.platform:id,image'])
            ->get()->map(function ($row) {
                $service = $row->service;
                return [
                    'service_id' => $row->service_id,
                    'service_name' => $this->serviceName($service),
                    'platform_icon' => $service?->image ?: $service?->category?->platform?->image ?: 'fa-solid fa-star',
                    'total' => (float) $row->total,
                ];
            })->values();

        return response()->json($rows);
    }

    public function top10UsersCharge(Request $request)
    {
        [$from, $to] = $this->dateRange($request);
        $rows = Order::where('orders.domain', getDomain())
            ->whereBetween('orders.created_at', [$from, $to])
            ->join('users', 'users.id', '=', 'orders.user_id')
            ->selectRaw('users.id, users.username as account_user, SUM(orders.charge) as total')
            ->groupBy('users.id', 'users.username')->orderByDesc('total')->limit(10)->get()
            ->map(fn ($row) => ['account_user' => $row->account_user, 'total' => (float) $row->total]);

        return response()->json($rows);
    }

    public function summary()
    {
        $status = Order::where('domain', getDomain())
            ->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $normalized = collect($status)->mapWithKeys(fn ($value, $key) => [strtolower((string) $key) => (int) $value]);
        $get = fn ($name) => (int) $normalized->get(strtolower($name), 0);
        $deposit = Transaction::where('domain', getDomain())
            ->whereRaw('LOWER(status) = ?', ['completed'])
            ->whereIn('type', ['deposit', 'payment', 'fund'])->sum('amount');

        return response()->json([
            'total_order' => (int) $status->sum(),
            'total_deposit' => round((float) $deposit, 3),
            'status' => [
                'Failed' => $get('Failed'), 'Awaiting' => $get('Awaiting'),
                'Schedule' => $get('Schedule'), 'Pending' => $get('Pending'),
                'Processing' => $get('Processing'), 'In_progress' => $get('In progress'),
                'Done' => $get('Completed') + $get('Canceled') + $get('Partial'),
            ],
        ]);
    }

    private function serviceRows($rows): array
    {
        return $rows->map(fn ($row) => [
            'service_id' => $row->service_id,
            'service_name' => $this->serviceName($row->service),
            'total' => (float) $row->total,
        ])->values()->all();
    }

    private function serviceName($service): string
    {
        if (!$service) return 'N/A';
        $name = $service->name;
        return is_array($name)
            ? (string) ($name['en'] ?? $name['vi'] ?? reset($name) ?: 'N/A')
            : (string) ($name ?: 'N/A');
    }

    private function dateRange(Request $request): array
    {
        try {
            $from = Carbon::parse($request->input('from', now()))->startOfDay();
            $to = Carbon::parse($request->input('to', now()))->endOfDay();
        } catch (\Throwable) {
            abort(422, 'Invalid date range');
        }
        if ($from->gt($to)) abort(422, 'Invalid date range');
        return [$from, $to];
    }
}
