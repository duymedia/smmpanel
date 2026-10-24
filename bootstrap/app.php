<?php

use App\Http\Middleware\Admin;
use App\Http\Middleware\ApiToken;
use App\Http\Middleware\Client;
use App\Http\Middleware\ClientThemePreview;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__ . '/../routes/web.php',
            __DIR__ . '/../routes/admin.php',
        ],
        api: __DIR__ . '/../routes/api.php',
        channels: __DIR__ . '/../routes/channels.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware([])->group(base_path('routes/webhook.php'));
            Route::prefix('cron')->group(base_path('routes/crons.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->alias([
            'admin' => Admin::class,
            'api.token' => ApiToken::class,
            'client' => Client::class,
            'client.theme.preview' => ClientThemePreview::class,
        ]);

        $middleware->web(
            append: [SetLocale::class],
            replace: [
                \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class
                    => VerifyCsrfToken::class,
            ],
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        $exceptions->render(function (QueryException $e) {
            return response('Vui lòng kết nối Database', 500)
                ->header('Content-Type', 'text/plain; charset=UTF-8');
        });

        $exceptions->render(function (\PDOException $e) {
            return response('Vui lòng kết nối Database', 500)
                ->header('Content-Type', 'text/plain; charset=UTF-8');
        });
    })
    ->create();
