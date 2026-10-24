<?php

namespace App\Jobs;

use App\Http\Controllers\Crons\CronStatusController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateOrdersStatusJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 300;
    public int $uniqueFor = 120;

    public function __construct(public readonly int $providerId)
    {
        $this->onConnection(config('queue.default'))->onQueue('order-status');
    }

    public function handle(CronStatusController $controller): void
    {
        try {
            $controller->processOrdersStatus(request()->merge([
                'provider' => $this->providerId,
            ]));
        } catch (\Throwable $e) {
            Log::error('UpdateOrdersStatusJob failed', [
                'provider_id' => $this->providerId,
                'queue' => $this->queue,
                'error' => $e->getMessage(),
                'exception' => get_class($e),
            ]);
            throw $e;
        }
    }

    public function uniqueId(): string
    {
        return 'provider-status:' . $this->providerId;
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('UpdateOrdersStatusJob permanently failed', [
            'provider_id' => $this->providerId,
            'connection' => $this->connection,
            'queue' => $this->queue,
            'error' => $exception->getMessage(),
            'exception' => get_class($exception),
        ]);
    }
}
