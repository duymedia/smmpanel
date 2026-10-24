<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApiProvider;
use App\Smm\Smm;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApiProviderController extends Controller
{
    public function index()
    {
        return view('admin.providers.index', [
            'providers' => ApiProvider::where('domain', getDomain())
                ->orderBy('position')
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }

    public function list(Request $request)
    {
        $filters = $request->validate([
            'type' => ['nullable', 'string', 'max:50'],
            'status' => ['nullable', 'boolean'],
            'search' => ['nullable', 'string', 'max:100'],
            'sort_by' => ['nullable', 'in:id,name,balance,currency,warning,position,status,created_at'],
            'sort_order' => ['nullable', 'in:asc,desc'],
        ]);
        $query = ApiProvider::where('domain', getDomain());
        !empty($filters['type']) && $query->where('type', $filters['type']);
        array_key_exists('status', $filters) && $query->where('status', (bool) $filters['status']);
        !empty($filters['search']) && $query->where('name', 'like', "%{$filters['search']}%");

        $sortBy = $filters['sort_by'] ?? 'position';
        $sortOrder = $filters['sort_order'] ?? 'asc';

        $query->orderBy($sortBy, $sortOrder);
        $sortBy !== 'created_at' && $query->orderBy('created_at', 'desc');

        return ['success' => true, 'data' => $query->get(['id', 'name', 'type', 'balance', 'currency', 'warning', 'position', 'status', 'created_at'])];
    }

    public function create()
    {
        return redirect()->route('admin.providers.index');
    }

    public function edit($providers = null)
    {
        return redirect()->route('admin.providers.index');
    }

    public function show(Request $request)
    {
        $provider = ApiProvider::where('domain', getDomain())->findOrFail($this->providerId($request));

        return [
            'success' => true,
            'id' => $provider->id,
            'url' => $provider->link,
            'key' => $provider->api_key,
            'name' => $provider->name,
            'rate' => $provider->rate_api,
            'balance_alert' => $provider->warning,
            'fixed_decimal' => $provider->fixed_decimal,
        ];
    }

    public function store(Request $request)
    {
        try {
            $validated = $this->validateProviderData($request);
            $validated += [
                'status' => true,
                'domain' => getDomain(),
                'type' => 'api',
                'fixed_decimal' => $validated['fixed_decimal'] ?? '10',
                'position' => (ApiProvider::where('domain', getDomain())->max('position') ?? 0) + 1,
            ];

            try {
                $balance = $this->fetchBalance($validated['link'], $validated['api_key']);
                if (!isset($balance['balance'])) {
                    return ['error' => 'Không thể kết nối tới API: ' . ($balance['error'] ?? 'Lỗi')];
                }
                $validated += $balance;
            } catch (\Exception $e) {
                Log::error('Fetch.balance', ['url' => $validated['link'], 'error' => $e->getMessage()]);
                return ['error' => 'Không thể kết nối tới API: ' . $e->getMessage()];
            }

            $provider = ApiProvider::create($validated);

            return [
                'success' => true,
                'message' => "Thêm nhà cung cấp '{$provider->name}' thành công!",
                'data' => $provider,
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ['error' => collect($e->errors())->flatten()->first()];
        } catch (\Exception $e) {
            Log::error('Provider.store', ['error' => $e->getMessage()]);
            return ['error' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }

    public function update(Request $request)
    {
        try {
            $provider = ApiProvider::where('domain', getDomain())->findOrFail($this->providerId($request));
            $data = $this->validateProviderData($request, $provider);

            if (empty($data['api_key'] ?? null)) {
                unset($data['api_key']);
            }

            $data['fixed_decimal'] ??= $provider->fixed_decimal;
            $provider->update($data);

            return [
                'success' => true,
                'message' => "Cập nhật nhà cung cấp '{$provider->name}' thành công!",
                'data' => $provider->fresh(),
            ];
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ['error' => collect($e->errors())->flatten()->first()];
        } catch (\Exception $e) {
            Log::error('Provider.update', ['error' => $e->getMessage()]);
            return ['error' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }

    public function destroy(Request $request)
    {
        try {
            $provider = ApiProvider::where('domain', getDomain())->findOrFail($this->providerId($request));
            $name = $provider->name;
            $provider->delete();

            return ['success' => true, 'message' => "Đã xóa nhà cung cấp '{$name}' thành công!"];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return ['error' => 'Nhà cung cấp không tồn tại'];
        } catch (\Exception $e) {
            Log::error('Provider.delete', ['error' => $e->getMessage()]);
            return ['error' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }

    public function getBalance(Request $request)
    {
        try {
            $provider = ApiProvider::where('domain', getDomain())->findOrFail($this->providerId($request));

            if (!$provider->link || !$provider->api_key) {
                return ['error' => "Nhà cung cấp '{$provider->name}' chưa cấu hình API URL hoặc API Key"];
            }

            try {
                $balance = $this->fetchBalance($provider->link, $provider->api_key);
            } catch (\Exception $e) {
                Log::error('Fetch.balance', ['url' => $provider->link, 'error' => $e->getMessage()]);
                return ['error' => $e->getMessage()];
            }

            if (!isset($balance['balance'])) {
                $provider->update(['balance' => 0, 'status' => false]);
                return ['error' => $balance['error'] ?? 'Không thể lấy số dư từ API'];
            }

            $provider->update([
                'balance' => $balance['balance'],
                'currency' => $balance['currency'] ?? $provider->currency,
            ]);

            return [
                'success' => true,
                'message' => "Cập nhật số dư '{$provider->name}' thành công!",
                'balance' => $balance['balance'],
                'currency' => $balance['currency'] ?? $provider->currency,
            ];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException) {
            return ['error' => 'Nhà cung cấp không tồn tại'];
        } catch (\Exception $e) {
            Log::error('Provider.getBalance', ['error' => $e->getMessage()]);
            return ['error' => 'Lỗi hệ thống: ' . $e->getMessage()];
        }
    }

    public function syncAllBalances()
    {
        $providers = ApiProvider::where('domain', getDomain())
            ->where('status', true)
            ->whereNotNull('link')
            ->whereNotNull('api_key')
            ->get();

        if ($providers->isEmpty()) {
            return ['error' => 'Không có nhà cung cấp nào được cấu hình'];
        }

        $results = $providers->map(function ($provider) {
            try {
                $balance = $this->fetchBalance($provider->link, $provider->api_key);

                if (isset($balance['balance'])) {
                    $provider->update([
                        'balance' => $balance['balance'],
                        'currency' => $balance['currency'] ?? $provider->currency,
                    ]);

                    return ['id' => $provider->id, 'name' => $provider->name, 'success' => true] + $balance;
                }

                return [
                    'id' => $provider->id,
                    'name' => $provider->name,
                    'success' => false,
                    'error' => $balance['error'] ?? 'Lỗi',
                ];
            } catch (\Exception $e) {
                return ['id' => $provider->id, 'name' => $provider->name, 'success' => false, 'error' => $e->getMessage()];
            }
        });

        $success = $results->where('success', true)->count();
        $fail = $results->where('success', false)->count();

        return [
            'success' => true,
            'message' => "Cập nhật {$success} thành công" . ($fail > 0 ? ", {$fail} thất bại" : ''),
            'results' => $results,
        ];
    }

    public function sort(Request $request)
    {
        $items = $request->input('data.dataSort', []);
        if (empty($items)) {
            return ['error' => 'No data'];
        }

        foreach ($items as $index => $item) {
            $id = Arr::get($item, 'i', $item);
            $position = (int) Arr::get($item, 's', $index + 1);

            ApiProvider::where('id', $id)
                ->where('domain', getDomain())
                ->update(['position' => $position]);
        }

        return ['success' => adminMessage('update')];
    }

    public function products(Request $request)
    {
        try {
            ApiProvider::where('domain', getDomain())->findOrFail($this->providerId($request));
            return ['success' => []];
        } catch (\Exception $e) {
            Log::error('Provider.products', ['error' => $e->getMessage()]);
            return ['error' => $e->getMessage()];
        }
    }

    public function syncFor1dg()
    {
        try {
            $count = ApiProvider::where('domain', getDomain())->where('status', true)->count();
            return ['success' => "Synced {$count} providers"];
        } catch (\Exception $e) {
            Log::error('Provider.syncFor1dg', ['error' => $e->getMessage()]);
            return ['error' => 'Sync failed: ' . $e->getMessage()];
        }
    }

    public function checkOfNMH(Request $request)
    {
        try {
            ApiProvider::where('domain', getDomain())->findOrFail($this->providerId($request));
            return ['error' => 'NMH check not implemented'];
        } catch (\Exception $e) {
            Log::error('Provider.checkOfNMH', ['error' => $e->getMessage()]);
            return ['error' => $e->getMessage()];
        }
    }

    private function validateProviderData(Request $request, ?ApiProvider $provider = null): array
    {
        $input = $request->input('data', []);
        if (!is_array($input) || $input === []) {
            $input = $request->only(['url', 'link', 'key', 'api_key', 'name', 'rate', 'rate_api', 'fixed_decimal', 'balance_alert', 'warning']);
        }

        $data = [
            'link' => $input['url'] ?? $input['link'] ?? '',
            'api_key' => $input['key'] ?? $input['api_key'] ?? '',
            'name' => $input['name'] ?? '',
            'rate_api' => $input['rate'] ?? $input['rate_api'] ?? '1',
            'fixed_decimal' => $input['fixed_decimal'] ?? '10',
            'warning' => $input['balance_alert'] ?? $input['warning'] ?? '0',
        ];

        $nameRule = Rule::unique('api_providers', 'name')
            ->where(fn ($query) => $query->where('domain', getDomain()));
        if ($provider) {
            $nameRule->ignore($provider->id);
        }

        $rules = [
            'name' => ['required', 'string', 'max:255', $nameRule],
            'link' => ['required', 'url', 'max:500'],
            'api_key' => [$provider ? 'nullable' : 'required', 'string', 'max:500'],
            'rate_api' => ['nullable', 'numeric', 'min:0'],
            'fixed_decimal' => ['nullable', 'integer', 'between:0,10'],
            'warning' => ['nullable', 'numeric', 'min:0'],
        ];

        return Validator::make($data, $rules)->validate();
    }

    private function providerId(Request $request): mixed
    {
        return $request->input('data.id', $request->route('providers'));
    }

    private function fetchBalance(string $url, string $apiKey): array
    {
        $balance = $this->requestBalance($url, $apiKey, 'json');
        if (isset($balance['balance']) || isset($balance['currency'])) {
            return $balance;
        }

        $fallback = $this->requestBalance($url, $apiKey, 'form');
        if (isset($fallback['balance']) || isset($fallback['currency'])) {
            return $fallback;
        }

        return $fallback ?: $balance;
    }

    private function requestBalance(string $url, string $apiKey, string $format): array
    {
        $smm = new Smm();
        $smm->api_url = $url;
        $smm->api_key = $apiKey;
        $smm->format = $format;

        $result = $smm->balance();

        return is_object($result) ? (array) $result : ($result ?? []);
    }
}
