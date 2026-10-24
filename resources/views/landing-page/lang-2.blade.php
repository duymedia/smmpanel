<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#08090a" />
    <title>{{ getDomain() }} — {{ $config->title ?? '' }}</title>

    <meta name="description" content="{{ $config->description ?? '' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ getDomain() }} — {{ $config->title ?? '' }}" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin />

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;450;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    },
                    colors: {
                        bg: '#08090a',
                        surface: '#0c0d0f',
                        elevated: '#111214',
                        border: '#1d1f23',
                        'border-strong': '#2a2d33',
                        ink: '#ededed',
                        sub: '#a0a0a8',
                        muted: '#6a6a72',
                        faint: '#3f4046',
                        violet: '#7c5cff',
                        fuchsia: '#c084fc',
                        mint: '#3ddc97',
                        amber: '#ffb547',
                    },
                    letterSpacing: {
                        'tightest': '-0.04em',
                        'tighter': '-0.025em',
                        'tight': '-0.015em',
                    },
                    fontSize: {
                        'hero': ['clamp(3rem, 8vw, 6.5rem)', {
                            lineHeight: '0.98',
                            letterSpacing: '-0.04em'
                        }],
                        'h2': ['clamp(2rem, 4.5vw, 3.75rem)', {
                            lineHeight: '1.02',
                            letterSpacing: '-0.03em'
                        }],
                        'h3': ['clamp(1.25rem, 1.8vw, 1.5rem)', {
                            lineHeight: '1.2',
                            letterSpacing: '-0.015em'
                        }],
                    }
                }
            }
        };
    </script>

    <style>
        html {
            background: #08090a;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #08090a;
            color: #ededed;
            font-feature-settings: "ss01", "ss03", "cv11";
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        /* --- Hairline grid background --- */
        .grid-bg {
            background-image:
                linear-gradient(to right, rgba(255, 255, 255, .025) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(255, 255, 255, .025) 1px, transparent 1px);
            background-size: 64px 64px;
            mask-image: radial-gradient(ellipse 90% 60% at 50% 0%, #000 30%, transparent 100%);
        }

        /* --- Spotlight glow under hero --- */
        .spotlight {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background:
                radial-gradient(60% 50% at 50% 0%, rgba(124, 92, 255, .18), transparent 70%),
                radial-gradient(40% 40% at 80% 10%, rgba(192, 132, 252, .12), transparent 70%);
        }

        /* --- Gradient text --- */
        .grad-text {
            background: linear-gradient(180deg, #ffffff 0%, #b3b3bb 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .accent-text {
            background: linear-gradient(90deg, #7c5cff 0%, #c084fc 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        /* --- Card with subtle inner highlight (Linear-style) --- */
        .card {
            background: linear-gradient(180deg, rgba(255, 255, 255, .02), rgba(255, 255, 255, 0)), #0c0d0f;
            border: 1px solid #1d1f23;
            border-radius: 14px;
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 14px;
            padding: 1px;
            background: linear-gradient(180deg, rgba(255, 255, 255, .06), transparent 30%);
            -webkit-mask: linear-gradient(#000 0 0) content-box, linear-gradient(#000 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
        }

        /* --- Buttons --- */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            height: 38px;
            padding: 0 14px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            letter-spacing: -0.005em;
            transition: background .15s ease, color .15s ease, border-color .15s ease, transform .15s ease;
            white-space: nowrap;
        }

        .btn-primary {
            background: #ededed;
            color: #08090a;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .4) inset, 0 -1px 0 rgba(0, 0, 0, .1) inset;
        }

        .btn-primary:hover {
            background: #ffffff;
            transform: translateY(-1px);
        }

        .btn-ghost {
            background: transparent;
            color: #ededed;
            border: 1px solid #2a2d33;
        }

        .btn-ghost:hover {
            background: #111214;
            border-color: #3a3d44;
        }

        .btn-lg {
            height: 44px;
            padding: 0 18px;
            font-size: 14px;
            border-radius: 10px;
        }

        /* --- Pill badge --- */
        .pill {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            height: 28px;
            padding: 0 12px 0 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .04);
            border: 1px solid #1d1f23;
            font-size: 12.5px;
            color: #a0a0a8;
            font-weight: 450;
        }

        .pill .dot {
            width: 6px;
            height: 6px;
            border-radius: 999px;
            background: #3ddc97;
            box-shadow: 0 0 0 3px rgba(61, 220, 151, .15);
        }

        /* --- Section heading kicker --- */
        .kicker {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11.5px;
            color: #7c5cff;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            font-weight: 500;
        }

        /* --- Code block --- */
        .code {
            background: #0c0d0f;
            border: 1px solid #1d1f23;
            border-radius: 12px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px;
            line-height: 1.75;
            color: #ededed;
        }

        .code .k {
            color: #c084fc;
        }

        .code .s {
            color: #3ddc97;
        }

        .code .n {
            color: #ffb547;
        }

        .code .c {
            color: #6a6a72;
            font-style: italic;
        }

        .code .p {
            color: #a0a0a8;
        }

        /* --- Reveal --- */
        .reveal {
            opacity: 0;
            transform: translateY(14px);
            transition: opacity .7s ease, transform .7s cubic-bezier(.22, 1, .36, 1);
        }

        .reveal.in {
            opacity: 1;
            transform: none;
        }

        /* --- Marquee logos --- */
        .marquee {
            display: flex;
            gap: 3.5rem;
            animation: scroll 40s linear infinite;
        }

        @keyframes scroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        /* --- Tabular numerics --- */
        .tnum {
            font-variant-numeric: tabular-nums;
        }

        /* --- Border focus ring on hover for nav links --- */
        .navlink {
            color: #a0a0a8;
            transition: color .15s;
        }

        .navlink:hover {
            color: #ededed;
        }

        /* --- Link arrow nudge --- */
        .lnk {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            color: #ededed;
        }

        .lnk .arr {
            transition: transform .15s;
        }

        .lnk:hover .arr {
            transform: translateX(3px);
        }

        /* --- Selection --- */
        ::selection {
            background: rgba(124, 92, 255, .4);
            color: #fff;
        }

        /* --- Alpine cloak --- */
        [x-cloak] {
            display: none !important;
        }

        /* --- Reduce motion --- */
        @media (prefers-reduced-motion: reduce) {

            .reveal,
            .marquee {
                opacity: 1;
                transform: none;
                animation: none;
            }
        }

        /* ============ MOBILE RESPONSIVE ============ */

        /* Prevent horizontal scroll */
        html,
        body {
            overflow-x: hidden;
        }

        /* --- Tablet & Phone (≤ 639px) --- */
        @media (max-width: 639px) {
            section {
                padding-top: 3.5rem;
                padding-bottom: 3.5rem;
            }

            /* Order rows: stack on small screens */
            .order-row {
                flex-direction: column;
                align-items: flex-start !important;
                gap: 0.5rem;
            }

            .order-row>div:last-child {
                align-self: flex-end;
            }

            /* Code block */
            .code pre {
                font-size: 10.5px;
                line-height: 1.6;
                overflow-x: auto;
            }
        }

        /* --- Phone (≤ 479px) --- */
        @media (max-width: 479px) {
            .pill {
                font-size: 10.5px;
                height: 22px;
                padding: 0 7px;
            }

            .btn {
                height: 36px;
                padding: 0 12px;
                font-size: 13px;
            }

            .btn-lg {
                height: 40px;
                padding: 0 14px;
            }
        }

        /* --- Tiny (≤ 374px) --- */
        @media (max-width: 374px) {
            .pill {
                font-size: 10px;
                padding: 0 6px;
                height: 20px;
            }

            .btn {
                height: 34px;
                padding: 0 10px;
                font-size: 12.5px;
            }

            .btn-lg {
                height: 38px;
                padding: 0 12px;
                font-size: 13px;
            }
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>

    <!-- ===================== NAV ===================== -->
    <header x-data="{ open: false }" class="fixed inset-x-0 top-0 z-50 border-b backdrop-blur-xl bg-bg/70 border-border">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 h-14 flex items-center justify-between gap-3">
            <div class="flex items-center gap-8 min-w-0 flex-1">
                <a href="#"
                    class="flex items-center gap-2 font-semibold tracking-tight text-[15px] whitespace-nowrap">
                    {{ getDomain() }}
                </a>
                <nav class="hidden md:flex items-center gap-6 text-[13.5px]">
                    <a href="#features" class="navlink">Features</a>
                    <a href="#services" class="navlink">Services</a>
                    <a href="#pricing" class="navlink">Pricing</a>
                    <a href="#api" class="navlink">API</a>
                    <a href="#faq" class="navlink">FAQ</a>
                </nav>
            </div>

            <div class="items-center hidden gap-2 md:flex flex-shrink-0">
                <a href="#" class="btn btn-ghost">Sign in</a>
                <a href="#" class="btn btn-primary">
                    Get started
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M5 12h14M13 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <button @click="open = !open"
                class="md:hidden flex-shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-lg border border-border-strong hover:bg-elevated active:bg-elevated transition-colors"
                aria-label="Menu">
                <!-- Hamburger icon -->
                <svg x-show="!open" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <!-- Close icon -->
                <svg x-show="open" x-cloak width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M18 6L6 18M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div x-show="open" x-collapse x-cloak class="border-t md:hidden border-border bg-bg">
            <nav class="flex flex-col gap-1 px-6 py-5 text-sm text-sub">
                <a href="#features" @click="open=false"
                    class="py-2.5 px-2 rounded-lg hover:bg-elevated hover:text-ink transition-colors">Features</a>
                <a href="#services" @click="open=false"
                    class="py-2.5 px-2 rounded-lg hover:bg-elevated hover:text-ink transition-colors">Services</a>
                <a href="#pricing" @click="open=false"
                    class="py-2.5 px-2 rounded-lg hover:bg-elevated hover:text-ink transition-colors">Pricing</a>
                <a href="#api" @click="open=false"
                    class="py-2.5 px-2 rounded-lg hover:bg-elevated hover:text-ink transition-colors">API</a>
                <a href="#faq" @click="open=false"
                    class="py-2.5 px-2 rounded-lg hover:bg-elevated hover:text-ink transition-colors">FAQ</a>
                <div class="flex gap-2 pt-4 mt-2 border-t border-border">
                    <a href="#" class="justify-center flex-1 btn btn-ghost">Sign in</a>
                    <a href="#" class="justify-center flex-1 btn btn-primary">Get started</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- ===================== HERO ===================== -->
    <section class="relative pt-24 pb-16 overflow-hidden sm:pt-32 sm:pb-24 lg:pt-40 lg:pb-32">
        <div class="absolute inset-0 grid-bg"></div>
        <div class="spotlight"></div>

        <div class="relative max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex justify-center reveal">
                <a href="#" class="pill">
                    <span class="dot"></span>
                    v2 API is now live
                    <span class="text-muted">·</span>
                    <span class="lnk text-ink/90 text-[12.5px]">Read changelog <span class="arr">→</span></span>
                </a>
            </div>

            <h1 class="mt-8 font-medium reveal text-hero grad-text">
                The social<br />
                <span class="accent-text">performance</span> layer.
            </h1>

            <p class="reveal mt-7 text-sub max-w-xl mx-auto text-[16px] leading-relaxed">
                An automated SMM panel for Instagram, TikTok, YouTube and Facebook.
                Wholesale rates per 1K, refill guarantee, and a documented REST API for resellers.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-3 mt-10 reveal">
                <a href="#" class="btn btn-primary btn-lg">
                    Start free
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M5 12h14M13 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="#api" class="btn btn-ghost btn-lg">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M16 18l6-6-6-6M8 6l-6 6 6 6" />
                    </svg>
                    View API docs
                </a>
            </div>

            <!-- Inline metrics -->
            <div
                class="reveal mt-12 sm:mt-16 inline-flex flex-wrap items-center justify-center gap-x-4 sm:gap-x-8 gap-y-2 sm:gap-y-3 text-[12px] sm:text-[13px] text-muted">
                <span><span class="font-medium text-ink tnum">12.4M+</span> orders</span>
                <span class="text-faint hidden sm:inline">·</span>
                <span><span class="font-medium text-ink tnum">99.4%</span> auto</span>
                <span class="text-faint hidden sm:inline">·</span>
                <span><span class="font-medium text-ink tnum">420+</span> services</span>
                <span class="text-faint hidden sm:inline">·</span>
                <span><span class="font-medium text-ink tnum">99.98%</span> uptime</span>
            </div>

            <!-- Hero product card preview -->
            <div class="max-w-5xl mx-auto mt-12 sm:mt-20 reveal">
                <div class="overflow-hidden text-left card">
                    <div class="flex items-center h-10 gap-2 px-4 border-b border-border">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#ff5f57]"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-[#febc2e]"></span>
                        <span class="w-2.5 h-2.5 rounded-full bg-[#28c840]"></span>
                        <span class="ml-3 font-mono text-[11px] text-muted">{{ getDomain() }} / dashboard</span>
                    </div>

                    <div class="grid grid-cols-12 divide-x divide-border">
                        <!-- side -->
                        <aside class="col-span-3 hidden md:block p-5 text-[13px]">
                            <p class="mb-4 kicker">Workspace</p>
                            <ul class="space-y-2 text-sub">
                                <li class="flex items-center justify-between text-ink"><span>● Dashboard</span><span
                                        class="text-xs text-muted">⌘1</span></li>
                                <li class="flex items-center justify-between"><span>Orders</span><span
                                        class="text-xs text-muted">⌘2</span></li>
                                <li class="flex items-center justify-between"><span>Services</span><span
                                        class="text-xs text-muted">⌘3</span></li>
                                <li class="flex items-center justify-between"><span>API keys</span><span
                                        class="text-xs text-muted">⌘4</span></li>
                                <li class="flex items-center justify-between"><span>Billing</span><span
                                        class="text-xs text-muted">⌘5</span></li>
                            </ul>
                        </aside>

                        <!-- main -->
                        <div class="col-span-12 p-5 md:col-span-9 md:p-7">
                            <div class="flex flex-wrap items-end justify-between gap-4 mb-6">
                                <div>
                                    <p class="mb-2 kicker">Balance</p>
                                    <p class="text-xl sm:text-3xl font-semibold tracking-tight tnum">12,480,000 <span
                                            class="text-sm sm:text-base font-normal text-muted">VND</span></p>
                                </div>
                                <div class="flex gap-2">
                                    <span class="pill">+ 4.2% this week</span>
                                    <button class="px-3 text-xs btn btn-ghost h-7">Top-up</button>
                                </div>
                            </div>

                            <div class="grid gap-3 mb-6 sm:grid-cols-3">
                                <div class="rounded-lg border border-border p-3.5">
                                    <p class="text-[11px] text-muted uppercase tracking-wider">In progress</p>
                                    <p class="mt-1 text-xl font-semibold tnum">14</p>
                                </div>
                                <div class="rounded-lg border border-border p-3.5">
                                    <p class="text-[11px] text-muted uppercase tracking-wider">Completed · 24h</p>
                                    <p class="mt-1 text-xl font-semibold tnum text-mint">128</p>
                                </div>
                                <div class="rounded-lg border border-border p-3.5">
                                    <p class="text-[11px] text-muted uppercase tracking-wider">Refill ratio</p>
                                    <p class="mt-1 text-xl font-semibold tnum">2.7%</p>
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                <div
                                    class="order-row flex items-center justify-between rounded-lg border border-border px-3.5 py-2.5 text-[13px]">
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-xs text-muted">ord_482910</span>
                                        <span>TikTok views</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-muted tnum">+50,000</span>
                                        <span class="pill"><span class="dot"
                                                style="background:#ffb547;box-shadow:0 0 0 3px rgba(255,181,71,.15)"></span>processing</span>
                                    </div>
                                </div>
                                <div
                                    class="order-row flex items-center justify-between rounded-lg border border-border px-3.5 py-2.5 text-[13px]">
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-xs text-muted">ord_482908</span>
                                        <span>Instagram followers</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-muted tnum">+2,500</span>
                                        <span class="pill"><span class="dot"></span>completed</span>
                                    </div>
                                </div>
                                <div
                                    class="order-row flex items-center justify-between rounded-lg border border-border px-3.5 py-2.5 text-[13px]">
                                    <div class="flex items-center gap-3">
                                        <span class="font-mono text-xs text-muted">ord_482903</span>
                                        <span>YouTube watch time</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-muted tnum">+4,000h</span>
                                        <span class="pill"><span class="dot"
                                                style="background:#c084fc;box-shadow:0 0 0 3px rgba(192,132,252,.15)"></span>queued</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== LOGO MARQUEE ===================== -->
    <section class="py-8 overflow-hidden border-y border-border">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 mb-5">
            <p class="text-center kicker text-muted">Powering campaigns for 2,400+ studios &amp; resellers</p>
        </div>
        <marquee behavior="scroll" direction="left" scrollamount="3"
            class="text-lg font-medium tracking-tight text-muted/70 py-2">
            <span class="inline-flex items-center gap-14">
                <span>STUDIO BRICK</span><span class="text-faint">●</span>
                <span>NORTHLIGHT</span><span class="text-faint">●</span>
                <span>halftone.</span><span class="text-faint">●</span>
                <span>FOLIO/24</span><span class="text-faint">●</span>
                <span>Saigon Co.</span><span class="text-faint">●</span>
                <span>METHOD &amp; CO</span><span class="text-faint">●</span>
                <span>plainwork™</span><span class="text-faint">●</span>
                <span>OFFLOAD</span><span class="text-faint">●</span>
                <span>STUDIO BRICK</span><span class="text-faint">●</span>
                <span>NORTHLIGHT</span><span class="text-faint">●</span>
                <span>halftone.</span><span class="text-faint">●</span>
                <span>FOLIO/24</span><span class="text-faint">●</span>
                <span>Saigon Co.</span><span class="text-faint">●</span>
                <span>METHOD &amp; CO</span><span class="text-faint">●</span>
                <span>plainwork™</span><span class="text-faint">●</span>
                <span>OFFLOAD</span><span class="text-faint">●</span>
            </span>
        </marquee>
    </section>

    <!-- ===================== FEATURES (Bento) ===================== -->
    <section id="features" class="py-28 lg:py-36">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl reveal">
                <p class="mb-4 kicker">Features</p>
                <h2 class="font-medium text-h2 grad-text">Everything you need to ship a campaign — nothing you don’t.
                </h2>
                <p class="mt-5 text-sub text-[15.5px] leading-relaxed">A focused panel built around order flow,
                    observability, and a clean reseller API. Designed in Hanoi, used in 38 countries.</p>
            </div>

            <div class="grid grid-cols-12 gap-4 mt-14">
                <!-- big card -->
                <div class="col-span-12 lg:col-span-7 card p-7 reveal min-h-[280px]">
                    <div class="flex items-start justify-between mb-6">
                        <div class="kicker">01 · Automation</div>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7c5cff"
                            stroke-width="1.5">
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg>
                    </div>
                    <h3 class="mb-3 font-semibold text-h3">Orders flow in seconds, not screenshots.</h3>
                    <p class="max-w-md text-sm leading-relaxed text-sub">Paste a link, pick a service, confirm. The
                        pipeline does the rest — status pings, refill detection, partial-refund logic, all built in.</p>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-2 text-[11.5px] font-mono text-muted">
                        <div class="rounded-md border border-border px-2.5 py-2">queued · 0.3s</div>
                        <div class="rounded-md border border-border px-2.5 py-2 text-amber">processing · 4m</div>
                        <div class="rounded-md border border-border px-2.5 py-2 text-mint">delivered ✓</div>
                    </div>
                </div>

                <!-- side small -->
                <div class="col-span-12 lg:col-span-5 card p-7 reveal">
                    <div class="mb-4 kicker">02 · Pricing</div>
                    <h3 class="mb-3 font-semibold text-h3">Per 1K, never per riddle.</h3>
                    <p class="text-sm leading-relaxed text-sub">A flat rate card. Volume tiers unlock automatically at
                        5M, 25M, and 100M VND monthly spend.</p>
                    <div class="mt-6 border border-border rounded-lg divide-y divide-border text-[13px]">
                        <div class="flex items-center justify-between px-3.5 py-2.5"><span>Starter</span><span
                                class="text-muted tnum">0 — 5M</span></div>
                        <div class="flex items-center justify-between px-3.5 py-2.5"><span>Studio <span
                                    class="font-medium accent-text">↗</span></span><span class="text-muted tnum">5M —
                                25M</span></div>
                        <div class="flex items-center justify-between px-3.5 py-2.5"><span>Reseller</span><span
                                class="text-muted tnum">25M+</span></div>
                    </div>
                </div>

                <!-- 3 small -->
                <div class="col-span-12 md:col-span-4 card p-7 reveal">
                    <div class="mb-4 kicker">03 · Refill</div>
                    <h3 class="mb-3 font-semibold text-h3">30-day guarantee.</h3>
                    <p class="text-sm leading-relaxed text-sub">If a count drops within the window, refill is one click
                        — no ticket, no investigation queue.</p>
                </div>

                <div class="col-span-12 md:col-span-4 card p-7 reveal">
                    <div class="mb-4 kicker">04 · API</div>
                    <h3 class="mb-3 font-semibold text-h3">REST + webhooks.</h3>
                    <p class="text-sm leading-relaxed text-sub">Place orders, query status, request refills. Sandbox
                        keys on request, no sales call required.</p>
                </div>

                <div class="col-span-12 md:col-span-4 card p-7 reveal">
                    <div class="mb-4 kicker">05 · Support</div>
                    <h3 class="mb-3 font-semibold text-h3">Written by humans.</h3>
                    <p class="text-sm leading-relaxed text-sub">Tickets answered in your timezone. Median first
                        response: 8 minutes during studio hours.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== SERVICES ===================== -->
    <section id="services" class="border-t py-28 lg:py-36 border-border">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between gap-6 mb-14 reveal">
                <div class="max-w-2xl">
                    <p class="mb-4 kicker">Services</p>
                    <h2 class="font-medium text-h2 grad-text">Six platforms.<br />One panel.</h2>
                </div>
                <a href="#" class="lnk hidden md:inline-flex text-[13.5px] text-sub hover:text-ink">All services
                    <span class="arr">→</span></a>
            </div>

            <div class="grid grid-cols-12 gap-4">
                @php
                    $platforms = [
                        [
                            'name' => 'Instagram',
                            'sub' => 'Followers · Reels · Stories',
                            'from' => '38K / 1K',
                            'grad' => 'from-[#feda75] via-[#fa7e1e] to-[#d62976]',
                            'img' => '/storage/images/instagram.gif',
                        ],
                        [
                            'name' => 'TikTok',
                            'sub' => 'Views · Likes · Followers',
                            'from' => '12K / 1K',
                            'grad' => 'from-[#25f4ee] via-white to-[#fe2c55]',
                            'img' => '/storage/images/tiktok.gif',
                        ],
                        [
                            'name' => 'YouTube',
                            'sub' => 'Watch time · Subs · Views',
                            'from' => '95K / 1K',
                            'grad' => 'from-[#ff0000] via-[#ff6b6b] to-[#ff0000]',
                            'img' => '/storage/images/youtube.gif',
                        ],
                        [
                            'name' => 'Facebook',
                            'sub' => 'Page likes · Reach · Shares',
                            'from' => '64K / 1K',
                            'grad' => 'from-[#1877f2] via-[#42a5f5] to-[#0866ff]',
                            'img' => '/storage/images/facebook.gif',
                        ],
                        [
                            'name' => 'Telegram',
                            'sub' => 'Members · Views · Reactions',
                            'from' => '72K / 1K',
                            'grad' => 'from-[#2aabee] via-[#229ed9] to-[#2aabee]',
                            'img' => '/storage/images/telegram.gif',
                        ],
                        [
                            'name' => 'X · Twitter',
                            'sub' => 'Followers · Reposts · Likes',
                            'from' => '82K / 1K',
                            'grad' => 'from-[#1d1d1f] via-[#3a3a3c] to-[#1d1d1f]',
                            'img' => '/storage/images/x.gif',
                        ],
                    ];
                @endphp

                @foreach ($platforms as $p)
                    <a href="#"
                        class="col-span-12 p-4 sm:p-6 transition md:col-span-6 lg:col-span-4 card reveal hover:border-border-strong group overflow-hidden">
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="w-10 h-10 rounded-lg bg-gradient-to-br {{ $p['grad'] }} overflow-hidden flex-shrink-0">
                                <img src="{{ $p['img'] }}" alt="{{ $p['name'] }}"
                                    class="w-full h-full object-cover" loading="lazy" />
                            </div>
                            <span class="font-mono text-[11px] text-muted">from {{ $p['from'] }}</span>
                        </div>
                        <h3 class="text-h3 font-semibold mb-1.5">{{ $p['name'] }}</h3>
                        <p class="text-sub text-[13.5px]">{{ $p['sub'] }}</p>
                        <div class="mt-6 flex items-center justify-between pt-4 border-t border-border text-[13px]">
                            <span class="text-muted">View catalogue</span>
                            <span class="transition-transform text-ink group-hover:translate-x-1">→</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ===================== API ===================== -->
    <section id="api" class="border-t py-28 lg:py-36 border-border">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-12 gap-6 lg:gap-10 items-center">
            <div class="col-span-12 lg:col-span-5 reveal">
                <p class="mb-4 kicker">API</p>
                <h2 class="font-medium text-h2 grad-text">Built for<br />resellers.</h2>
                <p class="mt-5 text-sub text-[15.5px] leading-relaxed max-w-md">
                    REST endpoints over HTTPS, panel-key auth, webhooks for every status transition. Idempotent orders,
                    sandbox env, and rate-limited at 60 req/min.
                </p>
                <ul class="mt-7 space-y-3 text-[14px]">
                    <li class="flex items-start gap-3"><span class="text-violet mt-0.5">→</span> <span><span
                                class="font-mono text-ink">POST /v2/add</span> <span class="text-muted">place an
                                order</span></span></li>
                    <li class="flex items-start gap-3"><span class="text-violet mt-0.5">→</span> <span><span
                                class="font-mono text-ink">GET /v2/status</span> <span class="text-muted">query
                                progress</span></span></li>
                    <li class="flex items-start gap-3"><span class="text-violet mt-0.5">→</span> <span><span
                                class="font-mono text-ink">POST /v2/refill</span> <span class="text-muted">trigger
                                refill</span></span></li>
                    <li class="flex items-start gap-3"><span class="text-violet mt-0.5">→</span> <span><span
                                class="font-mono text-ink">POST /v2/cancel</span> <span class="text-muted">partial
                                refund</span></span></li>
                </ul>
                <div class="flex gap-2 mt-9">
                    <a href="#" class="btn btn-primary">Read docs <span>↗</span></a>
                    <a href="#" class="btn btn-ghost">Get sandbox key</a>
                </div>
            </div>

            <div class="col-span-12 lg:col-span-7 reveal">
                <div class="p-3 sm:p-5 md:p-7 overflow-hidden code">
                    <div class="flex items-center gap-2 pb-4 mb-5 border-b border-border">
                        <span class="kicker">POST</span>
                        <span class="font-mono text-sm text-ink">/v2</span>
                        <span class="ml-auto font-mono text-[11px] text-muted">201 Created</span>
                    </div>
                    <pre class="overflow-x-auto"><span class="c">// Place an order for TikTok views</span>
<span class="k">curl</span> -X POST https://{{ getDomain() }}/v2 \
  -H <span class="s">"Content-Type: application/json"</span> \
  -d <span class="s">'{
    "key": "&lt;api_key&gt;",
    "action": "&lt;add&gt;",
    "service": <span class="n">2103</span>,
    "link": "https://tiktok.com/@studio/video/7384...",
    "quantity": <span class="n">25000</span>
  }'</span>

<span class="c">// → response</span>
{
  <span class="p">"order"</span>:    <span class="n">482910</span>
}</pre>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== PRICING ===================== -->
    <section id="pricing" class="border-t py-28 lg:py-36 border-border">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto text-center reveal">
                <p class="mb-4 kicker">Pricing</p>
                <h2 class="font-medium text-h2 grad-text">Simple plans, fair rates.</h2>
                <p class="mt-5 text-sub text-[15.5px]">Pay as you go, or save with a monthly subscription. All plans
                    share the same API and SLA.</p>
            </div>

            <div class="grid grid-cols-12 gap-4 mt-14">

                <!-- Starter -->
                <div class="col-span-12 lg:col-span-4 card p-7 reveal">
                    <p class="mb-3 kicker">Starter</p>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-4xl font-semibold tracking-tightest tnum">99K</span>
                        <span class="text-sm text-muted">/ month</span>
                    </div>
                    <p class="text-sub text-[13.5px] mt-2">For independent operators.</p>
                    <a href="#" class="justify-center w-full mt-6 btn btn-ghost">Choose Starter</a>
                    <ul class="mt-7 space-y-2.5 text-[13.5px] text-sub">
                        <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> 100 orders / month</li>
                        <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> All platforms unlocked</li>
                        <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> Email support</li>
                        <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> Wallet top-up automation</li>
                    </ul>
                </div>

                <!-- Studio (featured) -->
                <div class="relative col-span-12 overflow-hidden lg:col-span-4 card p-7 reveal">
                    <div class="absolute inset-0 pointer-events-none opacity-60"
                        style="background: radial-gradient(70% 50% at 50% 0%, rgba(124,92,255,.18), transparent 70%);">
                    </div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-3">
                            <p class="kicker">Studio</p>
                            <span class="pill"
                                style="border-color:#33256a; background:rgba(124,92,255,.08); color:#c4b3ff;">
                                <span class="dot"
                                    style="background:#7c5cff; box-shadow:0 0 0 3px rgba(124,92,255,.2);"></span>
                                Most popular
                            </span>
                        </div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-4xl font-semibold tracking-tightest tnum accent-text">299K</span>
                            <span class="text-sm text-muted">/ month</span>
                        </div>
                        <p class="text-sub text-[13.5px] mt-2">For studios and freelancers.</p>
                        <a href="#" class="justify-center w-full mt-6 btn btn-primary">
                            Start free trial
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5">
                                <path d="M5 12h14M13 5l7 7-7 7" />
                            </svg>
                        </a>
                        <ul class="mt-7 space-y-2.5 text-[13.5px] text-sub">
                            <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> Unlimited orders</li>
                            <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> Full REST API + webhooks
                            </li>
                            <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> Priority support · 8 min
                                SLA</li>
                            <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> Volume tier auto-discount
                            </li>
                            <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> Refill guarantee 30d</li>
                        </ul>
                    </div>
                </div>

                <!-- Reseller -->
                <div class="col-span-12 lg:col-span-4 card p-7 reveal">
                    <p class="mb-3 kicker">Reseller</p>
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-4xl font-semibold tracking-tightest tnum">599K</span>
                        <span class="text-sm text-muted">/ month</span>
                    </div>
                    <p class="text-sub text-[13.5px] mt-2">For white-label operators.</p>
                    <a href="#" class="justify-center w-full mt-6 btn btn-ghost">Contact sales</a>
                    <ul class="mt-7 space-y-2.5 text-[13.5px] text-sub">
                        <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> White-label sub-domain</li>
                        <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> Customer ledger &amp; wallets
                        </li>
                        <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> Custom rate-card per client
                        </li>
                        <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> Wholesale discount tier</li>
                        <li class="flex gap-2.5"><span class="text-mint mt-0.5">✓</span> Dedicated CSM</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== TESTIMONIAL ===================== -->
    <section class="border-t py-28 lg:py-36 border-border">
        <div class="max-w-[1080px] mx-auto px-4 sm:px-6 lg:px-8 text-center reveal">
            <p class="mb-6 kicker">Customer note</p>
            <blockquote class="text-2xl md:text-4xl font-medium tracking-tightest leading-[1.15] grad-text">
                “We moved three client portfolios over and our refill ratio
                dropped from 18% to under 3%. The dashboard is the first one
                I haven’t asked our team to rebuild.”
            </blockquote>
            <div class="inline-flex items-center gap-3 mt-10 text-sm">
                <div class="rounded-full w-9 h-9 bg-gradient-to-br from-violet to-fuchsia"></div>
                <div class="text-left">
                    <p class="font-medium">Linh Hà</p>
                    <p class="text-muted text-[12.5px]">Founder, Studio Brick · Hanoi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===================== FAQ ===================== -->
    <section id="faq" class="border-t py-28 lg:py-36 border-border">
        <div class="max-w-[1080px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 reveal">
                <p class="mb-4 kicker">Frequently asked</p>
                <h2 class="font-medium text-h2 grad-text">Questions, answered.</h2>
            </div>

            <div class="divide-y card divide-border" x-data="{ active: 0 }">
                <template
                    x-for="(item, i) in [
          { q: 'Are the followers and views real?',          a: 'For flagship services (TikTok views, IG real-tier followers, YouTube watch time) — yes. Each service page declares its source clearly: real accounts, high-quality bots, or mixed.' },
          { q: 'How fast does an order start?',               a: 'Most services start within 0–30 minutes. Slower ones like subs and watch time are paced to look organic. Exact ETA is shown on the order receipt.' },
          { q: 'What is the refill guarantee?',               a: 'If a count drops within the refill window listed on each service, refill is one click from the order page — usually fulfilled in under 24 hours.' },
          { q: 'Can I cancel an order in progress?',          a: 'Yes, while status is queued or below 25% delivered. Partial orders are refunded pro-rata to your wallet within minutes.' },
          { q: 'Do you offer white-label?',                   a: 'The Reseller plan ships with a sub-domain, custom branding, customer wallets and a discount table you control. The API stays ours.' },
          { q: 'Which payment methods do you accept?',         a: 'Vietnamese bank transfer (auto-credit), MoMo, ZaloPay, and USDT (TRC-20). International cards via processor on request.' }
        ]"
                    :key="i">
                    <div>
                        <button @click="active === i ? active = null : active = i" :aria-expanded="active === i"
                            class="flex items-center w-full gap-3 sm:gap-4 px-4 sm:px-6 py-4 sm:py-5 text-left">
                            <span class="font-mono text-[11.5px] text-muted tnum"
                                x-text="String(i + 1).padStart(2,'0')"></span>
                            <span class="flex-1 text-[15.5px] font-medium" x-text="item.q"></span>
                            <span class="text-lg transition-transform text-sub"
                                :class="active === i ? 'rotate-45 text-violet' : ''">+</span>
                        </button>
                        <div x-show="active === i" x-collapse x-cloak>
                            <p class="px-4 sm:px-6 pb-5 sm:pb-6 pl-[2.8rem] sm:pl-[3.6rem] text-sub text-[13px] sm:text-[14px] leading-relaxed max-w-2xl"
                                x-text="item.a"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </section>

    <!-- ===================== CTA ===================== -->
    <section class="relative overflow-hidden border-t py-28 lg:py-36 border-border">
        <div class="absolute inset-0 opacity-50 grid-bg"></div>
        <div class="absolute inset-0 pointer-events-none"
            style="background: radial-gradient(50% 60% at 50% 100%, rgba(124,92,255,.18), transparent 70%);"></div>

        <div class="relative max-w-[1080px] mx-auto px-4 sm:px-6 lg:px-8 text-center reveal">
            <h2 class="font-medium text-h2 grad-text">Ready to ship<br />your first campaign?</h2>
            <p class="max-w-lg mx-auto mt-5 text-sub">Free account, no credit card. First order delivers in minutes.
            </p>
            <div class="flex flex-wrap justify-center gap-3 mt-9">
                <a href="#" class="btn btn-primary btn-lg">
                    Get started for free
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M5 12h14M13 5l7 7-7 7" />
                    </svg>
                </a>
                <a href="#" class="btn btn-ghost btn-lg">Talk to sales</a>
            </div>
        </div>
    </section>

    <!-- ===================== FOOTER ===================== -->
    <footer class="pt-12 sm:pt-16 pb-8 border-t border-border">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-12 gap-8">
            <div class="col-span-12 md:col-span-4">
                <a href="#" class="flex items-center gap-2 font-semibold tracking-tight text-[15px] mb-4">
                    {{ getDomain() }}
                </a>
                <p class="text-sub text-[13.5px] max-w-xs leading-relaxed">The social performance layer. Independently
                    held, made in Hanoi.</p>
                <div class="mt-6 flex items-center gap-2 text-[12.5px] text-muted">
                    <span class="w-1.5 h-1.5 rounded-full bg-mint"></span>
                    All systems operational
                </div>
            </div>

            <div class="col-span-6 md:col-span-2">
                <p class="mb-4 kicker text-muted" style="color:#6a6a72">Product</p>
                <ul class="space-y-2.5 text-sub text-[13.5px]">
                    <li><a href="#features" class="hover:text-ink">Features</a></li>
                    <li><a href="#services" class="hover:text-ink">Services</a></li>
                    <li><a href="#pricing" class="hover:text-ink">Pricing</a></li>
                    <li><a href="#api" class="hover:text-ink">API</a></li>
                </ul>
            </div>

            <div class="col-span-6 md:col-span-2">
                <p class="mb-4 kicker text-muted" style="color:#6a6a72">Resources</p>
                <ul class="space-y-2.5 text-sub text-[13.5px]">
                    <li><a href="#" class="hover:text-ink">Docs</a></li>
                    <li><a href="#" class="hover:text-ink">Changelog</a></li>
                    <li><a href="#" class="hover:text-ink">Status</a></li>
                    <li><a href="#" class="hover:text-ink">Refill policy</a></li>
                </ul>
            </div>

            <div class="col-span-6 md:col-span-2">
                <p class="mb-4 kicker text-muted" style="color:#6a6a72">Company</p>
                <ul class="space-y-2.5 text-sub text-[13.5px]">
                    <li><a href="#" class="hover:text-ink">About</a></li>
                    <li><a href="#" class="hover:text-ink">Customers</a></li>
                    <li><a href="#" class="hover:text-ink">Careers</a></li>
                    <li><a href="#" class="hover:text-ink">Contact</a></li>
                </ul>
            </div>

            <div class="col-span-6 md:col-span-2">
                <p class="mb-4 kicker text-muted" style="color:#6a6a72">Legal</p>
                <ul class="space-y-2.5 text-sub text-[13.5px]">
                    <li><a href="#" class="hover:text-ink">Terms</a></li>
                    <li><a href="#" class="hover:text-ink">Privacy</a></li>
                    <li><a href="#" class="hover:text-ink">DPA</a></li>
                </ul>
            </div>
        </div>

        <div
            class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 mt-14 pt-6 border-t border-border flex flex-col md:flex-row items-center justify-between gap-3 text-[12.5px] text-muted">
            <span>© 2026 {{ getDomain() }}. All rights reserved.</span>
            <span class="font-mono">v2.0 · build 4821</span>
        </div>
    </footer>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            if (reduceMotion) {
                document.querySelectorAll('.reveal').forEach((el) => el.classList.add('in'));
                return;
            }
            const io = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in');
                        io.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -6% 0px'
            });
            document.querySelectorAll('.reveal').forEach((el) => io.observe(el));
        });
    </script>
</body>

</html>
