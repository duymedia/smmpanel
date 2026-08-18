<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Forgot Password - {{ config('app.name') }}</title>
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

        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 order-2 order-lg-1">
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <div class="w-lg-500px p-10">

                    {{-- Flash messages via Modal --}}
                    @if(session('error'))
                    <div class="modal fade" id="modal-auth-alert" tabindex="-1" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered rounded-4">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white py-4">
                                    <h4 class="modal-title text-white ls-1">Alert</h4>
                                </div>
                                <div class="modal-body py-10 fs-4" style="word-break: break-word;">{{ session('error') }}</div>
                                <div class="modal-footer text-center py-4">
                                    <button type="button" class="btn btn-sm btn-danger px-4 rounded-4" data-bs-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(session('status'))
                    <div class="modal fade" id="modal-auth-alert" tabindex="-1" data-bs-backdrop="static">
                        <div class="modal-dialog modal-dialog-centered rounded-4">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white py-4">
                                    <h4 class="modal-title text-white ls-1">Success</h4>
                                </div>
                                <div class="modal-body py-10 fs-4" style="word-break: break-word;">{{ session('status') }}</div>
                                <div class="modal-footer text-center py-4">
                                    <button type="button" class="btn btn-sm btn-success px-4 rounded-4" data-bs-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="form w-100">
                        @csrf

                        <div class="text-center mb-11">
                            <h1 class="text-dark fw-bolder mb-3">Forgot Password?</h1>
                            <div class="text-gray-500 fw-semibold fs-6">Enter your email to reset your password.</div>
                        </div>

                        <div class="fv-row mb-8">
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control form-control-solid @error('email') is-invalid @enderror"
                                placeholder="Email" autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-10">
                            <button type="submit" class="btn btn-primary">Send Reset Link</button>
                        </div>

                        <div class="text-gray-500 text-center fw-semibold fs-6">
                            <a href="{{ route('login') }}" class="link-primary">Back to Sign In</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
            style="background-image: url(https://cdn.whoispanel.com/1/media/misc/auth-bg.png)">
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                <a href="/" class="mb-0 mb-lg-12">
                    <img alt="Logo" src="/assets/media/logo_1773336732.jpg" class="h-60px h-lg-75px">
                </a>
                <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">
                    World's Best Cheap &amp; Easy SMM Panel
                </h1>
            </div>
        </div>

    </div>
</div>
<script src="https://cdn.whoispanel.com/1/plugins/global/plugins.bundle.js"></script>
<script src="https://cdn.whoispanel.com/1/js/scripts.bundle.js"></script>
<script src="{{ asset('js/loader.js') }}"></script>
<script>
document.querySelector('form').addEventListener('submit', function () {
    var btn = this.querySelector('button[type="submit"]');
    if (btn) btn.disabled = true;
    showFullScreenLoader('Sending reset link...');
});
var modalAlert = document.getElementById('modal-auth-alert');
if (modalAlert) {
    var bsModal = new bootstrap.Modal(modalAlert);
    bsModal.show();
    if (modalAlert.querySelector('.bg-success')) {
        setTimeout(function() { bsModal.hide(); }, 2000);
    }
}
</script>
</body>
</html>
