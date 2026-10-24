<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ApiProvider;
use App\Models\Category;
use App\Models\Config;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Platform;
use App\Models\Service;
use App\Models\Ticket;
use App\Models\TicketSubject;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ServiceSyncLog;
use App\Models\ProductOrder;
use App\Models\ProductGroup;
use App\Models\ActivityLog;
use App\Models\UserCustomRate;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * ViewController - Xử lý hiển thị giao diện
 */
class ViewController extends Controller
{
    public function landing()
    {
        if (Auth::check()) return $this->index();

        $config = Config::where('domain', getDomain())->first() ?? Config::first();
        $template = (string) ($config?->default_landingpage ?: 'default');
        $redirects = [
            '-1' => 'clients.services.index',
            '-2' => 'clients.products.index',
        ];

        if (isset($redirects[$template])) return redirect()->route($redirects[$template]);

        if ($template === 'default' || ctype_digit($template)) {
            $disk = Storage::disk('local');
            $path = 'themes/' . sha1(getDomain()) . "/landing-{$template}.html";
            if ($disk->exists($path)) {
                return new Response($disk->get($path), 200, ['Content-Type' => 'text/html; charset=UTF-8']);
            }
        }

        $view = ctype_digit($template) ? "landing-page.lang-{$template}" : "landing-page.{$template}";
        $view = view()->exists($view) ? $view : 'landing-page.default';
        $data = compact('config');

        if ($view === 'landing-page.lang-10') {
            $data['platforms'] = Platform::where('status', true)
                ->where('domain', getDomain())
                ->orderBy('position')
                ->get(['name', 'image'])
                ->map(function (Platform $platform): array {
                    $image = trim((string) $platform->image);
                    $isImage = preg_match('/\.(?:png|jpe?g|gif|webp|svg)(?:\?.*)?$/i', $image) === 1
                        || preg_match('#^/?(?:storage|images|assets)/#i', $image) === 1;

                    return [
                        'name' => trim((string) $platform->name),
                        'image' => $isImage
                            ? (filter_var($image, FILTER_VALIDATE_URL) ? $image : asset(ltrim($image, '/')))
                            : null,
                    ];
                });
        }

        return view($view, $data);
    }

    /**
     * Display dashboard
     */
    public function dashboard(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $user = Auth::user();
        $userLang = $user->lang ?? 'en';
        $currency_code = $user->currency ?? 'USD';

        // Get currency
        $currency = Currency::where('status', true)
            ->where('code', $currency_code)
            ->first();

        if (!$currency) {
            $currency = (object) [
                'code' => 'USD',
                'symbol' => '$',
                'symbol_position' => 'before',
                'exchange_rate' => 1
            ];
        }

        // Get statistics
        $userOrders = Order::where('user_id', $user->id);
        $totalOrders = $userOrders->count();
        $totalSpent = $userOrders->sum('charge');
        $pendingOrders = $userOrders->where('status', 'pending')->count();
        $completedOrders = $userOrders->where('status', 'completed')->count();

        // Format balance
        $balance = $user->balance;
        if ($currency->exchange_rate > 0) {
            $balance = $balance / $currency->exchange_rate;
        }
        $balanceFormatted = ($currency->symbol_position === 'before' ? $currency->symbol : '') .
            number_format($balance, 8) .
            ($currency->symbol_position === 'after' ? $currency->symbol : '');

        // Orders by status for chart
        $ordersByStatus = $userOrders->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Revenue by date (last 30 days)
        $revenueByDate = $userOrders->where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, SUM(charge) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date')
            ->toArray();

        // Recent orders
        $recentOrders = $userOrders->with(['service.category.platform'])
            ->latest()
            ->limit(5)
            ->get();

        $data = [
            'balance_formatted' => $balanceFormatted,
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'completed_orders' => $completedOrders,
            'total_spent' => $totalSpent,
            'orders_by_status' => $ordersByStatus,
            'revenue_by_date' => $revenueByDate,
            'recent_orders' => $recentOrders,
            'currency_symbol' => $currency->symbol,
        ];

        return view("clients.theme-{$theme}.dashboard", compact('data'));
    }

    public function index(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $user = Auth::user();
        $userRole = userRole($user);
        $userLang = $user->lang ?? 'en';
        $currency_code = $user->currency ?? 'USD';

        // Get service ID from URL query parameter or route parameter
        $serviceId = request('service') ?? request('serviceId');
        $selectedService = null;

        // Simplified currency lookup - no domain checking
        $currency = Currency::where('status', true)
            ->where('code', $currency_code)
            ->first();

        // If no currency found, create a default one
        if (!$currency) {
            $currency = (object) [
                'code' => 'USD',
                'symbol' => '$',
                'symbol_position' => 'before',
                'exchange_rate' => 1
            ];
        }

        $serviceFixedDecimals = Service::join(
            'api_providers',
            'services.provider_id',
            '=',
            'api_providers.id'
        )
            ->where('services.status', true)
            ->pluck('api_providers.fixed_decimal', 'services.id');

        $formatNumber = function ($n, $decimals = null) use ($currency_code) {
            if ($currency_code === 'VND') {
                $n = number_format((float) $n, $decimals ?? 10, ',', '.');

                return str_contains($n, ',')
                    ? rtrim(rtrim($n, '0'), ',')
                    : $n;
            }

            if ($decimals !== null) {
                $n = number_format((float) $n, $decimals, '.', '');
            }

            $n = (string) $n;
            // Xóa các số 0 ở cuối nhưng giữ lại ít nhất một chữ số sau dấu phẩy nếu có
            if (str_contains($n, '.')) {
                $n = rtrim($n, '0');
                // Nếu kết thúc bằng dấu phẩy, xóa nó
                $n = rtrim($n, '.');
            }
            return $n;
        };

        $formatPrice = function ($rate, $serviceId = null) use (
            $currency,
            $currency_code,
            $formatNumber,
            $serviceFixedDecimals
        ) {
            // Lấy fixed_decimal từ Provider của service
            $fixedDecimal = $serviceId && isset($serviceFixedDecimals[$serviceId])
                ? $serviceFixedDecimals[$serviceId]
                : null;

            // Áp dụng exchange rate nếu cần (chia để chuyển đổi)
            if (
                $currency &&
                $currency->code === $currency_code &&
                $currency->exchange_rate > 0
            ) {
                $rate *= $currency->exchange_rate;
            }

            // Format rate theo fixed_decimal của Provider
            $rate = $formatNumber($rate, $fixedDecimal);

            return ($currency->symbol_position ?? 'before') === 'before'
                ? ($currency->symbol ?? '$') . $rate
                : $rate . ($currency->symbol ?? '$');
        };

        // Platforms - with domain checking
        $platforms = Platform::where('status', true)
            ->where('domain', getDomain())
            ->orderBy('position', 'asc')
            ->get(['id', 'name', 'image'])
            ->map(function (Platform $platform) {
                $image = (string) ($platform->image ?? '');
                $isImage = preg_match('/\.(?:png|jpe?g|gif|webp|svg)(?:\?.*)?$/i', $image) === 1
                    || str_starts_with($image, '/assets/');

                if ($image !== '' && !$isImage && filter_var($image, FILTER_VALIDATE_URL)) {
                    $platform->image = null;
                }

                return $platform;
            });

        // Categories + xử lý tên đa ngôn ngữ - with domain checking
        $categories = Category::where('status', true)
            ->where('domain', getDomain())
            ->orderBy('position')
            ->get(['id', 'name', 'platform_id', 'image', 'display'])
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name[$userLang] ?? $c->name['en'] ?? reset($c->name),
                'platform_id' => $c->platform_id,
                'image' => $c->image,
                'display' => (int) $c->display,
            ])
            ->values();

        $platformsById = $platforms->keyBy('id');

        // Load custom rates for current user (keyed by service_id)
        $customRates = UserCustomRate::where('user_id', $user->id)
            ->where('domain', getDomain())
            ->where('service_id', '!=', -1)
            ->get()
            ->keyBy('service_id');

        // Services + rate theo role + tên đa ngôn ngữ - with domain checking
        $services = Service::where('status', true)
            ->where('domain', getDomain())
            ->orderBy('position', 'asc')
            ->get()
            ->map(function ($svc) use ($userRole, $userLang, $formatPrice, $customRates, $categories, $platformsById, $config) {
                // Rate theo role
                $rate = getUserServiceRate($userRole, $svc);

                // Apply custom rate if exists for this service
                if (isset($customRates[$svc->id])) {
                    $cr = $customRates[$svc->id];
                    if ($cr->rate !== null) {
                        $rate = getUserServiceRate($userRole, $svc, $cr);
                    } elseif ($cr->percent !== null) {
                        $rate = getUserServiceRate($userRole, $svc, $cr);
                    }
                }

                // Tên đa ngôn ngữ - name is cast to json, so it's already an array
                $name = $svc->name;
                if (is_array($name)) {
                    $name = $name[$userLang] ?? $name['en'] ?? reset($name) ?? '';
                }
                $name = (string) $name;

                // Ensure all fields are strings, not arrays
                $description = $svc->description ?? '';
                if (is_array($description)) {
                    $description = json_encode($description);
                }
                $description = (string) $description;

                $note = $svc->note ?? '';
                if (is_array($note)) {
                    $note = json_encode($note);
                }
                $note = (string) $note;

                $averageTime = $svc->average_time ?? '';
                if (is_array($averageTime)) {
                    $averageTime = json_encode($averageTime);
                }
                $averageTime = (string) $averageTime;

                $title = $svc->title ?? '';
                if (is_array($title)) {
                    $title = json_encode($title);
                }
                $title = (string) $title;

                $attributes = $svc->attributes ?? '';
                if (is_array($attributes)) {
                    $attributes = json_encode($attributes);
                }
                $attributes = (string) $attributes;

                $category = $categories->firstWhere('id', $svc->category_id) ?? [];
                $platform = $platformsById->get($category['platform_id'] ?? null);
                $attributes = $svc->attributes;
                if (!is_array($attributes)) {
                    $attributes = json_decode((string) $attributes, true) ?: [];
                }

                return [
                    'id' => $svc->id,
                    'catid' => $svc->category_id,
                    'cat' => $category['name'] ?? '',
                    'cat_display_as' => (int) ($category['display'] ?? 0),
                    'name' => $name,
                    'description' => $description,
                    'image' => $svc->image,
                    'platformicon' => $this->safePlatformIcon(
                        ($category['image'] ?? '') ?: ($platform->image ?? '')
                    ),
                    'title' => $title,
                    'category_id' => $svc->category_id,
                    'desc' => $description,
                    'note' => $note,
                    'avg' => $averageTime,
                    'min' => $svc->min ?? 1,
                    'max' => $svc->max ?? 100000,
                    'rate' => (float) $rate,
                    'rate0' => (float) $rate,
                    'rate1' => (float) $rate,
                    'rate2' => (float) $rate,
                    'rate_formatted' => $formatPrice($rate, $svc->id),
                    'position' => $svc->position ?? 0,
                    'attrs' => $attributes,
                    'type' => $svc->type_service ?? 'Default',
                    'type_radio' => $svc->type_service ?? '',
                    'refill' => ($svc->refill ?? 0),
                    'cancel' => ($svc->cancel ?? 0),
                    'dripfeed' => (bool) ($svc->dripfeed ?? 0),
                    'schedule' => true,
                    'loop' => true,
                    'confirm' => serviceOn($config, 'require_confirm_service'),
                    'platformid' => (int) ($category['platform_id'] ?? -1),
                    'summary' => '{}',
                    'feature' => array_values($attributes),
                    'advanced_settings' => false,
                    'advanced_settings_data' => ['min_balance' => '0', 'max_order' => '0'],
                    'quantity_discount' => false,
                    'quantity_discount_data' => [],
                ];
            })
            ->values();

        $data = [
            'platforms' => $platforms,
            'categories' => $categories,
            'services' => $services,
            'selectedService' => $serviceId ? $services->firstWhere('id', (int) $serviceId) : null,
            'showAverageTime' => serviceOn($config, 'service_average_time'),
            'announcement' => [
                'content' => (string) ($config->announcement_content ?? ''),
                'showPage' => !empty(trim(strip_tags((string) ($config->announcement_content ?? ''))))
                    && in_array($config->announcement_position ?? '', ['page', 'page_and_modal'], true),
                'showModal' => !empty(trim(strip_tags((string) ($config->announcement_content ?? ''))))
                    && in_array($config->announcement_position ?? '', ['modal', 'page_and_modal'], true),
            ],
        ];

        return view("clients.theme-{$theme}.new", compact('data'));
    }

    private function safePlatformIcon($value): string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return '';
        }

        if (preg_match('/\.(?:png|jpe?g|gif|webp|svg)(?:\?.*)?$/i', $value) === 1
            || str_starts_with($value, '/assets/')) {
            return $value;
        }

        return filter_var($value, FILTER_VALIDATE_URL) ? '' : $value;
    }

    /**
     * Hiển thị danh sách dịch vụ.
     * Khi service_require_login bật, người dùng phải đăng nhập trước khi xem.
     */
    public function servicesIndex(): View|RedirectResponse
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        if (serviceOn($config, 'service_require_login') && !Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        $userRole = userRole($user);
        $currency_code = $user?->currency ?? 'USD';

        // Ưu tiên: request param ?lang= (từ localStorage truyền lên) → user->lang → config->default_lang → 'en'
        $allowed = ['en', 'vi', 'af', 'al'];
        $langParam = request('lang');
        $userLang = (in_array($langParam, $allowed) ? $langParam : null)
            ?? $user?->lang
            ?? ($config?->default_lang ?? 'en');

        // Simplified currency lookup
        $currency = Currency::where('status', true)
            ->where('code', $currency_code)
            ->first();

        if (!$currency) {
            $currency = (object) [
                'code' => 'USD',
                'symbol' => '$',
                'symbol_position' => 'before',
                'exchange_rate' => 1
            ];
        }

        $serviceFixedDecimals = Service::join('api_providers', 'services.provider_id', '=', 'api_providers.id')
            ->where('services.status', true)
            ->pluck('api_providers.fixed_decimal', 'services.id');

        $formatNumber = function ($n, $decimals = null) use ($currency_code) {
            if ($currency_code === 'VND') {
                $n = number_format((float) $n, $decimals ?? 10, ',', '.');

                return str_contains($n, ',')
                    ? rtrim(rtrim($n, '0'), ',')
                    : $n;
            }

            if ($decimals !== null) {
                $n = number_format((float) $n, $decimals, '.', '');
            }
            $n = (string) $n;
            // Xóa các số 0 ở cuối nhưng giữ lại ít nhất một chữ số sau dấu phẩy nếu có
            if (str_contains($n, '.')) {
                $n = rtrim($n, '0');
                // Nếu kết thúc bằng dấu phẩy, xóa nó
                $n = rtrim($n, '.');
            }
            return $n;
        };

        $formatPrice = function ($rate, $serviceId = null) use ($currency, $currency_code, $formatNumber, $serviceFixedDecimals) {
            $fixedDecimal = $serviceId && isset($serviceFixedDecimals[$serviceId]) ? $serviceFixedDecimals[$serviceId] : null;

            if ($currency && $currency->code === $currency_code && $currency->exchange_rate > 0) {
                $rate *= $currency->exchange_rate;
            }

            $rate = $formatNumber($rate, $fixedDecimal);
            return ($currency->symbol_position ?? 'before') === 'before'
                ? ($currency->symbol ?? '$') . $rate
                : $rate . ($currency->symbol ?? '$');
        };

        // Get categories - simplified
        $categories = Category::where('status', true)
            ->whereHas('services', fn($q) => $q->where('status', true))
            ->orderBy('position')
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->name[$userLang] ?? $c->name['en'] ?? reset($c->name),
                'image' => $c->image,
                'platform_id' => $c->platform_id,
                'display' => (int) ($c->display ?? 0),
            ]);

        // Get services - simplified
        $services = Service::where('status', true)
            ->orderBy('position', 'asc')
            ->get()
            ->map(function ($svc) use ($userRole, $userLang, $formatPrice) {
                $rate = getUserServiceRate($userRole, $svc);

                // Tên đa ngôn ngữ - name is cast to json, so it's already an array
                $name = $svc->name;
                if (is_array($name)) {
                    $name = $name[$userLang] ?? $name['en'] ?? reset($name) ?? '';
                }
                $name = (string) $name;

                // Ensure all fields are strings, not arrays
                $description = $svc->description ?? '';
                if (is_array($description)) {
                    $description = json_encode($description);
                }
                $description = (string) $description;

                $averageTime = $svc->average_time ?? '';
                if (is_array($averageTime)) {
                    $averageTime = json_encode($averageTime);
                }
                $averageTime = (string) $averageTime;

                return [
                    'id' => $svc->id,
                    'name' => $name,
                    'category_id' => $svc->category_id,
                    'image' => $svc->image ? asset($svc->image) : null,
                    'platformicon' => $svc->image ? asset($svc->image) : '',
                    'description' => $description,
                    'desc' => $description,
                    'min' => $svc->min ?? 1,
                    'max' => $svc->max ?? 100000,
                    'rate' => (float) $rate,
                    'rate_formatted' => $formatPrice($rate, $svc->id),
                    'average_time' => $averageTime,
                    'attributes' => is_array($svc->attributes) ? $svc->attributes : (json_decode($svc->attributes ?? '[]', true) ?? []),
                ];
            });

        $labelColors = [
            'Owner' => 'danger', 'Exclusive' => 'danger', 'Provider Direct' => 'danger',
            'Best seller' => 'danger', 'No refund' => 'danger', 'New' => 'success',
            'Promotion' => 'success', 'Recommend' => 'success', 'Instant' => 'success',
            'Super Fast' => 'success', 'Real' => 'success', 'Lifetime' => 'success',
            'Auto Refill' => 'success', 'Refill Button' => 'success', 'Cancel Button' => 'success',
            'No refill' => 'success', '7 days Refill' => 'success', '15 days Refill' => 'success',
            '30 days Refill' => 'success', '60 days Refill' => 'success', '90 days Refill' => 'success',
            '120 days Refill' => 'success', '365 days Refill' => 'success',
        ];

        $services = $services->map(function (array $service) use ($labelColors) {
            $service['min_formatted'] = number_format($service['min']);
            $service['max_formatted'] = number_format($service['max']);
            $service['attribute_badges'] = collect($service['attributes'])
                ->filter(fn ($attribute) => is_string($attribute) && $attribute !== '')
                ->map(fn ($attribute) => [
                    'name' => $attribute,
                    'color' => $labelColors[$attribute] ?? 'primary',
                ])
                ->values()
                ->all();

            return $service;
        });

        $groupedServices = $services->groupBy('category_id');
        $platformIds = $categories->pluck('platform_id')->filter()->unique();
        $platforms = Platform::where('status', true)
            ->whereIn('id', $platformIds)
            ->orderBy('position')
            ->get(['id', 'name', 'image'])
            ->map(function (Platform $platform) {
                // A platform value can also be a Facebook page/photo URL.
                // Do not render those URLs as <img src>; Facebook blocks
                // cross-origin image responses and produces 404/ORB errors.
                $platformImage = (string) ($platform->image ?? '');
                $isImage = filled($platformImage)
                    && (preg_match('/\.(?:png|jpe?g|gif|webp|svg)(?:\?.*)?$/i', $platformImage) === 1
                        || str_starts_with($platformImage, '/assets/'));
                $icon = $isImage
                    ? '<img src="' . e($platform->image) . '" class="w-15px h-15px me-1" />'
                    : (filled($platform->image) ? '<i class="' . e($platform->image) . '"></i> ' : '');

                return [
                    'id' => $platform->id,
                    'name' => $platform->name,
                    'image_url' => $isImage ? $platformImage : null,
                    'icon_class' => !$isImage ? $platformImage : null,
                    'option_html' => $icon . e($platform->name),
                ];
            });

        $platformsById = $platforms->keyBy('id');
        $categoriesById = $categories->keyBy('id');
        $serviceGroups = $categories->map(function (array $category) use ($groupedServices, $platformsById) {
            $categoryServices = $groupedServices->get($category['id'], collect());
            $platform = $platformsById->get($category['platform_id']);

            return [
                'id' => $category['id'],
                'name' => $category['name'],
                'platform_id' => $category['platform_id'] ?? -1,
                'platform_name' => $platform['name'] ?? '',
                'platform_image_url' => $platform['image_url'] ?? null,
                'platform_icon_class' => $platform['icon_class'] ?? null,
                'title' => filled($platform['name'] ?? null)
                    ? $platform['name'] . ' | ' . $category['name']
                    : $category['name'],
                'services' => $categoryServices,
            ];
        })->filter(fn (array $group) => $group['services']->isNotEmpty())->values();

        $servicesPayload = $services->map(function (array $service) use ($categoriesById, $platformsById) {
            $category = $categoriesById->get($service['category_id'], []);
            $platform = $platformsById->get($category['platform_id'] ?? null, []);

            return [
                'id' => $service['id'],
                'catid' => $service['category_id'],
                'cat' => $category['name'] ?? '',
                'cat_display_as' => (int) ($category['display'] ?? 0),
                'name' => $service['name'],
                'rate' => $service['rate'],
                'min' => $service['min'],
                'max' => $service['max'],
                'feature' => array_values($service['attributes']),
                'advanced_settings' => false,
                'advanced_settings_data' => ['min_balance' => '0', 'max_order' => '0'],
                'quantity_discount' => false,
                'quantity_discount_data' => [],
                'desc' => $service['desc'],
                'type' => 'Default',
                'schedule' => true,
                'avg' => $service['average_time'],
                'loop' => true,
                'platformid' => (int) ($category['platform_id'] ?? -1),
                'platform' => $platform['name'] ?? '',
                'platformicon' => $this->safePlatformIcon($platform['image_url'] ?? $platform['icon_class'] ?? ''),
                'confirm' => false,
                'summary' => '{}',
            ];
        })->values();

        $showAverageTime = serviceOn($config, 'service_average_time');
        $serviceColumnCount = $showAverageTime ? 8 : 7;
        $rateMin = (float) ($services->min('rate') ?? 0);
        $rateMax = (float) ($services->max('rate') ?? 100);

        return view("clients.theme-{$theme}.services.index", compact(
            'categories',
            'services',
            'groupedServices',
            'serviceGroups',
            'servicesPayload',
            'platforms',
            'showAverageTime',
            'serviceColumnCount',
            'rateMin',
            'rateMax'
        ));
    }

    /**
     * Display orders list
     */
    public function ordersIndex(string $status = null): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme  = $config ? ($config->default_interface ?? 'default') : 'default';

        $user     = auth()->user();
        $userLang = $user->lang ?? 'en';

        // Currency của user
        $currency = Currency::where('status', true)
            ->where('code', $user->currency ?? 'USD')
            ->first();
        if (!$currency) {
            $currency = (object)['symbol' => '$', 'symbol_position' => 'before', 'exchange_rate' => 1, 'code' => 'USD'];
        }
        $sym    = $currency->symbol;
        $symPos = $currency->symbol_position ?? 'before';
        $exRate = (float) ($currency->exchange_rate ?? 1);

        $query = Order::where('user_id', $user->id)->with('service.category');

        // Status từ route segment hoặc query param
        $status = $status ?? request('status');
        if ($status && !in_array($status, ['', 'all'])) {
            $query->where('status', $status);
        }

        // Date range từ start/end params
        $start = request('start');
        $end   = request('end');
        if ($start && $end) {
            $query->whereBetween('created_at', [
                str_replace('/', '-', $start) . ' 00:00:00',
                str_replace('/', '-', $end)   . ' 23:59:59',
            ]);
        }

        // Search
        $type    = request('type', '0');
        $keyword = request('keyword');
        if ($keyword) {
            $query->where(function ($q) use ($type, $keyword) {
                match ($type) {
                    '1' => $q->where('id', 'like', "%{$keyword}%"),
                    '2' => $q->where('link', 'like', "%{$keyword}%"),
                    '3' => $q->where('service_id', 'like', "%{$keyword}%"),
                    default => $q->where('id', 'like', "%{$keyword}%")
                        ->orWhere('link', 'like', "%{$keyword}%")
                        ->orWhere('service_id', 'like', "%{$keyword}%"),
                };
                return $q;
            });
        }

        $orders = $query->latest()->paginate(20)->withQueryString();
        $orderStatusOptions = [
            ['value' => 'pending', 'label' => 'Pending'],
            ['value' => 'processing', 'label' => 'Processing'],
            ['value' => 'inprogress', 'label' => 'In progress'],
            ['value' => 'completed', 'label' => 'Completed'],
            ['value' => 'partial', 'label' => 'Partial'],
            ['value' => 'canceled', 'label' => 'Canceled'],
        ];

        // Format name + charge trong controller — view chỉ echo
        $orders->getCollection()->transform(function ($order) use ($userLang, $sym, $symPos, $exRate) {
            // Service name theo ngôn ngữ user
            $name = $order->service->name ?? 'N/A';
            if (is_array($name)) {
                $name = $name[$userLang] ?? $name['en'] ?? reset($name) ?? 'N/A';
            }
            $order->service_name = (string) $name;
            $order->has_service_name = $order->service_name !== '' && $order->service_name !== 'N/A';

            $status = match ($order->status) {
                'failed' => 'Pending',
                'in progress', 'in_progress', 'inprogress' => 'In progress',
                default => ucfirst((string) $order->status),
            };
            $order->display_status = $status;
            $order->status_class = match (strtolower($status)) {
                'completed' => 'text-success',
                'canceled' => 'text-danger',
                'partial' => 'text-danger',
                'processing' => 'text-warning',
                'in progress' => 'text-info',
                default => 'text-gray-600',
            };

            $serviceIcon = $order->service?->image ?? $order->service?->category?->image;
            $isImage = filled($serviceIcon)
                && (str_contains($serviceIcon, '/') || str_contains($serviceIcon, '.'));
            $order->service_icon_url = $isImage ? $serviceIcon : null;
            $order->service_icon_class = !$isImage && filled($serviceIcon) ? $serviceIcon : null;
            $order->quantity_display = number_format($order->quantity ?? 0);

            // Charge: DB lưu USD → convert sang currency user
            $amount = $exRate > 0 ? (float) $order->charge * $exRate : (float) $order->charge;
            $str    = rtrim(rtrim(number_format($amount, 8, '.', ''), '0'), '.');
            if ($str === '' || $str === '.') $str = '0';
            $order->charge_display = $symPos === 'before' ? $sym . $str : $str . ' ' . $sym;

            if ($order->status === 'partial' && (float) ($order->total ?? 0) > (float) $order->charge) {
                $original = (float) $order->total * $exRate;
                $original = rtrim(rtrim(number_format($original, 8, '.', ''), '0'), '.');
                $order->original_charge_display = $symPos === 'before'
                    ? $sym . $original
                    : $original . ' ' . $sym;
            }

            return $order;
        });

        return view("clients.theme-{$theme}.orders.index", compact('orders', 'orderStatusOptions'));
    }

    /**
     * Display order details
     */
    public function ordersShow($id): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $order = Order::where('user_id', auth()->id())
            ->where('id', $id)
            ->with(['service.category.platform'])
            ->firstOrFail();

        return view("clients.theme-{$theme}.orders.show", compact('order'));
    }

    public function loopOrdersIndex(Request $request): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';
        $link = trim((string) $request->query('link', ''));
        $currency = Currency::where('status', true)
            ->where('code', Auth::user()?->currency ?? 'USD')
            ->first();
        $currency ??= (object) ['symbol' => '$', 'symbol_position' => 'before', 'exchange_rate' => 1];
        $currencyRate = (float) ($currency->exchange_rate ?? 1);
        $currencySymbol = (string) ($currency->symbol ?? '$');
        $symbolPosition = (string) ($currency->symbol_position ?? 'before');

        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->where('dripfeed', true)
            ->whereNotNull('loop_quantity')
            ->whereNotNull('loop_spacing')
            ->with('service')
            ->when($link !== '', fn ($query) => $query->where('link', 'like', '%' . addcslashes($link, '%_') . '%'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $orders->getCollection()->transform(function (Order $order) use ($currencyRate, $currencySymbol, $symbolPosition) {
            $serviceName = $order->service?->name ?? 'N/A';
            if (is_array($serviceName)) {
                $lang = Auth::user()?->lang ?? 'en';
                $serviceName = $serviceName[$lang] ?? $serviceName['en'] ?? reset($serviceName) ?? 'N/A';
            }

            $order->loop_done_display = (int) ($order->loop_current ?? 0);
            $order->loop_total_display = (int) $order->loop_quantity;
            $order->loop_progress = $order->loop_total_display > 0
                ? min(100, round($order->loop_done_display / $order->loop_total_display * 100, 1))
                : 0;
            $order->service_name_display = (string) $serviceName;
            $order->display_status = match (strtolower((string) $order->status)) {
                'in progress', 'in_progress', 'inprogress' => 'In progress',
                'awaiting' => 'Pending',
                default => ucfirst((string) $order->status),
            };
            $order->status_class = match (strtolower($order->display_status)) {
                'completed' => 'success',
                'canceled', 'failed' => 'danger',
                'processing', 'in progress' => 'warning',
                default => 'secondary',
            };
            $charge = (float) $order->charge * $currencyRate;
            $chargeFormatted = rtrim(rtrim(number_format($charge, 8, '.', ''), '0'), '.');
            $order->charge_display = $symbolPosition === 'before'
                ? $currencySymbol . $chargeFormatted
                : $chargeFormatted . ' ' . $currencySymbol;

            return $order;
        });

        return view("clients.theme-{$theme}.loop_orders.index", compact('orders', 'link'));
    }

    /**
     * Display API documentation
     */
    public function apiIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';
        $apiKey = Auth::user()?->api_key ?? '';
        $maskedApiKey = $apiKey
            ? substr($apiKey, 0, 5) . str_repeat('*', max(0, strlen($apiKey) - 5))
            : '—';

        return view("clients.theme-{$theme}.api.index", compact('maskedApiKey'));
    }

    /**
     * Display add funds page
     */
    public function addFundsIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $user = Auth::user();
        $currencyCode = $user->currency ?? 'USD';
        $transferContent = trim((string) $user->transfer_code);
        $transferContent = $transferContent !== '' ? $transferContent . ' a chuyen tien' : '';

        $currency = Currency::where('status', true)->where('code', $currencyCode)->first();
        if (!$currency) {
            $currency = (object)[
                'code' => 'USD',
                'symbol' => '$',
                'symbol_position' => 'before',
                'exchange_rate' => 1,
            ];
        }

        $nonDecimalCodes = Currency::where('status', true)
            ->whereIn('code', ['VND', 'JPY', 'KRW', 'IDR', 'CLP', 'HUF', 'TWD'])
            ->pluck('code')->toArray();

        // Get active payment methods
        $payments = PaymentMethod::active()->ordered()->where('domain', getDomain())->get();
        $needsVndTransferCode = empty(trim((string) $user->transfer_code));
        $paymentMethodsForDashboard = $payments->map(function (PaymentMethod $payment) use ($needsVndTransferCode): array {
            $config = $payment->parsed_config;
            $config = is_array($config) ? $config : (array) $config;
            $paymentCurrency = strtoupper((string) $payment->currency);
            $hideVndBankDetails = $needsVndTransferCode && $paymentCurrency === 'VND';

            if ($hideVndBankDetails) {
                $hiddenConfigKeys = array_map(
                    static fn (string $key): string => strtolower(str_replace(['-', '_'], '', $key)),
                    [
                        'account',
                        'account_number',
                        'account_no',
                        'account_name',
                        'bank',
                        'bank_account',
                        'bank_code',
                        'bank_name',
                        'name',
                        'qr',
                        'qr_image',
                        'qr_url',
                    ]
                );
                $sanitizeConfig = static function (array $values) use (&$sanitizeConfig, $hiddenConfigKeys): array {
                    foreach ($values as $key => $value) {
                        $normalizedKey = strtolower(str_replace(['-', '_'], '', (string) $key));

                        if (in_array($normalizedKey, $hiddenConfigKeys, true)) {
                            unset($values[$key]);
                            continue;
                        }

                        if (is_array($value)) {
                            $values[$key] = $sanitizeConfig($value);
                        }
                    }

                    return $values;
                };
                $config = $sanitizeConfig($config);
            }

            $toScalar = static function ($value, $fallback = '') {
                if (is_scalar($value)) {
                    return $value;
                }

                if (is_object($value)) {
                    $value = (array) $value;
                }

                if (is_array($value)) {
                    foreach (['code', 'value', 'name', 'label', 'title'] as $key) {
                        if (isset($value[$key]) && is_scalar($value[$key])) {
                            return $value[$key];
                        }
                    }
                }

                return $fallback;
            };

            $toNumber = static function ($value, float $fallback = 0): float {
                return is_scalar($value) && is_numeric($value) ? (float) $value : $fallback;
            };

            $bonus = $payment->bonus;
            if (is_string($bonus)) {
                $bonus = json_decode($bonus, true);
            } elseif (is_object($bonus)) {
                $bonus = (array) $bonus;
            }

            $bonus = is_array($bonus) ? $bonus : [];
            $bonusData = [];
            foreach ($bonus as $tier) {
                if (is_object($tier)) {
                    $tier = (array) $tier;
                }
                if (!is_array($tier)) {
                    continue;
                }

                $bonusData[] = [
                    'q' => $toNumber($tier['min'] ?? ($tier['q'] ?? 0)),
                    'p' => $toNumber($tier['percent'] ?? ($tier['p'] ?? 0)),
                ];
            }

            $currency = $toScalar($paymentCurrency, 'USD');
            $paymentRate = $paymentCurrency === 'USD'
                ? 1
                : $toNumber($config['rate'] ?? 27000, 27000);
            $details = $toScalar(
                $payment->details,
                is_array($payment->details) || is_object($payment->details)
                    ? json_encode($payment->details, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
                    : ''
            );
            $image = $toScalar($payment->image_url ?? $payment->image, '');
            $options = json_encode($config, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            return [
                'id' => $toNumber($payment->id),
                'pma_id' => $hideVndBankDetails ? 0 : $toNumber($payment->method_payment_id ?? 0),
                'group_id' => 0,
                'pma_status' => (int) $payment->status,
                'currency' => strtoupper((string) $currency),
                'name' => (string) $toScalar($payment->name, ''),
                'custom_icon' => $image,
                'icon' => $image,
                'rate' => $paymentRate,
                'details' => (string) $details,
                'options' => $options === false ? '{}' : $options,
                'bonus' => $bonusData !== [] ? 1 : 0,
                'bonus_data' => $bonusData,
                'min' => $toNumber($payment->min ?? 0),
                'max' => $toNumber($payment->max ?? 0),
                'type' => (string) $toScalar($payment->type, ''),
                'account_number' => $hideVndBankDetails ? '' : (string) $toScalar($config['account_number'] ?? ($config['account'] ?? ''), ''),
                'account_name' => $hideVndBankDetails ? '' : (string) $toScalar($config['account_name'] ?? ($config['name'] ?? ''), ''),
                'bank_code' => $hideVndBankDetails ? '' : (string) $toScalar($config['bank_code'] ?? ($config['bank'] ?? ''), ''),
                'qr_image' => $hideVndBankDetails ? '' : (string) $toScalar($config['qr_image'] ?? '', ''),
                'binance_id' => (string) $toScalar($config['binance_id'] ?? ($config['uid'] ?? ''), ''),
                'binance_currency' => strtoupper((string) $toScalar(
                    $config['asset'] ?? ($config['binance_currency'] ?? 'USDT'),
                    'USDT'
                )),
            ];
        })->values()->all();

        // Get current user's payment transactions
        $transactions = Payment::where('user_id', $user->id)
            ->where('domain', getDomain())
            ->with('paymentMethod')
            ->ordered()
            ->get();

        return view("clients.theme-{$theme}.addfunds.index", compact(
            'payments',
            'paymentMethodsForDashboard',
            'transactions',
            'currency',
            'nonDecimalCodes',
            'transferContent'
        ));
    }

    /**
     * Display invoice page for a payment
     */
    public function invoiceView(int $id): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $payment = Payment::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('paymentMethod')
            ->firstOrFail();

        $nonDecimalCodes = Currency::where('status', true)
            ->whereIn('code', ['VND', 'JPY', 'KRW', 'IDR', 'CLP', 'HUF', 'TWD'])
            ->pluck('code')->toArray();

        // Get currency object for formatting
        $currencyCode = $payment->paymentMethod->currency ?? 'USD';
        $currency = Currency::where('status', true)
            ->where('code', $currencyCode)
            ->first();

        if (!$currency) {
            $currency = (object)[
                'code' => 'USD',
                'symbol' => '$',
                'symbol_position' => 'before',
                'exchange_rate' => 1,
            ];
        }

        return view("clients.theme-{$theme}.addfunds.invoice", compact('payment', 'config', 'nonDecimalCodes', 'currency'));
    }

    /**
     * Download invoice as PDF
     */
    public function invoiceDownload(int $id)
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $payment = Payment::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('paymentMethod')
            ->firstOrFail();

        $nonDecimalCodes = Currency::where('status', true)
            ->whereIn('code', ['VND', 'JPY', 'KRW', 'IDR', 'CLP', 'HUF', 'TWD'])
            ->pluck('code')->toArray();

        // Get currency object for formatting
        $currencyCode = $payment->paymentMethod->currency ?? 'USD';
        $currency = Currency::where('status', true)
            ->where('code', $currencyCode)
            ->first();

        if (!$currency) {
            $currency = (object)[
                'code' => 'USD',
                'symbol' => '$',
                'symbol_position' => 'before',
                'exchange_rate' => 1,
            ];
        }

        // Return the invoice view with a download flag to auto-trigger PDF download
        return view("clients.theme-{$theme}.addfunds.invoice", compact('payment', 'config', 'nonDecimalCodes', 'currency'))->with('download', true);
    }

    /**
     * Download invoice as PDF for theme-6 (direct download without view)
     */
    public function invoiceDownloadDirect(int $id)
    {
        $config = Config::where('domain', getDomain())->first();
        $payment = Payment::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('paymentMethod')
            ->firstOrFail();

        $nonDecimalCodes = Currency::where('status', true)
            ->whereIn('code', ['VND', 'JPY', 'KRW', 'IDR', 'CLP', 'HUF', 'TWD'])
            ->pluck('code')->toArray();

        // Get currency object for formatting
        $currencyCode = $payment->paymentMethod->currency ?? 'USD';
        $currency = Currency::where('status', true)
            ->where('code', $currencyCode)
            ->first();

        if (!$currency) {
            $currency = (object)[
                'code' => 'USD',
                'symbol' => '$',
                'symbol_position' => 'before',
                'exchange_rate' => 1,
            ];
        }

        // Return the simple invoice template with auto-download flag
        // The template will auto-trigger PDF download via html2pdf.js
        return view('clients.theme-6.addfunds.invoice-simple', compact('payment', 'currency', 'nonDecimalCodes', 'config'))->with('download', true);
    }

    /**
     * Display bank transfer payment page
     */
    public function addFundsPayment(string $ref): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $amount = request('amount');
        $paymentId = request('payment_id');

        $payment = null;
        if ($paymentId) {
            $payment = PaymentMethod::find($paymentId);
        }

        // Fallback: get first active bank_vn method
        if (!$payment) {
            $payment = PaymentMethod::active()
                ->whereIn('type', ['bank_vn', 'bank'])
                ->first();
        }

        return view("clients.theme-{$theme}.addfunds.payment", compact('ref', 'amount', 'payment'));
    }

    /**
     * Display refill page
     */
    public function refillIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $query = Order::where('user_id', auth()->id())
            ->whereIn('refill_status', ['pending', 'inprogress', 'completed', 'rejected'])
            ->with(['service.category.platform']);

        // Filter by refill_status if provided (từ /refill/{status} hoặc ?status=)
        $status = request()->route('status') ?? request('status');
        // dashboard.js uses /refill/search for keyword searches; "search" is
        // a route marker, not a refill status.
        $status = $status === 'search' ? null : $status;
        if ($status && $status !== 'all') {
            $query->where('refill_status', $status);
        }

        // Search functionality
        $search = request('keyword', request('search'));
        $type   = request('type', '0');
        if ($search) {
            $query->where(function ($q) use ($search, $type) {
                if ($type == '1') {
                    // Refill ID = orders.id
                    $q->where('id', $search);
                } elseif ($type == '2') {
                    // Order ID = orders_api
                    $q->where('orders_api', 'like', "%{$search}%");
                } else {
                    // All fields
                    $q->where('id', 'like', "%{$search}%")
                        ->orWhere('orders_api', 'like', "%{$search}%")
                        ->orWhere('link', 'like', "%{$search}%")
                        ->orWhereHas('service', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
                }
            });
        }

        $refills = $query->latest()->paginate(20);

        return view("clients.theme-{$theme}.refill.index", compact('refills'));
    }

    /**
     * Display product orders page
     */
    public function productOrdersIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme  = $config ? ($config->default_interface ?? 'default') : 'default';
        $user   = Auth::user();

        $currency = Currency::where('status', true)->where('code', $user->currency ?? 'USD')->first();
        if (!$currency) {
            $currency = (object)['symbol' => '$', 'symbol_position' => 'before', 'exchange_rate' => 1, 'code' => 'USD'];
        }
        $sym    = $currency->symbol;
        $symPos = $currency->symbol_position ?? 'before';
        $exRate = (float)($currency->exchange_rate ?? 1);

        $orders = ProductOrder::where('user_id', $user->id)
            ->where('domain', getDomain())
            ->with('product')
            ->latest()
            ->paginate(20);

        return view("clients.theme-{$theme}.product_orders.index", compact('orders', 'sym', 'symPos', 'exRate'));
    }

    /**
     * Display products page
     */
    public function productsIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        // dashboard.js navigates with ?cat= and ?search=.
        $categoryId = request('cat', request('category'));
        $keyword    = request('search', request('keyword'));

        $categories = ProductCategory::where('domain', getDomain())
            ->where('status', true)
            ->orderBy('position')
            ->get();

        $query = Product::where('domain', getDomain())
            ->where('status', true)
            ->with('category', 'group')
            ->orderBy('position');

        if ($categoryId) {
            $query->where('product_category_id', $categoryId);
        }
        if ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        }

        // Group by product_group_id for display
        $products = $query->get()->groupBy('product_group_id');
        $groups   = ProductGroup::where('domain', getDomain())
            ->orderBy('position')->get()->keyBy('id');

        return view("clients.theme-{$theme}.products.index", compact('categories', 'products', 'groups'));
    }

    /**
     * Display product detail page
     */
    public function productShow(string $slug): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $product = Product::where('domain', getDomain())
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();

        return view("clients.theme-{$theme}.products.show", compact('product'));
    }

    /**
     * Display update (service sync logs) page
     */
    public function updateIndex(string $segment = null): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme  = $config ? ($config->default_interface ?? 'default') : 'default';

        // Nếu segment là số → page number từ path /updates/2
        if ($segment !== null && ctype_digit($segment)) {
            request()->merge(['page' => (int) $segment]);
            $segment = null;
        }

        $query = ServiceSyncLog::forDomain()
            ->with('service')
            ->when(\Schema::hasColumn('service_sync_logs', 'log_type'), fn($q) => $q->where('log_type', 'website'));

        // Filter từ path segment hoặc query param
        $filter = $segment ?? request('filter');
        if ($filter) {
            $typeMap = [
                'new'       => 'new',
                'decreased' => 'price_decrease',
                'increased' => 'price_increase',
                'enabled'   => 'enable',
                'disabled'  => 'disable',
            ];
            if (isset($typeMap[$filter])) {
                $query->where('change_type', $typeMap[$filter]);
            }
        }

        // Search
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('service_id', 'like', "%{$search}%")
                    ->orWhereHas('service', fn($sq) => $sq->where('name', 'like', "%{$search}%"));
            });
        }

        $logs = $query->latest()->paginate(50)->withQueryString();
        $logs->withPath('/updates');

        return view("clients.theme-{$theme}.update.index", compact('logs'));
    }

    /**
     * Display cashflow page
     */
    public function cashflowIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';
        $user = Auth::user();

        $orderId = request('id');

        $currency = Currency::where('status', true)
            ->where('code', $user->currency ?? 'USD')
            ->first();
        if (!$currency) {
            $currency = (object)['symbol' => '$', 'symbol_position' => 'before', 'exchange_rate' => 1, 'code' => 'USD'];
        }
        $sym    = $currency->symbol;
        $symPos = $currency->symbol_position ?? 'before';
        $exRate = (float)($currency->exchange_rate ?? 1);

        $query = Transaction::where('user_id', $user->id)
            ->where('domain', getDomain())
            ->latest();

        if ($orderId) {
            $query->where('order_id', $orderId);
        }

        $transactions = $query->paginate(50);
        $order = $orderId ? Order::where('user_id', $user->id)->find($orderId) : null;

        return view("clients.theme-{$theme}.cashflow.index", compact('transactions', 'orderId', 'order', 'sym', 'symPos', 'exRate'));
    }

    /**
     * Display affiliates page
     */
    public function affiliatesIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme  = $config ? ($config->default_interface ?? 'default') : 'default';
        $user   = Auth::user();

        // Referral link
        $referralLink = url('/signup') . '?ref=' . $user->referral_code;

        // Danh sách người được giới thiệu
        $referrals = \App\Models\Affiliate::where('referrer_id', $user->id)
            ->with('referred')
            ->latest()
            ->get();

        $totalEarned  = $referrals->sum('total_earned');
        $totalOrders  = $referrals->sum('orders_count');

        return view("clients.theme-{$theme}.affiliates.index", [
            'config'       => $config,
            'referralLink' => $referralLink,
            'referrals'    => $referrals,
            'totalEarned'  => $totalEarned,
            'totalOrders'  => $totalOrders,
        ]);
    }

    /**
     * Display refunds page
     */
    public function refundsIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $query = Order::where('user_id', auth()->id())
            ->whereIn('status', ['canceled', 'partial'])
            ->where('charge', '>', 0)
            ->with(['service.category.platform']);

        // Filter by order status if provided
        $orderStatus = request('order_status');
        if ($orderStatus && $orderStatus !== 'all') {
            $query->where('status', $orderStatus);
        }

        // Search functionality
        $search = request('search');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q
                    ->where('id', 'like', "%{$search}%")
                    ->orWhere('link', 'like', "%{$search}%");
            });
        }

        // Filter by last 90 days (optional, can be removed for testing)
        if (request('show_all') !== '1') {
            $query->where('created_at', '>=', now()->subDays(90));
        }

        $refunds = $query->latest()->paginate(20);

        return view("clients.theme-{$theme}.refunds.index", compact('refunds'));
    }

    /**
     * Display child panel page
     */
    public function childPanelIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme  = $config ? ($config->default_interface ?? 'default') : 'default';

        $user         = Auth::user();
        $currencyCode = $user->currency ?? 'USD';
        $baseCost     = (float) ($config->child_panel_cost ?? 0);

        // Tính cost theo currency của user
        $currency = Currency::where('status', true)->where('code', $currencyCode)->first();
        $rate     = $currency ? (float) $currency->exchange_rate : 1;
        $costFormatted = $rate > 1
            ? number_format($baseCost * $rate, 0, '.', ',') . ' ' . $currencyCode
            : '$' . number_format($baseCost, 2);

        return view("clients.theme-{$theme}.childpanel.index", compact('config', 'costFormatted', 'currencyCode'));
    }

    /**
     * Display tickets page
     */
    public function ticketsIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        // Load ticket subjects
        $ticketSubjects = TicketSubject::active()->ordered()->get();
        $categories = $ticketSubjects->pluck('category')->unique()->values();
        $categoriesData = $categories;

        $query = Auth::user()
            ->tickets()
            ->with(['ticketSubject', 'replies'])
            ->withCount(['replies as unread_count' => function ($query) {
                $query->whereNull('read_at')->where('is_admin', true);
            }]);

        // Filter by status if provided
        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Search functionality
        if (request('search')) {
            $search = request('search');
            $query->where('subject', 'like', "%{$search}%");
        }

        $tickets = $query
            ->orderBy('last_reply_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view("clients.theme-{$theme}.tickets.index", compact('tickets', 'ticketSubjects', 'categories', 'categoriesData'));
    }

    /**
     * Display create ticket page
     */
    public function ticketsCreate(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';
        return view("clients.theme-{$theme}.tickets.create");
    }

    /**
     * Display ticket details
     */
    public function ticketsShow($id): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $ticket = Auth::user()
            ->tickets()
            ->with(['user', 'assignedTo', 'ticketSubject', 'replies.user'])
            ->findOrFail($id);

        // Mark admin replies as read
        $ticket
            ->replies()
            ->where('is_admin', true)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return view("clients.theme-{$theme}.tickets.show", compact('ticket'));
    }

    /**
     * Display mass order page
     */
    public function massOrderIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';
        return view("clients.theme-{$theme}.mass.index");
    }

    /**
     * Display account page
     */
    public function accountIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';

        $user = Auth::user();
        $userLang = $user->lang ?? 'en';
        $userTimezone = $user->timezone ?? '0';

        $twoFactor = null;
        if (!$user->two_factor_enabled) {
            $google2fa = new \PragmaRX\Google2FA\Google2FA();
            $secret = $user->two_factor_secret ?: $google2fa->generateSecretKey(16);

            if (!$user->two_factor_secret) {
                $user->update(['two_factor_secret' => $secret]);
            }

            $otpUrl = $google2fa->getQRCodeUrl(
                config('app.name', 'App'),
                $user->email,
                $secret
            );
            $renderer = new \BaconQrCode\Renderer\ImageRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200, 2),
                new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
            );
            $svg = (new \BaconQrCode\Writer($renderer))->writeString($otpUrl);

            $twoFactor = [
                'secret' => $secret,
                'qr' => 'data:image/svg+xml;base64,' . base64_encode($svg),
            ];
        }

        $languages = Language::where('status', true)
            ->get(['id', 'code', 'name', 'flag'])
            ->map(function (Language $language): array {
                $flagClass = trim((string) $language->flag);
                $flagCode = $language->flag_code;

                return [
                    'id' => $language->id,
                    'code' => $language->code,
                    'name' => $language->name,
                    'flag_class' => $flagClass,
                    'flag_code' => $flagCode,
                    'flag_url' => $flagCode !== ''
                        ? asset("cdn.whoispanel.com/flags/4x3/{$flagCode}.svg")
                        : '',
                ];
            })
            ->all();
        if (empty($languages)) {
            $languages = [
                [
                    'id' => null,
                    'code' => 'en',
                    'name' => 'English',
                    'flag_class' => 'fi fi-us',
                    'flag_code' => 'us',
                    'flag_url' => asset('cdn.whoispanel.com/flags/4x3/us.svg'),
                ],
                [
                    'id' => null,
                    'code' => 'vi',
                    'name' => 'Vietnam',
                    'flag_class' => 'fi fi-vn',
                    'flag_code' => 'vn',
                    'flag_url' => asset('cdn.whoispanel.com/flags/4x3/vn.svg'),
                ],
            ];
        }
        $timezones = getTimezones();
        $currencies = Currency::where('status', true)->orderBy('code')->get(['id', 'code', 'name', 'symbol', 'exchange_rate', 'symbol_position']);

        $data = [
            'lang'          => $userLang,
            'languages'     => $languages,
            'timezone'      => $userTimezone,
            'timezones'     => $timezones,
            'currencies'    => $currencies,
            'user_currency' => $user->currency ?? 'USD',
            'two_factor'    => $twoFactor,
            'login_history' => ActivityLog::where('user_id', $user->id)
                ->where('type', 'login')
                ->latest('created_at')
                ->limit(20)
                ->get(['activity', 'created_at'])
                ->map(function ($log) {
                    $act = $log->activity ?? [];
                    if (!is_array($act)) $act = json_decode($act, true) ?? [];
                    return [
                        'time' => $log->created_at->format('Y-m-d H:i'),
                        'ip'   => $act['ip_address'] ?? '—',
                        'ua'   => $act['user_agent'] ?? '—',
                    ];
                }),
        ];

        // Keep the dedicated Settings view on /settings while /account keeps
        // its own page. Themes without a Settings view fall back to Account.
        $accountView = "clients.theme-{$theme}.account.index";
        $settingsView = "clients.theme-{$theme}.settings.index";
        $themePreview = request()->session()->get('client_theme_preview');
        if (
            (string) $theme === '4' &&
            ($themePreview['file'] ?? null) === 'account/edit.blade.php' &&
            view()->exists("clients.theme-{$theme}.account.edit")
        ) {
            return view("clients.theme-{$theme}.account.edit", compact('data'));
        }

        $viewName = request()->routeIs('clients.settings.*') && view()->exists($settingsView)
            ? $settingsView
            : (view()->exists($accountView) ? $accountView : $settingsView);

        return view($viewName, compact('data'));
    }

    public function notificationsIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';
        return view("clients.theme-{$theme}.account.notifications");
    }

    /**
     * Display cooperate page
     */
    public function cooperateIndex(): View
    {
        $config = Config::where('domain', getDomain())->first();
        $theme = $config ? ($config->default_interface ?? 'default') : 'default';
        if ($theme === '1') {
            $theme = 'default';
        }

        $view = "clients.theme-{$theme}.cooperate.index";
        abort_unless(view()->exists($view), 404);

        return view($view);
    }

    /**
     * Create checkout session for Binance payment
     */
    public function createCheckout(Request $request)
    {
        try {
            $validated = $request->validate([
                'pm_id' => 'required|integer',
                'amount' => 'required|numeric|min:0.01',
            ]);

            // Get payment method
            $paymentMethod = PaymentMethod::where('domain', getDomain())
                ->find($validated['pm_id']);
            if (!$paymentMethod || !$paymentMethod->status) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment method not available'
                ], 400);
            }

            // Check if it's Binance
            if ($paymentMethod->type !== 'binance' && $paymentMethod->type !== 'crypto') {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid payment method type'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => 'Checkout is ready'
            ]);
        } catch (\Exception $e) {
            Log::error('Create checkout error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error creating checkout: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display checkout page for Binance payment
     */
    public function checkoutView($id)
    {
        try {
            // Get transaction
            $transaction = Transaction::find($id);

            if (!$transaction) {
                abort(404, 'Checkout not found');
            }

            // Verify user owns this transaction
            if ($transaction->user_id !== Auth::id()) {
                abort(403, 'Unauthorized');
            }

            // Get payment method
            $paymentMethod = PaymentMethod::find($transaction->payment_method_id);
            if (!$paymentMethod) {
                abort(404, 'Payment method not found');
            }

            // Get config for theme
            $config = Config::where('domain', getDomain())->first();
            $theme = $config ? ($config->default_interface ?? 'default') : 'default';

            // Get user
            $user = Auth::user();

            // Parse payment method config
            $pmConfig = is_array($paymentMethod->parsed_config) ? $paymentMethod->parsed_config : [];
            $binanceId = $pmConfig['binance_id'] ?? ($pmConfig['uid'] ?? '');
            $qrImage = $pmConfig['qr_image'] ?? '';

            // Prepare data for checkout page
            $data = [
                'transaction' => $transaction,
                'paymentMethod' => $paymentMethod,
                'amount' => $transaction->amount,
                'currency' => $paymentMethod->currency ?? 'USDT',
                'binanceId' => $binanceId,
                'qrImage' => $qrImage,
                'user' => $user,
                'config' => $config
            ];

            // Return checkout view
            return view("clients.theme-{$theme}.addfunds.checkout", $data);
        } catch (\Exception $e) {
            Log::error('Checkout view error: ' . $e->getMessage());
            abort(500, 'Error loading checkout page');
        }
    }
}
