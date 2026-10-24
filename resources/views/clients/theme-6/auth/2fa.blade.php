<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Two Step Verification - {{ $settings['title'] ?? config('app.name') }}</title>
    <link rel="manifest" href="{{ route('manifest') }}">
    <link rel="canonical" href="{{ route('2fa.show') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Two Step Verification - {{ $settings['title'] ?? config('app.name') }}">
    <meta property="og:image" content="{{ !empty($config?->logo_facebook) ? asset('assets/media/' . basename($config->logo_facebook)) : asset('assets/media/logo.png') }}">
    <meta property="og:image:alt" content="{{ $config?->title ?? config('app.name') }}">
    <meta property="og:description" content="{{ $settings['description'] ?? '' }}">
    <meta name="keywords" content="{{ $settings['keywords'] ?? '' }}">
    <meta name="description" content="{{ $settings['description'] ?? '' }}">
    <link rel="shortcut icon" href="{{ !empty($config?->favicon) ? asset('assets/media/' . basename($config->favicon)) : asset('assets/media/favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/css/style.bundle.css') }}" rel="stylesheet">
</head>

<body id="kt_body" class="app-blank" data-theme="light">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">

            {{-- Form side --}}
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 order-2 order-lg-1">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">

                    <div class="w-lg-500px p-10">
                        <form id="two-factor-form" class="form w-100" method="post"
                            action="{{ route('2fa.verify') }}" onsubmit="return false;">
                            @csrf

                            <div class="text-center mb-10">
                                <h1 class="text-dark fw-bolder mb-3" data-lang="Two Step Verification">Xác minh hai bước</h1>
                                <div class="text-gray-500 fw-semibold fs-6" data-lang="Type your 6 digit security code">
                                    Nhập mã bảo mật gồm 6 chữ số</div>
                            </div>

                            <div class="fv-row mb-8">
                                <div class="mb-3">
                                    <input type="text" name="code" id="2fa-code" class="form-control"
                                        placeholder="Mã xác minh" data-lang="Verification code" maxlength="6"
                                        inputmode="numeric" pattern="[0-9]{6}"
                                        autocomplete="one-time-code" autofocus>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap justify-content-center pb-lg-0">
                                <button type="button" id="btn-check-2fa" class="btn btn-primary">
                                    <span class="indicator-label" data-lang="Submit">Gửi</span>
                                    <span class="indicator-progress">Đang xác minh...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                                <a href="{{ route('login') }}" class="btn btn-light ms-4"
                                    data-lang="Back to Sign In">Quay lại đăng nhập</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
            style="background-image: url('https://cdn.whoispanel.com/1/media/misc/auth-bg.png');">
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                <a href="/" class="mb-0 mb-lg-12">
                    <img alt="{{ $config?->title ?? config('app.name') }}"
                        src="{{ !empty($config?->logo) ? asset('assets/media/' . basename($config->logo)) : asset('assets/media/logo.png') }}"
                        class="h-60px h-lg-75px">
                </a>
                <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20 cmz-background1 background1"
                    src="https://cdn.mypanel.link/6f7slz/jd7xmobnjdlu0eun.webp" alt="">
                <h1 class="block-signin__title d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                    {{ $config?->title ?? config('app.name') }}
                </h1>
                <div class="block-signin__description d-none d-lg-block text-white fs-base text-center" style="max-width: 550px;">
                    {{ $config?->description ?? '' }}
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('cdn.whoispanel.com/dashboard/5/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('cdn.whoispanel.com/libs/jquery.blockUI/2.70/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('assets/app.js') }}?v=16.8"></script>
    <script src="{{ asset('assets/client/auth.js') }}?v=16.9"></script>
</body>

</html>
