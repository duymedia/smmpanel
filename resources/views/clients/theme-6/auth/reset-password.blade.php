<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - {{ $settings['title'] ?? config('app.name') }}</title>
    <link rel="manifest" href="{{ route('manifest') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="shortcut icon" href="{{ !empty($config?->favicon) ? asset('assets/media/' . basename($config->favicon)) : asset('assets/media/favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/css/style.bundle.css') }}" rel="stylesheet">
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
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image:url('https://cdn.whoispanel.com/1/media/misc/auth-bg.png')">
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                <a href="/" class="mb-0 mb-lg-12"><img src="{{ !empty($config?->logo) ? asset('assets/media/' . basename($config->logo)) : asset('assets/media/logo.png') }}" class="h-60px h-lg-75px" alt="Logo"></a>
                <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20 cmz-background1 background1" src="https://cdn.mypanel.link/6f7slz/jd7xmobnjdlu0eun.webp" alt="">
                <h1 class="block-signin__title d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">{{ $config?->title ?? config('app.name') }}</h1>
                <div class="block-signin__description d-none d-lg-block text-white fs-base text-center" style="max-width:550px">{{ $config?->description ?? '' }}</div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('cdn.whoispanel.com/dashboard/5/js/scripts.bundle.js') }}"></script>
</body>
</html>
