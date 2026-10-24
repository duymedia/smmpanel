<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Crons\CronStatusController;
use App\Http\Controllers\Crons\CronSyncController;
use App\Http\Controllers\Crons\CronBinanceController;

// Cập nhật trạng thái orders theo provider
Route::get('/status/orders', [CronStatusController::class, 'updateOrdersStatus']);
Route::get('/status/orders/process', [CronStatusController::class, 'processOrdersStatus']);

// Đồng bộ services từ API provider
Route::get('/sync/services', [CronSyncController::class, 'syncServices']);

Route::get('/binance/transactions', [CronBinanceController::class, 'binance']);
Route::post('/loop/orders', [CronStatusController::class, 'statusLoopOrders']);
Route::get('/schedule/orders', [CronStatusController::class, 'processScheduledOrders']);

// Process queued orders (.json files in storage/app/orders older than 3s, max 10 per run)

// Tính thời gian trung bình hoàn thành đơn hàng và update cho service
Route::get('/update/average-time', [CronStatusController::class, 'updateAverageTime']);
