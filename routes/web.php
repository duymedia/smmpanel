<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Client\DataController;
use App\Http\Controllers\Client\ViewController;
use App\Http\Controllers\Client\EventController;
use App\Http\Controllers\Client\LandingPageController;
use App\Http\Controllers\CacheController;
use App\Http\Controllers\ImageProxyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Redirect /admin to /admin/orders
Route::get('/admin', function () {
    return redirect('/admin/orders');
});

// Public lang JSON — no middleware needed
// Route::get('/lang/{lang}.json', function (string $lang) {
//     $allowed = ['en', 'vi', 'af', 'al'];
//     if (!in_array($lang, $allowed)) abort(404);
//     $path = resource_path("lang/{$lang}.json");
//     if (!file_exists($path)) abort(404);
//     return response()->file($path, ['Content-Type' => 'application/json']);
// })->where('lang', '[a-z]{2}');
// Cache clear — no middleware, no token required

Route::get('/clear-view-cache', [CacheController::class, 'clearViewCache'])
    ->name('clear.view.cache');

// Image proxy — bypass CORS issues
Route::get('/proxy-image', [ImageProxyController::class, 'proxy'])
    ->name('proxy.image');

// ============================================
// All other routes with Client Middleware
// ============================================
Route::middleware(['client'])->group(function () {

    Route::get('/', function () {
        if (auth()->check()) {
            return redirect()->route('clients.new');
        }

        $config = \App\Models\Config::first();
        $template = $config->default_landingpage ?? 'default';

        if (is_numeric($template)) {
            $viewName = 'landing-page.lang-' . $template;
        } else {
            $viewName = 'landing-page.' . $template;
        }

        // Kiểm tra view tồn tại, nếu không thì fallback về 'default'
        if (!view()->exists($viewName)) {
            $viewName = 'landing-page.default';
        }

        return view($viewName);
    })->name('landing');

    Route::get('/install', [AuthController::class, 'showInstall'])->name('install');
    Route::post('/install', [AuthController::class, 'install'])->name('install.store');

    Route::get('/signin', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/signin', [AuthController::class, 'login'])->name('login.store');

    Route::get('/signup', [AuthController::class, 'showRegister'])->name('signup');
    Route::post('/signup', [AuthController::class, 'register'])->name('signup.store');

    Route::get('/resetpassword', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/resetpassword', [AuthController::class, 'sendResetLink'])->name('password.email');

    Route::get('/2fa-auth', [AuthController::class, 'show2FA'])->name('2fa.show');
    Route::post('/2fa-auth', [AuthController::class, 'verify2FA'])->name('2fa.verify');

    Route::get('/signout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    })->name('logout');

    // Services & API — public (không cần đăng nhập)
    Route::get('/services', [ViewController::class, 'servicesIndex'])->name('clients.services.index');
    Route::get('/api', [ViewController::class, 'apiIndex'])->name('clients.api.index');
    Route::get('/apidoc', [ViewController::class, 'apiIndex'])->name('clients.api.doc');

    // ============================================
    // Protected Client Routes (Authenticated users only)
    // ============================================
    Route::middleware(['auth'])->group(function () {

        // Dashboard
        Route::get('/new', [ViewController::class, 'index'])->name('clients.new');
        Route::get('/dashboard', [ViewController::class, 'index'])->name('clients.dashboard');

        // Orders
        Route::prefix('orders')->name('clients.orders.')->group(function () {
            Route::get('/', [ViewController::class, 'ordersIndex'])->name('index');
            Route::get('search', [ViewController::class, 'ordersIndex'])->name('search');
            Route::get('refunds', [ViewController::class, 'refundsIndex'])->name('refunds');
            Route::get('{status}', [ViewController::class, 'ordersIndex'])->name('status')
                ->where('status', 'pending|processing|inprogress|completed|partial|canceled');
            Route::get('{id}', [ViewController::class, 'ordersShow'])->name('show');
            Route::post('create', [DataController::class, 'createOrder'])->name('store');
            Route::get('{id}/refill', [DataController::class, 'orderAction'])->name('refill');
            Route::get('{id}/cancel', [DataController::class, 'orderAction'])->name('cancel');
            Route::post('{id}/report', [DataController::class, 'orderReport'])->name('report');
        });

        // Add Funds
        Route::get('/addfunds', [ViewController::class, 'addFundsIndex'])->name('clients.addfunds.index');
        Route::post('/addfunds/create-checkout', [ViewController::class, 'createCheckout'])->name('clients.addfunds.create-checkout');
        Route::get('/addfunds/invoice/{id}/download', [ViewController::class, 'invoiceDownload'])->name('clients.addfunds.invoice.download');
        Route::get('/addfunds/invoice/{id}/download-direct', [ViewController::class, 'invoiceDownloadDirect'])->name('clients.addfunds.invoice.download-direct');
        Route::get('/addfunds/invoice/{id}', [ViewController::class, 'invoiceView'])->name('clients.addfunds.invoice');
        Route::get('/addfunds/{ref}', [ViewController::class, 'addFundsPayment'])->name('clients.addfunds.payment');

        // Checkout
        Route::get('/checkout/{id}', [ViewController::class, 'checkoutView'])->name('clients.checkout.view');

        // Refill
        Route::get('/refill', [ViewController::class, 'refillIndex'])->name('clients.refill.refill');
        Route::get('/refill/{status}', [ViewController::class, 'refillIndex'])->name('clients.refill.status')
            ->where('status', 'all|pending|inprogress|completed|rejected|error');

        // Cashflow
        Route::get('/cashflow', [ViewController::class, 'cashflowIndex'])->name('clients.cashflow.index');

        // Update (service sync logs) — /update, /updates, /updates/2, /updates/decreased
        Route::get('/update{s?}', [ViewController::class, 'updateIndex'])->name('clients.update.index')
            ->where('s', 's?');
        Route::get('/updates/{segment}', [ViewController::class, 'updateIndex'])->name('clients.update.segment')
            ->where('segment', '[0-9]+|new|decreased|increased|enabled|disabled');

        // Products
        Route::get('/products', [ViewController::class, 'productsIndex'])->name('clients.products.index');
        Route::get('/products/{slug}', [ViewController::class, 'productShow'])->name('clients.products.show');
        Route::post('/product-order/{id}', [DataController::class, 'createOrderProduct'])->name('clients.products.order');
        Route::get('/product_orders', [ViewController::class, 'productOrdersIndex'])->name('clients.product_orders.index');

        // Affiliates
        Route::get('/affiliates', [ViewController::class, 'affiliatesIndex'])->name('clients.affiliates.index');

        // Child Panel
        Route::get('/child-panel', [ViewController::class, 'childPanelIndex'])->name('clients.childpanel.index');
        Route::get('/childpanel', [ViewController::class, 'childPanelIndex'])->name('clients.childpanel.index');
        Route::post('/child-panel', [DataController::class, 'createChildPanel'])->name('clients.childpanel.store');

        // Tickets
        Route::prefix('tickets')->name('clients.tickets.')->group(function () {
            Route::get('/', [ViewController::class, 'ticketsIndex'])->name('index');
            Route::post('create', [DataController::class, 'createTicket'])->name('store');
            Route::get('{id}', [ViewController::class, 'ticketsShow'])->name('show');
            Route::post('{id}/reply', [DataController::class, 'replyTicket'])->name('reply');
            Route::put('{id}/close', [DataController::class, 'closeTicket'])->name('close');
            Route::get('{id}/messages', [DataController::class, 'getTicketMessages'])->name('messages');
        });

        // Alias /viewticket/{id} -> tickets show
        Route::get('/viewticket/{id}', [ViewController::class, 'ticketsShow'])->name('clients.viewticket');

        // Mass Order — accessible via both /massorder and /mass
        Route::get('/massorder', [ViewController::class, 'massOrderIndex'])->name('clients.massorder.index');
        Route::get('/mass', [ViewController::class, 'massOrderIndex'])->name('clients.mass.index');

        // Account Management
        Route::prefix('account')->name('clients.account.')->group(function () {
            Route::get('/', [ViewController::class, 'accountIndex'])->name('index');
            Route::post('update-currency', [DataController::class, 'updateCurrency'])->name('update-currency');
            Route::post('update-language', [DataController::class, 'updateLanguage'])->name('update-language');
            Route::post('update-timezone', [DataController::class, 'updateTimezone'])->name('update-timezone');
            Route::post('update-email', [DataController::class, 'updateEmail'])->name('update-email');
            Route::post('update-password', [DataController::class, 'updatePassword'])->name('update-password');
            Route::post('2fa-setup', [DataController::class, 'twoFaSetup'])->name('2fa-setup');
            Route::post('2fa-generate', [DataController::class, 'twoFaGenerate'])->name('2fa-generate');
            Route::post('2fa-approve', [DataController::class, 'twoFaApprove'])->name('2fa-approve');
            Route::post('2fa-disable', [DataController::class, 'twoFaDisable'])->name('2fa-disable');
            Route::post('generate-api-key', [DataController::class, 'generateApiKey'])->name('generate-api-key');
        });

        // Settings (alias of account with same actions)
        Route::prefix('settings')->name('clients.settings.')->group(function () {
            Route::get('/', [ViewController::class, 'accountIndex'])->name('index');
            Route::post('update-currency', [DataController::class, 'updateCurrency'])->name('update-currency');
            Route::post('update-language', [DataController::class, 'updateLanguage'])->name('update-language');
            Route::post('update-timezone', [DataController::class, 'updateTimezone'])->name('update-timezone');
            Route::post('update-email', [DataController::class, 'updateEmail'])->name('update-email');
            Route::post('update-password', [DataController::class, 'updatePassword'])->name('update-password');
            Route::post('2fa-setup', [DataController::class, 'twoFaSetup'])->name('2fa-setup');
            Route::post('2fa-generate', [DataController::class, 'twoFaGenerate'])->name('2fa-generate');
            Route::post('2fa-approve', [DataController::class, 'twoFaApprove'])->name('2fa-approve');
            Route::post('2fa-disable', [DataController::class, 'twoFaDisable'])->name('2fa-disable');
            Route::post('generate-api-key', [DataController::class, 'generateApiKey'])->name('generate-api-key');
        });

        // Notifications
        Route::prefix('notifications')->name('clients.notifications.')->group(function () {
            Route::get('/', [ViewController::class, 'notificationsIndex'])->name('index');
            Route::post('connect-telegram', [DataController::class, 'connectTelegram'])->name('connect-telegram');
            Route::post('update', [DataController::class, 'updateNotifications'])->name('update');
        });

        // Cooperate
        Route::get('/cooperate', [ViewController::class, 'cooperateIndex'])->name('clients.cooperate.index');

        // Event Spin
        Route::post('/events/{event}/spin', [EventController::class, 'spin'])->name('clients.events.spin');

        // Service detail — phải đặt CUỐI CÙNG để không conflict với các route cụ thể
        Route::get('{id}', [ViewController::class, 'servicesShow'])->name('clients.services.show');
    });

    // ============================================
    // Public API Routes (AJAX calls)
    // ============================================
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('categories-by-platform/{platformId}', [DataController::class, 'getCategoriesByPlatform'])->name('categories.by-platform');
        Route::get('services-by-category/{categoryId}', [DataController::class, 'getServicesByCategory'])->name('services.by-category');
        Route::get('categories', [DataController::class, 'getCategoriesByPlatform'])->name('categories.all');

        // Ticket API (for authenticated users)
        Route::middleware('auth')->group(function () {
            Route::get('ticket-categories', [DataController::class, 'getTicketCategories'])->name('clients.api.ticket-categories');
            Route::get('ticket-subcategories', [DataController::class, 'getTicketSubcategories'])->name('clients.api.ticket-subcategories');
        });
    });
});
