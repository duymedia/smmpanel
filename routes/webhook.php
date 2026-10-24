<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webhook\PaymentWebhookController;

/*
|--------------------------------------------------------------------------
| Webhook Routes
|--------------------------------------------------------------------------
|
| These routes are loaded without CSRF protection and other web middleware
| to handle external webhook calls from payment providers.
|
*/

// Payment webhook routes
Route::get('/webhook/sieuthicode', [PaymentWebhookController::class, 'handlePayment'])
    ->name('webhook.sieuthicode.get');
Route::post('/webhook/sieuthicode', [PaymentWebhookController::class, 'handlePayment'])
    ->name('webhook.sieuthicode');;

// Notification webhook - POST để đẩy thông báo modal
Route::post('/webhook/notification', function (\Illuminate\Http\Request $request) {
    $content = $request->input('content') ?? $request->input('message') ?? '';
    $title = $request->input('title') ?? 'Thông báo';

    if (empty(trim(strip_tags($content)))) {
        return response()->json(['status' => false, 'msg' => 'Content is required'], 400);
    }

    $data = [
        'title' => $title,
        // Keep basic rich text while rejecting executable markup from payloads.
        'content' => strip_tags($content, '<p><br><strong><b><em><i><u><ol><ul><li><a>'),
        'version' => (string) time(),
    ];

    $path = storage_path('app/notifications.json');
    file_put_contents($path, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), LOCK_EX);

    return response()->json(['status' => true, 'msg' => 'Notification sent', 'version' => $data['version']]);
})->name('webhook.notification');

//demo webhook notice
// {
//     "title": "Thông báo",
//     "content": "<p>Hello mọi người</p>"
// }
