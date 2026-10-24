<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiV2Controller;
use App\Http\Controllers\Api\ApiAdminV1Controller;
use App\Http\Controllers\Api\ApiAdminV2Controller;
use App\Http\Controllers\Auth\AuthController;

// API v2 validates the API key in ApiV2Controller so malformed requests can
// use the API's documented 200/"Incorrect request" response format.
Route::prefix('v2')->group(function () {
    Route::match(['get', 'post'], '/', [ApiV2Controller::class, 'handleAction']);
});

// Admin API v1 (legacy)
// Admin API v1 handles its legacy key/action validation in the controller,
// preserving its documented 200/"Incorrect request" error response.
Route::post('/admin/v1', [ApiAdminV1Controller::class, 'handleAction']);
Route::post('/adminv1', [ApiAdminV1Controller::class, 'handleAction']);

// Admin API v2 RESTful
Route::prefix('adminapi/v2')->middleware(['api.token:admin', 'throttle:300,1'])->group(function () {
    Route::post('/orders/pull',                   [ApiAdminV2Controller::class, 'pullOrders']);
    Route::get('/orders',                         [ApiAdminV2Controller::class, 'getOrders']);
    Route::post('/orders/update',                 [ApiAdminV2Controller::class, 'updateOrders']);
    Route::post('/orders/resend',                 [ApiAdminV2Controller::class, 'resendOrders']);
    Route::post('/orders/change-status',          [ApiAdminV2Controller::class, 'changeStatus']);
    Route::post('/orders/request-cancel',         [ApiAdminV2Controller::class, 'requestCancel']);
    Route::post('/orders/cancel',                 [ApiAdminV2Controller::class, 'cancelOrders']);
    Route::get('/orders/{order_id}',              [ApiAdminV2Controller::class, 'getOrder']);
    Route::post('/orders/{order_id}/edit-link',   [ApiAdminV2Controller::class, 'editOrderLink']);
    Route::post('/orders/{order_id}/set-partial', [ApiAdminV2Controller::class, 'setPartial']);
    Route::post('/cancel/pull',                   [ApiAdminV2Controller::class, 'pullCancelTasks']);
    Route::post('/cancel/reject',                 [ApiAdminV2Controller::class, 'rejectCancelTasks']);
    Route::post('/refill/pull',                   [ApiAdminV2Controller::class, 'pullRefillTasks']);
    Route::get('/payments',                       [ApiAdminV2Controller::class, 'getPayments']);
    Route::post('/payments/add',                  [ApiAdminV2Controller::class, 'addPayment']);
    Route::post('/users/add',                     [ApiAdminV2Controller::class, 'addUser']);
});

Route::post('/oauth_google', [AuthController::class, 'loginGoogle']);

// // Tool: Convert Facebook link to UID
// Route::get('/convert-fb-id', [\App\Http\Controllers\Api\ToolController::class, 'uid']);

// // Tool: Get Facebook followers count
// Route::match(['get', 'post'], '/fb-followers', [\App\Http\Controllers\Api\ToolController::class, 'getFollowers']);
