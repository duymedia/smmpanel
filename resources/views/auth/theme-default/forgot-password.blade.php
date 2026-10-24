<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - {{ $siteTitle }}</title>
    <link rel="manifest" href="{{ route('manifest') }}">
    <link rel="canonical" href="{{ route('login') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Forgot Password - {{ $siteTitle }}">
    <meta property="og:image" content="{{ !empty($config?->logo_facebook) ? asset('assets/media/' . basename($config->logo_facebook)) : asset('assets/media/logo.png') }}">
    <meta property="og:image:alt" content="{{ $config?->title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $siteDescription }}">
    <meta name="keywords" content="{{ $siteKeywords }}">
    <meta name="description" content="{{ $siteDescription }}">
    <link rel="shortcut icon" href="{{ !empty($config?->favicon) ? asset('assets/media/' . basename($config->favicon)) : asset('assets/media/favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/css/style.bundle.css') }}" rel="stylesheet">
    <style>
        .auth-hero-logo {
            width: min(220px, 70%);
            height: auto;
            max-height: 64px;
            object-fit: contain;
        }
    </style>
</head>

<body id="kt_body" class="app-blank" data-theme="light">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">

            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 order-2 order-lg-1">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">

                        <form class="form w-100" id="forgot-password-form" action="{{ route('password.email') }}"
                            method="post" onsubmit="return false;">
                            @csrf
                            <div class="text-center mb-10">
                                <h1 class="text-dark fw-bolder mb-3" data-lang="Forgot Password">Khôi phục mật khẩu</h1>
                                <div class="text-gray-500 fw-semibold fs-6"
                                    data-lang="Enter your email to reset your password">Nhập email của bạn để khôi phục mật khẩu</div>
                            </div>
                            <div class="alert alert-primary fw-bold" style="display: none;"
                                data-lang="Check your email inbox to get new password">Kiểm tra hộp thư đến để nhận mật khẩu mới</div>
                            <div class="fv-row mb-8">
                                <div class="mb-3">

                                    <input type="email" id="ipt-email" name="email" class="form-control"
                                        placeholder="Email" data-lang="Email" autocomplete="email" autofocus>

                                </div>
                            </div>
                            <div class="d-flex justify-content-center mb-5">
                            </div>
                            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                <button type="button" id="btn-reset-password" class="btn btn-primary" name="Submit"
                                    data-lang="Submit">Gửi</button>
                                <a href="{{ route('login') }}" class="btn btn-light ms-4"
                                    data-lang="Back to Sign In">Quay lại đăng nhập</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url('{{ asset('images/misc/auth-bg.png') }}')">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <!--begin::Logo-->
                    <a href="/" class="mb-0 mb-lg-12">
                        <img alt="Logo" src="{{ !empty($config?->logo) ? $config->logo : asset('assets/media/logo.png') }}" class="h-60px h-lg-75px">
                    </a>
                    <!--end::Logo-->
                    <!--begin::Image-->
                    <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="{{ asset('cdn.whoispanel.com/1/media/misc/auth-screens.png') }}" alt="">
                    <!--end::Image-->
                    <!--begin::Title-->
                    <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">{{ $config?->title ?? '' }}</h1>
                    <!--end::Title-->
                    <!--begin::Text-->
                    <div class="d-none d-lg-block text-white fs-base text-center" style="max-width: 550px;">{{ $config?->description ?? '' }}</div>
                    <!--end::Text-->
                </div>
                <!--end::Content-->
            </div>

        </div>
    </div>
    <script src="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('cdn.whoispanel.com/dashboard/5/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('cdn.whoispanel.com/libs/jquery.blockUI/2.70/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('assets/client/language.js') }}?v={{ filemtime(public_path('assets/client/language.js')) }}"></script>
    <script>
        (function () {
            var language = window.LANGUAGE;
            if (!language) return;

            var segments = window.location.pathname.split('/');
            var page = '/' + (segments[1] || '');

            document.querySelectorAll('[data-lang]').forEach(function (element) {
                var key = element.getAttribute('data-lang') || element.textContent.trim();
                var elementPage = element.getAttribute('data-page') || page;
                var group = key.indexOf('::') >= 0 ? key.split('::')[0] : elementPage;
                var localized = language.language?.[group]?.[key]
                    || language.core?.[group]?.[key];

                if (!localized) return;

                if (element.matches('input, textarea')) {
                    if (element.hasAttribute('placeholder')) {
                        element.setAttribute('placeholder', localized);
                    } else if (element.hasAttribute('value')) {
                        element.value = localized;
                    }
                } else {
                    element.innerHTML = localized;
                }
            });
        })();
    </script>
    <script src="{{ asset('assets/app.js') }}?v=16.8"></script>
    <script src="{{ asset('assets/client/auth.js') }}?v=16.20"></script>
</body>

</html>
