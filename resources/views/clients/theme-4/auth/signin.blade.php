<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('auth.sign_in') }} - {{ $settings['title'] ?? config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="{{ $settings['keywords'] ?? '' }}">
    <meta name="description" content="{{ $settings['description'] ?? '' }}">
    <link rel="shortcut icon" href="/assets/media/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <link href="https://cdn.whoispanel.com/1/plugins/global/plugins.bundle.css" rel="stylesheet">
    <link href="https://cdn.whoispanel.com/1/css/style.bundle.css" rel="stylesheet">
     <style>
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
</head>
<body id="kt_body" class="app-blank" data-theme="light">
<div class="d-flex flex-column flex-root" id="kt_app_root">
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">

        {{-- Form side --}}
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 order-2 order-lg-1">
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <div class="w-lg-500px p-10">

                    {{-- Modal Alert --}}
                    <div class="modal fade" id="modal-auth-alert" tabindex="-1" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered rounded-4">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white py-4">
                                    <h4 class="modal-title text-white ls-1">Alert</h4>
                                </div>
                                <div class="modal-body py-10 fs-4" style="word-break: break-word;"></div>
                                <div class="modal-footer text-center py-4">
                                    <button type="button" class="btn btn-sm btn-danger px-4 rounded-4" data-bs-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('login.store') }}" class="form w-100">
                        @csrf

                        <div class="text-center mb-11">
                            <h1 class="text-dark fw-bolder mb-3">Sign in</h1>
                            <div class="text-gray-500 fw-semibold fs-6">{{ config('app.name') }}</div>
                        </div>

                        {{-- Google OAuth --}}
                        <div class="row g-3 mb-9">
                            <div class="col-12">
                                <a href="/api/oauth_google"
                                    class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                    <img alt="Google" src="https://cdn.whoispanel.com/1/media/svg/brand-logos/google-icon.svg" class="h-15px me-3">
                                    Sign in with Google
                                </a>
                            </div>
                        </div>

                        <div class="separator separator-content my-14">
                            <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
                        </div>

                        {{-- Username --}}
                        <div class="fv-row mb-8">
                            <input type="text" name="username" value="{{ old('username') }}"
                                class="form-control form-control-solid @error('username') is-invalid @enderror"
                                placeholder="Username" autofocus>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="fv-row mb-3">
                            <input type="password" name="password"
                                class="form-control form-control-solid @error('password') is-invalid @enderror"
                                placeholder="Password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                            <div>
                                <label class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" name="remember" value="1">
                                    <span class="form-check-label text-gray-700">Remember me</span>
                                </label>
                            </div>
                            <a href="{{ route('password.request') }}" class="link-primary">Forgot Password?</a>
                        </div>

                        <div class="d-grid mb-10">
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </div>

                        <div class="text-gray-500 text-center fw-semibold fs-6">
                            Not a Member yet?
                            <a href="{{ route('signup') }}" class="link-primary">Sign up</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- Aside --}}
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
            style="background-image: url(https://cdn.whoispanel.com/1/media/misc/auth-bg.png)">
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                <a href="/" class="mb-0 mb-lg-12">
                    <img alt="Logo" src="/assets/media/logo_1773336732.jpg" class="h-60px h-lg-75px">
                </a>
                <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
                    src="https://cdn.mypanel.link/6f7slz/jd7xmobnjdlu0eun.webp" alt="">
                <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                    World's Best Cheap &amp; Easy SMM Panel
                </h1>
                <div class="d-none d-lg-block text-white fs-base text-center" style="max-width: 550px;">
                    We offer several advantages that make us the best SMM panel. Our SMM services are diverse,
                    making us the cheapest around. Many agencies and freelancers worldwide rely on us.
                </div>
            </div>
        </div>

    </div>
</div>
<script src="https://cdn.whoispanel.com/1/plugins/global/plugins.bundle.js"></script>
<script src="https://cdn.whoispanel.com/1/js/scripts.bundle.js"></script>
<script src="{{ asset('js/loader.js') }}"></script>
<script>
document.querySelector('form').addEventListener('submit', function (e) {
    e.preventDefault();
    var form = this;
    var btn = form.querySelector('button[type="submit"]');
    if (btn) btn.disabled = true;
    showFullScreenLoader('Signing in...', 'body');

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(function(r) { return r.json(); })
    .then(function(res) {
        hideFullScreenLoader();
        setTimeout(function() {
            if (res.success) {
                showAuthModal('success', res.message || 'Sign in successfully');
                setTimeout(function() { window.location.href = res.redirect || '/'; }, 2000);
            } else {
                if (btn) btn.disabled = false;
                showAuthModal('error', res.message || 'Login failed');
            }
        }, 400);
    })
    .catch(function() {
        hideFullScreenLoader();
        setTimeout(function() {
            if (btn) btn.disabled = false;
            showAuthModal('error', 'Network error. Please try again.');
        }, 400);
    });
});

function showAuthModal(type, msg) {
    var modalEl = document.getElementById('modal-auth-alert');
    var color = type === 'error' ? 'danger' : 'success';
    modalEl.querySelector('.modal-header').className = 'modal-header bg-' + color + ' text-white py-4';
    modalEl.querySelector('.modal-title').textContent = type === 'error' ? 'Alert' : 'Success';
    modalEl.querySelector('.modal-body').textContent = msg;
    modalEl.querySelector('.modal-footer .btn').className = 'btn btn-sm btn-' + color + ' px-4 rounded-4';
    var existing = bootstrap.Modal.getInstance(modalEl);
    if (existing) existing.dispose();
    new bootstrap.Modal(modalEl).show();
}
</script>
</body>
</html>
