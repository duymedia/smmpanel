<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign in - {{ $siteTitle }}</title>
    <link rel="manifest" href="{{ route('manifest') }}">
    <link rel="canonical" href="{{ route('login') }}">
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:title" content="Sign in - {{ $siteTitle }}">
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

        .google-login-icon {
            width: 18px;
            height: 18px;
            flex: 0 0 18px;
        }
    </style>
</head>

<body id="kt_body" class="app-blank" data-theme="light">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">

            {{-- Form side --}}
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 order-2 order-lg-1">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-500px p-10">

                        <form class="form w-100" id="signin-form" action="{{ route('login.store') }}" method="post">
                            @csrf

                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-3" data-lang="Sign in">Sign in</h1>
                                <div class="text-gray-500 fw-semibold fs-6">
                                    {{ $settings['title'] ?? config('app.name') }}
                                </div>
                            </div>

                            {{-- Google OAuth --}}
                            @if ($config?->google_oauth_status && $config?->google_oauth_client_id && $config?->google_oauth_client_secret)
                                <div class="row g-3 mb-9">
                                    <div class="col-md-12">
                                        <a href="{{ route('login.google') }}"
                                            class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                        <svg class="google-login-icon me-3" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                                            <path fill="#4285F4" d="M21.35 12.27c0-.77-.07-1.52-.22-2.23H12v4.22h5.24a4.48 4.48 0 0 1-1.94 2.94v2.45h3.14c1.84-1.69 2.91-4.18 2.91-7.38z" />
                                            <path fill="#34A853" d="M12 21.98c2.63 0 4.84-.87 6.45-2.33l-3.14-2.45c-.87.58-1.98.92-3.31.92-2.54 0-4.69-1.72-5.46-4.03H3.3v2.53A9.74 9.74 0 0 0 12 21.98z" />
                                            <path fill="#FBBC05" d="M6.54 14.09a5.86 5.86 0 0 1 0-4.18V7.38H3.3a9.99 9.99 0 0 0 0 9.24l3.24-2.53z" />
                                            <path fill="#EA4335" d="M12 5.88c1.43 0 2.72.49 3.73 1.46l2.8-2.8C16.84 2.98 14.63 2.02 12 2.02a9.74 9.74 0 0 0-8.7 5.36l3.24 2.53C7.31 7.6 9.46 5.88 12 5.88z" />
                                        </svg>
                                        <span data-lang="Sign in with Google">Đăng nhập với Google</span>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            {{-- Username --}}
                            <div class="fv-row mb-8">
                                <div class="mb-3">
                                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                                        class="form-control"
                                        placeholder="Tài khoản" data-lang="Username" autocomplete="username" autofocus>
                                </div>
                            </div>

                            {{-- Password --}}
                            <div class="fv-row mb-3">
                                <div class="mb-3">
                                    <input type="password" id="password" name="password"
                                        class="form-control"
                                        placeholder="Mật khẩu" data-lang="Password" autocomplete="current-password">
                                </div>
                            </div>

                            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                                <div></div>
                                <a href="{{ route('password.request') }}" class="link-primary" data-lang="Forgot Password">Quên mật khẩu?</a>
                            </div>

                            <div class="d-flex justify-content-center mb-5"></div>

                            <div class="d-grid mb-10">
                                <button type="button" id="btn-signin" class="btn btn-primary" name="Sign In"
                                    data-lang="Sign in">Đăng nhập</button>
                            </div>

                            <div class="text-gray-500 text-center fw-semibold fs-6">
                                <span data-lang="Not a Member yet">Bạn chưa có tài khoản?</span>
                                <a href="{{ route('signup') }}" class="link-primary" data-lang="Sign up">Đăng ký tại đây</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            {{-- Aside --}}
            <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url('{{ asset('images/misc/auth-bg.png') }}')">
                <!--begin::Content-->
                <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                    <!--begin::Logo-->
                    <a href="/" class="mb-0 mb-lg-12">
                        <img alt="Logo" src="{{ !empty($config?->logo) ? $config->logo : asset('assets/media/logo.png') }}" class="h-60px h-lg-75px">
                    </a>
                    <!--end::Logo-->
                    <!--begin::Image-->
                    <img data-auth-theme-image class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20" src="{{ asset('cdn.whoispanel.com/1/media/misc/auth-screens.png') }}" alt="">
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
    <script src="{{ asset('assets/client/auth.js') }}?v=16.21"></script>
    @if (session('error'))
        <div class="modal fade" id="auth-error-modal" tabindex="-1" data-bs-backdrop="static"
            data-bs-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-white">Thông báo</h5>
                    </div>
                    <div class="modal-body">{{ session('error') }}</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đã đọc</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.addEventListener('load', function () {
                var modal = document.getElementById('auth-error-modal');
                if (modal && window.bootstrap?.Modal) bootstrap.Modal.getOrCreateInstance(modal).show();
            });
        </script>
    @endif
</body>

</html>
