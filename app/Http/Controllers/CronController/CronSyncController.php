<?php

namespace App\Http\Controllers\CronController;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ApiProvider;
use App\Models\ServiceSyncLog;
use App\Smm\Smm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CronSyncController extends Controller
{
    private string $domain;
    private string $syncBatch;

    public function syncServices(Request $request)
    {
        $providerId = $request->query('provider');
        if (!$providerId) {
            return response()->json(['status' => 'error', 'message' => 'Provider ID is required'], 400);
        }

        $provider = ApiProvider::find($providerId);
        if (!$provider) {
            return response()->json(['status' => 'error', 'message' => 'Provider not found'], 404);
        }

        $services = Service::where('provider_id', $providerId)
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

        $this->domain    = getDomain();
        $this->syncBatch = (string) Str::uuid();

        $updated = $skipped = $errors = 0;

        try {
            $apiServices = $smm->services();

            if (isset($apiServices->error)) {
                Log::error('Smm services error', ['provider_id' => $providerId, 'error' => $apiServices->error]);
                return response()->json(['status' => 'error', 'message' => $apiServices->error], 500);
            }

            // Map: service_id (string) => object
            $apiMap = [];
            foreach ($apiServices as $item) {
                if (isset($item->service)) {
                    $apiMap[(string) $item->service] = $item;
                }
            }

            foreach ($services as $service) {
                $api = $apiMap[(string) $service->service_api] ?? null;

                // Không tìm thấy service từ Smm => tắt nếu sync_status bật
                if (!$api) {
                    if ($service->sync_status) {
                        $service->status = 0;
                        $service->save();
                        $this->log($service, $provider, 'disable', 'status', 1, 0, 'api');
                    }
                    $skipped++;
                    continue;
                }

                try {
                    $changes  = [];
                    $needSave = false;

                    $this->syncRate($service, $api, $changes, $needSave);
                    $this->syncMinMax($service, $api, $changes);
                    $this->syncRefill($service, $api, $changes);
                    $this->syncCancel($service, $api, $changes);

                    if ($needSave || !empty($changes)) {
                        $service->save();
                        foreach ($changes as $c) {
                            $this->log($service, $provider, $c['change_type'], $c['field'], $c['old_value'], $c['new_value'], $c['log_type'] ?? 'api');
                        }
                        $updated++;
                    } else {
                        $skipped++;
                    }
                } catch (\Exception $e) {
                    $errors++;
                    Log::error('Error syncing service', ['service_id' => $service->id, 'error' => $e->getMessage()]);
                }
            }

            return response()->json(['status' => 'success', 'message' => 'Sync completed', 'updated' => $updated, 'skipped' => $skipped, 'errors' => $errors]);

        } catch (\Exception $e) {
            Log::error('Cron sync failed', ['provider_id' => $providerId, 'error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // ── Sync helpers ──────────────────────────────────────────────────────────

    private function syncRate(Service $service, object $api, array &$changes, bool &$needSave): void
    {
        if (!$service->sync_rate || !isset($api->rate)) return;

        $attr = $service->getAttributes();
        $newRate  = (float) $api->rate;
        $oldRate  = (float) ($attr['rate_original']    ?? 0);
        $upRetail = (float) ($attr['rate_retail_up']   ?? 0);
        $upAgent  = (float) ($attr['rate_agent_up']    ?? 0);
        $upDist   = (float) ($attr['rate_distributor_up'] ?? 0);

        $calcRetail = round($newRate * $upRetail / 100, 8);
        $calcAgent  = round($newRate * $upAgent  / 100, 8);
        $calcDist   = round($newRate * $upDist   / 100, 8);

        $rateChanged   = round($newRate, 8) !== round($oldRate, 8);
        $retailChanged = $calcRetail !== round((float)($attr['rate_retail']      ?? 0), 8);
        $agentChanged  = $calcAgent  !== round((float)($attr['rate_agent']       ?? 0), 8);
        $distChanged   = $calcDist   !== round((float)($attr['rate_distributor'] ?? 0), 8);

        if (!$rateChanged && !$retailChanged && !$agentChanged && !$distChanged) return;

        $service->rate_original    = $newRate;
        $service->rate_retail      = $newRate * $upRetail / 100;
        $service->rate_agent       = $newRate * $upAgent  / 100;
        $service->rate_distributor = $newRate * $upDist   / 100;
        $needSave = true;

        if ($rateChanged) {
            // rate từ Smm() thay đổi => log_type api
            $changes[] = ['field' => 'rate', 'change_type' => $newRate > $oldRate ? 'price_increase' : 'price_decrease', 'old_value' => $oldRate, 'new_value' => $newRate, 'log_type' => 'api'];
        } else {
            // chỉ rate_retail/agent/distributor thay đổi do _up => log_type website
            $changes[] = ['field' => 'rate', 'change_type' => 'price_same', 'old_value' => (float)($attr['rate_retail'] ?? 0), 'new_value' => $calcRetail, 'log_type' => 'website'];
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
            ->where('domain', $this->domain)
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
            'domain'        => $this->domain,
        ];

        if (\Schema::hasColumn('service_sync_logs', 'log_type'))   $data['log_type']   = $logType;
        if (\Schema::hasColumn('service_sync_logs', 'sync_batch')) $data['sync_batch'] = $this->syncBatch;

        ServiceSyncLog::create($data);
    }
}
