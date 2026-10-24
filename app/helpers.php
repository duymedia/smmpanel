<?php

use App\Models\ChildPanel;
use App\Models\Currency;

if (!function_exists('getCurrencyData')) {
    /**
     * Get currency symbols and names (used by currency migration/update).
     */
    function getCurrencyData(): array
    {
        static $data;
        if ($data !== null) {
            return $data;
        }

        $currencies = [
            'USD' => ['$', 'US Dollar'],
            'EUR' => ['€', 'Euro'],
            'GBP' => ['£', 'British Pound'],
            'JPY' => ['¥', 'Japanese Yen'],
            'VND' => ['₫', 'Vietnamese Dong'],
            'AUD' => ['A$', 'Australian Dollar'],
            'CAD' => ['C$', 'Canadian Dollar'],
            'CHF' => ['CHF', 'Swiss Franc'],
            'CNY' => ['¥', 'Chinese Yuan'],
            'KRW' => ['₩', 'South Korean Won'],
            'SGD' => ['S$', 'Singapore Dollar'],
            'HKD' => ['HK$', 'Hong Kong Dollar'],
            'INR' => ['₹', 'Indian Rupee'],
            'IDR' => ['Rp', 'Indonesian Rupiah'],
            'THB' => ['฿', 'Thai Baht'],
            'PHP' => ['₱', 'Philippine Peso'],
            'MYR' => ['RM', 'Malaysian Ringgit'],
        ];

        return $data = [
            'symbols' => array_map(fn (array $currency) => $currency[0], $currencies),
            'names' => array_map(fn (array $currency) => $currency[1], $currencies),
        ];
    }
}
use App\Models\User;

if (!function_exists('getDomain')) {
    function getDomain(): string
    {
        return (string) (request()->getHost() ?: env('APP_MAIN_SITE', 'localhost'));
    }
}

if (!function_exists('isChildPanel')) {
    function isChildPanel(?string $domain = null): bool
    {
        try {
            return ChildPanel::where('domain_panel', $domain ?: getDomain())->exists();
        } catch (\Throwable $e) {
            return false;
        }
    }
}

if (!function_exists('childPanelParent')) {
    function childPanelParent(?string $domain = null): ?User
    {
        try {
            return ChildPanel::with('user')
                ->where('domain_panel', $domain ?: getDomain())
                ->first()?->user;
        } catch (\Throwable $e) {
            return null;
        }
    }
}

if (!function_exists('panelAccess')) {
    /** Return the current panel access level: parent or child. */
    function panelAccess(?string $domain = null): string
    {
        static $access = [];
        $domain ??= getDomain();

        if (array_key_exists($domain, $access)) {
            return $access[$domain];
        }

        try {
            $value = ChildPanel::where('domain_panel', $domain)->value('access');
            return $access[$domain] = is_string($value) && $value !== '' ? $value : 'custom';
        } catch (\Throwable $e) {
            return $access[$domain] = 'parent';
        }
    }
}

if (!function_exists('panelCanAccess')) {
    function panelCanAccess(string $page, ?string $domain = null): bool
    {
        // Request paths include the /admin prefix, while access values are
        // stored as page keys (for example: orders, services, reports).
        $page = trim(strtolower($page), " /\\");
        $page = preg_replace('#^admin(?:/|$)#', '', $page);
        if ($page === '' || $page === 'dashboard' || $page === 'cron-jobs' || str_starts_with($page, 'cron-jobs/')) {
            return false;
        }

        $access = panelAccess($domain);
        if ($access === 'all' || $access === 'parent' || panelAccessPages($domain) === ['*']) {
            return true;
        }

        // Ticket subjects are an administrative configuration page and are
        // intentionally unavailable to restricted child panels, even when an
        // older access list still contains the legacy key.
        if ($page === 'ticket-subjects' || str_starts_with($page, 'ticket-subjects/')) {
            return false;
        }

        return collect(panelAccessPages($domain))->contains(function ($item) use ($page) {
            $item = trim(strtolower((string) $item), " /\\");
            $item = preg_replace('#^admin(?:/|$)#', '', $item);
            if ($item === '') {
                return false;
            }

            if ($item === '*') {
                return true;
            }

            return $item === $page || str_starts_with($page, $item . '/');
        });
    }
}

if (!function_exists('panelAccessPages')) {
    /** Return the admin page prefixes granted by child_panels.access. */
    function panelAccessPages(?string $domain = null): array
    {
        $domain ??= getDomain();
        static $pages = [];

        if (array_key_exists($domain, $pages)) {
            return $pages[$domain];
        }

        try {
            $value = ChildPanel::where('domain_panel', $domain)->value('access');
            if (is_string($value)) {
                $decoded = json_decode($value, true);
                $value = json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
            }

            if ($value === 'all' || $value === ['all']) {
                return $pages[$domain] = ['*'];
            }

            $pages[$domain] = is_array($value)
                ? array_values(array_filter($value, 'is_string'))
                : array_values(array_filter(preg_split('/[,|\s]+/', (string) $value)));

            // Keep one canonical format for both the router and navigation.
            return $pages[$domain] = array_values(array_filter(array_map(
                static function ($page): string {
                    $page = trim(strtolower((string) $page), " /\\");
                    return preg_replace('#^admin(?:/|$)#', '', $page);
                },
                $pages[$domain]
            )));
        } catch (\Throwable $e) {
            return $pages[$domain] = [];
        }
    }
}

if (!function_exists('getTimezones')) {
    function getTimezones(): array
    {
        static $timezones;

        return $timezones ??= [
            ['label' => '(UTC -12:00) Baker/Howland Island', 'timezone' => '-54000'],
            ['label' => '(UTC -11:00) Niue', 'timezone' => '-50400'],
            ['label' => '(UTC -10:00) Hawaii-Aleutian Standard Time, Cook Islands, Tahiti', 'timezone' => '-46800'],
            ['label' => '(UTC -9:30) Marquesas Islands', 'timezone' => '-45000'],
            ['label' => '(UTC -9:00) Alaska Standard Time, Gambier Islands', 'timezone' => '-43200'],
            ['label' => '(UTC -8:00) Pacific Standard Time, Clipperton Island', 'timezone' => '-39600'],
            ['label' => '(UTC -7:00) Mountain Standard Time', 'timezone' => '-36000'],
            ['label' => '(UTC -6:00) Central Standard Time', 'timezone' => '-32400'],
            ['label' => '(UTC -5:00) Eastern Standard Time, Western Caribbean Standard Time', 'timezone' => '-28800'],
            ['label' => '(UTC -4:30) Venezuelan Standard Time', 'timezone' => '-27000'],
            ['label' => '(UTC -4:00) Atlantic Standard Time, Eastern Caribbean Standard Time', 'timezone' => '-25200'],
            ['label' => '(UTC -3:30) Newfoundland Standard Time', 'timezone' => '-23400'],
            ['label' => '(UTC -3:00) Argentina, Brazil, French Guiana, Uruguay', 'timezone' => '-21600'],
            ['label' => '(UTC -2:00) South Georgia/South Sandwich Islands', 'timezone' => '-18000'],
            ['label' => '(UTC -1:00) Azores, Cape Verde Islands', 'timezone' => '-14400'],
            ['label' => '(UTC) Greenwich Mean Time, Western European Time', 'timezone' => '-10800'],
            ['label' => '(UTC +1:00) Central European Time, West Africa Time', 'timezone' => '-7200'],
            ['label' => '(UTC +2:00) Central Africa Time, Eastern European Time, Kaliningrad Time', 'timezone' => '-3600'],
            ['label' => '(UTC +3:00) Moscow Time, East Africa Time, Arabia Standard Time', 'timezone' => '0'],
            ['label' => '(UTC +3:30) Iran Standard Time', 'timezone' => '1800'],
            ['label' => '(UTC +4:00) Azerbaijan Standard Time, Samara Time', 'timezone' => '3600'],
            ['label' => '(UTC +4:30) Afghanistan', 'timezone' => '5400'],
            ['label' => '(UTC +5:00) Pakistan Standard Time, Yekaterinburg Time', 'timezone' => '7200'],
            ['label' => '(UTC +5:30) Indian Standard Time, Sri Lanka Time', 'timezone' => '9000'],
            ['label' => '(UTC +5:45) Nepal Time', 'timezone' => '9900'],
            ['label' => '(UTC +6:00) Bangladesh Standard Time, Bhutan Time, Omsk Time', 'timezone' => '10800'],
            ['label' => '(UTC +6:30) Cocos Islands, Myanmar', 'timezone' => '12600'],
            ['label' => '(UTC +7:00) Krasnoyarsk Time, Cambodia, Laos, Thailand, Vietnam', 'timezone' => '14400'],
            ['label' => '(UTC +8:00) Australian Western Standard Time, Beijing Time, Irkutsk Time', 'timezone' => '18000'],
            ['label' => '(UTC +8:45) Australian Central Western Standard Time', 'timezone' => '20700'],
            ['label' => '(UTC +9:00) Japan Standard Time, Korea Standard Time, Yakutsk Time', 'timezone' => '21600'],
            ['label' => '(UTC +9:30) Australian Central Standard Time', 'timezone' => '23400'],
            ['label' => '(UTC +10:00) Australian Eastern Standard Time, Vladivostok Time', 'timezone' => '25200'],
            ['label' => '(UTC +10:30) Lord Howe Island', 'timezone' => '27000'],
            ['label' => '(UTC +11:00) Srednekolymsk Time, Solomon Islands, Vanuatu', 'timezone' => '28800'],
            ['label' => '(UTC +11:30) Norfolk Island', 'timezone' => '30600'],
            ['label' => '(UTC +12:00) Fiji, Gilbert Islands, Kamchatka Time, New Zealand Standard Time', 'timezone' => '32400'],
            ['label' => '(UTC +12:45) Chatham Islands Standard Time', 'timezone' => '35100'],
            ['label' => '(UTC +13:00) Samoa Time Zone, Phoenix Islands Time, Tonga', 'timezone' => '36000'],
            ['label' => '(UTC +14:00) Line Islands', 'timezone' => '39600'],
        ];
    }
}

if (!function_exists('adminMessage')) {
    
    function adminMessage(string $type): string
    {
        $lang = request()->input('lang')
            ?? request()->input('data.lang')
            ?? request()->input('data-lang')
            ?? auth()->user()?->lang
            ?? app()->getLocale();
        $lang = strtolower((string) $lang);
        $lang = str_starts_with($lang, 'vi') ? 'vi' : 'en';

        return match ($type) {
            'add' => $lang === 'vi' ? 'Thêm thành công!' : 'Add successfully!',
            'delete' => $lang === 'vi' ? 'Xóa thành công' : 'Delete successfully',
            'save' => $lang === 'vi' ? 'Đã lưu thành công' : 'Saved successfully',
            'sync' => $lang === 'vi' ? 'Đồng bộ thành công' : 'Sync successfully',
            'status' => $lang === 'vi' ? 'Cập nhật thành công' : 'Updated successfully',
            default => $lang === 'vi' ? 'Cập nhật thành công' : 'Update successfully',
        };
    }
}

if (!function_exists('adminSuccess')) {
    
    function adminSuccess(string $type = 'update', array $data = [], int $status = 200)
    {
        return response()->json(array_merge([
            'success' => adminMessage($type),
        ], $data), $status);
    }
}

if (!function_exists('orderStatusToDatabase')) {
    function orderStatusMap(): array
    {
        static $map = [
            'pending' => 'pending',
            'processing' => 'processing',
            'in progress' => 'in progress',
            'inprogress' => 'in progress',
            'completed' => 'completed',
            'partial' => 'partial',
            'canceled' => 'canceled',
            'cancelled' => 'canceled',
            'awaiting' => 'awaiting',
            'failed' => 'failed',
        ];

        return $map;
    }

    
    function orderStatusToDatabase(?string $status): string
    {
        $status = trim((string) $status);
        $normalized = strtolower(str_replace(['_', '-'], ' ', $status));

        return orderStatusMap()[$normalized] ?? $normalized;
    }
}

if (!function_exists('orderStatusToDisplay')) {
    
    function orderStatusToDisplay(?string $status): string
    {
        $display = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'in progress' => 'In progress',
            'completed' => 'Completed',
            'partial' => 'Partial',
            'canceled' => 'Canceled',
            'awaiting' => 'Awaiting',
            'failed' => 'Failed',
        ];

        return $display[orderStatusToDatabase($status)] ?? 'Pending';
    }
}

if (!function_exists('getOrderStatusText')) {
    
    function getOrderStatusText(?string $status): string
    {
        return orderStatusToDisplay($status);
    }
}

if (!function_exists('orderStatusFromUrl')) {
    
    function orderStatusFromUrl(?string $status): string
    {
        $status = strtolower(trim((string) $status));
        if ($status === '') {
            return '';
        }

        return [
            'all' => '',
            'manual' => 'Manual',
            'ticket' => 'Ticket',
        ][$status] ?? orderStatusToDisplay($status);
    }
}

if (!function_exists('roundExchangeRate')) {
    
    function roundExchangeRate($rate)
    {
        $rate = (float) $rate;

        if ($rate == 1.0) return 1;
        if ($rate < 1) return (float) rtrim(rtrim(number_format($rate, 8, '.', ''), '0'), '.');
        if ($rate < 10) return round($rate, 2);
        if ($rate < 100) return round($rate, 1);

        return round($rate, 0);
    }
}

if (!function_exists('fetchCurrencyRates')) {
    
    function fetchCurrencyRates($baseCurrency = 'USD')
    {
        $apiKey = 'efbb7163444e6bb8819e6dbf';
        $url = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/{$baseCurrency}";

        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($error || $httpCode !== 200) {
                return false;
            }

            $data = json_decode($response, true);

            if (!$data || !isset($data['result']) || $data['result'] !== 'success') {
                return false;
            }

            return [
                'success' => true,
                'base_code' => $data['base_code'],
                'time_last_update' => $data['time_last_update_utc'],
                'time_next_update' => $data['time_next_update_utc'],
                'conversion_rates' => $data['conversion_rates']
            ];
        } catch (Exception $e) {
            return false;
        }
    }
}

if (!function_exists('getCurrencyData')) {
    function getCurrencyData(): array
    {
        static $data;
        if ($data !== null) {
            return $data;
        }

        $currencies = [
            'USD' => ['$', 'US Dollar'],
            'AUD' => ['A$', 'Australian Dollar'],
            'CAD' => ['C$', 'Canadian Dollar'],
            'CHF' => ['CHF', 'Swiss Franc'],
            'CNY' => ['¥', 'Chinese Yuan'],
            'EUR' => ['€', 'Euro'],
            'GBP' => ['£', 'British Pound'],
            'IDR' => ['Rp', 'Indonesian Rupiah'],
            'INR' => ['₹', 'Indian Rupee'],
            'JPY' => ['¥', 'Japanese Yen'],
            'KRW' => ['₩', 'South Korean Won'],
            'PHP' => ['₱', 'Philippine Peso'],
            'RUB' => ['₽', 'Russian Ruble'],
            'THB' => ['฿', 'Thai Baht'],
            'TRY' => ['₺', 'Turkish Lira'],
            'VND' => ['₫', 'Vietnamese Dong'],
        ];

        return $data = [
            'symbols' => array_map(fn (array $currency) => $currency[0], $currencies),
            'names' => array_map(fn (array $currency) => $currency[1], $currencies),
        ];
    }
}

if (!function_exists('userMoney')) {
    
    function userMoney($user, $currencies, $nonDecimalCodes = []): array
    {
        $userCurrency = $currencies?->firstWhere('code', $user->currency ?? 'USD')
            ?: Currency::where('code', 'USD')->first()
            ?: (object) [
                'code' => 'USD',
                'symbol' => '$',
                'name' => 'US Dollar',
                'symbol_position' => 'before',
                'exchange_rate' => 1,
            ];

        return [
            'currency' => $userCurrency,
            'balance' => fmtMoney($user->balance ?? 0, $userCurrency, $nonDecimalCodes),
            'spent' => fmtMoney($user->spent ?? 0, $userCurrency, $nonDecimalCodes),
        ];
    }
}

if (!function_exists('langData')) {
    
    function langData(?object $language = null, ?string $fallback = 'en'): array
    {
        $code = strtolower((string) ($language?->code ?: $fallback ?: 'en'));
        $flagClass = trim((string) ($language?->flag ?: ($code === 'vi' ? 'fi fi-vn' : 'fi fi-us')));
        $flagCode = preg_replace('/^(?:fi\s+)?fi-/', '', $flagClass) ?: ($code === 'vi' ? 'vn' : 'us');

        return [
            'id' => $language?->id,
            'code' => $code,
            'name' => $language?->name ?: strtoupper($code),
            'flag_class' => $flagClass,
            'flag_code' => $flagCode,
            'flag_url' => asset("cdn.whoispanel.com/flags/4x3/{$flagCode}.svg"),
        ];
    }
}

if (!function_exists('userUi')) {
    
    function userUi($user, $currencies, ?object $language = null): array
    {
        $currencyData = userMoney($user, $currencies, ['VND']);
        $langData = langData($language, $user->lang ?? 'en');

        return [
            'balance' => [
                'amount' => (float) ($user->balance ?? 0),
                'formatted' => $currencyData['balance'],
                'currency' => $currencyData['currency'],
            ],
            'spent' => [
                'amount' => (float) ($user->spent ?? 0),
                'formatted' => $currencyData['spent'],
                'currency' => $currencyData['currency'],
            ],
            'lang' => $langData,
        ];
    }
}

if (!function_exists('fmtMoney')) {
    
    function fmtMoney($amount, $currency, $nonDecimalCodes = [], bool $full = false): string
    {
        $currency = is_object($currency) ? $currency : (object) [];
        $code = strtoupper((string) ($currency->code ?? 'USD'));
        $converted = (float) $amount * (float) ($currency->exchange_rate ?? 1);
        $noDecimals = in_array($code, $nonDecimalCodes, true) || $code === 'VND';

        if ($full) {
            $formatted = rtrim(rtrim(number_format($converted, 8, '.', ''), '0'), '.') ?: '0';
        } elseif ($noDecimals) {
            $formatted = number_format($converted, 0, '.', ',');
        } elseif ($converted == 0.0) {
            $formatted = '0.00';
        } else {
            $decimals = $code === 'USD' ? 3 : ($converted >= 1000 ? 0 : ($converted >= 100 ? 1 : 2));
            $formatted = rtrim(rtrim(number_format($converted, $decimals, '.', ','), '0'), '.') ?: '0';
        }

        $symbol = (string) ($currency->symbol ?? '');
        return ($currency->symbol_position ?? 'before') === 'before'
            ? $symbol . $formatted
            : $formatted . ($symbol !== '' ? ' ' . $symbol : '');
    }
}

if (!function_exists('formatCurrencyAmount')) {
    function formatCurrencyAmount($amount, $currency, $nonDecimalCodes = [])
    {
        return fmtMoney($amount, $currency, $nonDecimalCodes);
    }
}

if (!function_exists('formatCharge')) {
    function formatCharge($charge)
    {
        if ($charge == 0) {
            return '0';
        }

        $charge = (float) $charge;
        $formatted = number_format($charge, 8, '.', '');
        $formatted = rtrim($formatted, '0');
        $formatted = rtrim($formatted, '.');

        return $formatted ?: '0';
    }
}

if (!function_exists('userRole')) {
    
    function userRole($user = null, ?string $value = null): int|array|string
    {
        static $configs;
        $configs ??= [
            User::ROLE_ADMIN => ['key' => 'menu::Admin', 'text' => 'Admin', 'badge' => 'badge-light-danger', 'service' => 'rate_retail', 'product' => 'price'],
            User::ROLE_AGENT => ['key' => 'menu::Agent', 'text' => 'Agent', 'badge' => 'badge-light-warning', 'service' => 'rate_agent', 'product' => 'price_1'],
            User::ROLE_DISTRIBUTOR => ['key' => 'menu::Distributor', 'text' => 'Distributor', 'badge' => 'badge-light-primary', 'service' => 'rate_distributor', 'product' => 'price_2'],
            User::ROLE_STAFF => ['key' => 'menu::Staff', 'text' => 'Staff', 'badge' => 'badge-light-info', 'service' => 'rate_retail', 'product' => 'price'],
            User::ROLE_RETAIL => ['key' => 'menu::Customer', 'text' => 'Customer', 'badge' => 'badge-light-success', 'service' => 'rate_retail', 'product' => 'price'],
        ];

        $role = (int) (is_numeric($user)
            ? $user
            : ($user?->role ?? auth()->user()?->role ?? User::ROLE_RETAIL));
        $config = $configs[$role] ?? $configs[User::ROLE_RETAIL];

        return $value === null ? $role : ($value === 'role' ? $role : ($config[$value] ?? $config));
    }
}

if (!function_exists('getUserServiceRate')) {
    function getUserServiceRate($user, $service, $customRate = null): float
    {
        $rate = (float) ($service->{userRole($user, 'service')} ?? $service->rate_retail ?? 0);
        if (is_object($customRate)) {
            if ($customRate->rate !== null) return (float) $customRate->rate;
            if ($customRate->percent !== null) return $rate * (float) $customRate->percent / 100;
        }
        return is_numeric($customRate) ? (float) $customRate : $rate;
    }
}

if (!function_exists('getUserProductRate')) {
    function getUserProductRate($user, $product): float
    {
        $field = userRole($user, 'product');
        return (float) ($product->{$field} ?? $product->price ?? 0);
    }
}

if (!function_exists('formatAverageTime')) {
    function formatAverageTime($seconds)
    {
        if (!$seconds || $seconds <= 0) {
            return '';
        }

        $seconds = (int) $seconds;
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        $parts = [];

        if ($hours > 0) {
            $parts[] = $hours . 'h';
        }

        if ($minutes > 0) {
            $parts[] = $minutes . 'm';
        }

        if ($secs > 0 || empty($parts)) {
            $parts[] = $secs . 's';
        }

        return implode(' ', $parts);
    }
}

if (!function_exists('adminNotice')) {
    
    function adminNotice(): ?array
    {
        $path = storage_path('app/notifications.json');
        if (!is_file($path)) {
            return null;
        }

        $notice = json_decode((string) file_get_contents($path), true);
        if (!is_array($notice) || empty(trim(strip_tags((string) ($notice['content'] ?? ''))))) {
            return null;
        }

        return [
            'title' => (string) ($notice['title'] ?? ''),
            'content' => (string) $notice['content'],
            'version' => (string) ($notice['version'] ?? '0'),
        ];
    }
}

if (!function_exists('serviceOn')) {
    
    function serviceOn($config, string $feature): bool
    {
        $enabled = is_object($config)
            ? $config->enable_services ?? false
            : ($config['enable_services'] ?? false);
        $value = is_object($config)
            ? $config->{$feature} ?? false
            : ($config[$feature] ?? false);

        return (bool) $enabled && (bool) $value;
    }
}
