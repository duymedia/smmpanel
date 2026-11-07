<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('install.title') }} - {{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ asset('assets/media/favicon.ico') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.css') }}" rel="stylesheet">
    <link href="{{ asset('cdn.whoispanel.com/dashboard/5/css/style.bundle.css') }}" rel="stylesheet">
    <style>
        .install-page { min-height: 100vh; }
        .install-form-side { min-height: 100vh; }
        .install-form-wrap { width: min(100%, 520px); }
        .install-aside {
            min-height: 100vh;
            background: #202124 url('{{ asset('images/misc/auth-bg.png') }}') center / cover no-repeat;
        }
        .install-logo { width: auto; max-width: 190px; max-height: 54px; object-fit: contain; }
        .install-input { min-height: 44px; }
        @media (max-width: 991.98px) {
            .install-form-side { min-height: 100vh; padding: 32px 20px !important; }
        }
    </style>
</head>

<body id="kt_body" class="app-blank" data-theme="light">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid install-page">
            <main class="d-flex flex-column flex-lg-row-fluid w-lg-50 order-2 order-lg-1 install-form-side px-5 px-lg-10 py-10">
                <div class="d-flex flex-center flex-column flex-grow-1">
                    <div class="install-form-wrap">
                        <div class="text-center mb-8">
                            <a href="/" class="d-inline-flex align-items-center justify-content-center mb-6" aria-label="Home">
                                <img src="{{ asset('assets/media/logo.png') }}" alt="{{ config('app.name') }}" class="install-logo">
                            </a>
                            <div class="text-gray-500 fw-semibold fs-7 text-uppercase mb-2">{{ strtoupper(getDomain()) }}</div>
                            <h1 class="text-dark fw-bolder mb-2">{{ __('install.title') }}</h1>
                            <div class="text-gray-500 fw-semibold fs-6">
                                @if ($isChild ?? false)
                                    {{ __('install.child_subtitle', ['domain' => $parentDomain ?? '']) }}
                                @else
                                    {{ __('install.subtitle') }}
                                @endif
                            </div>
                        </div>

                        <form class="form w-100" id="install-form" method="POST" action="{{ route('install.store') }}">
                            @csrf

                            @if ($isChild ?? false)
                                <div class="fv-row mb-5">
                                    <label for="api_key" class="form-label fw-semibold">{{ __('install.api_key') }}</label>
                                    <input type="text" id="api_key" name="api_key" class="form-control install-input"
                                        placeholder="{{ __('install.api_key_placeholder') }}" value="{{ old('api_key') }}" autocomplete="off" required>
                                </div>
                            @endif

                            <div class="fv-row mb-5">
                                <label for="name" class="form-label fw-semibold">{{ __('install.full_name') }}</label>
                                <input type="text" id="name" name="name" class="form-control install-input"
                                    placeholder="{{ __('install.full_name_placeholder') }}" value="{{ old('name') }}"
                                    autocomplete="name" required>
                            </div>

                            <div class="fv-row mb-5">
                                <label for="username" class="form-label fw-semibold">{{ __('install.username') }}</label>
                                <input type="text" id="username" name="username" class="form-control install-input"
                                    placeholder="{{ __('install.username_placeholder') }}" value="{{ old('username') }}"
                                    autocomplete="username" required>
                            </div>

                            <div class="fv-row mb-5">
                                <label for="email" class="form-label fw-semibold">{{ __('install.email') }}</label>
                                <input type="email" id="email" name="email" class="form-control install-input"
                                    placeholder="{{ __('install.email_placeholder') }}" value="{{ old('email') }}"
                                    autocomplete="email" required>
                            </div>

                            <div class="row g-5">
                                <div class="col-md-6 fv-row">
                                    <label for="password" class="form-label fw-semibold">{{ __('install.password') }}</label>
                                    <input type="password" name="password" id="password" class="form-control install-input"
                                        placeholder="{{ __('install.password_placeholder') }}" autocomplete="new-password" required>
                                </div>
                                <div class="col-md-6 fv-row">
                                    <label for="passwordConfirm" class="form-label fw-semibold">{{ __('install.confirm_password') }}</label>
                                    <input type="password" name="password_confirmation" id="passwordConfirm" class="form-control install-input"
                                        placeholder="{{ __('install.confirm_password_placeholder') }}" autocomplete="new-password" required>
                                </div>
                            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary w-100 mt-8">
                                <span>{{ __('install.submit') }}</span>
                            </button>
                        </form>

                        <p class="text-gray-500 text-center fs-8 mt-6 mb-0">
                            {{ __('install.terms_text') }}
                            <a href="/terms" class="link-primary">{{ __('install.terms_link') }}</a>
                            {{ __('install.and') }}
                            <a href="/privacy" class="link-primary">{{ __('install.privacy_link') }}</a>.
                        </p>
                    </div>
                </div>
            </main>

            <aside class="d-none d-lg-flex flex-lg-row-fluid w-lg-50 order-1 order-lg-2 bgi-size-cover bgi-position-center install-aside">
                <div class="d-flex flex-column flex-center py-10 px-10 px-xl-20 w-100 text-center">
                    <a href="/" class="mb-12">
                        <img src="{{ asset('assets/media/logo.png') }}" alt="{{ config('app.name') }}" class="install-logo">
                    </a>
                    <h2 class="text-white fs-2x fw-bolder mb-5">{{ __('install.title') }}</h2>
                    <p class="text-white opacity-75 fs-5 fw-semibold mb-0" style="max-width: 480px;">
                        @if ($isChild ?? false)
                            {{ __('install.child_subtitle', ['domain' => $parentDomain ?? '']) }}
                        @else
                            {{ __('install.subtitle') }}
                        @endif
                    </p>
                </div>
            </aside>
        </div>
    </div>

    <script src="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('cdn.whoispanel.com/dashboard/5/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('cdn.whoispanel.com/libs/jquery.blockUI/2.70/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('assets/app.js') }}?v=16.10"></script>
    <script src="{{ asset('assets/client/auth.js') }}?v=16.11"></script>
</body>

</html>
