<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
use App\Models\ApiProvider;
use App\Models\Order;
use App\Jobs\ProcessStagedOrdersJob;
use App\Jobs\UpdateOrdersStatusJob;
use App\Http\Controllers\Crons\CronStatusController;
use App\Http\Controllers\Crons\CronSyncController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('orders:update-status', function () {
    $providers = ApiProvider::where('status', true)->pluck('id');

    foreach ($providers as $providerId) {
        try {
            UpdateOrdersStatusJob::dispatch((int) $providerId);
        } catch (\Throwable $e) {
            report($e);
            UpdateOrdersStatusJob::dispatchSync((int) $providerId);
        }
    }

    $this->info("Queued status updates for {$providers->count()} providers.");
})->purpose('Update active provider order statuses');

Artisan::command('orders:process-staged', function () {
    $path = storage_path('app/orders');
    $files = File::glob($path . DIRECTORY_SEPARATOR . '*.json');
    $processed = 0;
    $queuedIds = [];

    foreach ($files as $file) {
        $staged = json_decode(File::get($file), true) ?: [];
        $orderId = (int) ($staged['order_id'] ?? 0);
        $domain = (string) ($staged['domain'] ?? getDomain());

        if (!$orderId) {
            continue;
        }

        try {
            ProcessStagedOrdersJob::dispatch($orderId, $domain)->delay(now()->addSeconds(3));
            $queuedIds[$orderId] = true;
            $processed++;
        } catch (\Throwable $e) {
            File::delete($file);
            report($e);
        }
    }

    // Retry orders left waiting after a previous provider/API failure, even
    // when their temporary staging file was already removed.
    foreach (Order::where('status', 'waiting')->where('domain', getDomain())->pluck('id') as $orderId) {
        if (isset($queuedIds[(int) $orderId])) continue;
        ProcessStagedOrdersJob::dispatch((int) $orderId, getDomain())->delay(now()->addSeconds(3));
        $queuedIds[(int) $orderId] = true;
        $processed++;
    }

    $this->info("Processed {$processed} staged orders.");
})->purpose('Process staged orders without a queue worker');

Artisan::command('orders:queue-worker', function () {
    $workers = max(1, (int) config('queue.staged_orders_workers', 10));
    $maxTime = 50;

    $processes = [];
    for ($i = 0; $i < $workers; $i++) {
        $processes[] = proc_open(
            [
                PHP_BINARY,
                base_path('artisan'),
                'queue:work',
                config('queue.default'),
                '--queue=staged-orders',
                '--stop-when-empty',
                '--max-time=' . $maxTime,
                '--sleep=1',
                '--tries=3',
            ],
            [1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
            $pipes
        );
    }

    foreach ($processes as $process) {
        proc_close($process);
    }

    $this->info("Started {$workers} queue workers for staged orders.");
})->purpose('Run parallel RabbitMQ workers for staged orders');

Artisan::command('services:sync', function () {
    $providers = ApiProvider::where('status', true)->get(['id', 'domain']);
    $controller = app(CronSyncController::class);

    foreach ($providers as $provider) {
        $response = $controller->syncServices(
            Request::create('/cron/sync/services', 'GET', [
                'provider' => $provider->id,
                'domain' => $provider->domain,
            ])
        );

        if ($response->getStatusCode() >= 400) {
            $message = "Service sync failed for provider {$provider->id} ({$provider->domain})";
            $this->error($message);
            Log::error($message, ['response' => $response->getContent()]);
        }
    }

    $this->info("Service sync started for {$providers->count()} providers.");
})->purpose('Sync services from all active providers');

// One scheduler entry for hosting cron: schedule:run.
Artisan::command('app:cron', function () {
    $this->call('orders:update-status');
    $this->call('orders:process-staged');
    $this->call('services:sync');

    if (config('queue.default') !== 'sync') {
        try {
            $this->call('queue:work', [
                'connection' => config('queue.default'),
                '--queue' => 'staged-orders,service-sync,order-status',
                '--stop-when-empty' => true,
                '--max-time' => 50,
                '--sleep' => 1,
                '--tries' => 3,
            ]);
        } catch (\Throwable $e) {
            report($e);
            $this->error('Queue worker failed: ' . $e->getMessage());
        }
    }
})->purpose('Run all application cron tasks');

Schedule::command('app:cron')->everyMinute()->withoutOverlapping(5);
