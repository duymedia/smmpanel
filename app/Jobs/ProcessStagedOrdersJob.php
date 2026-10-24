<?php

namespace App\Jobs;

use App\Http\Controllers\Crons\CronStatusController;
use App\Models\Order;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessStagedOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 60;
    public int $backoff = 5;

    public function __construct(
        public readonly int $orderId,
        public readonly string $domain,
    )
    {
        $this->onConnection(config('queue.default'))->onQueue('staged-orders');
    }

    public function handle(CronStatusController $controller): void
    {
        $path = storage_path('app/orders/' . $this->orderId . '.json');
        $order = Order::where('id', $this->orderId)
            ->where('domain', $this->domain)
            ->first();
        if (!$order) {
            File::delete($path);
            return;
        }

        // Queue a second time while the first job is still running.
        $lockKey = 'staged-order:' . $this->domain . ':' . $this->orderId;
        if (!Cache::add($lockKey, 1, 120)) {
            Log::info('Skip duplicate staged order job', [
                'order_id' => $this->orderId,
                'domain' => $this->domain,
            ]);
            return;
        }

        $retry = false;
        File::ensureDirectoryExists(dirname($path));
        try {
            // Do not overwrite a file owned by another worker.
            if (!File::exists($path)) {
                File::put($path, json_encode([
                    'order_id' => $order->id,
                    'service_id' => $order->service_id,
                    'service_type' => $order->service?->type_service ?? 'Default',
                    'order_data' => $order->order_data,
                    'domain' => $this->domain,
                ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }

            $controller->processStagedOrders(request()->merge(['order_id' => $order->id, 'ignore_delay' => true]));
            $order->refresh();
            if ($order->status === 'waiting') {
                $retry = true;
            }
        } finally {
            // Remove the lock before the job exits so retries/cron can re-run it.
            Cache::forget($lockKey);
            if (!$retry) File::delete($path);
        }
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('ProcessStagedOrdersJob permanently failed', [
            'order_id' => $this->orderId,
            'domain' => $this->domain,
            'connection' => $this->connection,
            'queue' => $this->queue,
            'error' => $exception->getMessage(),
            'exception' => get_class($exception),
        ]);
    }
}

