<?php

namespace App\Jobs;

use App\Http\Controllers\Crons\CronSyncController;
use App\Models\Service;
use App\Models\ApiProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SyncServiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 120;

    public function __construct(
        public readonly int $serviceId,
        public readonly int $providerId,
        public readonly ?array $apiData,
        public readonly string $syncBatch,
        public readonly string $domain,
    )
    {
        $this->onConnection(config('queue.default'))->onQueue('service-sync');
    }

    public function handle(CronSyncController $controller): void
    {
        try {
            $controller->syncServiceItem(
                $this->serviceId,
                $this->providerId,
                $this->apiData,
                $this->syncBatch,
                $this->domain
            );
        } catch (\Throwable $e) {
            Log::error('SyncServiceJob failed', [
                'service_id' => $this->serviceId,
                'provider_id' => $this->providerId,
                'domain' => $this->domain,
                'error' => $e->getMessage(),
                'exception' => get_class($e),
            ]);
            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('SyncServiceJob permanently failed', [
            'service_id' => $this->serviceId,
            'provider_id' => $this->providerId,
            'domain' => $this->domain,
            'connection' => $this->connection,
            'queue' => $this->queue,
            'error' => $exception->getMessage(),
            'exception' => get_class($exception),
        ]);
    }
}
