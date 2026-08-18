<?php

use App\Models\Currency;


if (!function_exists('convertToUSD')) {
    /**
     * Quy đổi tiền tệ về USD
     */
    function convertToUSD($amount, $from = 'USD')
    {
        if (strtoupper($from) === 'USD') {
            return round($amount, 2);
        }

        $from = strtoupper($from);
        $url = "https://api.exchangerate.host/convert?from={$from}&to=USD&amount={$amount}";
        $response = @file_get_contents($url);

        if ($response === false) {
            return 0;
        }

        $data = json_decode($response, true);
        return isset($data['result']) ? round((float)$data['result'], 2) : 0;
    }
}

if (!function_exists('roundExchangeRate')) {
    /**
     * Làm tròn tỷ giá hối đoái thông minh
     */
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
    /**
     * Lấy tỷ giá từ ExchangeRate-API
     */
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
    /**
     * Lấy dữ liệu tiền tệ (symbols và names)
     */
    function getCurrencyData()
    {
        return [
            'symbols' => [
                'AED' => 'د.إ',
                'AFN' => '؋',
                'ALL' => 'L',
                'AMD' => '֏',
                'ANG' => 'ƒ',
                'AOA' => 'Kz',
                'ARS' => '$',
                'AUD' => 'A$',
                'AWG' => 'ƒ',
                'AZN' => '₼',
                'BAM' => 'КМ',
                'BBD' => '$',
                'BDT' => '৳',
                'BGN' => 'лв',
                'BHD' => '.د.ب',
                'BIF' => 'FBu',
                'BMD' => '$',
                'BND' => '$',
                'BOB' => '$b',
                'BRL' => 'R$',
                'BSD' => '$',
                'BTN' => 'Nu.',
                'BWP' => 'P',
                'BYN' => 'Br',
                'BZD' => 'BZ$',
                'CAD' => 'C$',
                'CDF' => 'FC',
                'CHF' => 'CHF',
                'CLP' => '$',
                'CNY' => '¥',
                'COP' => '$',
                'CRC' => '₡',
                'CUP' => '₱',
                'CVE' => '$',
                'CZK' => 'Kč',
                'DJF' => 'Fdj',
                'DKK' => 'kr',
                'DOP' => 'RD$',
                'DZD' => 'دج',
                'EGP' => '£',
                'ERN' => 'Nfk',
                'ETB' => 'Br',
                'EUR' => '€',
                'FJD' => '$',
                'FKP' => '£',
                'GBP' => '£',
                'GEL' => '₾',
                'GGP' => '£',
                'GHS' => '¢',
                'GIP' => '£',
                'GMD' => 'D',
                'GNF' => 'FG',
                'GTQ' => 'Q',
                'GYD' => '$',
                'HKD' => 'HK$',
                'HNL' => 'L',
                'HRK' => 'kn',
                'HTG' => 'G',
                'HUF' => 'Ft',
                'IDR' => 'Rp',
                'ILS' => '₪',
                'IMP' => '£',
                'INR' => '₹',
                'IQD' => 'ع.د',
                'IRR' => '﷼',
                'ISK' => 'kr',
                'JEP' => '£',
                'JMD' => 'J$',
                'JOD' => 'JD',
                'JPY' => '¥',
                'KES' => 'KSh',
                'KGS' => 'лв',
                'KHR' => '៛',
                'KMF' => 'CF',
                'KPW' => '₩',
                'KRW' => '₩',
                'KWD' => 'KD',
                'KYD' => '$',
                'KZT' => '₸',
                'LAK' => '₭',
                'LBP' => '£',
                'LKR' => '₨',
                'LRD' => '$',
                'LSL' => 'M',
                'LYD' => 'LD',
                'MAD' => 'MAD',
                'MDL' => 'lei',
                'MGA' => 'Ar',
                'MKD' => 'ден',
                'MMK' => 'K',
                'MNT' => '₮',
                'MOP' => 'MOP$',
                'MRU' => 'UM',
                'MUR' => '₨',
                'MVR' => 'Rf',
                'MWK' => 'MK',
                'MXN' => '$',
                'MYR' => 'RM',
                'MZN' => 'MT',
                'NAD' => '$',
                'NGN' => '₦',
                'NIO' => 'C$',
                'NOK' => 'kr',
                'NPR' => '₨',
                'NZD' => 'NZ$',
                'OMR' => '﷼',
                'PAB' => 'B/.',
                'PEN' => 'S/.',
                'PGK' => 'K',
                'PHP' => '₱',
                'PKR' => '₨',
                'PLN' => 'zł',
                'PYG' => 'Gs',
                'QAR' => '﷼',
                'RON' => 'lei',
                'RSD' => 'Дин.',
                'RUB' => '₽',
                'RWF' => 'R₣',
                'SAR' => '﷼',
                'SBD' => '$',
                'SCR' => '₨',
                'SDG' => 'ج.س.',
                'SEK' => 'kr',
                'SGD' => 'S$',
                'SHP' => '£',
                'SLE' => 'Le',
                'SLL' => 'Le',
                'SOS' => 'S',
                'SRD' => '$',
                'SSP' => '£',
                'STN' => 'Db',
                'SYP' => '£',
                'SZL' => 'E',
                'THB' => '฿',
                'TJS' => 'SM',
                'TMT' => 'T',
                'TND' => 'د.ت',
                'TOP' => 'T$',
                'TRY' => '₺',
                'TTD' => 'TT$',
                'TVD' => '$',
                'TWD' => 'NT$',
                'TZS' => 'TSh',
                'UAH' => '₴',
                'UGX' => 'USh',
                'USD' => '$',
                'UYU' => '$U',
                'UZS' => 'лв',
                'VED' => 'Bs',
                'VES' => 'Bs',
                'VND' => '₫',
                'VUV' => 'VT',
                'WST' => 'WS$',
                'XAF' => 'FCFA',
                'XCD' => '$',
                'XDR' => 'SDR',
                'XOF' => 'CFA',
                'XPF' => '₣',
                'YER' => '﷼',
                'ZAR' => 'R',
                'ZMW' => 'ZK',
                'ZWL' => 'Z$'
            ],
            'names' => [
                'AED' => 'United Arab Emirates Dirham',
                'AFN' => 'Afghan Afghani',
                'ALL' => 'Albanian Lek',
                'AMD' => 'Armenian Dram',
                'ANG' => 'Netherlands Antillean Guilder',
                'AOA' => 'Angolan Kwanza',
                'ARS' => 'Argentine Peso',
                'AUD' => 'Australian Dollar',
                'AWG' => 'Aruban Florin',
                'AZN' => 'Azerbaijani Manat',
                'BAM' => 'Bosnia-Herzegovina Convertible Mark',
                'BBD' => 'Barbadian Dollar',
                'BDT' => 'Bangladeshi Taka',
                'BGN' => 'Bulgarian Lev',
                'BHD' => 'Bahraini Dinar',
                'BIF' => 'Burundian Franc',
                'BMD' => 'Bermudan Dollar',
                'BND' => 'Brunei Dollar',
                'BOB' => 'Bolivian Boliviano',
                'BRL' => 'Brazilian Real',
                'BSD' => 'Bahamian Dollar',
                'BTN' => 'Bhutanese Ngultrum',
                'BWP' => 'Botswanan Pula',
                'BYN' => 'Belarusian Ruble',
                'BZD' => 'Belize Dollar',
                'CAD' => 'Canadian Dollar',
                'CDF' => 'Congolese Franc',
                'CHF' => 'Swiss Franc',
                'CLP' => 'Chilean Peso',
                'CNY' => 'Chinese Yuan',
                'COP' => 'Colombian Peso',
                'CRC' => 'Costa Rican Colón',
                'CUP' => 'Cuban Peso',
                'CVE' => 'Cape Verdean Escudo',
                'CZK' => 'Czech Republic Koruna',
                'DJF' => 'Djiboutian Franc',
                'DKK' => 'Danish Krone',
                'DOP' => 'Dominican Peso',
                'DZD' => 'Algerian Dinar',
                'EGP' => 'Egyptian Pound',
                'ERN' => 'Eritrean Nakfa',
                'ETB' => 'Ethiopian Birr',
                'EUR' => 'Euro',
                'FJD' => 'Fijian Dollar',
                'FKP' => 'Falkland Islands Pound',
                'GBP' => 'British Pound Sterling',
                'GEL' => 'Georgian Lari',
                'GGP' => 'Guernsey Pound',
                'GHS' => 'Ghanaian Cedi',
                'GIP' => 'Gibraltar Pound',
                'GMD' => 'Gambian Dalasi',
                'GNF' => 'Guinean Franc',
                'GTQ' => 'Guatemalan Quetzal',
                'GYD' => 'Guyanaese Dollar',
                'HKD' => 'Hong Kong Dollar',
                'HNL' => 'Honduran Lempira',
                'HRK' => 'Croatian Kuna',
                'HTG' => 'Haitian Gourde',
                'HUF' => 'Hungarian Forint',
                'IDR' => 'Indonesian Rupiah',
                'ILS' => 'Israeli New Sheqel',
                'IMP' => 'Manx pound',
                'INR' => 'Indian Rupee',
                'IQD' => 'Iraqi Dinar',
                'IRR' => 'Iranian Rial',
                'ISK' => 'Icelandic Króna',
                'JEP' => 'Jersey Pound',
                'JMD' => 'Jamaican Dollar',
                'JOD' => 'Jordanian Dinar',
                'JPY' => 'Japanese Yen',
                'KES' => 'Kenyan Shilling',
                'KGS' => 'Kyrgystani Som',
                'KHR' => 'Cambodian Riel',
                'KMF' => 'Comorian Franc',
                'KPW' => 'North Korean Won',
                'KRW' => 'South Korean Won',
                'KWD' => 'Kuwaiti Dinar',
                'KYD' => 'Cayman Islands Dollar',
                'KZT' => 'Kazakhstani Tenge',
                'LAK' => 'Laotian Kip',
                'LBP' => 'Lebanese Pound',
                'LKR' => 'Sri Lankan Rupee',
                'LRD' => 'Liberian Dollar',
                'LSL' => 'Lesotho Loti',
                'LYD' => 'Libyan Dinar',
                'MAD' => 'Moroccan Dirham',
                'MDL' => 'Moldovan Leu',
                'MGA' => 'Malagasy Ariary',
                'MKD' => 'Macedonian Denar',
                'MMK' => 'Myanma Kyat',
                'MNT' => 'Mongolian Tugrik',
                'MOP' => 'Macanese Pataca',
                'MRU' => 'Mauritanian Ouguiya',
                'MUR' => 'Mauritian Rupee',
                'MVR' => 'Maldivian Rufiyaa',
                'MWK' => 'Malawian Kwacha',
                'MXN' => 'Mexican Peso',
                'MYR' => 'Malaysian Ringgit',
                'MZN' => 'Mozambican Metical',
                'NAD' => 'Namibian Dollar',
                'NGN' => 'Nigerian Naira',
                'NIO' => 'Nicaraguan Córdoba',
                'NOK' => 'Norwegian Krone',
                'NPR' => 'Nepalese Rupee',
                'NZD' => 'New Zealand Dollar',
                'OMR' => 'Omani Rial',
                'PAB' => 'Panamanian Balboa',
                'PEN' => 'Peruvian Nuevo Sol',
                'PGK' => 'Papua New Guinean Kina',
                'PHP' => 'Philippine Peso',
                'PKR' => 'Pakistani Rupee',
                'PLN' => 'Polish Zloty',
                'PYG' => 'Paraguayan Guarani',
                'QAR' => 'Qatari Rial',
                'RON' => 'Romanian Leu',
                'RSD' => 'Serbian Dinar',
                'RUB' => 'Russian Ruble',
                'RWF' => 'Rwandan Franc',
                'SAR' => 'Saudi Riyal',
                'SBD' => 'Solomon Islands Dollar',
                'SCR' => 'Seychellois Rupee',
                'SDG' => 'Sudanese Pound',
                'SEK' => 'Swedish Krona',
                'SGD' => 'Singapore Dollar',
                'SHP' => 'Saint Helena Pound',
                'SLE' => 'Sierra Leonean Leone',
                'SLL' => 'Sierra Leonean Leone (Old)',
                'SOS' => 'Somali Shilling',
                'SRD' => 'Surinamese Dollar',
                'SSP' => 'South Sudanese Pound',
                'STN' => 'São Tomé and Príncipe Dobra',
                'SYP' => 'Syrian Pound',
                'SZL' => 'Swazi Lilangeni',
                'THB' => 'Thai Baht',
                'TJS' => 'Tajikistani Somoni',
                'TMT' => 'Turkmenistani Manat',
                'TND' => 'Tunisian Dinar',
                'TOP' => 'Tongan Paʻanga',
                'TRY' => 'Turkish Lira',
                'TTD' => 'Trinidad and Tobago Dollar',
                'TVD' => 'Tuvaluan Dollar',
                'TWD' => 'New Taiwan Dollar',
                'TZS' => 'Tanzanian Shilling',
                'UAH' => 'Ukrainian Hryvnia',
                'UGX' => 'Ugandan Shilling',
                'USD' => 'US Dollar',
                'UYU' => 'Uruguayan Peso',
                'UZS' => 'Uzbekistan Som',
                'VED' => 'Venezuelan Bolívar Digital',
                'VES' => 'Venezuelan Bolívar Soberano',
                'VND' => 'Vietnamese Dong',
                'VUV' => 'Vanuatu Vatu',
                'WST' => 'Samoan Tala',
                'XAF' => 'CFA Franc BEAC',
                'XCD' => 'East Caribbean Dollar',
                'XDR' => 'Special Drawing Rights',
                'XOF' => 'CFA Franc BCEAO',
                'XPF' => 'CFP Franc',
                'YER' => 'Yemeni Rial',
                'ZAR' => 'South African Rand',
                'ZMW' => 'Zambian Kwacha',
                'ZWL' => 'Zimbabwean Dollar'
            ]
        ];
    }
}

if (!function_exists('updateCurrencyRates')) {
    /**
     * Cập nhật tỷ giá hối đoái vào database
     */
    function updateCurrencyRates($syncOnly = false)
    {
        $apiData = fetchCurrencyRates('USD');

        if (!$apiData) {
            return [
                'success' => false,
                'message' => 'Không thể lấy dữ liệu từ API',
                'updated' => 0,
                'created' => 0
            ];
        }

        $updated = 0;
        $created = 0;
        $rates = $apiData['conversion_rates'];
        $currencyData = getCurrencyData();
        $symbols = $currencyData['symbols'];
        $names = $currencyData['names'];

        if ($syncOnly) {
            // Chỉ cập nhật tỷ giá cho currencies có status = 1
            $existingCurrencies = \App\Models\Currency::where('status', 1)->get();

            foreach ($existingCurrencies as $currency) {
                if (isset($rates[$currency->code])) {
                    $roundedRate = roundExchangeRate($rates[$currency->code]);
                    $currency->update(['exchange_rate' => $roundedRate]);
                    $updated++;
                }
            }
        } else {
            // Tạo mới hoặc cập nhật tất cả currencies từ API
            foreach ($rates as $currencyCode => $rate) {
                if (!isset($names[$currencyCode])) continue;

                $roundedRate = roundExchangeRate($rate);
                $currency = \App\Models\Currency::where('code', $currencyCode)->first();

                $currencyData = [
                    'code' => $currencyCode,
                    'symbol' => $symbols[$currencyCode] ?? $currencyCode,
                    'exchange_rate' => $roundedRate,
                    'name' => $names[$currencyCode],
                    'sync' => true,
                    'status' => 1,
                    'symbol_position' => in_array($currencyCode, ['CHF', 'SEK', 'NOK', 'RUB', 'VND', 'CZK', 'PLN']) ? 'after' : 'before',
                    'domain' => null
                ];

                if ($currency) {
                    $currency->update(['exchange_rate' => $roundedRate]);
                    $updated++;
                } else {
                    \App\Models\Currency::create($currencyData);
                    $created++;
                }
            }
        }

        $message = $syncOnly
            ? "Đã đồng bộ tỷ giá cho {$updated} loại tiền tệ"
            : "Đã cập nhật {$updated} và tạo mới {$created} loại tiền tệ";

        return [
            'success' => true,
            'message' => $message,
            'updated' => $updated,
            'created' => $created,
            'last_update' => $apiData['time_last_update']
        ];
    }
}

if (!function_exists('formatSeconds')) {
    /**
     * Format seconds into human-readable time format (e.g., "2h 25m 44s")
     */
    function formatSeconds($seconds)
    {
        if (!$seconds || $seconds <= 0) {
            return '0s';
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

if (!function_exists('getDomain')) {
    function getDomain()
    {
        return request()->getHost();
    }
}

if (!function_exists('formatUserCurrency')) {
    function formatUserCurrency($user, $currencies, $nonDecimalCodes = [])
    {
        $userCurrency = $currencies->firstWhere('code', $user->currency ?? 'USD')
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
            'balance' => formatCurrencyAmount($user->balance, $userCurrency, $nonDecimalCodes),
            'spent' => formatCurrencyAmount($user->spent, $userCurrency, $nonDecimalCodes),
        ];
    }
}

if (!function_exists('formatCurrencyAmount')) {
    function formatCurrencyAmount($amount, $currency, $nonDecimalCodes = [])
    {
        $converted = $amount * $currency->exchange_rate;
        $isNonDecimal = in_array($currency->code, $nonDecimalCodes);

        if ($converted == 0) {
            $formatted = $isNonDecimal ? '0' : '0.00';
        } else {
            $decimals = $isNonDecimal ? 0 : ($converted >= 1000 ? 0 : ($converted >= 100 ? 1 : 2));

            if ($currency->code === 'VND') {
                $formatted = number_format($converted, 0, ',', '.');
            } else {
                $formatted = rtrim(number_format($converted, $decimals), '0.') ?: ($isNonDecimal ? '0' : '0.00');
            }
        }

        return $currency->symbol_position === 'before'
            ? $currency->symbol . $formatted
            : $formatted . ' ' . $currency->symbol;
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

if (!function_exists('getOrderStatusText')) {
    function getOrderStatusText($status)
    {
        return match ($status) {
            'awaiting'    => __('orders.awaiting', [], null) ?: __('status.pending'),
            'pending'     => __('orders.pending'),
            'processing'  => __('orders.processing'),
            'in_progress' => __('orders.processing'),
            'inprogress'  => __('orders.processing'),
            'completed'   => __('orders.completed'),
            'partial'     => __('orders.partial'),
            'canceled'    => __('orders.canceled'),
            'cancelled'   => __('orders.canceled'),
            'failed'      => __('orders.failed', [], null) ?: __('addfunds.failed'),
            default       => ucfirst(str_replace('_', ' ', $status))
        };
    }
}

if (!function_exists('getOrderStatusClass')) {
    function getOrderStatusClass($status)
    {
        return match ($status) {
            'awaiting' => 'btn-outline-secondary btn-outline',
            'pending' => 'btn btn-secondary btn-sm',
            'processing' => 'btn-primary',
            'in_progress' => 'btn-info',
            'completed' => 'btn-success',
            'partial' => 'btn-danger',
            'canceled' => 'btn-warning',
            'failed' => 'btn-outline-warning btn-outline',
            default => 'btn-outline-dark btn-outline'
        };
    }
}

if (!function_exists('formatAmount')) {
    function formatAmount($amount)
    {
        if ($amount == 0) {
            return '0';
        }

        $amount = (float) $amount;
        $formatted = number_format($amount, 4, '.', '');
        $formatted = rtrim($formatted, '0');
        $formatted = rtrim($formatted, '.');

        return $formatted ?: '0';
    }
}

if (!function_exists('trans_menu')) {
    function trans_menu($key)
    {
        $lang = session('language', 'vi');
        $isVietnamese = $lang === 'vi';

        $translations = [
            'menu::Orders' => $isVietnamese ? 'Đơn hàng' : 'Orders',
            'menu::List' => $isVietnamese ? 'Quản lý' : 'Manage',
            'menu::Payments' => $isVietnamese ? 'Thanh toán' : 'Payments',
            'menu::Support' => $isVietnamese ? 'Hỗ trợ' : 'Support',
            'menu::Others' => $isVietnamese ? 'Khác' : 'Others',
            'menu::Services' => $isVietnamese ? 'Dịch vụ' : 'Services',
            'menu::Products' => $isVietnamese ? 'Sản phẩm' : 'Products',
            'menu::Refill services' => $isVietnamese ? 'Bảo hành dịch vụ' : 'Refill services',
            'menu::Refill products' => $isVietnamese ? 'Bảo hành sản phẩm' : 'Refill products',
            'menu::Cancel services' => $isVietnamese ? 'Hủy dịch vụ' : 'Cancel services',
            'menu::Accounts' => $isVietnamese ? 'Tài khoản' : 'Accounts',
            'menu::Categories' => $isVietnamese ? 'Danh mục dịch vụ' : 'Categories',
            'menu::Providers' => $isVietnamese ? 'Nhà cung cấp' : 'Providers',
            'menu::Sync Logs' => $isVietnamese ? 'Thông tin đồng bộ dịch vụ' : 'Sync Logs',
            'menu::Payment methods' => $isVietnamese ? 'Phương thức' : 'Methods',
            'menu::Payment history' => $isVietnamese ? 'Giao dịch' : 'History',
            'menu::Coupon List' => $isVietnamese ? 'Danh sách' : 'List',
            'menu::Coupon usage' => $isVietnamese ? 'Lịch sử' : 'Usage',
            'menu::Messages' => $isVietnamese ? 'Tin nhắn' : 'Messages',
            'menu::Tickets' => $isVietnamese ? 'Phiếu hỗ trợ' : 'Tickets',
            'menu::News' => $isVietnamese ? 'Thông báo' : 'News',
            'menu::Ticket Statistics by Service' => $isVietnamese ? 'Thống kê phiếu hỗ trợ theo dịch vụ' : 'Ticket Statistics by Service',
            'menu::Settings' => $isVietnamese ? 'Cài đặt' : 'Settings',
            'menu::Analytics' => $isVietnamese ? 'Phân tích' : 'Analytics',
            'menu::Reports' => $isVietnamese ? 'Thống kê' : 'Reports',
            'menu::Affiliates' => $isVietnamese ? 'Tiếp thị liên kết' : 'Affiliates',
            'menu::Backup' => $isVietnamese ? 'Sao lưu' : 'Backup',
            'menu::Warehouse' => $isVietnamese ? 'Kho sản phẩm' : 'Warehouse',
        ];

        return $translations[$key] ?? $key;
    }
}

if (!function_exists('langToFlag')) {
    function langToFlag(string $lang): string
    {
        $map = [
            'en' => 'us',
            'vi' => 'vn',
            'zh' => 'cn',
            'ja' => 'jp',
            'ko' => 'kr',
            'fr' => 'fr',
            'de' => 'de',
            'es' => 'es',
            'pt' => 'pt',
            'it' => 'it',
            'ru' => 'ru',
            'ar' => 'sa',
            'hi' => 'in',
            'th' => 'th',
            'id' => 'id',
            'ms' => 'my',
            'tr' => 'tr',
            'pl' => 'pl',
            'nl' => 'nl',
            'sv' => 'se',
            'da' => 'dk',
            'fi' => 'fi',
            'no' => 'no',
            'cs' => 'cz',
            'hu' => 'hu',
            'ro' => 'ro',
            'uk' => 'ua',
            'he' => 'il',
            'fa' => 'ir',
            'bn' => 'bd',
        ];
        return $map[$lang] ?? 'us';
    }
}
