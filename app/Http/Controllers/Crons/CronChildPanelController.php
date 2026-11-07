<?php

namespace App\Http\Controllers\Crons;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildPanel;
use App\Models\Platform;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class CronChildPanelController extends Controller
{
    public function syncConfigured(): array
    {
        $summary = ['panels' => 0, 'synced' => 0, 'failed' => 0];

        ChildPanel::where('status', 'completed')
            ->where(fn ($query) => $query->whereNull('expires_at')->orWhere('expires_at', '>=', now()))
            ->orderBy('id')
            ->chunkById(50, function ($panels) use (&$summary): void {
                foreach ($panels as $panel) {
                    if (!data_get($panel->settings, 'service_sync.auto_sync', false)) continue;
                    $summary['panels']++;

                    try {
                        $this->syncPanel($panel);
                        $summary['synced']++;
                    } catch (Throwable $exception) {
                        $summary['failed']++;
                        Log::error('Child panel service sync failed', [
                            'child_panel_id' => $panel->id,
                            'domain' => $panel->domain,
                            'domain_panel' => $panel->domain_panel,
                            'error' => $exception->getMessage(),
                        ]);
                    }
                }
            });

        return $summary;
    }

    public function syncPanel(ChildPanel $panel): array
    {
        $panel->refresh();
        if (!$panel->is_active) {
            throw new RuntimeException('Child panel is not active.');
        }

        $sourceDomain = strtolower(trim((string) $panel->domain));
        $targetDomain = strtolower(trim((string) $panel->domain_panel));
        if ($sourceDomain === '' || $targetDomain === '' || $sourceDomain === $targetDomain) {
            throw new RuntimeException('Invalid main or child panel domain.');
        }

        $lock = Cache::lock('child-panel-service-sync:' . sha1($targetDomain), 600);
        if (!$lock->get()) {
            throw new RuntimeException('A service sync is already running for this child panel.');
        }

        try {
            return DB::transaction(function () use ($panel, $sourceDomain, $targetDomain): array {
                $settings = is_array($panel->settings) ? $panel->settings : [];
                $syncSettings = is_array($settings['service_sync'] ?? null) ? $settings['service_sync'] : [];
                $percent = max(0, min(1000, (float) ($syncSettings['markup_percent'] ?? 0)));
                $maps = is_array($syncSettings['maps'] ?? null) ? $syncSettings['maps'] : [];
                $platformMap = is_array($maps['platforms'] ?? null) ? $maps['platforms'] : [];
                $categoryMap = is_array($maps['categories'] ?? null) ? $maps['categories'] : [];
                $serviceMap = is_array($maps['services'] ?? null) ? $maps['services'] : [];
                $platformTargets = Platform::where('domain', $targetDomain)->get()->keyBy('id');
                $categoryTargets = Category::where('domain', $targetDomain)->get()->keyBy('id');
                $serviceTargets = Service::where('domain', $targetDomain)->get()->keyBy('id');
                $counts = [
                    'platforms_created' => 0, 'platforms_updated' => 0,
                    'categories_created' => 0, 'categories_updated' => 0,
                    'services_created' => 0, 'services_updated' => 0,
                ];

                foreach (Platform::where('domain', $sourceDomain)->orderBy('position')->get() as $source) {
                    $target = $this->mapped($platformMap, $source->id, $platformTargets);
                    if (!$target) {
                        $sourceName = strtolower(trim((string) $source->name));
                        $target = $platformTargets->first(
                            fn (Platform $item) => strtolower(trim((string) $item->name)) === $sourceName
                        );
                    }
                    if ($target) {
                        $platformMap[(string) $source->id] = $target->id;
                        continue;
                    }

                    $target = new Platform();
                    $target->fill([
                        'name' => $source->name,
                        'image' => $source->image,
                        'position' => $source->position,
                        'status' => $source->status,
                        'domain' => $targetDomain,
                    ]);
                    $this->saveMapped($target, true, $platformMap, $source->id, $counts, 'platforms');
                    $platformTargets->put($target->id, $target);
                }

                foreach (Category::where('domain', $sourceDomain)->orderBy('position')->get() as $source) {
                    $platformId = $platformMap[(string) $source->platform_id] ?? $platformMap[$source->platform_id] ?? null;
                    if (!$platformId) continue;

                    $target = $this->mapped($categoryMap, $source->id, $categoryTargets);
                    if (!$target) {
                        $sourceName = $this->nameKey($source->name);
                        $target = $categoryTargets->first(fn (Category $item) =>
                            (int) $item->platform_id === (int) $platformId && $this->nameKey($item->name) === $sourceName
                        );
                    }
                    if ($target) {
                        $categoryMap[(string) $source->id] = $target->id;
                        continue;
                    }

                    $target = new Category();
                    $target->fill([
                        'platform_id' => $platformId,
                        'name' => $this->localizedName($source->name),
                        'image' => $source->image,
                        'display' => $source->display,
                        'position' => $source->position,
                        'status' => $source->status,
                        'domain' => $targetDomain,
                    ]);
                    $this->saveMapped($target, true, $categoryMap, $source->id, $counts, 'categories');
                    $categoryTargets->put($target->id, $target);
                }

                foreach (Service::where('domain', $sourceDomain)->orderBy('position')->get() as $source) {
                    $categoryId = $categoryMap[(string) $source->category_id] ?? $categoryMap[$source->category_id] ?? null;
                    if (!$categoryId) continue;

                    $target = $this->mapped($serviceMap, $source->id, $serviceTargets);
                    if (!$target) {
                        $target = $serviceTargets->first(function (Service $item) use ($source, $categoryId): bool {
                            if (!$item->status || (int) $item->category_id !== (int) $categoryId) return false;
                            if ($source->provider_id && $source->service_api) {
                                return (int) $item->provider_id === (int) $source->provider_id
                                    && (string) $item->service_api === (string) $source->service_api;
                            }
                            return $this->nameKey($item->name) === $this->nameKey($source->name);
                        });
                    }
                    if ($target) {
                        $serviceMap[(string) $source->id] = $target->id;
                        if ($this->syncExistingPrices($target, $source, $percent)) {
                            $counts['services_updated']++;
                        }
                        continue;
                    }

                    $target = new Service();
                    $attributes = array_intersect_key($source->getAttributes(), array_flip($source->getFillable()));
                    unset($attributes['id'], $attributes['created_at'], $attributes['updated_at']);
                    $attributes['name'] = $this->localizedName($source->name);
                    foreach ([
                        'quantity_discount_data', 'advanced_settings_data',
                        'check_count_data', 'summaries',
                    ] as $jsonField) {
                        $attributes[$jsonField] = $this->jsonArray($source->{$jsonField});
                    }
                    $attributes['attributes'] = $this->jsonArray($source->attributes) ?? [];
                    $attributes['overflow'] = 0;
                    $attributes['quantity_discount'] = false;
                    $attributes['quantity_discount_data'] = [];
                    $attributes['advanced_settings'] = false;
                    $attributes['advanced_settings_data'] = ['min_balance' => 0, 'max_order' => 0];
                    $attributes['check_count'] = false;
                    $attributes['check_count_data'] = ['type' => 'facebook-followers', 'percent' => 0, 'auto' => 0];
                    $attributes['hidden_api'] = false;
                    $attributes['category_id'] = $categoryId;
                    $attributes['domain'] = $targetDomain;

                    foreach (['rate_retail', 'rate_agent', 'rate_distributor'] as $rateField) {
                        if (is_numeric($attributes[$rateField] ?? null)) {
                            $attributes[$rateField] = $this->markedUpRate($attributes[$rateField], $percent);
                        }
                    }

                    $target->fill($attributes);
                    $this->saveMapped($target, true, $serviceMap, $source->id, $counts, 'services');
                    $serviceTargets->put($target->id, $target);
                }

                $duplicatesHidden = $this->hideEmptyPlatformDuplicates($sourceDomain, $targetDomain, $platformMap);
                $syncSettings['markup_percent'] = $percent;
                $syncSettings['maps'] = [
                    'platforms' => $platformMap,
                    'categories' => $categoryMap,
                    'services' => $serviceMap,
                ];
                $syncSettings['last_counts'] = $counts;
                $settings['service_sync'] = $syncSettings;
                $panel->settings = $settings;
                $panel->last_sync_at = now();
                $panel->total_services = Service::where('domain', $targetDomain)->where('status', true)->count();
                $panel->save();

                return $counts + [
                    'markup_percent' => $percent,
                    'total_services' => $panel->total_services,
                    'empty_duplicate_platforms_hidden' => $duplicatesHidden,
                ];
            });
        } catch (Throwable $exception) {
            Log::error('Child panel service sync transaction failed', [
                'child_panel_id' => $panel->id,
                'domain' => $sourceDomain,
                'domain_panel' => $targetDomain,
                'error' => $exception->getMessage(),
            ]);
            throw $exception;
        } finally {
            $lock->release();
        }
    }

    private function mapped(array $map, int $sourceId, Collection $targets): ?Model
    {
        $targetId = $map[(string) $sourceId] ?? $map[$sourceId] ?? null;
        return $targetId ? $targets->get((int) $targetId) : null;
    }

    private function localizedName(mixed $value): array
    {
        for ($depth = 0; $depth < 3 && is_string($value); $depth++) {
            $decoded = json_decode($value, true);
            if (!is_array($decoded)) break;
            $value = $decoded;
        }

        return is_array($value) ? $value : ['en' => trim((string) $value)];
    }

    private function nameKey(mixed $value): string
    {
        $name = $this->localizedName($value);
        return strtolower(trim((string) ($name['en'] ?? reset($name) ?? '')));
    }

    private function syncExistingPrices(Service $target, Service $source, float $percent): bool
    {
        $changed = false;
        foreach (['rate_retail', 'rate_agent', 'rate_distributor'] as $field) {
            $expected = $this->markedUpRate($source->{$field}, $percent);
            if ($expected === null || number_format((float) $target->{$field}, 8, '.', '') === $expected) continue;
            $target->{$field} = $expected;
            $changed = true;
        }

        if ($changed) $target->saveQuietly();
        return $changed;
    }

    private function markedUpRate(mixed $rate, float $percent): ?string
    {
        return is_numeric($rate)
            ? number_format(round((float) $rate * (1 + $percent / 100), 8), 8, '.', '')
            : null;
    }

    private function jsonArray(mixed $value): ?array
    {
        for ($depth = 0; $depth < 3 && is_string($value); $depth++) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) return $decoded;
            if (!is_string($decoded)) return null;
            $value = $decoded;
        }

        return is_array($value) ? $value : null;
    }

    private function hideEmptyPlatformDuplicates(string $sourceDomain, string $targetDomain, array $platformMap): int
    {
        $hidden = 0;
        $childPlatforms = Platform::where('domain', $targetDomain)->get();

        foreach (Platform::where('domain', $sourceDomain)->get() as $source) {
            $targetId = $platformMap[(string) $source->id] ?? $platformMap[$source->id] ?? null;
            if (!$targetId) continue;

            $sourceName = strtolower(trim((string) $source->name));
            foreach ($childPlatforms as $duplicate) {
                if ($duplicate->id === (int) $targetId || strtolower(trim((string) $duplicate->name)) !== $sourceName) {
                    continue;
                }

                $categoryIds = Category::where('domain', $targetDomain)
                    ->where('platform_id', $duplicate->id)
                    ->pluck('id');
                $hasServices = $categoryIds->isNotEmpty() && Service::where('domain', $targetDomain)
                    ->whereIn('category_id', $categoryIds)
                    ->exists();

                if (!$hasServices) {
                    if ($duplicate->status) {
                        $duplicate->status = false;
                        $duplicate->saveQuietly();
                        $hidden++;
                    }
                    Category::where('domain', $targetDomain)
                        ->where('platform_id', $duplicate->id)
                        ->where('status', true)
                        ->update(['status' => false]);
                }
            }
        }

        return $hidden;
    }

    private function saveMapped(
        Platform|Category|Service $target,
        bool $created,
        array &$map,
        int $sourceId,
        array &$counts,
        string $type
    ): void {
        if ($created) {
            $target->saveQuietly();
            $counts[$type . '_created']++;
        } elseif ($target->isDirty()) {
            $target->saveQuietly();
            $counts[$type . '_updated']++;
        }

        $map[(string) $sourceId] = $target->id;
    }
}
