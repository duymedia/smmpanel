<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#2563eb" />
    <title>{{ getDomain() }} —
        {{ $config->title ?? '#1 Cheapest SMM Panel | Buy Instagram, TikTok, YouTube Followers' }}</title>

    <meta name="description"
        content="{{ $config->description ?? getDomain() . ' is the world\'s #1 cheapest and fastest SMM panel. Buy Instagram followers, TikTok likes, YouTube views, Facebook page likes at the lowest prices. Instant delivery, 24/7 support, API available.' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ getDomain() }} — SMM Panel" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin />

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;450;500;600;700;800;900&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html {
            scroll-behavior: smooth;
            background: #ffffff;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        section[id] {
            scroll-margin-top: 72px;
        }

        [x-cloak] {
            display: none !important;
        }

        ::selection {
            background: rgba(37, 99, 235, .22);
            color: #0f172a;
        }

        /* --- Marquee (live feed) --- */
        .marquee {
            overflow: hidden;
        }

        .marquee-track {
            width: max-content;
            animation: marquee 38s linear infinite;
        }

        @keyframes marquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* --- Slow pulse glows --- */
        @keyframes pulseSlow {

            0%,
            100% {
                opacity: .5;
                transform: scale(1);
            }

            50% {
                opacity: .85;
                transform: scale(1.06);
            }
        }

        .animate-pulse-slow {
            animation: pulseSlow 5s ease-in-out infinite;
        }

        /* --- Float --- */
        @keyframes floatSlow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-9px);
            }
        }

        .animate-float-slow {
            animation: floatSlow 6s ease-in-out infinite;
        }

        /* --- Reverse spin --- */
        @keyframes spinRev {
            to {
                transform: rotate(-360deg);
            }
        }

        .animate-spin-reverse {
            animation: spinRev 20s linear infinite;
        }

        /* --- Arrow flow (feature card) --- */
        @keyframes flowRight {

            0%,
            100% {
                opacity: .3;
                transform: translateX(0);
            }

            50% {
                opacity: 1;
                transform: translateX(3px);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            .marquee-track,
            .animate-pulse-slow,
            .animate-float-slow,
            .animate-spin-reverse,
            .animate-spin,
            .animate-ping,
            .animate-pulse,
            .animate-bounce {
                animation: none !important;
            }
        }

        html,
        body {
            overflow-x: hidden;
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="antialiased">
    <div class="min-h-screen bg-[#ffffff] text-[#0F172A] overflow-x-hidden">

        @php
            // Reusable logo mark
            $flameSvg =
                '<svg viewBox="0 0 24 24" class="text-[#0ea5e9]" width="22" height="22" fill="currentColor"><path d="M12 2c-1 4-4 5.5-4 9a4 4 0 0 0 8 0c0-3.5-3-5-4-9zM7 13c0 4 2.2 7 5 7s5-3 5-7c-1.4 1.2-3 1.8-5 1.8S8.4 14.2 7 13z"></path></svg>';
        @endphp

        <!-- ===================== HEADER ===================== -->
        <header x-data="{ open: false }"
            class="fixed top-0 inset-x-0 z-50 transition-all duration-300 backdrop-blur-xl bg-[#ffffff]/85 border-b border-[#e2e8f0]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <a class="flex items-center gap-2.5" href="{{ route('landing') }}">
                    <div class="relative shrink-0 group" style="width:40px;height:40px">
                        <div
                            class="absolute inset-0 rounded-2xl bg-[#2563eb]/30 blur-md opacity-50 group-hover:opacity-80 transition-opacity">
                        </div>
                        <div class="relative rounded-2xl flex items-center justify-center shadow-lg ring-1 ring-[#1e40af]/30 group-hover:scale-105 transition-transform overflow-hidden"
                            style="width:40px;height:40px;background:linear-gradient(135deg,#0c1929 0%,#1e3a8a 100%)">
                            @if (!empty($config->logo))
                                <img src="{{ $config->logo }}" alt="{{ getDomain() }}"
                                    class="w-full h-full object-contain" />
                            @else
                                {!! $flameSvg !!}
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col leading-none">
                        <span
                            class="font-extrabold text-base tracking-[-0.02em] text-[#0F172A]">{{ getDomain() }}</span>
                        <span class="text-[10px] text-[#64748B] tracking-[0.16em] uppercase mt-0.5">Global ·
                            Cheapest</span>
                    </div>
                </a>
                <nav class="hidden md:flex items-center gap-7 text-sm text-[#475569]">
                    <a href="#features" class="hover:text-[#0F172A] transition-colors">Features</a>
                    <a href="#how" class="hover:text-[#0F172A] transition-colors">How it works</a>
                    <a href="#pricing" class="hover:text-[#0F172A] transition-colors">Pricing</a>
                    <a href="{{ route('clients.api.index') }}" class="hover:text-[#0F172A] transition-colors">API</a>
                    <a href="#blog" class="hover:text-[#0F172A] transition-colors">Blog</a>
                </nav>
                <div class="hidden md:flex items-center gap-2">
                    <a class="h-9 px-4 inline-flex items-center text-sm font-medium text-[#475569] hover:text-[#0F172A] transition-colors"
                        href="{{ route('login') }}">Sign in</a>
                    <a class="h-9 px-5 inline-flex items-center gap-1.5 text-sm font-semibold rounded-[10px] bg-[#2563eb] text-[#ffffff] hover:bg-[#1d4ed8] hover:-translate-y-0.5 transition-all shadow-sm"
                        href="{{ route('signup') }}">Get started
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg></a>
                </div>
                <button @click="open = !open" aria-label="Menu"
                    class="md:hidden w-9 h-9 inline-flex items-center justify-center rounded-lg bg-white border border-[#e2e8f0] text-[#0F172A] hover:bg-[#f1f5f9]">
                    <svg x-show="!open" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" x2="20" y1="12" y2="12"></line>
                        <line x1="4" x2="20" y1="6" y2="6"></line>
                        <line x1="4" x2="20" y1="18" y2="18"></line>
                    </svg>
                    <svg x-show="open" x-cloak width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div x-show="open" x-collapse x-cloak class="md:hidden border-t border-[#e2e8f0] bg-white">
                <nav class="flex flex-col gap-1 px-5 py-4 text-[15px] text-[#475569]">
                    <a href="#features" @click="open=false"
                        class="py-2.5 px-3 rounded-lg hover:bg-[#f1f5f9] hover:text-[#0F172A]">Features</a>
                    <a href="#how" @click="open=false"
                        class="py-2.5 px-3 rounded-lg hover:bg-[#f1f5f9] hover:text-[#0F172A]">How it works</a>
                    <a href="#pricing" @click="open=false"
                        class="py-2.5 px-3 rounded-lg hover:bg-[#f1f5f9] hover:text-[#0F172A]">Pricing</a>
                    <a href="{{ route('clients.api.index') }}"
                        class="py-2.5 px-3 rounded-lg hover:bg-[#f1f5f9] hover:text-[#0F172A]">API</a>
                    <a href="#blog" @click="open=false"
                        class="py-2.5 px-3 rounded-lg hover:bg-[#f1f5f9] hover:text-[#0F172A]">Blog</a>
                    <div class="flex gap-2 pt-3 mt-2 border-t border-[#e2e8f0]">
                        <a href="{{ route('login') }}"
                            class="flex-1 h-10 inline-flex items-center justify-center rounded-[10px] border border-[#e2e8f0] text-sm font-semibold text-[#0F172A]">Sign
                            in</a>
                        <a href="{{ route('signup') }}"
                            class="flex-1 h-10 inline-flex items-center justify-center rounded-[10px] bg-[#2563eb] text-white text-sm font-semibold">Get
                            started</a>
                    </div>
                </nav>
            </div>
        </header>

        <!-- ===================== HERO ===================== -->
        <section
            class="relative min-h-[100vh] flex items-center pt-16 overflow-hidden bg-gradient-to-b from-[#eff6ff] via-white to-white">
            <div class="absolute inset-0 z-[1] pointer-events-none opacity-70"
                style="background:radial-gradient(ellipse 80% 60% at 70% 30%, rgba(37,99,235,0.18), transparent 60%), radial-gradient(ellipse 60% 50% at 20% 80%, rgba(14,165,233,0.14), transparent 55%), radial-gradient(ellipse 50% 40% at 50% 50%, rgba(99,102,241,0.10), transparent 60%)">
            </div>
            <div class="absolute inset-0 z-[1] pointer-events-none opacity-[0.15]"
                style="background-image:radial-gradient(circle, #2563eb 1px, transparent 1px);background-size:28px 28px">
            </div>
            <div
                class="absolute -top-40 -right-40 w-[700px] h-[700px] rounded-full bg-gradient-to-br from-[#2563eb]/22 to-[#0ea5e9]/10 blur-[140px] z-[1] pointer-events-none animate-pulse-slow">
            </div>
            <div
                class="absolute -bottom-48 -left-48 w-[600px] h-[600px] rounded-full bg-gradient-to-tr from-[#1e3a8a]/15 to-[#0ea5e9]/12 blur-[130px] z-[1] pointer-events-none animate-pulse-slow [animation-delay:1.5s]">
            </div>
            <div
                class="absolute top-[35%] left-[10%] w-[420px] h-[420px] rounded-full bg-[#67e8f9]/12 blur-[120px] z-[1] pointer-events-none animate-pulse-slow [animation-delay:3s]">
            </div>
            <div
                class="absolute inset-x-0 bottom-0 h-40 z-[2] pointer-events-none bg-gradient-to-t from-white via-white/85 to-transparent">
            </div>
            <svg class="hidden md:block absolute -top-20 -right-20 w-[420px] h-[420px] z-[2] pointer-events-none opacity-[0.18] animate-spin"
                style="animation-duration:60s" viewBox="0 0 200 200">
                <circle cx="100" cy="100" r="90" fill="none" stroke="url(#orbitGrad)"
                    stroke-width="1.2" stroke-dasharray="6 14"></circle>
                <defs>
                    <linearGradient id="orbitGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#2563eb"></stop>
                        <stop offset="100%" stop-color="#0ea5e9"></stop>
                    </linearGradient>
                </defs>
            </svg>
            <svg class="hidden lg:block absolute top-[12%] right-[8%] w-32 h-32 z-[2] pointer-events-none opacity-30 animate-spin-reverse"
                viewBox="0 0 64 64">
                <circle cx="32" cy="32" r="28" fill="none" stroke="#0ea5e9" stroke-width="1"
                    stroke-dasharray="3 5"></circle>
                <circle cx="60" cy="32" r="2.5" fill="#2563eb"></circle>
            </svg>
            <div class="hidden md:block absolute top-[30%] left-[5%] z-[2] pointer-events-none animate-float-slow">
                <div
                    class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#2563eb] to-[#1d4ed8] opacity-[0.18] shadow-2xl shadow-[#2563eb]/40 backdrop-blur">
                </div>
            </div>
            <svg class="hidden md:block absolute top-[20%] left-[40%] w-10 h-10 z-[2] pointer-events-none opacity-30 animate-float-slow [animation-delay:0.7s]"
                viewBox="0 0 32 32">
                <polygon points="16,4 28,26 4,26" fill="none" stroke="#0ea5e9" stroke-width="1.5"
                    stroke-linejoin="round"></polygon>
            </svg>
            <svg class="hidden md:block absolute bottom-[18%] left-[12%] w-14 h-14 z-[2] pointer-events-none opacity-40 animate-float-slow [animation-delay:1.4s]"
                viewBox="0 0 56 56">
                <circle cx="28" cy="28" r="22" fill="none" stroke="url(#ringGrad)"
                    stroke-width="2"></circle>
                <defs>
                    <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#2563eb"></stop>
                        <stop offset="100%" stop-color="#67e8f9"></stop>
                    </linearGradient>
                </defs>
            </svg>
            <svg class="hidden md:block absolute top-[18%] left-[42%] w-6 h-6 z-[3] text-[#2563eb]/45 pointer-events-none animate-pulse-slow"
                viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0l2.5 9.5L24 12l-9.5 2.5L12 24l-2.5-9.5L0 12l9.5-2.5L12 0z"></path>
            </svg>
            <svg class="hidden lg:block absolute top-[55%] right-[14%] w-5 h-5 z-[3] text-[#1d4ed8]/40 pointer-events-none animate-pulse-slow [animation-delay:1.8s]"
                viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 0l2.5 9.5L24 12l-9.5 2.5L12 24l-2.5-9.5L0 12l9.5-2.5L12 0z"></path>
            </svg>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-24 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                    <!-- copy -->
                    <div class="text-center lg:text-left order-2 lg:order-1">
                        <div
                            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/80 backdrop-blur border border-[#dbeafe] shadow-[0_4px_12px_-4px_rgba(37,99,235,0.18)] text-[12px] font-medium text-[#0F172A] mb-6">
                            <span class="relative flex size-1.5"><span
                                    class="absolute inline-flex h-full w-full animate-ping rounded-full bg-[#2563eb] opacity-75"></span><span
                                    class="relative inline-flex size-1.5 rounded-full bg-[#2563eb]"></span></span>
                            <span class="text-[#475569]">Trusted by</span> <span
                                class="font-bold text-[#1d4ed8]">100,000+ resellers</span> <span
                                class="text-[#475569]">in 80+ countries</span>
                        </div>
                        <h1
                            class="text-3xl sm:text-4xl md:text-5xl lg:text-[44px] xl:text-[52px] font-bold tracking-[-0.03em] leading-[1.1] text-[#0F172A]">
                            The world's
                            <span class="relative inline-block"><span
                                    class="relative z-10 bg-gradient-to-r from-[#2563eb] via-[#3b82f6] to-[#0ea5e9] bg-clip-text text-transparent">biggest
                                    &amp; cheapest</span><span
                                    class="absolute -bottom-1.5 left-0 right-0 h-3 bg-gradient-to-r from-[#2563eb]/20 via-[#0ea5e9]/20 to-transparent -z-0 rounded-full blur-sm"></span></span>
                            SMM panel
                        </h1>
                        <p class="mt-6 text-base md:text-lg text-[#475569] max-w-xl mx-auto lg:mx-0 leading-relaxed">
                            500+ services across every social platform. Prices start at<span
                                class="text-[#0F172A] font-semibold"> $0.001 per unit</span> — 50–80% cheaper than the
                            competition. Battle-tested API. Real human support 24/7.</p>
                        <div
                            class="mt-10 flex flex-col sm:flex-row items-center lg:items-start justify-center lg:justify-start gap-3">
                            <a class="group h-12 px-7 inline-flex items-center justify-center gap-2 rounded-[12px] text-sm font-bold bg-[#2563eb] text-[#ffffff] hover:bg-[#1d4ed8] hover:shadow-2xl hover:shadow-[#2563eb]/30 hover:-translate-y-0.5 transition-all"
                                href="{{ route('signup') }}">Start free<svg width="16" height="16"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="transition-transform group-hover:translate-x-0.5">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></a>
                            <a href="#pricing"
                                class="h-12 px-7 inline-flex items-center justify-center gap-2 rounded-[12px] text-sm font-semibold bg-white text-[#0F172A] hover:bg-[#f1f5f9] border border-[#e2e8f0] hover:border-[#CBD5E1] transition-all">View
                                pricing</a>
                        </div>
                        <div
                            class="mt-12 grid grid-cols-2 sm:grid-cols-4 gap-6 max-w-2xl mx-auto lg:mx-0 lg:max-w-none">
                            @php
                                $heroStats = [
                                    [
                                        ($totalOrders ?? 0) > 0 ? number_format($totalOrders) . '+' : '120M+',
                                        'Orders delivered',
                                    ],
                                    ['100K+', 'Resellers worldwide'],
                                    ['80+', 'Countries served'],
                                    ['99.99%', 'Uptime SLA'],
                                ];
                            @endphp
                            @foreach ($heroStats as $hs)
                                <div class="text-center">
                                    <p
                                        class="text-3xl md:text-4xl font-bold tabular-nums tracking-tight text-[#0F172A]">
                                        {{ $hs[0] }}</p>
                                    <p class="text-xs md:text-sm mt-1 text-[#64748B]">{{ $hs[1] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- sign-in card -->
                    <div class="relative order-1 lg:order-2 flex items-center justify-center py-4">
                        <div
                            class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_50%_50%,rgba(37,99,235,0.18),transparent_65%)] blur-2xl">
                        </div>
                        <div
                            class="absolute -top-2 left-4 sm:left-8 z-20 hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-[#dbeafe] shadow-md shadow-[#2563eb]/15 text-[11px] font-semibold text-[#1d4ed8] rotate-[-2deg] animate-float-slow">
                            <span class="size-1.5 rounded-full bg-[#2563eb] animate-pulse"></span>Free $5 credit on
                            signup
                        </div>
                        <div
                            class="absolute -bottom-2 right-2 sm:right-4 z-20 hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-[#e2e8f0] shadow-md text-[11px] font-semibold text-[#475569] rotate-[3deg] animate-float-slow [animation-delay:0.8s]">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-[#1d4ed8]">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>No credit card required
                        </div>
                        <form id="heroLoginForm" method="POST" action="{{ route('login.store') }}"
                            class="relative w-full max-w-[440px] rounded-[20px] bg-white border border-[#e2e8f0] shadow-[0_24px_48px_-16px_rgba(15,23,42,0.18)] p-7 sm:p-8">
                            @csrf
                            <div
                                class="absolute top-0 inset-x-0 h-1 rounded-t-[20px] bg-gradient-to-r from-[#2563eb] via-[#0ea5e9] to-[#1d4ed8]">
                            </div>
                            <div class="flex items-start justify-between mb-6">
                                <div>
                                    <h2 class="text-xl sm:text-2xl font-bold tracking-[-0.02em] text-[#0F172A]">Welcome
                                        back</h2>
                                    <p class="text-sm text-[#64748B] mt-1">Sign in to ship your next order</p>
                                </div><span
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#eff6ff] border border-[#dbeafe] text-[10px] font-bold uppercase tracking-[0.06em] text-[#1d4ed8]"><span
                                        class="size-1.5 rounded-full bg-[#2563eb] animate-pulse"></span>Live</span>
                            </div>
                            <a href="{{ route('login') }}"
                                class="w-full h-11 inline-flex items-center justify-center gap-2.5 rounded-[12px] bg-white border border-[#e2e8f0] text-sm font-semibold text-[#0F172A] hover:bg-[#f1f5f9] hover:border-[#CBD5E1] transition-all"><svg
                                    stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 48 48"
                                    height="18" width="18">
                                    <path fill="#FFC107"
                                        d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z">
                                    </path>
                                    <path fill="#FF3D00"
                                        d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z">
                                    </path>
                                    <path fill="#4CAF50"
                                        d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z">
                                    </path>
                                    <path fill="#1976D2"
                                        d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z">
                                    </path>
                                </svg>Continue with Google</a>
                            <div class="flex items-center gap-3 my-5">
                                <div class="flex-1 h-px bg-[#e2e8f0]"></div><span
                                    class="text-[10px] uppercase tracking-[0.16em] text-[#94A3B8] font-semibold">or</span>
                                <div class="flex-1 h-px bg-[#e2e8f0]"></div>
                            </div>
                            <label class="block mb-3.5"><span
                                    class="text-xs font-semibold text-[#475569] mb-1.5 block">Email or username</span>
                                <div class="relative"><svg width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                    </svg><input type="text" name="username" required
                                        placeholder="you@business.com"
                                        class="w-full h-11 pl-10 pr-3.5 text-sm rounded-[12px] bg-[#ffffff] border border-[#e2e8f0] text-[#0F172A] placeholder:text-[#94A3B8] focus:outline-none focus:border-[#2563eb] focus:ring-2 focus:ring-[#2563eb]/20 focus:bg-white transition-all">
                                </div>
                            </label>
                            <label class="block mb-2" x-data="{ show: false }">
                                <div class="flex items-center justify-between mb-1.5"><span
                                        class="text-xs font-semibold text-[#475569]">Password</span><a
                                        class="text-[11px] font-semibold text-[#1d4ed8] hover:text-[#1e40af]"
                                        href="{{ route('password.request') }}">Forgot?</a></div>
                                <div class="relative"><svg width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                                        <rect width="18" height="11" x="3" y="11" rx="2"
                                            ry="2"></rect>
                                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                    </svg><input :type="show ? 'text' : 'password'" name="password" required
                                        placeholder="••••••••"
                                        class="w-full h-11 pl-10 pr-10 text-sm rounded-[12px] bg-[#ffffff] border border-[#e2e8f0] text-[#0F172A] placeholder:text-[#94A3B8] focus:outline-none focus:border-[#2563eb] focus:ring-2 focus:ring-[#2563eb]/20 focus:bg-white transition-all"><button
                                        type="button" @click="show = !show" aria-label="Show password"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 p-1 rounded-md text-[#94A3B8] hover:text-[#475569] hover:bg-[#e2e8f0] transition-colors"><svg
                                            width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0">
                                            </path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg></button></div>
                            </label>
                            <label class="flex items-center gap-2 my-4 cursor-pointer select-none"><input
                                    type="checkbox" name="remember"
                                    class="size-4 rounded border-[#CBD5E1] text-[#2563eb] focus:ring-[#2563eb]/30 focus:ring-2 cursor-pointer accent-[#2563eb]"
                                    checked><span class="text-xs text-[#475569]">Remember me for 30 days</span></label>
                            <button type="submit"
                                class="group w-full h-12 inline-flex items-center justify-center gap-2 rounded-[12px] text-sm font-bold bg-[#2563eb] text-[#ffffff] hover:bg-[#1d4ed8] hover:shadow-xl hover:shadow-[#2563eb]/30 hover:-translate-y-0.5 transition-all">Sign
                                in<svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="transition-transform group-hover:translate-x-0.5">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></button>
                            <p class="mt-5 text-center text-xs text-[#64748B]">New to {{ getDomain() }}? <a
                                    class="font-semibold text-[#1d4ed8] hover:text-[#1e40af] hover:underline underline-offset-2"
                                    href="{{ route('signup') }}">Create your free account →</a></p>
                            <div
                                class="mt-5 pt-5 border-t border-[#e2e8f0] flex items-center justify-center gap-4 text-[10px] text-[#94A3B8]">
                                <span class="inline-flex items-center gap-1"><svg width="11" height="11"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="text-[#1d4ed8]">
                                        <path
                                            d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                        </path>
                                    </svg> SSL 256-bit</span><span
                                    class="size-1 rounded-full bg-[#CBD5E1]"></span><span
                                    class="inline-flex items-center gap-1"><svg width="11" height="11"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="text-[#1d4ed8]">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <path d="m9 12 2 2 4-4"></path>
                                    </svg> GDPR-ready</span><span
                                    class="size-1 rounded-full bg-[#CBD5E1]"></span><span>2FA</span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 animate-bounce"><svg width="20"
                    height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="text-[#94A3B8]">
                    <path d="m6 9 6 6 6-6"></path>
                </svg></div>
        </section>

        <!-- ===================== PLATFORM LOGOS ===================== -->
        <section class="py-16 bg-white border-y border-[#e2e8f0]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <p class="text-center text-xs uppercase tracking-[0.2em] text-[#94A3B8] mb-8 font-semibold">Powering
                    creators on 10+ platforms</p>
                @php
                    $brands = [
                        [
                            'Instagram',
                            '0 0 448 512',
                            '<path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path>',
                        ],
                        [
                            'TikTok',
                            '0 0 448 512',
                            '<path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"></path>',
                        ],
                        [
                            'YouTube',
                            '0 0 576 512',
                            '<path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"></path>',
                        ],
                        [
                            'Facebook',
                            '0 0 512 512',
                            '<path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"></path>',
                        ],
                        [
                            'Twitter / X',
                            '0 0 512 512',
                            '<path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path>',
                        ],
                        [
                            'Telegram',
                            '0 0 496 512',
                            '<path d="M248,8C111.033,8,0,119.033,0,256S111.033,504,248,504,496,392.967,496,256,384.967,8,248,8ZM362.952,176.66c-3.732,39.215-19.881,134.378-28.1,178.3-3.476,18.584-10.322,24.816-16.948,25.425-14.4,1.326-25.338-9.517-39.287-18.661-21.827-14.308-34.158-23.215-55.346-37.177-24.485-16.135-8.612-25,5.342-39.5,3.652-3.793,67.107-61.51,68.335-66.746.153-.655.3-3.1-1.154-4.384s-3.59-.849-5.135-.5q-3.283.746-104.608,69.142-14.845,10.194-26.894,9.934c-8.855-.191-25.888-5.006-38.551-9.123-15.531-5.048-27.875-7.717-26.8-16.291q.84-6.7,18.45-13.7,108.446-47.248,144.628-62.3c68.872-28.647,83.183-33.623,92.511-33.789,2.052-.034,6.639.474,9.61,2.885a10.452,10.452,0,0,1,3.53,6.716A43.765,43.765,0,0,1,362.952,176.66Z"></path>',
                        ],
                        [
                            'Discord',
                            '0 0 640 512',
                            '<path d="M524.531,69.836a1.5,1.5,0,0,0-.764-.7A485.065,485.065,0,0,0,404.081,32.03a1.816,1.816,0,0,0-1.923.91,337.461,337.461,0,0,0-14.9,30.6,447.848,447.848,0,0,0-134.426,0,309.541,309.541,0,0,0-15.135-30.6,1.89,1.89,0,0,0-1.924-.91A483.689,483.689,0,0,0,116.085,69.137a1.712,1.712,0,0,0-.788.676C39.068,183.651,18.186,294.69,28.43,404.354a2.016,2.016,0,0,0,.765,1.375A487.666,487.666,0,0,0,176.02,479.918a1.9,1.9,0,0,0,2.063-.676A348.2,348.2,0,0,0,208.12,430.4a1.86,1.86,0,0,0-1.019-2.588,321.173,321.173,0,0,1-45.868-21.853,1.885,1.885,0,0,1-.185-3.126c3.082-2.309,6.166-4.711,9.109-7.137a1.819,1.819,0,0,1,1.9-.256c96.229,43.917,200.41,43.917,295.5,0a1.812,1.812,0,0,1,1.924.233c2.944,2.426,6.027,4.851,9.132,7.16a1.884,1.884,0,0,1-.162,3.126,301.407,301.407,0,0,1-45.89,21.83,1.875,1.875,0,0,0-1,2.611,391.055,391.055,0,0,0,30.014,48.815,1.864,1.864,0,0,0,2.063.7A486.048,486.048,0,0,0,610.7,405.729a1.882,1.882,0,0,0,.765-1.352C623.729,277.594,590.933,167.465,524.531,69.836ZM222.491,337.58c-28.972,0-52.844-26.587-52.844-59.239S193.056,219.1,222.491,219.1c29.665,0,53.306,26.82,52.843,59.239C275.334,310.993,251.924,337.58,222.491,337.58Zm195.38,0c-28.971,0-52.843-26.587-52.843-59.239S388.437,219.1,417.871,219.1c29.667,0,53.307,26.82,52.844,59.239C470.715,310.993,447.538,337.58,417.871,337.58Z"></path>',
                        ],
                        [
                            'Twitch',
                            '0 0 512 512',
                            '<path d="M391.17,103.47H352.54v109.7h38.63ZM285,103H246.37V212.75H285ZM120.83,0,24.31,91.42V420.58H140.14V512l96.53-91.42h77.25L487.69,256V0ZM449.07,237.75l-77.22,73.12H294.61l-67.6,64v-64H140.14V36.58H449.07Z"></path>',
                        ],
                        [
                            'Spotify',
                            '0 0 496 512',
                            '<path d="M248 8C111.1 8 0 119.1 0 256s111.1 248 248 248 248-111.1 248-248S384.9 8 248 8zm100.7 364.9c-4.2 0-6.8-1.3-10.7-3.6-62.4-37.6-135-39.2-206.7-24.5-3.9 1-9 2.6-11.9 2.6-9.7 0-15.8-7.7-15.8-15.8 0-10.3 6.1-15.2 13.6-16.8 81.9-18.1 165.6-16.5 237 26.2 6.1 3.9 9.7 7.4 9.7 16.5s-7.1 15.4-15.2 15.4zm26.9-65.6c-5.2 0-8.7-2.3-12.3-4.2-62.5-37-155.7-51.9-238.6-29.4-4.8 1.3-7.4 2.6-11.9 2.6-10.7 0-19.4-8.7-19.4-19.4s5.2-17.8 15.5-20.7c27.8-7.8 56.2-13.6 97.8-13.6 64.9 0 127.6 16.1 177 45.5 8.1 4.8 11.3 11 11.3 19.7-.1 10.8-8.5 19.5-19.4 19.5zm31-76.2c-5.2 0-8.4-1.3-12.9-3.9-71.2-42.5-198.5-52.7-280.9-29.7-3.6 1-8.1 2.6-12.9 2.6-13.2 0-23.3-10.3-23.3-23.6 0-13.6 8.4-21.3 17.4-23.9 35.2-10.3 74.6-15.2 117.5-15.2 73 0 149.5 15.2 205.4 47.8 7.8 4.5 12.9 10.7 12.9 22.6 0 13.6-11 23.3-23.2 23.3z"></path>',
                        ],
                        [
                            'LinkedIn',
                            '0 0 448 512',
                            '<path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"></path>',
                        ],
                    ];
                @endphp
                <div class="grid grid-cols-5 md:grid-cols-10 gap-6 md:gap-8 items-center">
                    @foreach ($brands as $b)
                        <div title="{{ $b[0] }}"
                            class="flex items-center justify-center text-[#94A3B8] hover:text-[#0c1929] transition-colors">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                viewBox="{{ $b[1] }}" height="28"
                                width="28">{!! $b[2] !!}</svg>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ===================== LIVE FEED ===================== -->
        <section class="bg-[#0c1929] border-y border-[#1e3a8a] overflow-hidden relative">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_50%,rgba(37,99,235,0.18),transparent_50%)]">
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center gap-4">
                <div
                    class="shrink-0 flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/15 ring-1 ring-emerald-400/40 backdrop-blur">
                    <span class="relative flex size-2"><span
                            class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75 animate-ping"></span><span
                            class="relative inline-flex size-2 rounded-full bg-emerald-400"></span></span><span
                        class="text-[11px] font-bold uppercase tracking-[0.14em] text-emerald-300">Live feed</span>
                </div>
                <div class="flex-1 marquee">
                    <div class="marquee-track flex gap-8 text-[13px] text-white/85 whitespace-nowrap font-medium">
                        @php
                            $feed = [
                                ['🇻🇳', 'user***@gmail bought 5,000 Instagram followers', '12s'],
                                ['🇧🇷', 'carlos*** purchased 50,000 YouTube views', '28s'],
                                ['🇺🇸', 'grow***@biz topped up $500 USDT', '45s'],
                                ['🇮🇩', 'agency.id ordered 25,000 TikTok likes', '1m'],
                                ['🇮🇳', 'viralhub*** dispatched mass order (340 links)', '1m'],
                                ['🇹🇭', 'som*** subscribed to Reseller tier (-50%)', '2m'],
                                ['🇵🇭', 'manila.creator received refill on 8K followers', '2m'],
                                ['🇲🇾', 'ops*** integrated API webhook to n8n', '3m'],
                            ];
                        @endphp
                        @for ($i = 0; $i < 2; $i++)
                            @foreach ($feed as $fd)
                                <span class="inline-flex items-center gap-2 shrink-0"><span
                                        class="text-[15px]">{{ $fd[0] }}</span><span>{{ $fd[1] }}</span><span
                                        class="text-white/40 font-mono text-[11px]">· {{ $fd[2] }}
                                        ago</span><span class="text-[#0ea5e9]/40 mx-2">●</span></span>
                            @endforeach
                        @endfor
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== FEATURES (bento) ===================== -->
        <section id="features" class="py-24 md:py-32 bg-[#ffffff] relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#2563eb]/[0.06] rounded-full blur-[120px] pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[#0c1929]/[0.04] rounded-full blur-[120px] pointer-events-none">
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-16"><span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#eff6ff] border border-[#dbeafe] text-xs font-semibold text-[#1d4ed8] mb-4"><svg
                            width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z">
                            </path>
                            <path d="M20 3v4"></path>
                            <path d="M22 5h-4"></path>
                            <path d="M4 17v2"></path>
                            <path d="M5 18H3"></path>
                        </svg> Features</span>
                    <h2 class="text-3xl md:text-5xl font-bold tracking-[-0.03em] leading-tight text-[#0F172A]">
                        Everything you need to <span class="text-[#1d4ed8]">scale globally</span></h2>
                    <p class="mt-4 text-[#64748B]">Built by engineers. Tuned by marketers. One panel for solo creators
                        and 7-figure reseller operations alike.</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 auto-rows-[1fr]">
                    <!-- big bento card -->
                    <div style="background:linear-gradient(135deg, #eff6ff 0%, #FFFFFF 60%, #ffffff 100%)"
                        class="group relative md:col-span-2 md:row-span-2 p-8 lg:p-10 rounded-[20px] overflow-hidden border border-[#dbeafe] shadow-[0_4px_12px_-4px_rgba(37,99,235,0.15)] hover:shadow-[0_24px_48px_-16px_rgba(37,99,235,0.25)] transition-all">
                        <div class="absolute inset-0 opacity-50 pointer-events-none">
                            <div
                                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 size-[400px] rounded-full bg-[#2563eb]/[0.12] blur-3xl">
                            </div>
                        </div>
                        <div class="relative">
                            <div
                                class="size-14 rounded-[16px] bg-[#2563eb] flex items-center justify-center mb-6 shadow-xl shadow-[#2563eb]/30 group-hover:scale-110 group-hover:rotate-6 transition-all">
                                <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-[#ffffff]">
                                    <path
                                        d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-2xl md:text-3xl font-bold mb-3 tracking-[-0.02em] text-[#0F172A]">Lightning
                                dispatch</h3>
                            <p class="text-sm md:text-base text-[#475569] leading-relaxed max-w-md mb-6">Orders ship in
                                seconds via intelligent multi-provider routing. No manual queues. No bottlenecks. Ever.
                            </p>
                            <div
                                class="mt-8 inline-flex items-center gap-4 px-5 py-3.5 rounded-[16px] bg-white border border-[#e2e8f0] shadow-[0_1px_2px_0_rgba(15,23,42,0.04)]">
                                <div class="text-3xl md:text-4xl font-bold tabular-nums text-[#1d4ed8] tracking-tight">
                                    &lt;1.2s</div>
                                <div class="text-left border-l border-[#e2e8f0] pl-4">
                                    <p class="text-[11px] uppercase tracking-wider text-[#94A3B8] font-semibold">Avg.
                                        dispatch time</p>
                                    <p class="text-xs text-[#1d4ed8] font-semibold">↓ 78% vs industry</p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="absolute bottom-6 right-6 hidden lg:flex items-center gap-1 opacity-60 group-hover:opacity-100 transition-opacity">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-[#1d4ed8]"
                                style="animation:flowRight 1.5s 0s ease-in-out infinite">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-[#1d4ed8]"
                                style="animation:flowRight 1.5s 0.2s ease-in-out infinite">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-[#1d4ed8]"
                                style="animation:flowRight 1.5s 0.4s ease-in-out infinite">
                                <path d="M5 12h14"></path>
                                <path d="m12 5 7 7-7 7"></path>
                            </svg>
                        </div>
                    </div>

                    @php
                        $smallFeats = [
                            [
                                'Enterprise-grade security',
                                '256-bit SSL, isolated worker queues, zero password requests. Your credentials never leave your device.',
                                'navy',
                                '<path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"></path>',
                            ],
                            [
                                'Lowest prices on Earth',
                                'From $0.001 per unit. 50–80% cheaper than competing panels. Volume tiers cascade automatically — no negotiation.',
                                'blue',
                                '<polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline><polyline points="16 7 22 7 22 13"></polyline>',
                            ],
                            [
                                '24/7 multilingual support',
                                'Live agents + AI concierge in English, Vietnamese, Chinese, Indonesian, Thai. First response under 90 seconds.',
                                'navy',
                                '<path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"></path>',
                            ],
                            [
                                'Engineer-grade API',
                                'Drop-in compatible with Perfect Panel spec. REST + webhooks. Idempotent. Rate-limit-aware. Battle-tested at scale.',
                                'blue',
                                '<path d="m18 16 4-4-4-4"></path><path d="m6 8-4 4 4 4"></path><path d="m14.5 4-5 16"></path>',
                            ],
                            [
                                'Refill &amp; money-back guarantee',
                                'Auto-refill on eligible services. Partial deliveries refund automatically to your balance — never open a ticket.',
                                'navy',
                                '<path d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526"></path><circle cx="12" cy="8" r="6"></circle>',
                            ],
                        ];
                    @endphp
                    @foreach ($smallFeats as $sf)
                        <div
                            class="group relative p-6 rounded-[16px] bg-white border border-[#e2e8f0] shadow-[0_1px_2px_0_rgba(15,23,42,0.04)] hover:shadow-[0_8px_24px_-8px_rgba(15,23,42,0.12)] hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                            <div
                                class="absolute -top-12 -right-12 size-32 bg-[#2563eb]/0 group-hover:bg-[#2563eb]/[0.08] blur-2xl rounded-full transition-all duration-500">
                            </div>
                            <div class="relative">
                                @if ($sf[2] === 'navy')
                                    <div
                                        class="size-11 rounded-[12px] bg-[#E6F4F1] ring-1 ring-[#CDE6E0] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="text-[#0c1929]">{!! $sf[3] !!}</svg>
                                    </div>
                                @else
                                    <div
                                        class="size-11 rounded-[12px] bg-[#eff6ff] ring-1 ring-[#dbeafe] flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round"
                                            class="text-[#1d4ed8]">{!! $sf[3] !!}</svg>
                                    </div>
                                @endif
                                <h3 class="text-base font-semibold mb-1.5 text-[#0F172A]">{!! $sf[0] !!}</h3>
                                <p class="text-[13px] text-[#64748B] leading-relaxed">{{ $sf[1] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ===================== EVERY TEAM ===================== -->
        <section class="py-24 md:py-32 bg-white relative overflow-hidden border-y border-[#e2e8f0]">
            <div
                class="absolute -top-32 right-0 size-[500px] bg-[#2563eb]/[0.06] rounded-full blur-[120px] pointer-events-none">
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-14"><span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#eff6ff] border border-[#dbeafe] text-xs font-semibold text-[#1d4ed8] mb-4"><svg
                            width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg> Built for everyone</span>
                    <h2 class="text-3xl md:text-5xl font-bold tracking-[-0.03em] leading-tight text-[#0F172A]">One
                        platform. <span
                            class="bg-gradient-to-r from-[#2563eb] to-[#0ea5e9] bg-clip-text text-transparent">Every
                            team.</span></h2>
                    <p class="mt-4 text-[#64748B]">From solo creators to enterprise resellers — {{ getDomain() }}
                        scales with you.</p>
                </div>
                <div class="grid md:grid-cols-3 gap-5">
                    <!-- creators -->
                    <div
                        class="relative rounded-2xl border border-[#e2e8f0] bg-gradient-to-br from-[#eff6ff] to-white p-7 overflow-hidden hover:-translate-y-1 transition-transform duration-300">
                        <div class="relative">
                            <div
                                class="size-12 rounded-xl bg-gradient-to-br from-[#0ea5e9] to-[#2563eb] flex items-center justify-center text-white shadow-md shadow-[#2563eb]/30 mb-5">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z">
                                    </path>
                                </svg>
                            </div>
                            <span
                                class="inline-block text-[10px] font-mono uppercase tracking-[0.14em] text-[#2563eb] mb-2">Solo
                                creators</span>
                            <h3 class="text-xl md:text-2xl font-bold tracking-[-0.02em] text-[#0F172A] mb-3">For
                                creators</h3>
                            <p class="text-[14px] text-[#475569] leading-relaxed mb-5">Boost your post the moment it
                                goes live. Start at $0.10 per test, scale only when you see results.</p>
                            <ul class="space-y-2">
                                @foreach (['No minimum spend', 'Favorites for fast reorder', 'Mobile-first dashboard'] as $li)
                                    <li class="flex items-start gap-2 text-[13.5px] text-[#0F172A]"><svg
                                            width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="mt-0.5 shrink-0 text-[#2563eb]">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>{{ $li }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- agencies (dark) -->
                    <div
                        class="relative rounded-2xl border border-[#1e3a8a]/40 shadow-[0_30px_60px_-20px_rgba(37,99,235,0.55)] bg-gradient-to-br from-[#0c1929] via-[#1e3a8a] to-[#2563eb] text-white p-7 overflow-hidden hover:-translate-y-1 transition-transform duration-300">
                        <div class="absolute inset-0 opacity-[0.08]"
                            style="background-image:radial-gradient(circle at 20% 50%, white 1px, transparent 1px);background-size:28px 28px">
                        </div>
                        <div class="absolute -top-12 -right-12 size-44 bg-[#0ea5e9]/30 rounded-full blur-3xl"></div>
                        <div class="relative">
                            <div
                                class="size-12 rounded-xl bg-gradient-to-br from-[#2563eb] to-[#1e3a8a] flex items-center justify-center text-white shadow-lg ring-1 ring-white/15 mb-5">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                                    <rect width="20" height="14" x="2" y="6" rx="2"></rect>
                                </svg>
                            </div>
                            <span
                                class="inline-block text-[10px] font-mono uppercase tracking-[0.14em] text-[#0ea5e9] mb-2">Agencies</span>
                            <h3 class="text-xl md:text-2xl font-bold tracking-[-0.02em] text-white mb-3">For agencies
                            </h3>
                            <p class="text-[14px] text-white/80 leading-relaxed mb-5">Ship 10,000+ orders/month for 50+
                                client brands. Mass-CSV upload, batch tagging, white-label reports.</p>
                            <ul class="space-y-2">
                                @foreach (['Mass + CSV ordering', 'Per-client cost tracking', 'Webhooks → your CRM'] as $li)
                                    <li class="flex items-start gap-2 text-[13.5px] text-white"><svg width="15"
                                            height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="mt-0.5 shrink-0 text-[#0ea5e9]">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>{{ $li }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <!-- resellers -->
                    <div
                        class="relative rounded-2xl border border-[#e2e8f0] bg-gradient-to-br from-[#eff6ff] to-white p-7 overflow-hidden hover:-translate-y-1 transition-transform duration-300">
                        <div class="relative">
                            <div
                                class="size-12 rounded-xl bg-gradient-to-br from-[#1d4ed8] to-[#0ea5e9] flex items-center justify-center text-white shadow-md shadow-[#2563eb]/30 mb-5">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                                    <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                                    <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                                    <path d="M10 6h4"></path>
                                    <path d="M10 10h4"></path>
                                    <path d="M10 14h4"></path>
                                    <path d="M10 18h4"></path>
                                </svg>
                            </div>
                            <span
                                class="inline-block text-[10px] font-mono uppercase tracking-[0.14em] text-[#2563eb] mb-2">Resellers</span>
                            <h3 class="text-xl md:text-2xl font-bold tracking-[-0.02em] text-[#0F172A] mb-3">For
                                resellers</h3>
                            <p class="text-[14px] text-[#475569] leading-relaxed mb-5">Run your own panel? Plug into
                                our wholesale API and unlock 50% off. White-label endpoints, dedicated rep.</p>
                            <ul class="space-y-2">
                                @foreach (['Up to −50% wholesale', 'Drop-in PP API', 'Dedicated account manager'] as $li)
                                    <li class="flex items-start gap-2 text-[13.5px] text-[#0F172A]"><svg
                                            width="15" height="15" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="mt-0.5 shrink-0 text-[#2563eb]">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg>{{ $li }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== HOW IT WORKS ===================== -->
        <section id="how"
            class="py-24 md:py-32 bg-[#f8fafc] relative overflow-hidden border-b border-[#e2e8f0]">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_30%_50%,rgba(37,99,235,0.06),transparent_50%)]">
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-20"><span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#eff6ff] border border-[#dbeafe] text-xs font-semibold text-[#1d4ed8] mb-4"><svg
                            width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z">
                            </path>
                            <path
                                d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z">
                            </path>
                            <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"></path>
                            <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"></path>
                        </svg> How it works</span>
                    <h2 class="text-3xl md:text-5xl font-bold tracking-[-0.03em] leading-tight text-[#0F172A]">3 steps.
                        <span class="text-[#1d4ed8]">30 seconds.</span>
                    </h2>
                    <p class="mt-4 text-[#64748B]">From signup to your first order — no friction.</p>
                </div>
                <div class="relative">
                    <svg class="hidden md:block absolute top-9 left-[16%] right-[16%] w-[68%] h-24 pointer-events-none"
                        viewBox="0 0 800 100" fill="none" preserveAspectRatio="none">
                        <defs>
                            <linearGradient id="lineGrad" x1="0" y1="0" x2="800"
                                y2="0" gradientUnits="userSpaceOnUse">
                                <stop offset="0" stop-color="#2563eb"></stop>
                                <stop offset="0.5" stop-color="#1d4ed8"></stop>
                                <stop offset="1" stop-color="#2563eb"></stop>
                            </linearGradient>
                        </defs>
                        <path d="M 0 50 Q 200 0 400 50 T 800 50" stroke="url(#lineGrad)" stroke-width="2"
                            stroke-dasharray="6 6" opacity="0.5"></path>
                    </svg>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-6">
                        @php
                            $steps = [
                                [
                                    '01',
                                    'Sign up',
                                    'Create your free account in 30 seconds. No credit card required.',
                                    'check',
                                    'Email · Google · 2FA',
                                ],
                                [
                                    '02',
                                    'Top up',
                                    'Crypto, Bank, USDT, Binance Pay, PayPal — pick what fits your region.',
                                    'tags',
                                    '',
                                ],
                                [
                                    '03',
                                    'Place an order',
                                    'Pick a service, paste a link, set quantity. Orders start immediately.',
                                    'zap',
                                    'Avg. start: 1.2s',
                                ],
                            ];
                        @endphp
                        @foreach ($steps as $st)
                            <div class="relative flex flex-col items-center text-center">
                                <div class="relative size-[72px] mb-6">
                                    <div class="absolute inset-0 rounded-full bg-[#2563eb]/25 blur-xl animate-pulse">
                                    </div>
                                    <div class="relative size-[72px] rounded-full flex items-center justify-center text-2xl font-bold text-[#ffffff] shadow-lg shadow-[#2563eb]/30 ring-4 ring-[#2563eb]/15"
                                        style="background:linear-gradient(135deg, #0ea5e9 0%, #2563eb 50%, #1d4ed8 100%)">
                                        {{ $st[0] }}</div>
                                </div>
                                <div
                                    class="w-full p-6 rounded-[16px] bg-[#ffffff] border border-[#e2e8f0] hover:shadow-[0_8px_24px_-8px_rgba(15,23,42,0.10)] transition-all">
                                    <h3 class="text-xl font-semibold mb-2 text-[#0F172A]">{{ $st[1] }}</h3>
                                    <p class="text-sm text-[#64748B] leading-relaxed">{{ $st[2] }}</p>
                                    @if ($st[3] === 'tags')
                                        <div
                                            class="mt-4 flex flex-wrap items-center justify-center gap-1.5 text-[10px]">
                                            @foreach (['BTC', 'USDT', 'VND', 'PayPal'] as $tag)
                                                <span
                                                    class="px-2 py-0.5 rounded bg-white border border-[#e2e8f0] text-[#475569] font-mono">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                    @elseif ($st[3] === 'zap')
                                        <div
                                            class="mt-4 inline-flex items-center gap-1.5 text-[11px] text-[#1d4ed8] font-semibold tabular-nums">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path
                                                    d="M4 14a1 1 0 0 1-.78-1.63l9.9-10.2a.5.5 0 0 1 .86.46l-1.92 6.02A1 1 0 0 0 13 10h7a1 1 0 0 1 .78 1.63l-9.9 10.2a.5.5 0 0 1-.86-.46l1.92-6.02A1 1 0 0 0 11 14z">
                                                </path>
                                            </svg> {{ $st[4] }}
                                        </div>
                                    @else
                                        <div
                                            class="mt-4 inline-flex items-center gap-1.5 text-[11px] text-[#1d4ed8] font-semibold">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="m9 12 2 2 4-4"></path>
                                            </svg> {{ $st[4] }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== PRICING ===================== -->
        <section id="pricing" class="py-24 md:py-32 bg-[#ffffff] relative overflow-hidden">
            <div
                class="absolute top-1/3 -right-32 w-[500px] h-[500px] bg-[#2563eb]/[0.06] rounded-full blur-[120px] pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 -left-32 w-[400px] h-[400px] bg-[#0c1929]/[0.04] rounded-full blur-[120px] pointer-events-none">
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-12"><span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#eff6ff] border border-[#dbeafe] text-xs font-semibold text-[#1d4ed8] mb-4"><svg
                            width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                            <polyline points="16 7 22 7 22 13"></polyline>
                        </svg> Pricing</span>
                    <h2 class="text-3xl md:text-5xl font-bold tracking-[-0.03em] leading-tight text-[#0F172A]">Volume
                        pricing that <span class="text-[#1d4ed8]">scales with you</span></h2>
                    <p class="mt-4 text-[#64748B]">Three tiers. No subscriptions. No hidden fees. Pay only for what you
                        ship.</p>
                </div>
                <div class="max-w-4xl mx-auto mb-12 flex flex-wrap items-center justify-center gap-3">
                    @foreach (['30-day money-back', 'No credit card to start', 'Auto volume discount', 'Refill guarantee'] as $pf)
                        <span
                            class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-[#e2e8f0] text-xs font-medium text-[#475569] shadow-[0_1px_2px_0_rgba(15,23,42,0.03)]"><svg
                                width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-[#1d4ed8]">
                                <circle cx="12" cy="12" r="10"></circle>
                                <path d="m9 12 2 2 4-4"></path>
                            </svg>{{ $pf }}</span>
                    @endforeach
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 max-w-6xl mx-auto items-stretch pt-6">
                    @php
                        $plans = [
                            [
                                'emoji' => '👤',
                                'tag' => 'Solo',
                                'name' => 'Starter',
                                'for' => 'For individual creators',
                                'price' => '$0',
                                'note' => 'Forever free, no card required',
                                'noteColor' => '#94A3B8',
                                'cta' => 'Start free',
                                'ctaHref' => route('signup'),
                                'sub' => 'No commitment · cancel anytime',
                                'featured' => false,
                                'feats' => ['500+ services', 'Standard pricing', 'Email support'],
                            ],
                            [
                                'emoji' => '🚀',
                                'tag' => 'Agency',
                                'name' => 'Pro',
                                'for' => 'For agencies & power users',
                                'price' => '−15%',
                                'note' => '↓ Save up to $300/mo on volume',
                                'noteColor' => '#1d4ed8',
                                'cta' => 'Upgrade to Pro',
                                'ctaHref' => route('signup'),
                                'sub' => 'Auto-applies after $50 monthly volume',
                                'featured' => true,
                                'feats' => ['15% off every order', 'Priority refill', 'Telegram support'],
                            ],
                            [
                                'emoji' => '🏢',
                                'tag' => 'Wholesale',
                                'name' => 'Reseller',
                                'for' => 'For panel resellers & wholesalers',
                                'price' => '−50%',
                                'note' => '↓ Save up to $2,500/mo on volume',
                                'noteColor' => '#1d4ed8',
                                'cta' => 'Talk to sales',
                                'ctaHref' => route('signup'),
                                'sub' => 'Custom contract · dedicated support',
                                'featured' => false,
                                'feats' => ['Up to 50% off', 'Full API + webhooks', 'Dedicated account manager'],
                            ],
                        ];
                    @endphp
                    @foreach ($plans as $pl)
                        @if ($pl['featured'])
                            <div
                                class="group relative rounded-[20px] transition-all hover:-translate-y-2 shadow-[0_24px_48px_-12px_rgba(37,99,235,0.30)] md:scale-105 ring-2 ring-[#2563eb]">
                                <div class="absolute inset-0 rounded-[inherit] overflow-hidden bg-white">
                                    <div
                                        class="absolute -top-24 -right-24 size-56 bg-[#2563eb]/15 rounded-full blur-3xl">
                                    </div>
                                    <div
                                        class="absolute -bottom-24 -left-24 size-48 bg-[#0ea5e9]/10 rounded-full blur-3xl">
                                    </div>
                                    <div class="absolute inset-0 opacity-60"
                                        style="background:linear-gradient(180deg, rgba(236,253,245,0.6) 0%, rgba(255,255,255,1) 100%)">
                                    </div>
                                </div>
                                <span
                                    class="absolute -top-4 left-1/2 -translate-x-1/2 z-10 inline-flex items-center gap-1.5 px-4 py-2 text-[11px] font-bold uppercase tracking-[0.08em] rounded-full bg-[#2563eb] text-[#ffffff] shadow-xl shadow-[#2563eb]/40 whitespace-nowrap ring-2 ring-[#ffffff]"><svg
                                        width="11" height="11" viewBox="0 0 24 24" fill="currentColor"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                                        </path>
                                    </svg> Most popular</span>
                                <div class="relative p-7 lg:p-8"><span
                                        class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.08em] px-2.5 py-1 rounded-md mb-3 bg-[#2563eb] text-[#ffffff]"><span>{{ $pl['emoji'] }}</span>{{ $pl['tag'] }}</span>
                                    <h3 class="text-2xl font-bold tracking-[-0.02em] text-[#0F172A]">
                                        {{ $pl['name'] }}</h3>
                                    <p class="text-sm mt-1 text-[#64748B]">{{ $pl['for'] }}</p>
                                    <div class="mt-7 mb-2">
                                        <p
                                            class="text-6xl lg:text-[64px] font-bold tracking-[-0.04em] leading-none tabular-nums text-[#0F172A]">
                                            {{ $pl['price'] }}</p>
                                        <p class="mt-2 text-xs font-medium" style="color:{{ $pl['noteColor'] }}">
                                            {{ $pl['note'] }}</p>
                                    </div>
                                    <div
                                        class="h-px my-6 bg-gradient-to-r from-transparent via-[#e2e8f0] to-transparent">
                                    </div>
                                    <ul class="space-y-3.5 text-sm">
                                        @foreach ($pl['feats'] as $ft)
                                            <li class="flex items-center gap-3 text-[#1E293B]">
                                                <div
                                                    class="size-5 rounded-md flex items-center justify-center shrink-0 bg-[#eff6ff] ring-1 ring-[#dbeafe]">
                                                    <svg width="12" height="12" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="text-[#1d4ed8]">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <path d="m9 12 2 2 4-4"></path>
                                                    </svg>
                                                </div>{{ $ft }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a class="mt-8 h-12 w-full inline-flex items-center justify-center gap-1.5 rounded-[12px] text-sm font-bold transition-all bg-[#2563eb] text-[#ffffff] hover:bg-[#1d4ed8] hover:-translate-y-0.5 shadow-md shadow-[#2563eb]/25"
                                        href="{{ $pl['ctaHref'] }}">{{ $pl['cta'] }} <svg width="14"
                                            height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="m12 5 7 7-7 7"></path>
                                        </svg></a>
                                    <p class="mt-4 text-center text-[11px] text-[#94A3B8]">{{ $pl['sub'] }}</p>
                                </div>
                            </div>
                        @else
                            <div
                                class="group relative rounded-[20px] transition-all hover:-translate-y-2 shadow-[0_1px_3px_0_rgba(15,23,42,0.06)] hover:shadow-[0_12px_24px_-8px_rgba(15,23,42,0.12)] ring-1 ring-[#e2e8f0]">
                                <div class="absolute inset-0 rounded-[inherit] overflow-hidden bg-white"></div>
                                <div class="relative p-7 lg:p-8"><span
                                        class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-[0.08em] px-2.5 py-1 rounded-md mb-3 bg-[#ffffff] text-[#475569] border border-[#e2e8f0]"><span>{{ $pl['emoji'] }}</span>{{ $pl['tag'] }}</span>
                                    <h3 class="text-2xl font-bold tracking-[-0.02em] text-[#0F172A]">
                                        {{ $pl['name'] }}</h3>
                                    <p class="text-sm mt-1 text-[#64748B]">{{ $pl['for'] }}</p>
                                    <div class="mt-7 mb-2">
                                        <p
                                            class="text-6xl lg:text-[64px] font-bold tracking-[-0.04em] leading-none tabular-nums text-[#0F172A]">
                                            {{ $pl['price'] }}</p>
                                        <p class="mt-2 text-xs font-medium" style="color:{{ $pl['noteColor'] }}">
                                            {{ $pl['note'] }}</p>
                                    </div>
                                    <div
                                        class="h-px my-6 bg-gradient-to-r from-transparent via-[#e2e8f0] to-transparent">
                                    </div>
                                    <ul class="space-y-3.5 text-sm">
                                        @foreach ($pl['feats'] as $ft)
                                            <li class="flex items-center gap-3 text-[#1E293B]">
                                                <div
                                                    class="size-5 rounded-md flex items-center justify-center shrink-0 bg-[#eff6ff] ring-1 ring-[#dbeafe]">
                                                    <svg width="12" height="12" viewBox="0 0 24 24"
                                                        fill="none" stroke="currentColor" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="text-[#1d4ed8]">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <path d="m9 12 2 2 4-4"></path>
                                                    </svg>
                                                </div>{{ $ft }}
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a class="mt-8 h-12 w-full inline-flex items-center justify-center gap-1.5 rounded-[12px] text-sm font-bold transition-all bg-[#ffffff] text-[#0F172A] hover:bg-[#e2e8f0] border border-[#e2e8f0] hover:-translate-y-0.5"
                                        href="{{ $pl['ctaHref'] }}">{{ $pl['cta'] }} <svg width="14"
                                            height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="m12 5 7 7-7 7"></path>
                                        </svg></a>
                                    <p class="mt-4 text-center text-[11px] text-[#94A3B8]">{{ $pl['sub'] }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="mt-14 max-w-3xl mx-auto text-center">
                    <p class="text-xs uppercase tracking-[0.2em] text-[#94A3B8] mb-5 font-semibold">All plans accept
                        payments via</p>
                    <div class="flex flex-wrap items-center justify-center gap-2.5">
                        @foreach (['Visa', 'Mastercard', 'PayPal', 'Bitcoin', 'USDT', 'Binance Pay', 'Bank transfer', 'MoMo'] as $pm)
                            <span
                                class="px-3 py-1.5 rounded-[10px] text-[11px] font-semibold text-[#1E293B] bg-white border border-[#e2e8f0] shadow-[0_1px_2px_0_rgba(15,23,42,0.04)] hover:border-[#2563eb]/40 hover:shadow-md transition-all">{{ $pm }}</span>
                        @endforeach
                    </div>
                    <p class="mt-6 text-xs text-[#64748B]">Need a custom plan? <a
                            class="text-[#1d4ed8] hover:text-[#1e40af] font-semibold underline-offset-2 hover:underline"
                            href="{{ route('signup') }}">Talk to sales →</a></p>
                </div>
            </div>
        </section>

        <!-- ===================== COMPARISON ===================== -->
        <section id="api"
            class="py-24 md:py-32 bg-[#f8fafc] border-y border-[#e2e8f0] relative overflow-hidden">
            <div
                class="absolute -top-20 left-1/2 -translate-x-1/2 size-[600px] bg-[#2563eb]/5 rounded-full blur-[120px] pointer-events-none">
            </div>
            <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-12"><span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#eff6ff] border border-[#dbeafe] text-xs font-semibold text-[#1d4ed8] mb-4"><svg
                            width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2">
                            </path>
                        </svg> The receipts</span>
                    <h2 class="text-3xl md:text-5xl font-bold tracking-[-0.03em] leading-tight text-[#0F172A]">Why
                        marketers switch to <span
                            class="bg-gradient-to-r from-[#2563eb] to-[#0ea5e9] bg-clip-text text-transparent">{{ getDomain() }}</span>.
                    </h2>
                    <p class="mt-4 text-[#64748B]">Same providers. Better software. Honest pricing. See the difference.
                    </p>
                </div>
                <div
                    class="rounded-2xl bg-white border border-[#e2e8f0] shadow-[0_24px_48px_-24px_rgba(15,23,42,0.10)] overflow-hidden">
                    <div class="grid grid-cols-[1.4fr_1fr_1fr] text-[12.5px] sm:text-[13.5px]">
                        <div
                            class="px-5 py-4 bg-[#f8fafc] border-b border-[#e2e8f0] text-[11px] uppercase tracking-[0.12em] font-semibold text-[#94A3B8]">
                            Feature</div>
                        <div
                            class="px-5 py-4 bg-gradient-to-br from-[#2563eb] to-[#1d4ed8] text-white border-b border-[#1e3a8a] flex items-center gap-2 font-bold">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="text-[#67e8f9]">
                                <path
                                    d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z">
                                </path>
                            </svg>{{ getDomain() }}
                        </div>
                        <div class="px-5 py-4 bg-[#f8fafc] border-b border-[#e2e8f0] font-semibold text-[#475569]">
                            Typical SMM Panel</div>
                        @php
                            $cmp = [
                                ['Minimum unit price', '$0.001', '$0.005 – $0.02'],
                                ['Order dispatch speed', 'Under 800 ms', '30s – 2 min'],
                                ['API access', 'Free, all tiers', 'Paid add-on'],
                                ['Webhook delivery', 'HMAC-signed, retries', 'Manual polling'],
                                ['Auto refill on drops', 'Yes — up to 365 days', 'Manual ticket'],
                                ['Mass + CSV ordering', 'Built-in', 'Not supported'],
                                ['Volume tier discounts', 'Auto-applied', 'Manual negotiation'],
                                ['Multilingual support', '5 languages, 24/7', 'English, business hours'],
                                ['Uptime SLA', '99.99%', '≤ 99%'],
                                ['Crypto payments', 'USDT · BTC · ETH · BNB', 'Limited / none'],
                                ['Partial refund automation', 'Auto-credit to balance', 'Manual review'],
                                ['GDPR + CCPA compliant', 'Yes', 'Often missing'],
                            ];
                        @endphp
                        @foreach ($cmp as $i => $row)
                            @php $alt = $i % 2 === 1; @endphp
                            <div class="contents">
                                <div
                                    class="px-5 py-3.5 text-[#0F172A] font-medium border-b border-[#e2e8f0] {{ $alt ? 'bg-[#f8fafc]' : '' }}">
                                    {{ $row[0] }}</div>
                                <div
                                    class="px-5 py-3.5 border-b border-[#dbeafe] flex items-center gap-2 bg-[#eff6ff]/50">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="3" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-[#1d4ed8] shrink-0">
                                        <path d="M20 6 9 17l-5-5"></path>
                                    </svg><span class="font-bold text-[#0F172A]">{{ $row[1] }}</span>
                                </div>
                                <div
                                    class="px-5 py-3.5 border-b border-[#e2e8f0] flex items-center gap-2 text-[#64748B] {{ $alt ? 'bg-[#f8fafc]' : '' }}">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-[#94A3B8] shrink-0">
                                        <path d="M5 12h14"></path>
                                    </svg>{{ $row[2] }}
                                </div>
                            </div>
                        @endforeach
                        <div class="px-5 py-5 bg-[#f8fafc] text-[12px] text-[#64748B]">Numbers based on top-5 panel
                            competitors as of Q2 2026.</div>
                        <div class="px-5 py-5 bg-gradient-to-br from-[#2563eb] to-[#1d4ed8]"><a
                                class="inline-flex items-center gap-1.5 h-9 px-4 rounded-[10px] bg-white text-[#0F172A] text-[12.5px] font-bold hover:shadow-lg transition-all"
                                href="{{ route('signup') }}">Try {{ getDomain() }} free <svg width="13"
                                    height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="m12 5 7 7-7 7"></path>
                                </svg></a></div>
                        <div class="px-5 py-5 bg-[#f8fafc] text-[12px] text-[#94A3B8] italic">Stuck on a slow panel?
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== TESTIMONIALS ===================== -->
        <section class="py-24 md:py-32 bg-white border-b border-[#e2e8f0] relative overflow-hidden">
            <div
                class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 size-[600px] bg-[#2563eb]/5 rounded-full blur-[120px] pointer-events-none">
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl mx-auto text-center mb-14"><span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#FEF3C7] border border-[#FDE68A] text-xs font-semibold text-[#92400E] mb-4"><svg
                            width="12" height="12" viewBox="0 0 24 24" fill="currentColor"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z">
                            </path>
                        </svg> Customer love</span>
                    <h2 class="text-3xl md:text-5xl font-bold tracking-[-0.03em] leading-tight text-[#0F172A]">Trusted
                        by <span class="text-[#1d4ed8]">growth teams</span> worldwide</h2>
                </div>
                @php
                    $star =
                        '<svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"></path></svg>';
                    $tms = [
                        [
                            'Most reliable panel I\'ve worked with. API never flakes, support answers in minutes, 3–5× cheaper than my previous wholesaler.',
                            'Marcus Halverson',
                            '🇺🇸',
                            'CEO · GrowthLabs',
                            '40K orders/mo',
                            'M',
                            'from-[#2563eb] to-[#1d4ed8]',
                        ],
                        [
                            'We migrated our entire reseller stack here in 48 hours. Volume tier auto-applied — saved us $4,200 in the first month alone.',
                            'Priya Sharma',
                            '🇮🇳',
                            'Founder · ViralLab',
                            '120K orders/mo',
                            'P',
                            'from-[#0c1929] to-[#1e40af]',
                        ],
                        [
                            'Refill guarantee actually works. Partial deliveries auto-credit back without us opening a single ticket. Saves hours/week.',
                            'Carlos Mendes',
                            '🇧🇷',
                            'Ops Lead · Engaja+',
                            '8.5K orders/mo',
                            'C',
                            'from-[#0ea5e9] to-[#1d4ed8]',
                        ],
                    ];
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    @foreach ($tms as $t)
                        <div
                            class="group relative p-7 rounded-[16px] bg-[#ffffff] border border-[#e2e8f0] hover:border-[#2563eb]/30 hover:shadow-[0_12px_24px_-8px_rgba(15,23,42,0.12)] hover:-translate-y-1 transition-all">
                            <div class="flex gap-1 mb-4 text-[#F59E0B]">{!! str_repeat($star, 5) !!}</div>
                            <blockquote class="text-[15px] font-medium leading-relaxed text-[#1E293B] mb-6">
                                “{{ $t[0] }}”</blockquote>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-gradient-to-br {{ $t[6] }} flex items-center justify-center font-bold text-sm text-[#F1F5F9] shadow-lg">
                                        {{ $t[5] }}</div>
                                    <div>
                                        <p class="text-sm font-semibold flex items-center gap-1.5 text-[#0F172A]">
                                            {{ $t[1] }} <span class="text-base">{{ $t[2] }}</span>
                                        </p>
                                        <p class="text-[11px] text-[#64748B]">{{ $t[3] }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] uppercase tracking-wider text-[#94A3B8]">Volume</p>
                                    <p class="text-xs font-bold tabular-nums text-[#1d4ed8]">{{ $t[4] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- ===================== FAQ ===================== -->
        <section id="faq"
            class="py-24 md:py-32 bg-[#f8fafc] border-b border-[#e2e8f0] relative overflow-hidden">
            <div
                class="absolute -top-32 left-0 size-[500px] bg-[#0ea5e9]/5 rounded-full blur-[120px] pointer-events-none">
            </div>
            <div
                class="absolute -bottom-32 right-0 size-[500px] bg-[#2563eb]/[0.06] rounded-full blur-[120px] pointer-events-none">
            </div>
            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12"><span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#eff6ff] border border-[#dbeafe] text-xs font-semibold text-[#1d4ed8] mb-4"><svg
                            width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <path d="M12 17h.01"></path>
                        </svg> Questions, answered</span>
                    <h2 class="text-3xl md:text-5xl font-bold tracking-[-0.03em] leading-tight text-[#0F172A]">
                        Everything you need to know.</h2>
                    <p class="mt-4 text-[#64748B]">Quick answers to the most common questions. <a
                            class="text-[#2563eb] font-semibold hover:underline" href="#faq">See all 20+ →</a></p>
                </div>
                <div class="space-y-2.5">
                    @php
                        $faqs = [
                            [
                                'Will my Instagram / TikTok account get banned?',
                                'No. We use high-quality, drip-feed-capable providers that mimic organic engagement. We\'ve delivered 120M+ orders with zero confirmed permanent bans.',
                            ],
                            [
                                'How fast does an order actually start?',
                                'Average dispatch is under 800 ms. Instagram followers typically begin within 1–5 minutes, YouTube views within 10–30 minutes.',
                            ],
                            [
                                'What if my order isn\'t fully delivered?',
                                'Partial deliveries auto-credit the undelivered portion back to your balance — no ticket needed. Refill-enabled services auto-replace drops for up to 365 days.',
                            ],
                            [
                                'Do you have a developer API?',
                                'Yes — drop-in Perfect Panel compatible REST API. Free on all tiers. HMAC-signed webhooks. SDKs in Python, Node.js, PHP, Go. Migrate from any compatible panel in minutes.',
                            ],
                            [
                                'What\'s the minimum deposit?',
                                '$5 — kept low so you can test the platform before committing larger budgets. Crypto credits in 2–3 confirmations, cards instant, bank transfer same-day.',
                            ],
                        ];
                    @endphp
                    @foreach ($faqs as $i => $fq)
                        <details
                            class="group rounded-xl border border-[#e2e8f0] bg-white hover:border-[#2563eb]/30 hover:shadow-[0_8px_24px_-12px_rgba(37,99,235,0.18)] transition-all open:border-[#2563eb]/40 open:shadow-[0_12px_28px_-12px_rgba(37,99,235,0.22)]"
                            {{ $i === 0 ? 'open' : '' }}>
                            <summary
                                class="flex items-center justify-between gap-3 px-5 py-4 cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                                <span
                                    class="text-[14.5px] font-semibold text-[#0F172A] leading-snug">{{ $fq[0] }}</span><svg
                                    width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="shrink-0 text-[#64748B] transition-transform group-open:rotate-180 group-open:text-[#2563eb]">
                                    <path d="m6 9 6 6 6-6"></path>
                                </svg>
                            </summary>
                            <div class="px-5 pb-5 -mt-1">
                                <p class="text-[13.5px] text-[#475569] leading-relaxed">{{ $fq[1] }}</p>
                            </div>
                        </details>
                    @endforeach
                </div>
                <div class="mt-10 text-center"><a
                        class="inline-flex items-center gap-2 h-11 px-6 rounded-xl bg-white border border-[#e2e8f0] text-[#0F172A] font-semibold text-[13.5px] hover:bg-[#eff6ff] hover:border-[#2563eb]/40 transition-all"
                        href="#faq">View full FAQ <svg width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M5 12h14"></path>
                            <path d="m12 5 7 7-7 7"></path>
                        </svg></a></div>
            </div>
        </section>

        <!-- ===================== CTA ===================== -->
        <section class="py-24 md:py-32 bg-[#ffffff]">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="relative overflow-hidden rounded-[24px] p-10 md:p-16 lg:p-20 border border-[#dbeafe] shadow-[0_24px_48px_-16px_rgba(37,99,235,0.20)]"
                    style="background:linear-gradient(135deg, #eff6ff 0%, #FFFFFF 50%, #ffffff 100%)">
                    <div class="absolute inset-0 opacity-25"
                        style="background-image:radial-gradient(circle at 30% 50%, #2563eb 1px, transparent 1px);background-size:24px 24px">
                    </div>
                    <div
                        class="absolute -top-32 -right-32 size-96 bg-[#2563eb]/15 rounded-full blur-3xl animate-pulse-slow">
                    </div>
                    <div class="absolute -bottom-32 -left-32 size-96 bg-[#0ea5e9]/12 rounded-full blur-3xl"></div>
                    <div class="absolute top-6 right-8 hidden lg:block animate-float-slow">
                        <div
                            class="px-3 py-1.5 rounded-full bg-white border border-[#dbeafe] text-[11px] font-semibold text-[#0F172A] flex items-center gap-1.5 shadow-sm">
                            <span class="size-1.5 rounded-full bg-[#2563eb] animate-pulse"></span>Free forever
                        </div>
                    </div>
                    <div class="absolute bottom-8 right-12 hidden lg:block animate-float-slow [animation-delay:1.2s]">
                        <div
                            class="px-3 py-1.5 rounded-full bg-white border border-[#dbeafe] text-[11px] font-semibold text-[#0F172A] shadow-sm">
                            ⚡ Setup in 30s</div>
                    </div>
                    <div class="absolute top-1/2 left-6 hidden xl:block animate-float-slow [animation-delay:0.6s]">
                        <div
                            class="px-3 py-1.5 rounded-full bg-white border border-[#dbeafe] text-[11px] font-semibold text-[#0F172A] shadow-sm">
                            💳 No card required</div>
                    </div>
                    <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div class="text-center lg:text-left">
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-[#dbeafe] text-[11px] font-semibold text-[#1d4ed8] mb-5 shadow-sm">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M9.937 15.5A2 2 0 0 0 8.5 14.063l-6.135-1.582a.5.5 0 0 1 0-.962L8.5 9.936A2 2 0 0 0 9.937 8.5l1.582-6.135a.5.5 0 0 1 .963 0L14.063 8.5A2 2 0 0 0 15.5 9.937l6.135 1.581a.5.5 0 0 1 0 .964L15.5 14.063a2 2 0 0 0-1.437 1.437l-1.582 6.135a.5.5 0 0 1-.963 0z">
                                    </path>
                                    <path d="M20 3v4"></path>
                                    <path d="M22 5h-4"></path>
                                    <path d="M4 17v2"></path>
                                    <path d="M5 18H3"></path>
                                </svg> Limited bonus · $5 free credit on signup
                            </div>
                            <h2
                                class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-[-0.03em] leading-[1.05] text-[#0F172A]">
                                Ready to <span class="text-[#1d4ed8]">scale globally</span>?</h2>
                            <p
                                class="mt-5 text-base md:text-lg text-[#475569] max-w-lg mx-auto lg:mx-0 leading-relaxed">
                                Join <span class="font-semibold text-[#0F172A]">100,000+</span> creators and resellers
                                shipping with {{ getDomain() }}. Free forever. No credit card required.</p>
                            <div
                                class="mt-8 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3">
                                <a class="group h-12 px-7 inline-flex items-center justify-center gap-2 rounded-[12px] text-sm font-bold bg-[#2563eb] text-[#ffffff] hover:bg-[#1d4ed8] hover:shadow-2xl hover:shadow-[#2563eb]/30 hover:-translate-y-0.5 transition-all"
                                    href="{{ route('signup') }}">Create free account<svg width="16"
                                        height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="transition-transform group-hover:translate-x-0.5">
                                        <path d="M5 12h14"></path>
                                        <path d="m12 5 7 7-7 7"></path>
                                    </svg></a>
                                <a class="h-12 px-7 inline-flex items-center justify-center gap-2 rounded-[12px] text-sm font-semibold text-[#0F172A] bg-white hover:bg-[#f1f5f9] border border-[#e2e8f0] hover:border-[#CBD5E1] transition-all"
                                    href="{{ route('clients.api.index') }}"><svg width="16" height="16"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="m18 16 4-4-4-4"></path>
                                        <path d="m6 8-4 4 4 4"></path>
                                        <path d="m14.5 4-5 16"></path>
                                    </svg> Explore the API</a>
                            </div>
                            <div
                                class="mt-7 flex flex-wrap items-center justify-center lg:justify-start gap-x-5 gap-y-2 text-[12px] text-[#64748B]">
                                @foreach (['30-day refund', 'Cancel anytime', '99.99% uptime'] as $cf)
                                    <span class="inline-flex items-center gap-1.5"><svg width="13" height="13"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="text-[#1d4ed8]">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <path d="m9 12 2 2 4-4"></path>
                                        </svg> {{ $cf }}</span>
                                @endforeach
                            </div>
                        </div>
                        <!-- order card -->
                        <div class="hidden lg:block relative">
                            <div
                                class="relative rounded-[20px] bg-white border border-[#e2e8f0] p-6 shadow-2xl shadow-[#0F172A]/12 rotate-[2deg] hover:rotate-0 transition-transform duration-500">
                                <div class="flex items-center justify-between mb-5">
                                    <div class="flex items-center gap-2.5">
                                        <div
                                            class="size-8 rounded-[10px] bg-gradient-to-br from-[#E1306C] to-[#F77737] flex items-center justify-center">
                                            <svg stroke="currentColor" fill="currentColor" stroke-width="0"
                                                viewBox="0 0 448 512" class="text-white" height="14"
                                                width="14">
                                                <path
                                                    d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-[#64748B]">Order #14829</p>
                                            <p class="text-sm font-semibold text-[#0F172A]">Instagram followers</p>
                                        </div>
                                    </div><span
                                        class="inline-flex items-center gap-1 px-2 py-0.5 text-[9px] font-bold uppercase rounded-full bg-[#dbeafe] text-[#1e40af]"><span
                                            class="size-1 rounded-full bg-[#1e40af]"></span>Completed</span>
                                </div>
                                <div class="space-y-2 mb-4">
                                    <div class="flex justify-between text-[11px]"><span
                                            class="text-[#64748B]">Delivered</span><span
                                            class="text-[#1e40af] font-bold tabular-nums">10,000 / 10,000</span></div>
                                    <div class="h-2 rounded-full bg-[#F3F4F6] overflow-hidden">
                                        <div
                                            class="h-full w-full bg-gradient-to-r from-[#2563eb] to-[#0ea5e9] rounded-full">
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-3 gap-2 pt-4 border-t border-[#e2e8f0]">
                                    <div>
                                        <p class="text-[9px] uppercase tracking-wider text-[#94A3B8]">Cost</p>
                                        <p class="text-sm font-bold tabular-nums text-[#0F172A]">$8.50</p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] uppercase tracking-wider text-[#94A3B8]">Speed</p>
                                        <p class="text-sm font-bold tabular-nums text-[#1d4ed8]">2.3K/h</p>
                                    </div>
                                    <div>
                                        <p class="text-[9px] uppercase tracking-wider text-[#94A3B8]">ETA</p>
                                        <p class="text-sm font-bold tabular-nums text-[#1d4ed8]">4h 22m</p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="absolute -top-3 -left-4 px-3 py-2 rounded-[12px] bg-[#2563eb] text-[#ffffff] text-xs font-bold shadow-2xl rotate-[-3deg] flex items-center gap-2">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="m9 12 2 2 4-4"></path>
                                </svg> Order completed
                            </div>
                            <div
                                class="absolute -bottom-4 -right-4 px-3 py-2 rounded-[12px] bg-white border border-[#e2e8f0] shadow-2xl rotate-[4deg] flex items-center gap-2">
                                <div class="size-7 rounded-[8px] bg-[#2563eb] flex items-center justify-center"><svg
                                        width="13" height="13" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-[#ffffff]">
                                        <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"></polyline>
                                        <polyline points="16 7 22 7 22 13"></polyline>
                                    </svg></div>
                                <div>
                                    <p class="text-[10px] uppercase tracking-wider text-[#94A3B8] leading-none">+
                                        Growth</p>
                                    <p class="text-xs font-bold text-[#0F172A] tabular-nums leading-tight">+10K
                                        followers</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== FOOTER ===================== -->
        <footer class="bg-white border-t border-[#e2e8f0] relative overflow-hidden">
            <div
                class="absolute -top-40 left-1/2 -translate-x-1/2 size-[800px] bg-[#2563eb]/5 rounded-full blur-[120px] pointer-events-none">
            </div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-10">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 mb-12 pb-12 border-b border-[#e2e8f0]">
                    <div class="lg:col-span-2 max-w-md">
                        <a class="flex items-center gap-2.5 mb-4" href="{{ route('landing') }}">
                            <div class="relative shrink-0 group" style="width:40px;height:40px">
                                <div class="absolute inset-0 rounded-2xl bg-[#2563eb]/30 blur-md opacity-50"></div>
                                <div class="relative rounded-2xl flex items-center justify-center shadow-lg ring-1 ring-[#1e40af]/30 overflow-hidden"
                                    style="width:40px;height:40px;background:linear-gradient(135deg,#0c1929 0%,#1e3a8a 100%)">
                                    @if (!empty($config->logo))
                                        <img src="{{ $config->logo }}" alt="{{ getDomain() }}"
                                            class="w-full h-full object-contain" />
                                    @else
                                        {!! $flameSvg !!}
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col leading-none"><span
                                    class="font-extrabold text-base tracking-[-0.02em] text-[#0F172A]">{{ getDomain() }}</span><span
                                    class="text-[10px] text-[#64748B] tracking-[0.16em] uppercase mt-0.5">Global ·
                                    Cheapest</span></div>
                        </a>
                        <p class="text-sm text-[#475569] leading-relaxed mb-5">The world's biggest &amp; cheapest SMM
                            panel. 500+ services. 80+ countries. 24/7 multilingual support.</p>
                        <div class="flex flex-wrap items-center gap-2">
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-[#eff6ff] border border-[#dbeafe] text-[11px] font-semibold text-[#1d4ed8]"><span
                                    class="size-1.5 rounded-full bg-[#2563eb] animate-pulse"></span>99.99%
                                uptime</span>
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-[#ffffff] border border-[#e2e8f0] text-[11px] font-semibold text-[#475569]"><svg
                                    width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-[#1d4ed8]">
                                    <path
                                        d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z">
                                    </path>
                                </svg> SSL 256-bit</span>
                            <span
                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-[#ffffff] border border-[#e2e8f0] text-[11px] font-semibold text-[#475569]"><svg
                                    width="12" height="12" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-[#1d4ed8]">
                                    <path
                                        d="m15.477 12.89 1.515 8.526a.5.5 0 0 1-.81.47l-3.58-2.687a1 1 0 0 0-1.197 0l-3.586 2.686a.5.5 0 0 1-.81-.469l1.514-8.526">
                                    </path>
                                    <circle cx="12" cy="8" r="6"></circle>
                                </svg> ISO-grade</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-semibold mb-2 text-[#0F172A]">Stay in the loop</p>
                        <p class="text-xs text-[#64748B] mb-4">New services, price drops, and platform updates —
                            straight to your inbox.</p>
                        <form class="flex gap-2" onsubmit="return false"><input type="email"
                                placeholder="you@business.com"
                                class="flex-1 h-10 px-3.5 text-sm rounded-[10px] bg-[#ffffff] border border-[#e2e8f0] text-[#0F172A] placeholder:text-[#94A3B8] focus:outline-none focus:border-[#2563eb] focus:ring-2 focus:ring-[#2563eb]/20">
                            <button type="submit"
                                class="h-10 px-4 rounded-[10px] bg-[#2563eb] text-[#ffffff] text-sm font-bold hover:bg-[#1d4ed8] hover:shadow-lg hover:shadow-[#2563eb]/30 transition-all">Subscribe</button>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-10">
                    @php
                        $footCols = [
                            [
                                'Product',
                                [
                                    ['Features', '#features'],
                                    ['Pricing', '#pricing'],
                                    ['Services catalog', route('clients.services.index')],
                                    ['API reference', route('clients.api.index')],
                                ],
                            ],
                            [
                                'Support',
                                [
                                    ['Contact us', '#'],
                                    ['Blog', '#'],
                                    ['Documentation', route('clients.api.index')],
                                    ['Telegram', '#'],
                                ],
                            ],
                            ['Company', [['About', '#'], ['Careers', '#'], ['Partners', '#']]],
                            ['Legal', [['Terms of service', '#'], ['Privacy policy', '#'], ['Refund policy', '#']]],
                        ];
                    @endphp
                    @foreach ($footCols as $col)
                        <div>
                            <p class="text-xs uppercase tracking-wider text-[#94A3B8] mb-4 font-semibold">
                                {{ $col[0] }}</p>
                            <ul class="space-y-2.5 text-sm text-[#475569]">
                                @foreach ($col[1] as $lnk)
                                    <li><a href="{{ $lnk[1] }}"
                                            class="hover:text-[#0F172A] transition-colors">{{ $lnk[0] }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-wrap items-center justify-between gap-6 pb-8">
                    <div class="flex items-center gap-2">
                        @foreach ($brands as $b)
                            @if (in_array($b[0], ['Instagram', 'TikTok', 'YouTube', 'Twitter / X', 'Telegram', 'Discord']))
                                <a href="#"
                                    class="size-10 inline-flex items-center justify-center rounded-[12px] bg-[#ffffff] border border-[#e2e8f0] text-[#64748B] hover:bg-[#eff6ff] hover:text-[#1d4ed8] hover:border-[#2563eb]/40 transition-all"><svg
                                        stroke="currentColor" fill="currentColor" stroke-width="0"
                                        viewBox="{{ $b[1] }}" height="16"
                                        width="16">{!! $b[2] !!}</svg></a>
                            @endif
                        @endforeach
                    </div>
                    <div class="flex items-center gap-3 text-xs text-[#64748B]"><span
                            class="inline-flex items-center gap-1.5">🌐 English
                            (US)</span><span>·</span><span>USD</span></div>
                </div>
                <div
                    class="pt-8 border-t border-[#e2e8f0] flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-[#94A3B8]">
                    <p>© {{ date('Y') }} {{ getDomain() }} · All rights reserved.</p>
                    <p class="flex items-center gap-2"><span
                            class="size-1.5 rounded-full bg-[#2563eb] animate-pulse"></span>All systems operational ·
                        v1.0.0</p>
                </div>
            </div>
        </footer>
    </div>
    <!-- Login Modal -->
    <style>
        @keyframes modalSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.96);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes checkDraw {
            from {
                stroke-dashoffset: 60;
            }

            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes iconPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        @keyframes shimmer {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(100%);
            }
        }

        @keyframes confettiFall {
            0% {
                transform: translateY(-10px) rotate(0deg);
                opacity: 1;
            }

            100% {
                transform: translateY(80px) rotate(720deg);
                opacity: 0;
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            20%,
            60% {
                transform: translateX(-6px);
            }

            40%,
            80% {
                transform: translateX(6px);
            }
        }

        .login-modal-overlay {
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease;
        }

        .login-modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .login-modal-overlay.active .login-modal-card {
            animation: modalSlideUp .4s cubic-bezier(.16, 1, .3, 1) forwards;
        }

        .login-modal-card {
            opacity: 0;
        }

        .login-modal-overlay.active .login-modal-card.shake {
            animation: shake .5s ease;
        }

        .login-check-circle {
            stroke-dasharray: 60;
            stroke-dashoffset: 60;
        }

        .login-modal-overlay.active .login-check-circle {
            animation: checkDraw .6s .2s ease forwards;
        }

        .login-check-path {
            stroke-dasharray: 20;
            stroke-dashoffset: 20;
        }

        .login-modal-overlay.active .login-check-path {
            animation: checkDraw .4s .6s ease forwards;
        }

        .login-icon-pulse {
            animation: iconPulse 2s ease-in-out infinite;
        }

        .login-progress-shimmer {
            position: relative;
            overflow: hidden;
        }

        .login-progress-shimmer::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .4), transparent);
            animation: shimmer 1.5s infinite;
        }

        .login-confetti {
            position: absolute;
            width: 8px;
            height: 8px;
            border-radius: 2px;
            animation: confettiFall 1.5s ease forwards;
            pointer-events: none;
        }
    </style>

    <div id="loginModal" class="login-modal-overlay fixed inset-0 z-[9999] flex items-center justify-center p-4"
        style="background:rgba(15,23,42,0.5);backdrop-filter:blur(8px);-webkit-backdrop-filter:blur(8px)">
        <div
            class="login-modal-card relative w-full max-w-[380px] rounded-[24px] bg-white shadow-[0_32px_80px_-16px_rgba(15,23,42,0.3),0_0_0_1px_rgba(37,99,235,0.08)] overflow-hidden">
            <!-- Top gradient bar -->
            <div class="h-1.5 bg-gradient-to-r from-[#2563eb] via-[#0ea5e9] to-[#6366f1]"></div>

            <!-- Confetti container -->
            <div id="loginConfetti" class="absolute inset-0 pointer-events-none overflow-hidden"></div>

            <div class="relative px-8 pt-8 pb-7">
                <!-- Icon -->
                <div id="loginModalIcon" class="mx-auto mb-5 relative">
                    <div class="w-[72px] h-[72px] mx-auto rounded-full flex items-center justify-center login-icon-pulse"
                        style="background:linear-gradient(135deg,#eff6ff 0%,#dbeafe 100%);box-shadow:0 8px 24px -4px rgba(37,99,235,0.2)">
                        <svg id="loginIconSvg" width="32" height="32" viewBox="0 0 24 24"
                            fill="none" stroke="#2563eb" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle class="login-check-circle" cx="12" cy="12" r="10"></circle>
                            <path class="login-check-path" d="m9 12 2 2 4-4"></path>
                        </svg>
                    </div>
                </div>

                <!-- Title -->
                <h3 id="loginModalTitle" class="text-center text-xl font-bold text-[#0F172A] tracking-[-0.02em]">
                    Welcome back!</h3>

                <!-- Message -->
                <p id="loginModalMessage" class="text-center mt-2 text-sm text-[#64748B] leading-relaxed">Đăng nhập
                    thành công. Đang chuyển hướng...</p>

                <!-- Progress bar -->
                <div id="loginProgressWrap" class="mt-6">
                    <div class="w-full h-2 rounded-full bg-[#f1f5f9] overflow-hidden">
                        <div id="loginModalProgress"
                            class="h-full rounded-full login-progress-shimmer transition-all duration-[1800ms] ease-[cubic-bezier(0.4,0,0.2,1)]"
                            style="width:0%;background:linear-gradient(90deg,#2563eb,#0ea5e9,#6366f1)"></div>
                    </div>
                    <p id="loginProgressText"
                        class="mt-2.5 text-center text-[11px] text-[#94A3B8] font-medium tracking-wide">Preparing your
                        dashboard...</p>
                </div>

                <!-- Close button (error only) -->
                <button id="loginModalClose"
                    class="hidden mt-5 w-full h-11 rounded-[12px] bg-[#f1f5f9] border border-[#e2e8f0] text-sm font-semibold text-[#475569] hover:bg-[#e2e8f0] hover:text-[#0F172A] transition-all"
                    onclick="hideLoginModal()">
                    Thử lại
                </button>
            </div>
        </div>
    </div>

    <script>
        (function() {
            const form = document.getElementById('heroLoginForm');
            if (!form) return;

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const btn = form.querySelector('button[type="submit"]');
                const btnText = btn.innerHTML;
                btn.disabled = true;
                btn.style.opacity = '0.7';
                btn.innerHTML =
                    '<svg class="animate-spin" width="18" height="18" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" opacity="0.25"></circle><path d="M4 12a8 8 0 018-8" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path></svg><span class="ml-2">Đang đăng nhập...</span>';

                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData,
                    })
                    .then(r => r.json().then(data => ({
                        ok: r.ok,
                        data
                    })))
                    .then(({
                        ok,
                        data
                    }) => {
                        if (ok && data.success) {
                            showLoginModal('success', data.message || 'Đăng nhập thành công!',
                                'Đang chuyển hướng đến dashboard...', data.redirect || '/new');
                        } else {
                            showLoginModal('error', 'Đăng nhập thất bại', data.message ||
                                'Tài khoản hoặc mật khẩu không đúng.');
                            btn.disabled = false;
                            btn.style.opacity = '1';
                            btn.innerHTML = btnText;
                        }
                    })
                    .catch(() => {
                        showLoginModal('error', 'Lỗi kết nối', 'Đã xảy ra lỗi. Vui lòng thử lại.');
                        btn.disabled = false;
                        btn.style.opacity = '1';
                        btn.innerHTML = btnText;
                    });
            });

            function showLoginModal(type, title, message, redirect) {
                const modal = document.getElementById('loginModal');
                const card = modal.querySelector('.login-modal-card');
                const icon = document.getElementById('loginModalIcon');
                const titleEl = document.getElementById('loginModalTitle');
                const msgEl = document.getElementById('loginModalMessage');
                const progress = document.getElementById('loginModalProgress');
                const progressWrap = document.getElementById('loginProgressWrap');
                const progressText = document.getElementById('loginProgressText');
                const closeBtn = document.getElementById('loginModalClose');
                const confetti = document.getElementById('loginConfetti');

                titleEl.textContent = title;
                msgEl.textContent = message;
                confetti.innerHTML = '';

                if (type === 'success') {
                    icon.querySelector('div').style.background = 'linear-gradient(135deg,#eff6ff 0%,#dbeafe 100%)';
                    icon.querySelector('div').style.boxShadow = '0 8px 24px -4px rgba(37,99,235,0.2)';
                    icon.querySelector('svg').outerHTML =
                        '<svg id="loginIconSvg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle class="login-check-circle" cx="12" cy="12" r="10"></circle><path class="login-check-path" d="m9 12 2 2 4-4"></path></svg>';
                    progressWrap.style.display = '';
                    closeBtn.classList.add('hidden');
                    progress.style.width = '0%';
                    setTimeout(() => {
                        progress.style.width = '100%';
                    }, 80);

                    // Confetti
                    const colors = ['#2563eb', '#0ea5e9', '#6366f1', '#f59e0b', '#10b981', '#ec4899'];
                    for (let i = 0; i < 24; i++) {
                        const dot = document.createElement('div');
                        dot.className = 'login-confetti';
                        dot.style.left = Math.random() * 100 + '%';
                        dot.style.top = '-10px';
                        dot.style.background = colors[Math.floor(Math.random() * colors.length)];
                        dot.style.animationDelay = (Math.random() * 0.6) + 's';
                        dot.style.animationDuration = (1 + Math.random() * 0.8) + 's';
                        dot.style.width = (5 + Math.random() * 6) + 'px';
                        dot.style.height = (5 + Math.random() * 6) + 'px';
                        dot.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
                        confetti.appendChild(dot);
                    }

                    setTimeout(() => {
                        window.location.href = redirect;
                    }, 2000);
                } else {
                    icon.querySelector('div').style.background = 'linear-gradient(135deg,#fef2f2 0%,#fecaca 100%)';
                    icon.querySelector('div').style.boxShadow = '0 8px 24px -4px rgba(220,38,38,0.15)';
                    icon.querySelector('svg').outerHTML =
                        '<svg id="loginIconSvg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="m15 9-6 6"></path><path d="m9 9 6 6"></path></svg>';
                    progressWrap.style.display = 'none';
                    closeBtn.classList.remove('hidden');
                    card.classList.add('shake');
                    setTimeout(() => {
                        card.classList.remove('shake');
                    }, 600);
                    // Auto close after 4s
                    setTimeout(() => {
                        hideLoginModal();
                    }, 4000);
                }

                modal.classList.add('active');

                modal.onclick = function(e) {
                    if (e.target === modal && type === 'error') hideLoginModal();
                };
            }

            window.hideLoginModal = function() {
                const modal = document.getElementById('loginModal');
                modal.classList.remove('active');
            };
        })();
    </script>

</body>

</html>
