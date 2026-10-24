<?php

namespace App\Providers;

use App\Models\Config;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Order;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $domain = getDomain();
            $user = Auth::user();
            $global = Cache::remember("view.global.{$domain}", now()->addSeconds(30), function () use ($domain) {
                $config = Config::where('domain', $domain)->first() ?? Config::first();

                return [
                    'config' => $config ?? new Config(),
                    'totalServices' => Service::where('domain', $domain)->count(),
                    'totalOrders' => Order::where('domain', $domain)->count(),
                    'totalCompletedOrders' => Order::where('domain', $domain)->where('status', 'completed')->count(),
                    'pendingSupportCount' => Order::where('domain', $domain)
                        ->whereNotNull('ticket')->where('ticket', '!=', '')
                        ->where(function ($query) {
                            $query->whereNull('ticket_status')->orWhere('ticket_status', 'processing');
                        })->count(),
                ];
            });

            $config = $global['config'];
            $adminLangMap = [
                'en' => ['name' => 'English', 'flag' => 'united-states.svg'],
                'vi' => ['name' => 'Vietnamese', 'flag' => 'vietnam.svg'],
            ];
            $adminCurrentLang = $user?->lang ?? 'vi';
            $adminCurrentLang = array_key_exists($adminCurrentLang, $adminLangMap) ? $adminCurrentLang : 'vi';
            $adminLogoFile = $config->logo_square ?? $config->logo;
            $adminLogo = $adminLogoFile && file_exists(public_path('assets/media/' . $adminLogoFile))
                ? asset('assets/media/' . $adminLogoFile)
                : null;
            $shared = [
                'config' => $config,
                'siteTitle' => $config->title ?: '',
                'siteDescription' => $config->description ?: '',
                'siteKeywords' => $config->keywords ?: '',
                'siteLogo' => $config->logo ?: asset(''),
                'siteFavicon' => $config->favicon ?: asset(''),
                'themeId' => $config->default_theme ?: 'default',
                'siteLang' => $config->default_lang ?: app()->getLocale() ?: 'en',
                'totalServices' => $global['totalServices'],
                'totalOrders' => $global['totalOrders'],
                'totalCompletedOrders' => $global['totalCompletedOrders'],
                'pendingSupportCount' => $global['pendingSupportCount'],
                'adminLogo' => $adminLogo,
                'adminLangMap' => $adminLangMap,
                'adminCurrentLang' => $adminCurrentLang,
                'adminCurrentLangData' => $adminLangMap[$adminCurrentLang],
            ];
            $unreadMessagesCount = (bool) ($user?->is_admin)
                ? Cache::remember("view.unread.{$domain}", now()->addSeconds(15), fn () =>
                    TicketReply::whereHas('ticket', fn ($query) => $query->where('domain', $domain))
                        ->where('is_admin', false)->whereNull('read_at')->count())
                : 0;

            $view->with(array_merge($shared, [
                'authUser'             => $user,
                'roleMeta'             => $user ? userRole($user, 'config') : null,
                'unreadMessagesCount'  => $unreadMessagesCount,
                'adminNotice'          => request()->is('admin', 'admin/*') ? adminNotice() : null,
            ]));

            if (!$user) {
                $view->with(['userLang' => $config->default_lang ?: 'en']);
                return;
            }

            $currencies = Cache::remember("view.currencies.{$domain}", now()->addMinutes(5), fn () =>
                Currency::active()->orderBy('name')->get(['id', 'code', 'symbol', 'name', 'exchange_rate', 'symbol_position']));
            $currentLanguage = Language::where('code', $user->lang ?: 'en')
                ->where('status', true)
                ->where(function ($query) use ($domain) {
                    $query->where('domain', $domain)->orWhereNull('domain');
                })
                ->orderByRaw('domain IS NULL')
                ->first(['id', 'code', 'name', 'flag']);
            $uiData = userUi($user, $currencies, $currentLanguage);

            $pendingTicketsCount = Ticket::where('domain', $domain)
                ->where('user_id', $user->id)
                ->where('status', 'open')
                ->count();

            $view->with([
                'currencies'          => $currencies,
                'userCurrency'        => $uiData['balance']['currency'],
                'formattedBalance'    => $uiData['balance']['formatted'],
                'formattedSpent'      => $uiData['spent']['formatted'],
                'userLang'            => $uiData['lang']['code'],
                'uiData'              => $uiData,
                'pendingTicketsCount' => $pendingTicketsCount,
            ]);
        });
    }
}
