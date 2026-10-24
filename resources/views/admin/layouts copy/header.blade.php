<html lang="{{ (Auth::user()?->lang ?? 'vi') === 'en' ? 'en' : 'vi' }}" data-bs-theme="light">

<head>
    <base href="{{ url('/') }}/">
    <title>@yield('title', 'Admin') | {{ config('app.name', 'Panel') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.jQuery) {
                jQuery.ajaxSetup({
                    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}
                });
            }
        });
    </script>
    <link rel="manifest" href="/manifest">
    <link rel="canonical" href="{{ url('/') }}">
    <link rel="shortcut icon" href="{{ asset('assets/media/favicon.ico') }}?v={{ config('app.version') }}">
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <!--end::Fonts-->
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('cdn.whoispanel.com/admin/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet"
        type="text/css">
    <link href="{{ asset('cdn.whoispanel.com/admin/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css">
    <!--end::Vendor Stylesheets-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('cdn.whoispanel.com/admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('cdn.whoispanel.com/admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css">
    <!--end::Global Stylesheets Bundle-->
    <link href="{{ asset('cdn.whoispanel.com/flags/css/flag-icons.min.css') }}?v={{ filemtime(public_path('cdn.whoispanel.com/flags/css/flag-icons.min.css')) }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('cdn.whoispanel.com/libs/font-awesome/6.7.2/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/style.css') }}?v={{ config('app.version') }}" rel="stylesheet" type="text/css">
    @stack('styles')
    <script>
        var TIME_ZONE = 25200;
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="header-extended header-fixed header-tablet-and-mobile-fixed" style="">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Main-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Page-->
        <div class="flex-row page d-flex flex-column-fluid">
            <!--begin::Wrapper-->
            <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                <!--begin::Header-->
                <div id="kt_header" class="header">
                    <!--begin::Header top-->
                    <div class="header-top d-flex align-items-stretch flex-grow-1">
                        <!--begin::Container-->
                        <div class="d-flex container-xxl align-items-stretch">
                            <!--begin::Brand-->
                            <div class="d-flex align-items-center align-items-lg-stretch me-5 flex-row-fluid">
                                <!--begin::Heaeder navs toggle-->
                                <button
                                    class="d-lg-none btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px ms-n3 me-2"
                                    id="kt_header_navs_toggle">
                                    <i class="ki-duotone ki-abstract-14 fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </button>
                                <!--end::Heaeder navs toggle-->
                                <!--begin::Logo-->
                                <a href="/admin/settings" class="d-flex align-items-center">
                                    @if($adminLogo)
                                    <img alt="" src="{{ $adminLogo }}" class="h-25px h-lg-30px">
                                    @endif
                                </a>
                                <!--end::Logo-->
                                <!--begin::Tabs wrapper-->
                                <div class="overflow-auto align-self-end" id="kt_brand_tabs">
                                    <!--begin::Header tabs wrapper-->
                                    <div class="mx-4 mb-5 overflow-auto header-tabs ms-lg-10 mb-lg-0"
                                        id="kt_header_tabs" data-kt-swapper="true" data-kt-swapper-mode="prepend"
                                        data-kt-swapper-parent="{default: '#kt_header_navs_wrapper', lg: '#kt_brand_tabs'}">
                                        <!--begin::Header tabs-->
                                        <ul class="nav flex-nowrap text-nowrap" role="tablist">
                                            <li class="nav-item" role="presentation"><a class="nav-link {{ request()->is('admin/orders*') || request()->is('admin/product_orders*') || request()->is('admin/refill_services*') || request()->is('admin/refill_products*') || request()->is('admin/cancel_services*') ? 'active' : '' }}"
                                                    data-bs-toggle="tab" href="#header_orders" aria-selected="{{ request()->is('admin/orders*') || request()->is('admin/product_orders*') ? 'true' : 'false' }}"
                                                    role="tab"><span data-lang="menu::Orders">Đơn hàng</span></a>
                                            </li>
                                            <li class="nav-item" role="presentation"><a class="nav-link"
                                                    data-bs-toggle="tab" href="#header_list" aria-selected="false"
                                                    tabindex="-1" role="tab"><span data-lang="menu::List">Quản
                                                        lý</span></a>
                                            </li>
                                            <li class="nav-item" role="presentation"><a class="nav-link"
                                                    data-bs-toggle="tab" href="#header_payments"
                                                    data-lang="menu::Payments" aria-selected="false" tabindex="-1"
                                                    role="tab">Thanh toán</a></li>
                                            <li class="nav-item" role="presentation"><a class="nav-link {{ request()->is('admin/messages*') || request()->is('admin/tickets*') || request()->is('admin/news*') || request()->is('admin/ticket_statistics_by_service*') || request()->is('admin/ticket-subjects*') ? 'active' : '' }}"
                                                    data-bs-toggle="tab" href="#header_support" aria-selected="{{ request()->is('admin/messages*') || request()->is('admin/tickets*') || request()->is('admin/ticket-subjects*') ? 'true' : 'false' }}"
                                                    tabindex="-1" role="tab"><span data-lang="menu::Support">Hỗ
                                                        trợ</span>@if(($pendingSupportCount ?? 0) > 0)<span
                                                        class="badge badge-circle badge-danger badge-sm ms-2">{{ number_format($pendingSupportCount) }}</span>@endif</a>
                                            </li>
                                            <li class="nav-item" role="presentation"><a class="nav-link {{ request()->is('admin/api') || request()->is('admin/api_v2') ? 'active' : '' }}"
                                                    data-bs-toggle="tab" href="#header_others" aria-selected="false"
                                                    tabindex="-1" role="tab"><span
                                                        data-lang="menu::Others">Khác</span></a></li>
                                        </ul>
                                        <!--begin::Header tabs-->
                                    </div>
                                    <!--end::Header tabs wrapper-->
                                </div>
                                <!--end::Tabs wrapper-->
                            </div>
                            <!--end::Brand-->
                            <!--begin::Topbar-->
                            <div class="d-flex align-items-center flex-row-auto">
                                <div class="d-flex align-items-center ms-1 pointer">
                                    <div class="btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px position-relative"
                                        data-bs-custom-class="tooltip-dark" data-bs-toggle="tooltip"
                                        data-bs-placement="top" aria-label="Trang web đang hoạt động bình thường"
                                        data-bs-original-title="Trang web đang hoạt động bình thường"
                                        data-kt-initialized="1">
                                        <i class="fa-solid fa-shield-heart text-success fs-1"></i>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center ms-1">
                                    <!--begin::Menu toggle-->
                                    <a href="#"
                                        class="btn btn-icon btn-color-white bg-hover-white bg-hover-opacity-10 w-35px h-35px h-md-40px w-md-40px"
                                        data-kt-menu-trigger="{default:'click', lg: 'hover'}"
                                        data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                        <i class="ki-duotone ki-night-day theme-light-show fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                            <span class="path6"></span>
                                            <span class="path7"></span>
                                            <span class="path8"></span>
                                            <span class="path9"></span>
                                            <span class="path10"></span>
                                        </i>
                                        <i class="ki-duotone ki-moon theme-dark-show fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </a>
                                    <!--begin::Menu toggle-->
                                    <!--begin::Menu-->
                                    <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold fs-base w-150px"
                                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                                        <!--begin::Menu item-->
                                        <div class="px-3 my-0 menu-item">
                                            <a href="#" class="px-3 py-2 menu-link active"
                                                data-kt-element="mode" data-kt-value="light">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-duotone ki-night-day fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                        <span class="path6"></span>
                                                        <span class="path7"></span>
                                                        <span class="path8"></span>
                                                        <span class="path9"></span>
                                                        <span class="path10"></span>
                                                    </i>
                                                </span>
                                                <span class="menu-title" data-lang="menu::Light">Sáng</span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="px-3 my-0 menu-item">
                                            <a href="#" class="px-3 py-2 menu-link" data-kt-element="mode"
                                                data-kt-value="dark">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-duotone ki-moon fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </span>
                                                <span class="menu-title" data-lang="menu::Dark">Tối</span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Theme mode-->
                                <!--begin::User-->
                                <div class="d-flex align-items-center ms-1" id="kt_header_user_menu_toggle">
                                    <!--begin::User info-->
                                    <div class="py-2 btn btn-flex align-items-center bg-hover-white bg-hover-opacity-10 ps-2 pe-2 me-n2"
                                        data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                                        data-kt-menu-placement="bottom-end">
                                        <!--begin::Name-->
                                        <div
                                            class="d-none d-md-flex flex-column align-items-end justify-content-center me-2 me-md-4">
                                            <span
                                                class="mb-1 text-white opacity-75 fs-8 fw-semibold lh-1">{{ auth()->user()->username ?? 'Admin' }}</span>
                                            <span class="text-white fs-8 fw-bold lh-1">Admin</span>
                                        </div>
                                        <!--end::Name-->
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-30px symbol-md-40px">
                                            <img src="https://cdn.whoispanel.com/admin/media/avatars/300-1.jpg"
                                                alt="">
                                        </div>
                                        <!--end::Symbol-->
                                    </div>
                                    <!--end::User info-->
                                    <!--begin::User account menu-->
                                    <div class="py-4 menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold fs-6 w-275px"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="px-3 menu-item">
                                            <div class="px-3 menu-content d-flex align-items-center">
                                                <!--begin::Avatar-->
                                                <div class="symbol symbol-50px me-5">
                                                    <img alt=""
                                                        src="https://cdn.whoispanel.com/admin/media/avatars/300-1.jpg">
                                                </div>
                                                <!--end::Avatar-->
                                                <!--begin::Username-->
                                                <div class="d-flex flex-column">
                                                    <div class="fw-bold d-flex align-items-center fs-5">{{ auth()->user()->username ?? 'Admin' }}
                                                        <span
                                                            class="px-2 py-1 badge badge-light-success fw-bold fs-8 ms-2">Admin</span>
                                                    </div>
                                                    <a href="#"
                                                        class="fw-semibold text-muted text-hover-primary fs-7">{{ auth()->user()->email ?? '' }}</a>
                                                </div>
                                                <!--end::Username-->
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu separator-->
                                        <div class="my-2 separator"></div>
                                        <!--end::Menu separator-->
                                        <!--end::Menu separator-->
                                        <div class="px-5 menu-item">
                                            <a href="javascript:;" class="px-5 menu-link">App version: <span
                                                    class="fw-bolder ms-2">{{ config('app.version') }}
                                                </span></a>
                                        </div>
                                        <div class="my-2 separator"></div>
                                        <!--begin::Menu item-->
                                        <div class="px-5 menu-item"
                                            data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                            data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                            <a href="#" class="px-5 menu-link">
                                                <span class="menu-title position-relative">
                                                    <span data-page="/settings" data-lang="">Ngôn ngữ</span>
                                                    <span class="px-3 py-2 rounded fs-8 bg-light position-absolute translate-middle-y top-50 end-0">
                                                        {{ $adminCurrentLangData['name'] }}
                                                        <img class="w-15px h-15px rounded-1 ms-2"
                                                            src="https://cdn.whoispanel.com/admin/media/flags/{{ $adminCurrentLangData['flag'] }}"
                                                            alt="">
                                                    </span>
                                                </span>
                                            </a>
                                            <!--begin::Menu sub-->
                                            <div class="py-4 menu-sub menu-sub-dropdown w-175px">
                                                @foreach($adminLangMap as $code => $lang)
                                                <!--begin::Menu item-->
                                                <div class="px-3 menu-item">
                                                    <a href="javascript:;"
                                                        onclick="localStorage.setItem('data-lang', '{{ $code }}'); app_admin.on.click.changeLanguage('{{ $code }}')"
                                                        class="px-5 menu-link d-flex {{ $adminCurrentLang === $code ? 'active' : '' }}">
                                                        <span class="symbol symbol-20px me-4">
                                                            <img class="rounded-1"
                                                                src="https://cdn.whoispanel.com/admin/media/flags/{{ $lang['flag'] }}"
                                                                alt="">
                                                        </span>
                                                        {{ $lang['name'] }}
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                @endforeach
                                            </div>
                                            <!--end::Menu sub-->
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="px-5 my-1 menu-item">
                                            <a href="/settings" class="px-5 menu-link" data-lang="menu::Settings">Cài
                                                đặt</a>
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="px-5 menu-item">
                                            <a href="/signout" class="px-5 menu-link" data-lang="menu::Sign Out">Đăng
                                                xuất</a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::User account menu-->
                                </div>
                                <!--end::User -->
                            </div>
                            <!--end::Topbar-->
                        </div>
                        <!--end::Container-->
                    </div>
                    <!--end::Header top-->
                    <!--begin::Header navs-->
                    @include('admin.layouts.nav')
                    <!--end::Header navs-->
                </div>
                <!--end::Header-->
                <!--begin::Toolbar-->
                @include('admin.layouts.toolbar')
                <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
                    @yield('content')
