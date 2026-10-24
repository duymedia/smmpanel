<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="UTF-8" />
    <title>{{ __('install.title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'sans-serif'],
                    },
                    colors: {
                        brand: { 
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                    },
                },
            },
        };
    </script>
</head>

<body class="min-h-screen bg-gradient-to-b from-slate-50 to-slate-100 font-sans text-slate-800 antialiased flex items-center justify-center p-4">
    <div class="w-full max-w-[380px] bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-7">

        {{-- Animated brand badge with live domain initial --}}
        <div class="flex flex-col items-center text-center mb-4">
            <div class="relative w-16 h-16 mb-2">
                <img src="{{ asset('assets/media/logo-animated.gif') }}" alt="Logo"
                    width="64" height="64" class="w-16 h-16">
                <span class="absolute inset-0 flex items-center justify-center text-white font-bold text-lg pointer-events-none">
                    {{ strtoupper(getDomain())[0] }}
                </span>
            </div>
            <h1 class="text-base font-bold text-slate-900 leading-tight">{{ __('install.title') }}</h1>
            @if ($isChild ?? false)
                <p class="text-[12px] text-slate-500 mt-1">
                    {{ __('install.child_subtitle', ['domain' => $parentDomain ?? '']) }}
                </p>
            @else
                <p class="text-[12px] text-slate-500 mt-1">{{ __('install.subtitle') }}</p>
            @endif
        </div>

        <form id="install-form" method="POST" action="{{ route('install.store') }}"
            class="space-y-3">
            @csrf

            @if ($isChild ?? false)
                <div class="mb-3.5">
                    <label class="block text-[13px] font-medium text-slate-700 mb-1">{{ __('install.api_key') }}</label>
                    <div class="relative">
                        <i class="bi bi-key-fill absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="api_key"
                            class="w-full pl-9 pr-3 py-2.5 border rounded-lg text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:ring-2 transition {{ $errors->has('api_key') ? 'border-red-500 focus:border-red-500 focus:ring-red-100' : 'border-slate-300 focus:border-brand-500 focus:ring-brand-100' }}"
                            placeholder="{{ __('install.api_key_placeholder') }}" value="{{ old('api_key') }}" required>
                    </div>
                    @error('api_key')
                        <p class="text-[12px] text-red-600 mt-1 flex items-center gap-1">
                            <i class="bi bi-x-circle-fill"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
            @endif

            <div class="mb-3">
                <div class="relative">
                    <i class="bi bi-person-fill absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="name"
                        class="w-full pl-9 pr-3 py-2.5 border rounded-lg text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:ring-2 transition {{ $errors->has('name') ? 'border-red-500 focus:border-red-500 focus:ring-red-100' : 'border-slate-300 focus:border-brand-500 focus:ring-brand-100' }}"
                        placeholder="{{ __('install.full_name_placeholder') }}" value="{{ old('name') }}"
                        autocomplete="name" required>
                </div>
                @error('name')
                    <p class="text-[12px] text-red-600 mt-1 flex items-center gap-1">
                        <i class="bi bi-x-circle-fill"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-3">
                <div class="relative">
                    <i class="bi bi-at absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="username"
                        class="w-full pl-9 pr-3 py-2.5 border rounded-lg text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:ring-2 transition {{ $errors->has('username') ? 'border-red-500 focus:border-red-500 focus:ring-red-100' : 'border-slate-300 focus:border-brand-500 focus:ring-brand-100' }}"
                        placeholder="{{ __('install.username_placeholder') }}" value="{{ old('username') }}"
                        autocomplete="username" required>
                </div>
                @error('username')
                    <p class="text-[12px] text-red-600 mt-1 flex items-center gap-1">
                        <i class="bi bi-x-circle-fill"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-3">
                <div class="relative">
                    <i class="bi bi-envelope-fill absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="email" name="email"
                        class="w-full pl-9 pr-3 py-2.5 border rounded-lg text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:ring-2 transition {{ $errors->has('email') ? 'border-red-500 focus:border-red-500 focus:ring-red-100' : 'border-slate-300 focus:border-brand-500 focus:ring-brand-100' }}"
                        placeholder="{{ __('install.email_placeholder') }}" value="{{ old('email') }}"
                        autocomplete="email" required>
                </div>
                @error('email')
                    <p class="text-[12px] text-red-600 mt-1 flex items-center gap-1">
                        <i class="bi bi-x-circle-fill"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div class="flex items-center gap-3 my-3 text-[10px] font-semibold uppercase tracking-wider text-slate-400">
                <span class="h-px flex-1 bg-slate-200"></span>
                {{ __('install.password') }}
                <span class="h-px flex-1 bg-slate-200"></span>
            </div>

            <div class="mb-3">
                <div class="relative">
                    <i class="bi bi-lock-fill absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="password" name="password" id="password"
                        class="w-full pl-9 pr-9 py-2.5 border rounded-lg text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:ring-2 transition {{ $errors->has('password') ? 'border-red-500 focus:border-red-500 focus:ring-red-100' : 'border-slate-300 focus:border-brand-500 focus:ring-brand-100' }}"
                        placeholder="{{ __('install.password_placeholder') }}" autocomplete="new-password" required>
                    <i class="bi bi-eye absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 cursor-pointer p-1"
                        id="togglePwd"></i>
                </div>
                @error('password')
                    <p class="text-[12px] text-red-600 mt-1 flex items-center gap-1">
                        <i class="bi bi-x-circle-fill"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <div class="mb-1">
                <div class="relative">
                    <i class="bi bi-lock-fill absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="password" name="password_confirmation" id="passwordConfirm"
                        class="w-full pl-9 pr-9 py-2.5 border border-slate-300 rounded-lg text-sm text-slate-800 placeholder:text-slate-400 outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-100 transition"
                        placeholder="{{ __('install.confirm_password_placeholder') }}" autocomplete="new-password" required>
                    <i class="bi bi-eye absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 cursor-pointer p-1"
                        id="togglePwdConfirm"></i>
                </div>
            </div>

            <button type="submit" id="submitBtn"
                class="w-full mt-4 py-2.5 bg-brand-600 hover:bg-brand-700 disabled:opacity-65 disabled:cursor-not-allowed text-white text-sm font-semibold rounded-lg transition flex items-center justify-center gap-2">
                <span class="spin-ring hidden w-[15px] h-[15px] border-2 border-white/40 border-t-white rounded-full animate-spin"></span>
                <i class="bi bi-rocket-takeoff"></i>
                <span>{{ __('install.submit') }}</span>
            </button>
        </form>

        <p class="text-center text-[11px] text-slate-400 mt-3">
            {{ __('install.terms_text') }}
            <a href="#" class="text-brand-600 hover:underline">{{ __('install.terms_link') }}</a>
            {{ __('install.and') }}
            <a href="#" class="text-brand-600 hover:underline">{{ __('install.privacy_link') }}</a>.
        </p>
    </div>

    {{-- Bootstrap + jQuery + blockUI are required by app.js (app.alert / app.ajax) --}}
    <script src="{{ asset('cdn.whoispanel.com/dashboard/5/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('cdn.whoispanel.com/dashboard/5/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('cdn.whoispanel.com/libs/jquery.blockUI/2.70/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('assets/app.js') }}?v=16.8"></script>
    <script src="{{ asset('assets/client/auth.js') }}?v=16.9"></script>

</body>

</html>
