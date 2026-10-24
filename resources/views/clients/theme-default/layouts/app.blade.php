<html lang="{{ auth()->user()?->lang ?? ($config->default_lang ?? 'en') }}"
    data-bs-theme="{{ request()->cookie('data-bs-theme', 'light') }}"
    data-bs-theme-mode="{{ request()->cookie('data-bs-theme', 'light') }}"
    data-theme="{{ request()->cookie('data-bs-theme', 'light') }}">
<script>
    (function() {
        var theme = localStorage.getItem('theme') || '{{ request()->cookie('data-bs-theme', 'light') }}';
        document.documentElement.setAttribute('data-bs-theme', theme);
        document.documentElement.setAttribute('data-bs-theme-mode', theme);
        document.documentElement.setAttribute('data-theme', theme);
        document.cookie = 'data-bs-theme=' + theme + ';path=/;max-age=2592000;SameSite=Lax';
    })();
</script>

<head>
    <title>@yield('title') | {{ $config->title ?? '' }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="manifest" href="{{ route('manifest') }}">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.jQuery) {
                jQuery.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
                });
            }
        });
    </script>

    <link rel="shortcut icon" href="{{ $config?->favicon ? asset('assets/media/' . basename($config->favicon)) : asset('assets/media/favicon.ico') }}">

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/custom/datatables/datatables.bundle.css') }}"
        rel="stylesheet">

    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/custom/jstree/jstree.bundle.css') }}" rel="stylesheet">

    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.css') }}" rel="stylesheet"
        type="text/css">
    {{-- plugins.bundle.css references a missing fonts/@fortawesome directory.
         Load the complete local Font Awesome build so fa-brands/fab icons render correctly. --}}
    <link href="{{ asset('cdn.whoispanel.com/libs/font-awesome/6.7.2/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
    <style>
        /* Child Panel uses the Line Awesome icons from the original dashboard markup. */
        @font-face {
            font-family: "Line Awesome Free";
            src: url("{{ asset('cdn.whoispanel.com/admin/plugins/global/fonts/line-awesome/la-solid-900.woff2') }}") format("woff2"),
                url("{{ asset('cdn.whoispanel.com/admin/plugins/global/fonts/line-awesome/la-solid-900.woff') }}") format("woff");
            font-weight: 900;
            font-style: normal;
            font-display: block;
        }

        .la,
        .las {
            font-family: "Line Awesome Free";
            font-weight: 900;
        }

        .la-shopping-cart::before { content: "\f07a"; }
        .la-universal-access::before { content: "\f29a"; }
        .la-credit-card::before { content: "\f09d"; }
        .la-rocket::before { content: "\f135"; }
        .la-arrow-right::before { content: "\f061"; }
    </style>
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/css/style.bundle.css') }}" rel="stylesheet">

    <!--end::Global Stylesheets Bundle-->
    <link href="{{ asset('cdn.whoispanel.com/flags/css/flag-icons.min.css') }}?v={{ config('app.version') }}"
        rel="stylesheet" type="text/css">
    <style>
        .fi-vn {
            background-image: url("{{ asset('cdn.whoispanel.com/flags/4x3/vn.svg') }}") !important;
        }

        .fi-vn.fis {
            background-image: url("{{ asset('cdn.whoispanel.com/flags/1x1/vn.svg') }}") !important;
        }

        .fi-us {
            background-image: url("{{ asset('cdn.whoispanel.com/flags/4x3/us.svg') }}") !important;
        }

        .fi-us.fis {
            background-image: url("{{ asset('cdn.whoispanel.com/flags/1x1/us.svg') }}") !important;
        }
    </style>

    <link href="{{ asset('assets/client/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/client/metronic.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/custom.css') }}" rel="stylesheet">
    <style>
        /* The local plugins bundle contains KeenIcons CSS but not its font files. */
        @font-face {
            font-family: "keenicons-outline";
            src: url("https://cdn.whoispanel.com/dashboard/5/plugins/global/fonts/keenicons/keenicons-outline.woff?fzo4bm") format("woff");
            font-weight: normal;
            font-style: normal;
            font-display: block;
        }

        @font-face {
            font-family: "keenicons-duotone";
            src: url("https://cdn.whoispanel.com/dashboard/5/plugins/global/fonts/keenicons/keenicons-duotone.woff?eut7fk") format("woff");
            font-weight: normal;
            font-style: normal;
            font-display: block;
        }

        @font-face {
            font-family: "keenicons-solid";
            src: url("https://cdn.whoispanel.com/dashboard/5/plugins/global/fonts/keenicons/keenicons-solid.woff") format("woff");
            font-weight: normal;
            font-style: normal;
            font-display: block;
        }

        .form-control:focus,
        .input-group-text:focus {
            box-shadow: none;
        }

        .fullscreen-loader-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.42);
            backdrop-filter: blur(3px);
            z-index: 9998;
            animation: fadeIn 0.3s ease-in-out;
        }

        .fullscreen-loader {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            animation: slideUp 0.5s ease-out;
        }

        .fullscreen-loader-overlay.d-none,
        .fullscreen-loader.d-none {
            display: none !important;
        }

        .fullscreen-loader-overlay.fade-out,
        .fullscreen-loader.fade-out {
            animation: fadeOut 0.3s ease-in-out forwards;
        }
    </style>

    @stack('styles')

    <script>
        var ROLE = @json((int) (auth()->user()?->role ?? 0)),
            CURRENCY_ID = @json((int) (($userCurrency ?? $currency ?? null)?->id ?? 1)),
            CURRENCY_ICON = @json(($userCurrency ?? $currency ?? null)?->symbol ?? '$'),
            CURRENCY_SYMBOL = @json(($userCurrency ?? $currency ?? null)?->code ?? 'USD'),
            CURRENCY_RATE = @json((float) (($userCurrency ?? $currency ?? null)?->exchange_rate ?? 1));
    </script>
    <script>
        var TIME_ZONE = @json((int) (auth()->user()?->timezone ?? $config?->timezone ?? 0)),
            USERNAME = @json(auth()->user()?->username ?? ''),
            NEWS = @json((int) (auth()->user()?->news ?? 0));
    </script>
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-enabled">
    {{-- <div id="pm-modal" class="pm-modal">
        <div class="pm-box">

            <!-- IMAGE -->
            <div class="pm-img">
                <img src="https://cdn.phototourl.com/free/2026-03-26-bad6f205-cae1-42b9-93a1-0dc612ec591f.png"
                    alt="promo">
                <span class="pm-close">×</span>
            </div>

            <!-- CONTENT -->
            <div class="pm-content">
                <h2>🔥 ƯU ĐÃI ĐẶC BIỆT</h2>

                <p class="pm-big">
                    Tặng ngay <span>+10%</span> khi nạp lần đầu
                </p>

                <p class="pm-desc">
                    Nạp lần đầu – nhận thưởng liền tay 🎁
                    Ưu đãi chỉ dành cho thành viên mới!
                </p>

                <div class="pm-note">
                    Sau khi nạp thành công, liên hệ Zalo để nhận khuyến mãi
                </div>

                <a href="/anonym?url=https%3A%2F%2Fzalo.me%2F0334713016" target="_blank" class="pm-btn">
                    💬 Liên hệ Zalo: 0334713016
                </a>
            </div>

        </div>
    </div> --}}

    <style>
        /* ===== PROMO MODAL (SCOPED) ===== */
        #pm-modal.pm-modal {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(4px);
            z-index: 9999;

            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;

            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
        }

        #pm-modal.pm-show {
            opacity: 1;
            pointer-events: auto;
        }

        #pm-modal .pm-box {
            max-width: 420px;
            width: 100%;
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transform: translateY(-20px) scale(0.95);
            transition: all 0.3s ease;
        }

        #pm-modal.pm-show .pm-box {
            transform: translateY(0) scale(1);
        }

        #pm-modal .pm-img {
            position: relative;
        }

        #pm-modal .pm-img img {
            width: 100%;
            display: block;
        }

        #pm-modal .pm-close {
            position: absolute;
            top: 10px;
            right: 12px;
            font-size: 22px;
            color: #fff;
            cursor: pointer;
            background: rgba(0, 0, 0, 0.4);
            padding: 2px 8px;
            border-radius: 50%;
        }

        #pm-modal .pm-content {
            padding: 20px;
            text-align: center;
        }

        #pm-modal h2 {
            color: #ff3b3b;
            margin-bottom: 8px;
        }

        #pm-modal .pm-big {
            font-size: 20px;
            font-weight: bold;
        }

        #pm-modal .pm-big span {
            color: #16a34a;
            font-size: 24px;
        }

        #pm-modal .pm-desc {
            font-size: 14px;
            color: #555;
            margin: 8px 0;
        }

        #pm-modal .pm-note {
            font-size: 13px;
            color: #777;
            margin-bottom: 15px;
        }

        #pm-modal .pm-btn {
            display: block;
            padding: 12px;
            background: linear-gradient(45deg, #0068ff, #00c6ff);
            color: #fff;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
            transition: 0.25s;
        }

        #pm-modal .pm-btn:hover {
            transform: scale(1.05);
        }
    </style>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("pm-modal");
            if (!modal) return;

            const closeBtn = modal.querySelector(".pm-close");

            const KEY = "pm_hide_until";
            const ONE_HOUR = 60 * 60 * 1000;

            const now = Date.now();
            const hideUntil = parseInt(localStorage.getItem(KEY)) || 0;

            const showModal = () => {
                modal.classList.add("pm-show");
            };

            const closeModal = () => {
                modal.classList.remove("pm-show");
                localStorage.setItem(KEY, now + ONE_HOUR);
            };

            if (now > hideUntil) {
                setTimeout(showModal, 400);
            }

            closeBtn?.addEventListener("click", closeModal);

            modal.addEventListener("click", (e) => {
                if (e.target === modal) closeModal();
            });
        });
    </script> <!--begin::Body--> --}}

    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="page d-flex flex-column flex-column-fluid">
            @include('clients.theme-default.layouts.header')

            @include('clients.theme-default.layouts.footer')

