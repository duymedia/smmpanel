<?php

namespace App\Providers;

use App\Models\Config;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cache lang data theo singleton — chỉ đọc file 1 lần/request
        $this->app->singleton('langData', function () {
            $lang = Auth::user()?->lang ?? 'en';
            $file = resource_path("lang/{$lang}.json");
            if (!file_exists($file)) $file = resource_path('lang/en.json');
            return ['lang' => $lang, 'data' => json_decode(file_get_contents($file), true) ?? []];
        });

        View::composer('*', function ($view) {
            $config = Config::where('domain', getDomain())->first();

            $pendingCancelCount = Order::where('cancel', true)
                ->whereNotNull('cancel_status')
                ->where('cancel_status', 'pending')
                ->where('domain', getDomain())
                ->count();

            $view->with([
                'authUser'             => Auth::user(),
                'config'               => $config ?? new Config(),
                'totalServices'        => Service::count(),
                'totalOrders'          => Order::count(),
                'totalCompletedOrders' => Order::where('status', 'completed')->count(),
                'pendingCancelCount'   => $pendingCancelCount,
            ]);

            if (!Auth::check()) {
                // Ưu tiên: cookie data-lang (sync từ localStorage) → config->default_lang → 'en'
                $cookieLang = request()->cookie('data-lang');
                $guestLang  = $cookieLang ?: ($config?->default_lang ?: 'en');
                $guestFile  = resource_path("lang/{$guestLang}.json");
                if (!file_exists($guestFile)) { $guestLang = 'en'; $guestFile = resource_path('lang/en.json'); }
                $view->with(['userLang' => $guestLang, 'langData' => json_decode(file_get_contents($guestFile), true) ?? []]);
                return;
            }

            $user             = Auth::user();
            $currencies       = Currency::active()->orderBy('name')->get(['code', 'symbol', 'name', 'exchange_rate', 'symbol_position']);
            $userCurrencyData = formatUserCurrency($user, $currencies);

            $resolved = $this->app->make('langData');

            $pendingTicketsCount = Ticket::where('domain', getDomain())
                ->where('user_id', $user->id)
                ->where('status', 'open')
                ->count();

            $view->with([
                'currencies'          => $currencies,
                'userCurrency'        => $userCurrencyData['currency'],
                'formattedBalance'    => $userCurrencyData['balance'],
                'formattedSpent'      => $userCurrencyData['spent'],
                'userLang'            => $resolved['lang'],
                'langData'            => $resolved['data'],
                'pendingTicketsCount' => $pendingTicketsCount,
            ]);
        });
    }
}
