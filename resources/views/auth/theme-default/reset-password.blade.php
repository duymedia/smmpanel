<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - {{ $siteTitle }}</title>
    <link rel="manifest" href="{{ route('manifest') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{ !empty($config?->favicon) ? asset('assets/media/' . basename($config->favicon)) : asset('assets/media/favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/css/style.bundle.css') }}" rel="stylesheet">
    <style>
        .auth-hero-logo { width: min(220px, 70%); height: auto; max-height: 64px; object-fit: contain; }
    </style>
</head>
<body id="kt_body" class="app-blank" data-theme="light">
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 order-2 order-lg-1">
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <div class="w-lg-500px p-10">
                    <form method="POST" action="{{ route('password.update') }}" class="form w-100">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="text-center mb-11">
                            <h1 class="text-dark fw-bolder mb-3" data-lang="Reset Password">Đặt lại mật khẩu</h1>
                            <div class="text-gray-500 fw-semibold fs-6" data-lang="Enter your new password">Nhập mật khẩu mới cho tài khoản của bạn.</div>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="email" name="email" value="{{ old('email', $email) }}" class="form-control"
                                placeholder="Email" data-lang="Email" required autofocus>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="password" name="password" class="form-control" placeholder="Mật khẩu mới"
                                data-lang="New password" required>
                        </div>
                        <div class="fv-row mb-8">
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Nhập lại mật khẩu" data-lang="Repeat password" required>
                        </div>
                        <div class="d-grid mb-10"><button type="submit" class="btn btn-primary"
                                data-lang="Reset Password">Đặt lại mật khẩu</button></div>
                        <div class="text-center"><a href="{{ route('login') }}" class="link-primary"
                                data-lang="Back to Sign In">Quay lại đăng nhập</a></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url('{{ asset('images/misc/auth-bg.png') }}');">
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                <a href="/" class="mb-0 mb-lg-12"><img src="{{ !empty($config?->logo) ? asset('assets/media/' . basename($config->logo)) : asset('assets/media/logo.png') }}" class="auth-hero-logo" alt="{{ $config?->title ?? config('app.name') }}"></a>
                <img class="d-none d-lg-block mx-auto auth-hero-logo mb-10 mb-lg-20 cmz-background1 background1" src="{{ asset('assets/media/logo.png') }}" alt="">
                <h1 class="block-signin__title d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">{{ $config?->title ?? config('app.name') }}</h1>
                <div class="block-signin__description d-none d-lg-block text-white fs-base text-center" style="max-width:550px">{{ $config?->description ?? '' }}</div>
            </div>
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
<script src="{{ asset('assets/client/auth.js') }}?v=16.9"></script>
</body>
</html>

