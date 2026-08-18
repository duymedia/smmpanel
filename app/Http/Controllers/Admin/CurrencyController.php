<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $query = Currency::where('domain', $request->getHost());

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status === '1');
        }

        $currencies = $query->orderBy('created_at', 'desc')->get();

        return $request->expectsJson()
            ? response()->json(['success' => true, 'data' => $currencies])
            : view('admin.currency.index', compact('currencies'));
    }

    public function create()
    {
        return view('admin.currency.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies',
            'symbol' => 'nullable|string|max:10',
            'rate' => 'nullable|numeric|min:0',
            'status' => 'sometimes|boolean'
        ]);

        $validated['status'] = $request->boolean('status');
        $validated['domain'] = $request->getHost();
        $currency = Currency::create($validated);

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => "Tiền tệ <strong>{$currency->name}</strong> đã được tạo thành công!", 'currency' => $currency])
            : redirect()->route('admin.currency.index')->with('success', "Tiền tệ <strong>{$currency->name}</strong> đã được tạo thành công!");
    }

    public function show(Request $request, $id)
    {
        $currency = Currency::where('domain', $request->getHost())->findOrFail($id);

        return ($request->expectsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest')
            ? response()->json(['success' => true, 'currency' => $currency])
            : view('admin.currency.show', compact('currency'));
    }

    public function edit(Request $request, $id)
    {
        $currency = Currency::where('domain', $request->getHost())->findOrFail($id);
        return view('admin.currency.edit', compact('currency'));
    }

    public function update(Request $request, $id)
    {
        $currency = Currency::where('domain', $request->getHost())->findOrFail($id);

        if ($request->has('toggle_status')) {
            $statusValue = $request->input('status');
            $status = is_string($statusValue) ? filter_var($statusValue, FILTER_VALIDATE_BOOLEAN) : (bool) $statusValue;

            if ($currency->status !== $status) {
                $currency->update(['status' => $status]);
                $message = $status ? 'Kích hoạt tiền tệ thành công!' : 'Vô hiệu hóa tiền tệ thành công!';
            } else {
                $message = 'Trạng thái không thay đổi!';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'status' => $status,
                'currency' => $currency->fresh()
            ]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:currencies,code,' . $currency->id,
            'symbol' => 'nullable|string|max:10',
            'rate' => 'nullable|numeric|min:0'
        ]);

        $validated['status'] = $request->boolean('status');

        $currency->update($validated);
        $message = "Tiền tệ <strong>{$currency->name}</strong> đã được cập nhật thành công!";

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => $message, 'currency' => $currency->fresh()])
            : redirect()->route('admin.currency.index')->with('success', $message);
    }

    public function destroy(Request $request, $id)
    {
        $currency = Currency::where('domain', $request->getHost())->findOrFail($id);
        $currencyName = $currency->name;
        $currency->delete();

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => "Đã xóa tiền tệ {$currencyName} thành công!"])
            : redirect()->route('admin.currency.index')->with('success', "Đã xóa tiền tệ {$currencyName} thành công!");
    }

    public function toggleStatus(Request $request, $id)
    {
        $currency = Currency::where('domain', $request->getHost())->findOrFail($id);

        $newStatus = !$currency->status;
        $currency->update(['status' => $newStatus]);

        $message = $newStatus ? 'Kích hoạt tiền tệ thành công!' : 'Vô hiệu hóa tiền tệ thành công!';

        return response()->json([
            'success' => true,
            'message' => $message,
            'status' => $newStatus ? 1 : 0,
            'currency' => $currency->fresh()
        ]);
    }

    public function toggleSync(Request $request, $id)
    {
        $currency = Currency::where('domain', $request->getHost())->findOrFail($id);

        $newSync = !($currency->sync ?? false);
        $currency->update(['sync' => $newSync]);

        $message = $newSync ? 'Bật đồng bộ hóa thành công!' : 'Tắt đồng bộ hóa thành công!';

        return response()->json([
            'success' => true,
            'message' => $message,
            'sync' => $newSync ? 1 : 0,
            'currency' => $currency->fresh()
        ]);
    }

    public function fetchRates(Request $request)
    {
        // Fetch exchange rates from external API
        try {
            // This is a placeholder - implement actual API call
            return response()->json([
                'success' => true,
                'message' => 'Tỷ giá đã được cập nhật thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật tỷ giá: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateRates(Request $request)
    {
        try {
            $validated = $request->validate([
                'rates' => 'required|array',
                'rates.*.id' => 'required|integer',
                'rates.*.rate' => 'required|numeric|min:0'
            ]);

            foreach ($validated['rates'] as $rateData) {
                Currency::where('domain', $request->getHost())
                    ->where('id', $rateData['id'])
                    ->update(['rate' => $rateData['rate']]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tỷ giá đã được cập nhật thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật tỷ giá: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateCurrencies(Request $request)
    {
        try {
            $validated = $request->validate([
                'currencies' => 'required|array',
                'currencies.*.id' => 'required|integer',
                'currencies.*.name' => 'required|string',
                'currencies.*.code' => 'required|string',
                'currencies.*.symbol' => 'nullable|string'
            ]);

            foreach ($validated['currencies'] as $currencyData) {
                Currency::where('domain', $request->getHost())
                    ->where('id', $currencyData['id'])
                    ->update([
                        'name' => $currencyData['name'],
                        'code' => $currencyData['code'],
                        'symbol' => $currencyData['symbol'] ?? null
                    ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tiền tệ đã được cập nhật thành công!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi cập nhật tiền tệ: ' . $e->getMessage()
            ], 500);
        }
    }
}
