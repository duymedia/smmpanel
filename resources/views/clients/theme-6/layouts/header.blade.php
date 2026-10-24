<html id="theme_23" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    {{-- Responsive --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO --}}
    <title>@yield('title', $settings['site_name'] ?? config('app.name'))</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <meta name="robots" content="index, follow">
    <meta name="google-site-verification" content="">
    <meta name="format-detection" content="telephone=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="New order">
    <meta property="og:description" content="">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('assets/images/og-image.jpg') }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">

    {{-- Verification --}}
    <meta name="yandex-verification" content="5a57644791f5286d">
    <meta name="norton-safeweb-site-verification"
        content="EY3B12U-4NHJIS3X0UPWC9GVRBZEGR4177Y-WG73M0P3YA6VWDWWN72NRPF5YPR4WHS7TSWNBFLO4HJTI2R-WQ9Z0XIKPV80FCU27-XPYENDOCJIYWX-SUP9-PXQIQ-5">
    <meta name="p:domain_verify" content="e4746f3e3aea8aa0a409338ce669125c">

    {{-- Favicon --}}
    <link rel="shortcut icon" type="image/ico" href="{{ asset('storage.perfectcdn.com/theme-6/images/pl5a8f7ixl24q4hi.ico') }}">
    <link rel="icon" type="image/png" sizes="192x192"
        href="{{ asset('storage.perfectcdn.com/theme-6/images/pl5a8f7ixl24q4hi.ico') }}">
    <link rel="icon" type="image/png" sizes="512x512"
        href="{{ asset('storage.perfectcdn.com/theme-6/images/pl5a8f7ixl24q4hi.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('storage.perfectcdn.com/theme-6/images/pl5a8f7ixl24q4hi.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('storage.perfectcdn.com/theme-6/images/pl5a8f7ixl24q4hi.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage.perfectcdn.com/theme-6/images/pl5a8f7ixl24q4hi.ico') }}">

    {{-- HTML5 Support --}}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    {{-- Preload JS (local) --}}
    <link href="{{ asset('storage.perfectcdn.com/theme-6/js/99gttjw1i1l6jmws.js') }}" rel="preload" as="script">
    <link href="{{ asset('storage.perfectcdn.com/theme-6/js/qoy6usyny80ul09k.js') }}" rel="preload" as="script">
    <link href="{{ asset('storage.perfectcdn.com/theme-6/js/ap5ifcinp3jk13sr.js') }}" rel="preload" as="script">
    <link href="{{ asset('storage.perfectcdn.com/theme-6/js/f7lw81wrmhzxhpb3.js') }}" rel="preload" as="script">

    {{-- Main CSS (local).  Both stylesheets use ../fonts relative URLs,
         using the local Theme 6 CSS font paths. --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('storage.perfectcdn.com/theme-6/css/ojd5wm8q8es3jjdb.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('storage.perfectcdn.com/theme-6/css/wsz57ycp89410z6e.css') }}">

    {{-- Local Open Sans files (including Vietnamese glyphs).  The bundled
         theme CSS points to the remote CDN; keep the local definitions last
         so the application does not depend on that CDN or its encoding. --}}
    <style>
        @font-face {
            font-family: "Open Sans";
            font-style: normal;
            font-weight: 300;
            font-display: swap;
            src: url("{{ asset('storage.perfectcdn.com/theme-6/fonts/mem5YaGs126MiZpBA-UN_r8-VeJoCqeDjg.ttf') }}") format("truetype");
        }

        @font-face {
            font-family: "Open Sans";
            font-style: normal;
            font-weight: 400;
            font-display: swap;
            src: url("{{ asset('storage.perfectcdn.com/theme-6/fonts/mem8YaGs126MiZpBA-U1UpcaXcl0Aw.ttf') }}") format("truetype");
        }

        @font-face {
            font-family: "Open Sans";
            font-style: normal;
            font-weight: 600;
            font-display: swap;
            src: url("{{ asset('storage.perfectcdn.com/theme-6/fonts/mem5YaGs126MiZpBA-UNirk-VeJoCqeDjg.ttf') }}") format("truetype");
        }

        @font-face {
            font-family: "Open Sans";
            font-style: normal;
            font-weight: 700;
            font-display: swap;
            src: url("{{ asset('storage.perfectcdn.com/theme-6/fonts/mem5YaGs126MiZpBA-UN7rg-VeJoCqeDjg.ttf') }}") format("truetype");
        }

        html, body, .body {
            font-family: "Open Sans", sans-serif;
            font-size: 14px;
            font-weight: 600;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }
        .component-navbar-nav-link, .component-sidebar__menu-item-link {
            font-family: "Open Sans", sans-serif;
            font-size: 14px;
            font-weight: 500;
        }
        .table, .form-control, button, input, select, textarea {
            font-family: "Open Sans", sans-serif;
            font-size: 14px;
        }

        html,
        body {
            min-height: 100%;
            font-size: 14px;
        }

        .table th, .table td, .nav-link, .component-navbar-nav-link, .component-sidebar__menu-item-link { font-size: 14px; }

        /* Font Awesome Brands is included in ojd5wm8q8es3jjdb.css and uses
           the local fa-brands-400 font declared by that stylesheet. */
        .fab, .fa-brands {
            font-family: "Font Awesome 5 Brands" !important;
            font-weight: 400;
            font-style: normal;
            display: inline-block;
        }
        .fa-facebook::before { content: "\f09a"; }
        .fa-facebook-f::before { content: "\f39e"; }
        .fa-facebook-square::before { content: "\f082"; }

        /* DaoSMM original private shell: sidebar is fixed; content starts after it. */
        .wrapper-sidebar-navbar {
            display: block !important;
            width: 100%;
            min-height: 100vh;
        }

        .wrapper-sidebar-navbar>#block_87 {
            display: block;
            width: 250px;
        }

        .wrapper-sidebar-navbar>#block_87 .sidebar-block__left {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100%;
        }

        .wrapper-sidebar-navbar>#block_87 .sidebar-block__top {
            position: fixed;
            top: 0;
            right: 0;
            left: 250px;
            width: auto;
            height: 64px;
        }

        .wrapper-sidebar-navbar .sidebar-block__top-logo {
            display: block;
            width: auto !important;
            max-width: 150px !important;
            max-height: 52px !important;
            object-fit: contain;
        }

        .wrapper-sidebar-navbar .component-sidebar__menu-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 92px;
            overflow: hidden;
        }

        .wrapper-sidebar-navbar>.wrapper-content {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            width: calc(100% - 250px) !important;
            min-width: 0;
            min-height: 100vh;
            margin-left: 250px;
            padding-top: 64px;
        }

        .wrapper-sidebar-navbar .wrapper-content__body,
        .wrapper-sidebar-navbar .wrapper-content__body>* {
            width: 100% !important;
            min-width: 0;
        }

        .wrapper-sidebar-navbar .wrapper-content__body>[id^="block_"] {
            display: flex;
            width: 100% !important;
            min-width: 0;
        }

        .wrapper-sidebar-navbar .wrapper-content__body>[id^="block_"]>.container,
        .wrapper-sidebar-navbar .wrapper-content__body>[id^="block_"]>.container-fluid {
            flex: 1 1 auto;
            width: 100% !important;
            max-width: none !important;
            min-width: 0;
        }

        .wrapper-sidebar-navbar .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .wrapper-sidebar-navbar .table {
            width: 100%;
        }

        @media (max-width: 991px) {
            .wrapper-sidebar-navbar>#block_87 .sidebar-block__left {
                display: none;
            }

            .wrapper-sidebar-navbar>#block_87 .sidebar-block__top {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                width: 100%;
                height: 64px;
                z-index: 1030;
            }

            .wrapper-sidebar-navbar>.wrapper-content {
                width: 100% !important;
                margin-left: 0;
                padding-top: 76px !important;
            }

            .wrapper-sidebar-navbar>.wrapper-content>.wrapper-content__body {
                padding-top: 0 !important;
                margin-top: 0 !important;
            }

            .wrapper-sidebar-navbar>.wrapper-content>.wrapper-content__body>[id^="block_"] {
                margin-top: 0 !important;
            }

            .wrapper-sidebar-navbar>#block_87 {
                width: 100%;
            }

            .wrapper-sidebar-navbar .table {
                min-width: 0;
            }

            .wrapper-sidebar-navbar .sidebar-block__top-brand img {
                max-width: 120px !important;
                max-height: 44px !important;
            }

            .wrapper-sidebar-navbar .navbar-private__header {
                min-height: 64px;
            }

            /* Mobile private menu: keep the dropdown below the header instead
               of letting Bootstrap's collapse flow over the balance and page. */
            .wrapper-sidebar-navbar>#block_87 .sidebar-block__top {
                position: relative;
                height: auto;
                min-height: 64px;
                overflow: visible;
                background: #fff;
            }

            .wrapper-sidebar-navbar>.wrapper-content {
                padding-top: 0 !important;
            }

            .wrapper-sidebar-navbar>#block_87 .sidebar-block__top > div,
            .wrapper-sidebar-navbar>#block_87 .sidebar-block__top .navbar {
                width: 100%;
            }

            .wrapper-sidebar-navbar>#block_87 .navbar-private__header {
                height: 64px;
                padding: 0 16px;
                background: #fff;
            }

            .wrapper-sidebar-navbar>#block_87 .navbar-collapse {
                position: relative;
                top: auto;
                left: 0;
                right: 0;
                z-index: 1040;
                max-height: calc(100vh - 64px);
                overflow-y: auto;
                padding: 0 14px 12px;
                background: #fff;
                border-top: 1px solid #eee;
                box-shadow: none;
            }

            .wrapper-sidebar-navbar>#block_87 .navbar-collapse:not(.show) {
                display: none !important;
            }

            .wrapper-sidebar-navbar>#block_87 .component-navbar-collapse {
                display: flex !important;
                flex-direction: column;
                padding: 0;
            }

            .wrapper-sidebar-navbar>#block_87 .navbar-nav-sidebar-menu {
                order: 2;
            }

            .wrapper-sidebar-navbar>#block_87 .navbar-nav-currencies {
                order: 1;
            }

            .wrapper-sidebar-navbar>#block_87 .component-navbar-collapse > .navbar-nav:not(.navbar-nav-sidebar-menu):not(.navbar-nav-currencies) {
                order: 3;
            }

            .wrapper-sidebar-navbar>#block_87 .navbar-nav {
                display: block;
                width: 100%;
                margin: 0;
            }

            .wrapper-sidebar-navbar>#block_87 .navbar-nav-currencies {
                padding-top: 8px;
            }

            .wrapper-sidebar-navbar>#block_87 .component-navbar-nav-item,
            .wrapper-sidebar-navbar>#block_87 .component-navbar-nav-link {
                width: 100%;
            }

            .wrapper-sidebar-navbar>#block_87 .component-navbar-nav-link {
                display: block;
                padding: 7px 14px;
                color: #26345c;
                line-height: 1.45;
            }

            .wrapper-sidebar-navbar>#block_87 .component-navbar-nav-link-active__navbar-private {
                color: #725ed0;
                background: transparent;
            }

            .wrapper-sidebar-navbar>#block_87 .balance-dropdown-container {
                width: 100%;
                margin: 0 0 2px;
            }

            .wrapper-sidebar-navbar>#block_87 .balance-dropdown,
            .wrapper-sidebar-navbar>#block_87 .balance-dropdown__name {
                width: 100%;
            }

            .wrapper-sidebar-navbar>#block_87 .balance-dropdown__name {
                padding: 7px 14px;
                border-radius: 8px;
                background: #7561d0;
                color: #fff;
            }

            .wrapper-sidebar-navbar>#block_87 .balance-dropdown__container {
                position: static;
                width: 100%;
            }

            .wrapper-sidebar-navbar>#block_87 .navbar-toggler {
                display: block;
                margin-left: auto;
            }

            .wrapper-sidebar-navbar>#block_87 .sidebar-block__top-brand img {
                display: none;
            }

            .wrapper-sidebar-navbar>#block_87 .sidebar-block__top-brand a::after {
                content: "DAOSMM.COM";
                color: #7561d0;
                font-size: 24px;
                font-weight: 700;
                letter-spacing: 1.5px;
            }
        }
    </style>

  

    {{-- Google Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-817DDLKBXX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-817DDLKBXX');
    </script>

    {{-- Google Tag Manager --}}
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KQRQ8BJ4');
    </script>

    {{-- SF Badge --}}
    <script async src="https://b.sf-syn.com/badge_js?sf_id=3930786&variant_id=tbs"></script>
    <script async src="https://b.sf-syn.com/badge_js?sf_id=3930786&variant_id=sd"></script>
    <script async src="https://b.sf-syn.com/badge_js?sf_id=3930786&variant_id=sf"></script>

    {{-- Global Modules --}}
    <script>
        window.modules = {};
    </script>

</head>

<body class="body  body-internal">
    <div class="wrapper  wrapper-sidebar-navbar ">
        <div id="block_87" class="component_private_navbar">
            <span class="component_private_navbar ">
                <div class="component-navbar-private__wrapper component_private_sidebar ">
                    <div
                        class="sidebar-block__top component-navbar component-navbar__navbar-private editor__component-wrapper ">
                        <div>
                            <nav class="navbar navbar-expand-lg navbar-light">
                                <div class="navbar-private__header">
                                    <div class="sidebar-block__top-brand">
                                        <a href="/" class="component-navbar-brand component-navbar-public-brand">
                                            <img src="{{ !empty($config->logo_square ?? $config->logo) ? asset('assets/media/' . basename($config->logo_square ?? $config->logo)) : asset('assets/media/logo.png') }}" class="sidebar-block__top-logo" alt="{{ $settings['site_name'] ?? config('app.name') }}">
                                        </a>
                                    </div>
                                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                                        data-target="#navbar-collapse-87" aria-controls="navbar-collapse-87"
                                        aria-expanded="false" aria-label="Toggle navigation">
                                        <span class="navbar-burger">
                                            <span class="navbar-burger-line"></span>
                                        </span>
                                    </button>
                                </div>
                                <div class="collapse navbar-collapse" id="navbar-collapse-87">
                                    <div class="component-navbar-collapse-divider"></div>
                                    <div class="d-flex component-navbar-collapse">
                                        <ul class="navbar-nav navbar-nav-sidebar-menu">
                                            @auth
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private {{ request()->routeIs('clients.new', 'clients.dashboard') ? 'component-navbar-nav-link-active__navbar-private' : '' }}"
                                                    href="/new" data-lang="menu::New order">{{ __('menu.New order') }}</a>
                                            </li>
                                            @endauth
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private "
                                                    href="/services" data-lang="menu::Services">{{ __('menu.Services') }}</a>
                                            </li>
                                            @auth
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private "
                                                    href="/orders" data-lang="menu::Service orders">{{ __('menu.Service orders') }}</a>
                                            </li>
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private "
                                                    href="/addfunds" data-lang="menu::Add funds">{{ __('menu.Add funds') }}</a>
                                            </li>
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private "
                                                    href="/orders/refunds" data-lang="menu::Refill">{{ __('menu.Refill') }}</a>
                                            </li>
                                            @endauth
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private "
                                                    href="/apidoc" data-lang="menu::API">{{ __('menu.API') }}</a>
                                            </li>
                                            @auth
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private "
                                                    href="/affiliates" data-lang="menu::Affiliate">{{ __('menu.Affiliate') }}</a>
                                            </li>
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private "
                                                    href="/childpanel" data-lang="menu::Child Panel">{{ __('menu.Child Panel') }}</a>
                                            </li>
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private "
                                                    href="/tickets">
                                                    <span data-lang="menu::Support">{{ __('menu.Support') }}</span>
                                                    @if (($pendingTicketsCount ?? 0) > 0)
                                                    <span
                                                        class="badge badge-warning">{{ $pendingTicketsCount }}</span>
                                                    @endif
                                                </a>
                                            </li>
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private "
                                                    href="/mass" data-lang="menu::Mass order">{{ __('menu.Mass order') }}</a>
                                            </li>
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private "
                                                    href="/updates" data-lang="menu::Updates">{{ __('menu.Updates') }}</a>
                                            </li>
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link  component-navbar-nav-link__navbar-private "
                                                    href="/earn-money" data-lang="menu::Affiliate">{{ __('menu.Affiliate') }}</a>
                                            </li>
                                            @endauth
                                        </ul>
                                        @auth
                                        <ul class="navbar-nav navbar-nav-currencies">
                                            <div class="balance-dropdown-container component_balance_dropdown">
                                                <div class="balance-dropdown">
                                                    <div class="balance-dropdown__name balance-dropdown__toggle"
                                                        data-toggle="dropdown" data-hover="dropdown"
                                                        aria-expanded="false" id="balance-display">
                                                        {{ $formattedBalance ?? '0.00' }}
                                                    </div>
                                                    <ul class="balance-dropdown__container dropdown-menu"
                                                        id="currencies-list">
                                                        @foreach ($currencies ?? [] as $currency)
                                                        <li class="balance-dropdown__item">
                                                            <a href="#"
                                                                class="balance-dropdown__link currencies-item {{ isset($userCurrency) && $userCurrency->code == $currency->code ? 'active' : '' }}"
                                                                data-currency-code="{{ $currency->code }}"
                                                                data-currency-symbol="{{ $currency->symbol }}"
                                                                data-currency-name="{{ $currency->name }}"
                                                                data-symbol-position="{{ $currency->symbol_position }}"
                                                                data-exchange-rate="{{ $currency->exchange_rate }}">
                                                                {{ $currency->code }} {{ $currency->symbol }}
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </ul>
                                        <ul class="navbar-nav">
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link component-navbar-nav-link__navbar-private {{ request()->routeIs('clients.account.index') ? 'component-navbar-nav-link-active__navbar-private' : '' }}"
                                                    href="{{ route('clients.account.index') }}"
                                                    data-lang="menu::Account">{{ __('menu.Account') }}</a>
                                            </li>
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link component-navbar-nav-link__navbar-private"
                                                    href="{{ route('logout') }}"
                                                    data-lang="menu::Sign out">{{ __('menu.Sign out') }}</a>
                                            </li>
                                        </ul>
                                        @else
                                        <ul class="navbar-nav">
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link component-navbar-nav-link__navbar-private"
                                                    href="{{ route('login') }}"
                                                    data-lang="menu::Sign in">{{ __('menu.Sign in') }}</a>
                                            </li>
                                            <li
                                                class="nav-item component-navbar-nav-item component-navbar-private-nav-item">
                                                <a class="component-navbar-nav-link component-navbar-nav-link__navbar-private"
                                                    href="{{ route('signup') }}"
                                                    data-lang="menu::Sign up">{{ __('menu.Sign up') }}</a>
                                            </li>
                                        </ul>
                                        @endauth
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </span>
            <span class="component_private_sidebar ">
                <div class="component-sidebar_wrapper">
                    <div
                        class="sidebar-block__left component-sidebar component-sidebar-with-navbar component_private_navbar editor__component-wrapper">
                        <div class="component-sidebar__menu">
                            <div class="component-sidebar__menu-logo">
                                <a href="{{ url('/') }}" class="component-navbar-brand component-sidebar__menu-brand">
                                    <img src="{{ ($logoFile = basename((string) ($config->logo_square ?? $config->logo ?? ''))) !== '' ? asset('assets/media/' . $logoFile) : asset('assets/media/logo.png') }}" class="sidebar-block__top-logo" alt="{{ $settings['site_name'] ?? config('app.name') }}">
                                </a>
                            </div>
                            <ul class="sidebar-block__left-menu editor__component-wrapper">
                                @auth
                                <li class="component-sidebar__menu-item {{ request()->routeIs('clients.new', 'clients.dashboard') ? 'component-sidebar__menu-item-active' : '' }}">
                                    <a class="component-sidebar__menu-item-link" href="/new" data-lang="menu::New order">{{ __('menu.New order') }}</a>
                                </li>
                                @endauth
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="/services" data-lang="menu::Services">{{ __('menu.Services') }}</a>
                                </li>
                                @auth
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="/orders" data-lang="menu::Service orders">{{ __('menu.Service orders') }}</a>
                                </li>
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="/addfunds" data-lang="menu::Add funds">{{ __('menu.Add funds') }}</a>
                                </li>
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="/orders/refunds" data-lang="menu::Refill">{{ __('menu.Refill') }}</a>
                                </li>
                                @endauth
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="/apidoc" data-lang="menu::API">{{ __('menu.API') }}</a>
                                </li>
                                @auth
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="/affiliates" data-lang="menu::Affiliate">{{ __('menu.Affiliate') }}</a>
                                </li>
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="/childpanel" data-lang="menu::Child Panel">{{ __('menu.Child Panel') }}</a>
                                </li>
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="/tickets">
                                        <span data-lang="menu::Support">{{ __('menu.Support') }}</span>
                                        @if (($pendingTicketsCount ?? 0) > 0)
                                        <span class="badge badge-warning">{{ $pendingTicketsCount }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="/mass" data-lang="menu::Mass order">{{ __('menu.Mass order') }}</a>
                                </li>
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="/updates" data-lang="menu::Updates">{{ __('menu.Updates') }}</a>
                                </li>
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="/earn-money" data-lang="menu::Affiliate">{{ __('menu.Affiliate') }}</a>
                                </li>
                                @else
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="{{ route('login') }}" data-lang="menu::Sign in">{{ __('menu.Sign in') }}</a>
                                </li>
                                <li class="component-sidebar__menu-item">
                                    <a class="component-sidebar__menu-item-link" href="{{ route('signup') }}" data-lang="menu::Sign up">{{ __('menu.Sign up') }}</a>
                                </li>
                                @endauth
                            </ul>
                        </div>
                    </div>
                </div>
            </span>
        </div>
        <div class="wrapper-content">
            <div class="wrapper-content__header">
            </div>
            <div class="wrapper-content__body">



