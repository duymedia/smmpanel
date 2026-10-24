<?php

namespace App\Http\Controllers\Crons;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ApiProvider;
use App\Models\ServiceSyncLog;
use App\Smm\Smm;
use App\Jobs\SyncServiceJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CronSyncController extends Controller
{
    private string $syncBatch;

    public function syncServices(Request $request)
    {
        $providerId = $request->query('provider');
        if (!$providerId) {
            return response()->json(['status' => 'error', 'message' => 'Provider ID is required'], 400);
        }

        $provider = ApiProvider::where('domain', getDomain())->find($providerId);
        if (!$provider) {
            return response()->json(['status' => 'error', 'message' => 'Provider not found'], 404);
        }

        $services = Service::where('domain', getDomain())
            ->where('provider_id', $providerId)
            ->where('status', 1)
            ->whereNotNull('service_api')
            ->where('service_api', '!=', '')
            ->get();

        if ($services->isEmpty()) {
            return response()->json(['status' => 'success', 'message' => 'No services to sync']);
        }

        $smm          = new Smm();
        $smm->api_url = $provider->link;
        $smm->api_key = $provider->api_key;

        $this->syncBatch = (string) Str::uuid();

        try {
            $apiServices = $smm->services();
            if (isset($apiServices->error)) {
                Log::error('Smm services error', ['provider_id' => $providerId, 'error' => $apiServices->error]);
                return response()->json(['status' => 'error', 'message' => $apiServices->error], 500);
            }

            $apiMap = [];
            foreach ($apiServices as $item) {
                if (isset($item->service)) $apiMap[(string) $item->service] = $item;
            }

            foreach ($services as $service) {
                $apiData = $apiMap[(string) $service->service_api] ?? null;
                SyncServiceJob::dispatch(
                    $service->id,
                    $provider->id,
                    $apiData ? (array) $apiData : null,
                    $this->syncBatch
                );
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Sync jobs queued',
                'queued' => $services->count(),
                'sync_batch' => $this->syncBatch,
            ]);
        } catch (\Exception $e) {
            Log::error('Cron sync failed', ['provider_id' => $providerId, 'error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /** Process one service inside a queue worker. */
    public function syncServiceItem(int $serviceId, int $providerId, ?array $apiData, string $syncBatch): void
    {
        $this->syncBatch = $syncBatch;
        $service = Service::where('id', $serviceId)->where('domain', getDomain())->first();
        $provider = $service
            ? ApiProvider::whereKey($service->provider_id)
                ->where('id', $providerId)
                ->where('domain', getDomain())
                ->first()
            : null;
        if (!$service || !$provider) return;

        $api = $apiData === null ? null : (object) $apiData;
        if (!$api) {
            if ($service->sync_status) {
                $service->update(['status' => 0]);
                $this->log($service, $provider, 'disable', 'status', 1, 0, 'api');
            }
            return;
        }

        $changes = [];
        $needSave = false;
        $decimals = max(0, min(12, (int) ($provider->fixed_decimal ?? 10)));
        $rateApi = (float) ($provider->rate_api ?? 1);
        if ($rateApi <= 0) {
            $rateApi = 1;
        }

        $this->syncRate($service, $api, $changes, $needSave, $decimals, $rateApi);
        $this->syncMinMax($service, $api, $changes);
        $this->syncRefill($service, $api, $changes);
        $this->syncCancel($service, $api, $changes);
        if (!$needSave && !$changes) return;

        $service->save();
        foreach ($changes as $change) {
            $this->log($service, $provider, $change['change_type'], $change['field'], $change['old_value'], $change['new_value'], $change['log_type'] ?? 'api');
        }
    }
    private function syncRate(
        Service $service,
        object $api,
        array &$changes,
        bool &$needSave,
        int $decimals = 10,
        float $rateApi = 1
    ): void
    {
        if (!$service->sync_rate || !isset($api->rate)) return;

        $attr = $service->getAttributes();
        $newRate  = round((float) $api->rate / $rateApi, $decimals);
        $oldRate  = (float) ($attr['rate_original']    ?? 0);
        if (round($oldRate, $decimals) >= $newRate) return;

        // Khi chưa cấu hình phần trăm tăng giá, giữ giá bán bằng rate provider.
        $upRetail = $attr['rate_retail_up'] === null ? 100 : (float) $attr['rate_retail_up'];
        $upAgent  = $attr['rate_agent_up'] === null ? 100 : (float) $attr['rate_agent_up'];
        $upDist   = $attr['rate_distributor_up'] === null ? 100 : (float) $attr['rate_distributor_up'];

        $calcRetail = round($newRate * $upRetail / 100, $decimals);
        $calcAgent  = round($newRate * $upAgent  / 100, $decimals);
        $calcDist   = round($newRate * $upDist   / 100, $decimals);

        if (round($newRate, $decimals) !== round($oldRate, $decimals)) {
            $service->rate_original = $newRate;
            $needSave = true;
            $changes[] = [
                'field' => 'rate',
                'change_type' => $newRate > $oldRate ? 'price_increase' : 'price_decrease',
                'old_value' => $oldRate,
                'new_value' => $newRate,
                'log_type' => 'api',
            ];
        }

        foreach ([
            'rate_retail' => $calcRetail,
            'rate_agent' => $calcAgent,
            'rate_distributor' => $calcDist,
        ] as $field => $rate) {
            $old = (float) ($attr[$field] ?? 0);
            if (round($rate, $decimals) === round($old, $decimals)) continue;

            $service->{$field} = $rate;
            $needSave = true;
            $changes[] = [
                'field' => $field,
                'change_type' => $rate > $old ? 'price_increase' : 'price_decrease',
                'old_value' => $old,
                'new_value' => $rate,
                'log_type' => 'api',
            ];
        }
    }

    private function syncMinMax(Service $service, object $api, array &$changes): void
    {
        if (!$service->sync_min_max || !isset($api->min, $api->max)) return;

        $newMin = (int) $api->min;
        $newMax = (int) $api->max;

        if ($newMin !== (int) $service->min) {
            $changes[] = ['field' => 'min', 'change_type' => 'min_max_change', 'old_value' => (int) $service->min, 'new_value' => $newMin];
            $service->min = $newMin;
        }
        if ($newMax !== (int) $service->max) {
            $changes[] = ['field' => 'max', 'change_type' => 'min_max_change', 'old_value' => (int) $service->max, 'new_value' => $newMax];
            $service->max = $newMax;
        }
    }

    private function syncRefill(Service $service, object $api, array &$changes): void
    {
        if (!$service->sync_refill || !isset($api->refill)) return;

        $new = $api->refill ? 1 : 0;
        if ($new !== (int) $service->refill) {
            $changes[] = ['field' => 'refill', 'change_type' => $new ? 'enable' : 'disable', 'old_value' => (int) $service->refill, 'new_value' => $new];
            $service->refill = $new;
        }
    }

    private function syncCancel(Service $service, object $api, array &$changes): void
    {
        if (!$service->sync_cancel || !isset($api->cancel)) return;

        $new = $api->cancel ? 1 : 0;
        if ($new !== (int) $service->cancel) {
            $changes[] = ['field' => 'cancel', 'change_type' => $new ? 'enable' : 'disable', 'old_value' => (int) $service->cancel, 'new_value' => $new];
            $service->cancel = $new;
        }
    }

    // ── Log helper ────────────────────────────────────────────────────────────

    private function log(Service $service, ApiProvider $provider, string $changeType, ?string $field, $oldValue, $newValue, string $logType = 'api'): void
    {
        // Bỏ qua nếu đã có bản ghi giống hệt trong ngày hôm nay
        $exists = ServiceSyncLog::where('service_id', $service->id)
            ->where('domain', getDomain())
            ->where('change_type', $changeType)
            ->where('field_changed', $field)
            ->where('new_value', $newValue)
            ->whereDate('created_at', today())
            ->exists();

        if ($exists) return;

        $data = [
            'service_id'    => $service->id,
            'provider_id'   => $provider->id,
            'provider_name' => $provider->name,
            'service_api'   => $service->service_api,
            'change_type'   => $changeType,
            'old_value'     => $oldValue,
            'new_value'     => $newValue,
            'field_changed' => $field,
            'is_read'       => false,
            'domain'        => getDomain(),
        ];

        if (Schema::hasColumn('service_sync_logs', 'log_type'))   $data['log_type']   = $logType;
        if (Schema::hasColumn('service_sync_logs', 'sync_batch')) $data['sync_batch'] = $this->syncBatch;

        ServiceSyncLog::create($data);
    }
}
