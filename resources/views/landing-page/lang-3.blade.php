<!DOCTYPE html>
<html lang="vi" class="">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#f8f7f4" />
    <title>{{ getDomain() }} — SMM Panel for studios, agencies & resellers</title>

    <meta name="description"
        content="Production-grade SMM panel: 620+ services across 14 social networks. Wholesale rates per 1K, 30-day refill, REST API." />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ getDomain() }} — SMM Panel" />

    <!-- Set theme before paint to avoid flash -->
    <script>
        (function() {
            const saved = localStorage.getItem('sb-theme');
            const sys = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = saved || sys;
            if (theme === 'dark') document.documentElement.classList.add('dark');
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin />

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;450;500;600;700&family=Instrument+Serif:ital@0;1&family=JetBrains+Mono:wght@400;500&display=swap"
        rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
                        serif: ['"Instrument Serif"', 'Georgia', 'serif'],
                        mono: ['"JetBrains Mono"', 'ui-monospace', 'monospace'],
                    },
                    letterSpacing: {
                        'tightest': '-0.04em',
                        'tighter': '-0.025em',
                    },
                    fontSize: {
                        'hero': ['clamp(2.75rem, 6.5vw, 5.5rem)', {
                            lineHeight: '0.96',
                            letterSpacing: '-0.04em'
                        }],
                        'h2': ['clamp(1.75rem, 3.6vw, 2.875rem)', {
                            lineHeight: '1.05',
                            letterSpacing: '-0.025em'
                        }],
                        'h3': ['1.25rem', {
                            lineHeight: '1.25',
                            letterSpacing: '-0.015em'
                        }],
                        'stat': ['clamp(2rem, 4.5vw, 3rem)', {
                            lineHeight: '1',
                            letterSpacing: '-0.03em'
                        }],
                    }
                }
            }
        };
    </script>

    <style>
        /* ============ THEME TOKENS ============ */
        :root {
            --paper: #f8f7f4;
            --paper2: #f1efe9;
            --surface: #ffffff;
            --line: #e6e3dc;
            --line-strong: #d6d2c8;
            --ink: #0e0e0c;
            --sub: #5a584f;
            --muted: #8a8678;
            --faint: #b8b4a8;
            --indigo: #3d2bff;
            --indigo-deep: #2a1cc4;
            --indigo50: #eeebff;
            --saffron: #e87b18;
            --forest: #16794a;
            --crimson: #b3261e;
            --code-bg: #0e0e0c;
            --code-fg: #ededed;
            --grid-color: rgba(14, 14, 12, .04);
            --on-ink: #f8f7f4;
        }

        html.dark {
            --paper: #0a0b0d;
            --paper2: #0f1115;
            --surface: #14161b;
            --line: #22252c;
            --line-strong: #32363f;
            --ink: #f1efe9;
            --sub: #a8a59c;
            --muted: #6e6c64;
            --faint: #45433e;
            --indigo: #8e7bff;
            --indigo-deep: #6f59ff;
            --indigo50: #1a1635;
            --saffron: #f7a14c;
            --forest: #4dd58f;
            --crimson: #ff6b66;
            --code-bg: #050608;
            --code-fg: #ededed;
            --grid-color: rgba(255, 255, 255, .04);
            --on-ink: #f1efe9;
        }

        html {
            background: var(--paper);
            scroll-behavior: smooth;
            transition: background-color .3s;
        }

        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: var(--paper);
            color: var(--ink);
            font-feature-settings: "ss01", "ss03", "cv11";
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
            transition: background-color .3s, color .3s;
        }

        /* ============ UTILITY CLASSES ============ */
        .bg-paper {
            background: var(--paper);
        }

        .bg-paper2 {
            background: var(--paper2);
        }

        .bg-surface {
            background: var(--surface);
        }

        .bg-ink {
            background: var(--ink);
        }

        .text-ink {
            color: var(--ink);
        }

        .text-sub {
            color: var(--sub);
        }

        .text-muted {
            color: var(--muted);
        }

        .text-faint {
            color: var(--faint);
        }

        .text-indigo {
            color: var(--indigo);
        }

        .text-forest {
            color: var(--forest);
        }

        .text-saffron {
            color: var(--saffron);
        }

        .text-crimson {
            color: var(--crimson);
        }

        .text-on-ink {
            color: var(--on-ink);
        }

        .border-line {
            border-color: var(--line);
        }

        .border-line-strong {
            border-color: var(--line-strong);
        }

        .divide-line>*+* {
            border-color: var(--line);
        }

        .grid-bg {
            background-image:
                linear-gradient(to right, var(--grid-color) 1px, transparent 1px),
                linear-gradient(to bottom, var(--grid-color) 1px, transparent 1px);
            background-size: 48px 48px;
            mask-image: radial-gradient(ellipse 80% 60% at 50% 0%, #000 30%, transparent 90%);
        }

        .grad-text {
            background: linear-gradient(180deg, var(--ink) 0%, var(--sub) 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .ital {
            font-family: 'Instrument Serif', serif;
            font-style: italic;
            font-weight: 400;
            color: var(--indigo);
        }

        .card {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 14px;
        }

        .card-paper {
            background: var(--paper2);
            border: 1px solid var(--line);
            border-radius: 14px;
        }

        /* Buttons */
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
            transition: background .15s, color .15s, border-color .15s, transform .15s;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--ink);
            color: var(--paper);
            box-shadow: 0 1px 0 rgba(255, 255, 255, .15) inset, 0 1px 2px rgba(0, 0, 0, .1);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
        }

        .btn-ghost {
            background: transparent;
            color: var(--ink);
            border: 1px solid var(--line-strong);
        }

        .btn-ghost:hover {
            background: var(--paper2);
            border-color: var(--muted);
        }

        .btn-indigo {
            background: var(--indigo);
            color: #fff;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .2) inset, 0 6px 18px -8px rgba(61, 43, 255, .6);
        }

        html.dark .btn-indigo {
            color: #fff;
            box-shadow: 0 6px 24px -8px rgba(142, 123, 255, .5);
        }

        .btn-indigo:hover {
            transform: translateY(-1px);
        }

        .btn-lg {
            height: 44px;
            padding: 0 18px;
            font-size: 14px;
            border-radius: 10px;
        }

        .btn-sm {
            height: 30px;
            padding: 0 10px;
            font-size: 12.5px;
            border-radius: 7px;
        }

        .btn-icon {
            width: 34px;
            height: 34px;
            padding: 0;
            justify-content: center;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            height: 26px;
            padding: 0 10px;
            border-radius: 999px;
            background: var(--surface);
            border: 1px solid var(--line);
            font-size: 12px;
            color: var(--sub);
            font-weight: 450;
        }

        .pill .dot {
            width: 6px;
            height: 6px;
            border-radius: 999px;
            background: var(--forest);
            box-shadow: 0 0 0 3px rgba(22, 121, 74, .12);
        }

        html.dark .pill .dot {
            box-shadow: 0 0 0 3px rgba(77, 213, 143, .15);
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            height: 30px;
            padding: 0 11px;
            border-radius: 8px;
            background: var(--surface);
            border: 1px solid var(--line);
            font-size: 12.5px;
            color: var(--sub);
            cursor: pointer;
            transition: all .15s;
        }

        .chip:hover {
            color: var(--ink);
            border-color: var(--line-strong);
        }

        .chip.active {
            background: var(--ink);
            border-color: var(--ink);
            color: var(--paper);
        }

        .kicker {
            font-family: 'JetBrains Mono', monospace;
            font-size: 11px;
            color: var(--indigo);
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 500;
        }

        .kicker-muted {
            color: var(--muted);
        }

        .code {
            background: var(--code-bg);
            border: 1px solid #1d1f23;
            border-radius: 12px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 12.5px;
            line-height: 1.75;
            color: var(--code-fg);
        }

        .code .k {
            color: #c084fc;
        }

        .code .s {
            color: #95eab0;
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

        .reveal {
            opacity: 0;
            transform: translateY(12px);
            transition: opacity .6s ease, transform .6s cubic-bezier(.22, 1, .36, 1);
        }

        .reveal.in {
            opacity: 1;
            transform: none;
        }

        .marquee {
            display: flex;
            gap: 3.5rem;
            animation: scroll 50s linear infinite;
        }

        @keyframes scroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .tnum {
            font-variant-numeric: tabular-nums;
        }

        .navlink {
            color: var(--sub);
            transition: color .15s;
        }

        .navlink:hover {
            color: var(--ink);
        }

        .lnk {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            color: var(--ink);
        }

        .lnk .arr {
            transition: transform .15s;
        }

        .lnk:hover .arr {
            transform: translateX(3px);
        }

        /* Sidebar index */
        .idx-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .35rem .35rem;
            font-size: 12.5px;
            color: var(--muted);
            transition: color .15s;
            font-family: 'JetBrains Mono', monospace;
            letter-spacing: 0.02em;
        }

        .idx-link:hover,
        .idx-link.active {
            color: var(--ink);
        }

        .idx-link .idx-num {
            color: var(--faint);
            transition: color .15s;
        }

        .idx-link.active .idx-num,
        .idx-link:hover .idx-num {
            color: var(--indigo);
        }

        .idx-link .idx-bar {
            width: 16px;
            height: 1px;
            background: var(--line-strong);
            transition: width .25s, background .15s;
        }

        .idx-link.active .idx-bar {
            width: 28px;
            background: var(--indigo);
        }

        /* Status dots */
        .dot-forest {
            background: var(--forest);
            box-shadow: 0 0 0 3px rgba(22, 121, 74, .12);
        }

        .dot-saffron {
            background: var(--saffron);
            box-shadow: 0 0 0 3px rgba(232, 123, 24, .15);
        }

        .dot-indigo {
            background: var(--indigo);
            box-shadow: 0 0 0 3px rgba(61, 43, 255, .15);
        }

        .dot-crimson {
            background: var(--crimson);
            box-shadow: 0 0 0 3px rgba(179, 38, 30, .12);
        }

        ::selection {
            background: var(--indigo);
            color: #fff;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Network card brand colors */
        .net-card {
            transition: all .25s;
        }

        .net-card:hover {
            transform: translateY(-3px);
            border-color: var(--line-strong);
            box-shadow: 0 14px 36px -16px rgba(14, 14, 12, .18);
        }

        html.dark .net-card:hover {
            box-shadow: 0 14px 36px -16px rgba(0, 0, 0, .5);
        }

        /* Brand square backgrounds */
        .brand-ig {
            background: linear-gradient(135deg, #feda75, #fa7e1e, #d62976);
        }

        .brand-tt {
            background: linear-gradient(135deg, #25f4ee, #ffffff 50%, #fe2c55);
        }

        .brand-yt {
            background: #ff0033;
        }

        .brand-fb {
            background: #0866ff;
        }

        .brand-tg {
            background: #2aabee;
        }

        .brand-sp {
            background: #1ed760;
        }

        .brand-x {
            background: #0a0a0a;
        }

        .brand-th {
            background: #0a0a0a;
        }

        .brand-li {
            background: #0a66c2;
        }

        .brand-tw {
            background: #9146ff;
        }

        .brand-sc {
            background: #ff5500;
        }

        .brand-pi {
            background: #e60023;
        }

        .brand-dc {
            background: #5865f2;
        }

        .brand-sn {
            background: #fffc00;
            color: #0a0a0a !important;
        }

        section[id] {
            scroll-margin-top: 70px;
        }

        .bleed-line {
            border-top: 1px solid var(--line);
            border-bottom: 1px solid var(--line);
        }

        .glow-hover {
            transition: border-color .2s, transform .2s, box-shadow .2s;
        }

        .glow-hover:hover {
            border-color: var(--line-strong);
            transform: translateY(-2px);
            box-shadow: 0 12px 32px -16px rgba(14, 14, 12, .18);
        }

        /* Theme toggle */
        .theme-toggle {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            border: 1px solid var(--line-strong);
            background: transparent;
            color: var(--ink);
            transition: background .15s, border-color .15s;
            cursor: pointer;
        }

        .theme-toggle:hover {
            background: var(--paper2);
            border-color: var(--muted);
        }

        .theme-toggle .icon-sun {
            display: none;
        }

        .theme-toggle .icon-moon {
            display: block;
        }

        html.dark .theme-toggle .icon-sun {
            display: block;
        }

        html.dark .theme-toggle .icon-moon {
            display: none;
        }

        @media (prefers-reduced-motion: reduce) {

            .reveal,
            .marquee {
                opacity: 1;
                transform: none;
                animation: none;
            }
        }

        /* ============ MOBILE RESPONSIVE ============ */

        /* Prevent horizontal scroll on all devices */
        html,
        body {
            overflow-x: hidden;
        }

        /* --- Tablet (≤ 767px) --- */
        @media (max-width: 767px) {
            section {
                padding-top: 3.5rem;
                padding-bottom: 3.5rem;
            }

            .text-hero {
                font-size: clamp(2.2rem, 8vw, 3.5rem);
            }

            .text-stat {
                font-size: clamp(1.5rem, 5vw, 2rem);
            }

            .code {
                font-size: 11px;
            }

            .code pre {
                font-size: 10.5px;
                overflow-x: auto;
            }

            .text-xl {
                font-size: 1rem;
            }
        }

        /* --- Phone (≤ 479px) --- */
        @media (max-width: 479px) {
            .pill {
                font-size: 10.5px;
                height: 22px;
                padding: 0 7px;
            }

            .pill .dot {
                width: 5px;
                height: 5px;
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

            .btn-sm {
                height: 28px;
                padding: 0 8px;
                font-size: 12px;
            }

            .chip {
                height: 26px;
                padding: 0 7px;
                font-size: 11px;
            }

            .text-stat {
                font-size: 1.25rem;
            }

            .kicker {
                font-size: 10px;
                letter-spacing: 0.06em;
            }

            .text-h2 {
                font-size: clamp(1.4rem, 5vw, 2rem);
            }

            .text-h3 {
                font-size: 1.1rem;
            }
        }

        /* --- Tiny (≤ 374px, iPhone SE) --- */
        @media (max-width: 374px) {
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

            .text-hero {
                font-size: 1.8rem;
            }
        }
    </style>

    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>

    <!-- ===================== TOP NAV ===================== -->
    <header x-data="{ open: false }" class="sticky top-0 z-50 backdrop-blur-xl border-b border-line"
        style="background: color-mix(in srgb, var(--paper) 85%, transparent);">
        <div class="w-full px-4 sm:px-6 lg:px-10 h-[60px] flex items-center justify-between gap-3 relative">
            <div class="flex items-center gap-4 sm:gap-8 min-w-0">
                <a href="#"
                    class="flex items-center gap-2 font-semibold tracking-tight text-[15px] flex-shrink-0">
                    @if (!empty($config->logo))
                        <img src="{{ $config->logo }}" alt="{{ getDomain() }}"
                            class="w-6 h-6 rounded-md object-contain" />
                    @endif
                    <span class="hidden sm:inline">{{ getDomain() }}</span>
                </a>
                <span class="hidden lg:inline text-faint">·</span>
                <span class="hidden lg:inline text-[12.5px] font-mono text-muted">SMM panel / v2.0</span>
            </div>

            <nav class="hidden md:flex items-center gap-6 text-[13.5px] absolute left-1/2 -translate-x-1/2">
                <a href="#networks" class="navlink">Networks</a>
                <a href="#platforms" class="navlink">Catalogue</a>
                <a href="#features" class="navlink">Features</a>
                <a href="#api" class="navlink">API</a>
                <a href="#pricing" class="navlink">Pricing</a>
                <a href="#" class="navlink">Docs ↗</a>
            </nav>

            <div class="flex items-center gap-2 flex-shrink-0">
                <button onclick="toggleTheme()" class="theme-toggle" aria-label="Toggle theme" title="Toggle theme">
                    <svg class="icon-moon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                    </svg>
                    <svg class="icon-sun" width="15" height="15" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="4" />
                        <path
                            d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41" />
                    </svg>
                </button>
                <a href="#" class="hidden md:inline-flex btn btn-ghost btn-sm">Sign in</a>
                <a href="#" class="hidden md:inline-flex btn btn-primary btn-sm">
                    Open panel
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2.5">
                        <path d="M5 12h14M13 5l7 7-7 7" />
                    </svg>
                </a>

                <button @click="open = !open"
                    class="md:hidden flex-shrink-0 inline-flex items-center justify-center w-10 h-10 rounded-lg border border-line-strong hover:bg-paper2 active:bg-paper2 transition-colors"
                    :aria-label="open ? 'Close menu' : 'Open menu'" :aria-expanded="open" aria-controls="mobile-nav">
                    <svg x-show="!open" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="open" x-cloak width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M18 6L6 18M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <div x-show="open" x-collapse x-cloak id="mobile-nav" class="md:hidden border-t border-line bg-paper">
            <nav class="px-5 py-5 flex flex-col gap-1 text-sub text-sm">
                <a href="#networks" @click="open=false"
                    class="py-2.5 px-3 rounded-lg hover:bg-paper2 hover:text-ink transition-colors">Networks</a>
                <a href="#platforms" @click="open=false"
                    class="py-2.5 px-3 rounded-lg hover:bg-paper2 hover:text-ink transition-colors">Catalogue</a>
                <a href="#features" @click="open=false"
                    class="py-2.5 px-3 rounded-lg hover:bg-paper2 hover:text-ink transition-colors">Features</a>
                <a href="#api" @click="open=false"
                    class="py-2.5 px-3 rounded-lg hover:bg-paper2 hover:text-ink transition-colors">API</a>
                <a href="#pricing" @click="open=false"
                    class="py-2.5 px-3 rounded-lg hover:bg-paper2 hover:text-ink transition-colors">Pricing</a>
                <div class="flex gap-2 pt-4 mt-2 border-t border-line">
                    <a href="#" class="btn btn-ghost flex-1 justify-center">Sign in</a>
                    <a href="#" class="btn btn-primary flex-1 justify-center">Open panel</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- ===================== MAIN GRID — sidebar + content ===================== -->
    <div class="max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-10 grid grid-cols-12 gap-x-4 lg:gap-x-10">

        <!-- ============ STICKY SIDEBAR INDEX ============ -->
        <aside class="hidden lg:block col-span-2 relative">
            <nav class="sticky top-[80px] py-12 space-y-1.5" x-data="{ active: 'intro' }" x-init="const sections = ['intro', 'networks', 'platforms', 'features', 'workflow', 'dashboard', 'api', 'pricing', 'customers', 'faq'];
            const io = new IntersectionObserver((entries) => {
                entries.forEach(e => { if (e.isIntersecting) active = e.target.id; });
            }, { rootMargin: '-30% 0px -55% 0px' });
            sections.forEach(id => { const el = document.getElementById(id); if (el) io.observe(el); });">
                <p class="kicker kicker-muted mb-4">Index</p>
                @php
                    $idx = [
                        ['intro', 'Overview'],
                        ['networks', 'Networks'],
                        ['platforms', 'Catalogue'],
                        ['features', 'Features'],
                        ['workflow', 'Workflow'],
                        ['dashboard', 'Dashboard'],
                        ['api', 'API'],
                        ['pricing', 'Pricing'],
                        ['customers', 'Customers'],
                        ['faq', 'Notes'],
                    ];
                @endphp
                @foreach ($idx as $i => $row)
                    <a href="#{{ $row[0] }}" class="idx-link"
                        :class="active === '{{ $row[0] }}' ? 'active' : ''">
                        <span class="idx-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="idx-bar"></span>
                        <span>{{ $row[1] }}</span>
                    </a>
                @endforeach

                <div class="border-t border-line mt-8 pt-6 space-y-3">
                    <p class="kicker kicker-muted">Status</p>
                    <div class="text-[12px] space-y-1.5 font-mono text-sub">
                        <div class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full"
                                style="background: var(--forest)"></span> API · 99.98%</div>
                        <div class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full"
                                style="background: var(--forest)"></span> Panel · ok</div>
                        <div class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full"
                                style="background: var(--saffron)"></span> YT · paced</div>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- ============ MAIN CONTENT COLUMN ============ -->
        <main class="col-span-12 lg:col-span-10">

            <!-- ============ HERO — SPLIT 7/5 ============ -->
            <section id="intro" class="relative pt-14 lg:pt-20 pb-20 lg:pb-24 overflow-hidden">
                <div class="absolute inset-0 grid-bg pointer-events-none"></div>

                <div class="relative grid grid-cols-12 gap-8 items-start">
                    <div class="col-span-12 lg:col-span-7 reveal">
                        <div class="flex items-center gap-2 mb-7">
                            <span class="kicker">01 / Overview</span>
                            <span class="text-faint">—</span>
                            <span class="text-[12.5px] font-mono text-muted">Updated weekly</span>
                        </div>

                        <h1 class="text-hero font-medium grad-text">
                            Ship social<br />
                            campaigns with<br />
                            <span class="ital">precision.</span>
                        </h1>

                        <p class="mt-8 text-[16px] leading-relaxed max-w-xl text-sub">
                            {{ getDomain() }} is a production-grade SMM panel for studios, agencies, and resellers.
                            <span class="font-medium text-ink">620+ curated services</span> across
                            <span class="font-medium text-ink">14 social networks</span>, refill guarantee on every
                            order, and a documented REST API.
                        </p>

                        <div class="mt-9 flex flex-wrap items-center gap-3">
                            <a href="#" class="btn btn-indigo btn-lg">
                                Open a free panel
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path d="M5 12h14M13 5l7 7-7 7" />
                                </svg>
                            </a>
                            <a href="#api" class="btn btn-ghost btn-lg">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M16 18l6-6-6-6M8 6l-6 6 6 6" />
                                </svg>
                                Read the API
                            </a>
                        </div>

                        <div class="mt-10 inline-flex flex-wrap items-center gap-x-6 gap-y-2 text-[12.5px] text-muted">
                            <span class="inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full"
                                    style="background: var(--forest)"></span> No credit card</span>
                            <span class="text-faint">·</span>
                            <span class="inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full"
                                    style="background: var(--forest)"></span> Sandbox key on signup</span>
                            <span class="text-faint">·</span>
                            <span class="inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full"
                                    style="background: var(--forest)"></span> Cancel anytime</span>
                        </div>
                    </div>

                    <!-- Right 5/12 — vertical stat strip -->
                    <div class="col-span-12 lg:col-span-5 reveal">
                        <div class="card overflow-hidden">
                            <div
                                class="px-3 sm:px-5 py-3 sm:py-4 border-b border-line flex items-center justify-between">
                                <span class="kicker">Live · today</span>
                                <span class="pill"><span class="dot"></span>operational</span>
                            </div>

                            <div class="divide-y divide-line">
                                <div class="px-3 sm:px-5 py-3 sm:py-5 flex items-baseline justify-between gap-2">
                                    <div class="min-w-0">
                                        <p
                                            class="text-[10px] sm:text-[11px] text-muted uppercase tracking-wider truncate">
                                            Orders shipped · all-time</p>
                                        <p
                                            class="mt-1 text-xl sm:text-2xl md:text-3xl font-semibold tracking-tightest tnum">
                                            12,482,910</p>
                                    </div>
                                    <span class="text-forest text-[11px] sm:text-[12px] font-mono flex-shrink-0">↑
                                        4.2%</span>
                                </div>
                                <div class="px-3 sm:px-5 py-3 sm:py-5 flex items-baseline justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="text-[10px] sm:text-[11px] text-muted uppercase tracking-wider">
                                            Median delivery</p>
                                        <p
                                            class="mt-1 text-xl sm:text-2xl md:text-3xl font-semibold tracking-tightest tnum">
                                            4m 12s</p>
                                    </div>
                                    <span class="text-forest text-[11px] sm:text-[12px] font-mono flex-shrink-0">↓
                                        18s</span>
                                </div>
                                <div class="px-3 sm:px-5 py-3 sm:py-5 flex items-baseline justify-between gap-2">
                                    <div class="min-w-0">
                                        <p
                                            class="text-[10px] sm:text-[11px] text-muted uppercase tracking-wider truncate">
                                            Refill ratio · 90d MA</p>
                                        <p
                                            class="mt-1 text-xl sm:text-2xl md:text-3xl font-semibold tracking-tightest tnum">
                                            2.7%</p>
                                    </div>
                                    <span class="text-forest text-[11px] sm:text-[12px] font-mono flex-shrink-0">↓ 0.4
                                        pt</span>
                                </div>
                                <div class="px-3 sm:px-5 py-3 sm:py-5">
                                    <p
                                        class="text-[10px] sm:text-[11px] text-muted uppercase tracking-wider mb-2 sm:mb-3">
                                        Top platforms · last hour</p>
                                    <div class="space-y-2 sm:space-y-2.5 text-[12px] sm:text-[13px]">
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <span class="w-4 h-4 rounded-sm overflow-hidden flex-shrink-0"><img
                                                    src="/storage/images/tiktok.gif" alt="TikTok"
                                                    class="w-full h-full object-cover" /></span>
                                            <span class="flex-1">TikTok</span>
                                            <span class="font-mono tnum text-muted">142K</span>
                                        </div>
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <span class="w-4 h-4 rounded-sm overflow-hidden flex-shrink-0"><img
                                                    src="/storage/images/instagram.gif" alt="Instagram"
                                                    class="w-full h-full object-cover" /></span>
                                            <span class="flex-1">Instagram</span>
                                            <span class="font-mono tnum text-muted">88K</span>
                                        </div>
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <span class="w-4 h-4 rounded-sm overflow-hidden flex-shrink-0"><img
                                                    src="/storage/images/youtube.gif" alt="YouTube"
                                                    class="w-full h-full object-cover" /></span>
                                            <span class="flex-1">YouTube</span>
                                            <span class="font-mono tnum text-muted">22K</span>
                                        </div>
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <span class="w-4 h-4 rounded-sm overflow-hidden flex-shrink-0"><img
                                                    src="/storage/images/facebook.gif" alt="Facebook"
                                                    class="w-full h-full object-cover" /></span>
                                            <span class="flex-1">Facebook</span>
                                            <span class="font-mono tnum text-muted">16K</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- ============ TRUST / STATS STRIP ============ -->
    <section class="bleed-line bg-paper2">
        <div class="max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-10 py-8 sm:py-10 lg:py-12">
            <p class="kicker kicker-muted mb-7 text-center">By the numbers · v2.0</p>
            @php
                $trust = [
                    ['12.4M+', 'Orders processed'],
                    ['99.98%', 'API uptime · 90d'],
                    ['4m 12s', 'Avg delivery start'],
                    ['14', 'Networks'],
                    ['620+', 'Live services'],
                    ['2,100', 'Active resellers'],
                ];
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-y-8 gap-x-6">
                @foreach ($trust as $t)
                    <div class="text-center md:text-left">
                        <p class="text-stat font-semibold tracking-tightest tnum">{{ $t[0] }}</p>
                        <p class="mt-1.5 text-[11.5px] uppercase tracking-wider text-muted">{{ $t[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- ============ FULL-BLEED LOGO STRIP ============ -->
    <section class="bleed-line py-8 overflow-hidden bg-paper2">
        <div class="max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-10 mb-5">
            <p class="kicker kicker-muted text-center">Trusted by 2,400+ active panels</p>
        </div>
        <marquee behavior="scroll" direction="left" scrollamount="3"
            class="text-muted text-lg font-medium tracking-tight py-2">
            <span class="inline-flex items-center gap-14">
                <span>STUDIO BRICK</span><span class="text-faint">●</span>
                <span>NORTHLIGHT</span><span class="text-faint">●</span>
                <span>halftone.</span><span class="text-faint">●</span>
                <span>FOLIO/24</span><span class="text-faint">●</span>
                <span>Saigon Co.</span><span class="text-faint">●</span>
                <span>METHOD &amp; CO</span><span class="text-faint">●</span>
                <span>plainwork™</span><span class="text-faint">●</span>
                <span>OFFLOAD</span><span class="text-faint">●</span>
                <span>QUIETMARK</span><span class="text-faint">●</span>
                <span>tape/tape</span><span class="text-faint">●</span>
                <span>STUDIO BRICK</span><span class="text-faint">●</span>
                <span>NORTHLIGHT</span><span class="text-faint">●</span>
                <span>halftone.</span><span class="text-faint">●</span>
                <span>FOLIO/24</span><span class="text-faint">●</span>
                <span>Saigon Co.</span><span class="text-faint">●</span>
                <span>METHOD &amp; CO</span><span class="text-faint">●</span>
                <span>plainwork™</span><span class="text-faint">●</span>
                <span>OFFLOAD</span><span class="text-faint">●</span>
                <span>QUIETMARK</span><span class="text-faint">●</span>
                <span>tape/tape</span><span class="text-faint">●</span>
            </span>
        </marquee>
    </section>

    <!-- ============ MAIN GRID CONTINUES ============ -->
    <div class="max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-10 grid grid-cols-12 gap-x-4 lg:gap-x-10">
        <div class="hidden lg:block col-span-2"></div>
        <main class="col-span-12 lg:col-span-10">

            <!-- ============ 02 · NETWORKS — full grid of 14 ============ -->
            <section id="networks" class="py-24 lg:py-28 border-t border-line">
                <div class="grid grid-cols-12 gap-6 items-start mb-12 reveal">
                    <div class="col-span-12 md:col-span-5">
                        <p class="kicker mb-3">02 / Networks</p>
                        <h2 class="text-h2 font-medium grad-text">Fourteen networks,<br />one <span
                                class="ital">key.</span></h2>
                    </div>
                    <div class="col-span-12 md:col-span-7 md:pl-8 md:border-l border-line">
                        <p class="text-[15px] leading-relaxed text-sub">From global giants to niche channels —
                            campaigns across short-form video, music streaming, professional networks and community
                            platforms. One API key unlocks them all.</p>
                        <div class="mt-5 flex flex-wrap gap-x-5 gap-y-1.5 text-[12px] font-mono text-muted">
                            <span>14 networks</span><span>·</span>
                            <span>620+ services</span><span>·</span>
                            <span>refill on 80% of catalogue</span>
                        </div>
                    </div>
                </div>

                @php
                    $networks = [
                        [
                            'k' => 'ig',
                            'name' => 'Instagram',
                            'tag' => '92 services',
                            'from' => '9,500 ₫',
                            'sub' => 'Followers · Reels · Stories',
                            'brand' => 'brand-ig',
                            'svg' =>
                                '<svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M12 2.2c3.2 0 3.6 0 4.8.1 1.2.1 1.8.2 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.4 1 .4 2.2.1 1.2.1 1.6.1 4.8s0 3.6-.1 4.8c-.1 1.2-.2 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .4-2.2.4-1.2.1-1.6.1-4.8.1s-3.6 0-4.8-.1c-1.2-.1-1.8-.2-2.2-.4-.6-.2-1-.5-1.4-.9-.4-.4-.7-.8-.9-1.4-.2-.4-.4-1-.4-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.8c.1-1.2.2-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.4 2.2-.4C8.4 2.2 8.8 2.2 12 2.2zm0 1.8c-3.1 0-3.5 0-4.7.1-1.1 0-1.7.2-2.1.4-.5.2-.9.4-1.3.8-.4.4-.6.8-.8 1.3-.2.4-.3 1-.4 2.1C2.6 9.9 2.6 10.2 2.6 12s0 2.1.1 3.3c0 1.1.2 1.7.4 2.1.2.5.4.9.8 1.3.4.4.8.6 1.3.8.4.2 1 .3 2.1.4 1.2.1 1.6.1 4.7.1s3.5 0 4.7-.1c1.1 0 1.7-.2 2.1-.4.5-.2.9-.4 1.3-.8.4-.4.6-.8.8-1.3.2-.4.3-1 .4-2.1.1-1.2.1-1.6.1-3.3s0-2.1-.1-3.3c0-1.1-.2-1.7-.4-2.1-.2-.5-.4-.9-.8-1.3-.4-.4-.8-.6-1.3-.8-.4-.2-1-.3-2.1-.4-1.2-.1-1.6-.1-4.7-.1zm0 3c2.8 0 5 2.2 5 5s-2.2 5-5 5-5-2.2-5-5 2.2-5 5-5zm0 8.2c1.8 0 3.2-1.4 3.2-3.2S13.8 8.8 12 8.8 8.8 10.2 8.8 12s1.4 3.2 3.2 3.2zm5.2-8.4c0 .6-.5 1.2-1.2 1.2s-1.2-.5-1.2-1.2.5-1.2 1.2-1.2 1.2.5 1.2 1.2z"/></svg>',
                        ],
                        [
                            'k' => 'tt',
                            'name' => 'TikTok',
                            'tag' => '78 services',
                            'from' => '11,000 ₫',
                            'sub' => 'Views · Likes · Followers',
                            'brand' => 'brand-tt',
                            'svg' =>
                                '<svg width="22" height="22" viewBox="0 0 24 24"><path fill="#0a0a0a" d="M19.5 6.6c-1.6-.4-2.9-1.5-3.6-3V3h-3v12c0 1.4-1.1 2.5-2.5 2.5S7.9 16.4 7.9 15s1.1-2.5 2.5-2.5c.2 0 .4 0 .6.1V9.5c-.2 0-.4-.1-.6-.1-3 0-5.5 2.5-5.5 5.6s2.5 5.6 5.5 5.6 5.5-2.5 5.5-5.6V9.4c1.2.9 2.6 1.4 4.1 1.4V7.8c-.2 0-.3-.1-.5-.1z"/></svg>',
                        ],
                        [
                            'k' => 'yt',
                            'name' => 'YouTube',
                            'tag' => '64 services',
                            'from' => '15,000 ₫',
                            'sub' => 'Watch time · Subs · Views',
                            'brand' => 'brand-yt',
                            'svg' =>
                                '<svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M21.6 7.2s-.2-1.4-.8-2c-.7-.8-1.5-.8-1.9-.8C16 4.1 12 4.1 12 4.1s-4 0-6.9.3c-.4.1-1.2 0-1.9.8-.6.6-.8 2-.8 2S2.2 8.8 2.2 10.4v1.5C2.2 13.5 2.4 15 2.4 15s.2 1.4.8 2c.7.8 1.7.8 2.1.9 1.6.1 6.7.3 6.7.3s4 0 6.9-.3c.4-.1 1.2 0 1.9-.8.6-.6.8-2 .8-2s.2-1.5.2-3.1V10.4c0-1.6-.2-3.2-.2-3.2zM10 14V8.4l5 2.8L10 14z"/></svg>',
                        ],
                        [
                            'k' => 'fb',
                            'name' => 'Facebook',
                            'tag' => '56 services',
                            'from' => '12,000 ₫',
                            'sub' => 'Page likes · Reach',
                            'brand' => 'brand-fb',
                            'svg' =>
                                '<svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M22 12c0-5.5-4.5-10-10-10S2 6.5 2 12c0 5 3.7 9.1 8.4 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.3v7C18.3 21.1 22 17 22 12z"/></svg>',
                        ],
                        [
                            'k' => 'tg',
                            'name' => 'Telegram',
                            'tag' => '42 services',
                            'from' => '4,000 ₫',
                            'sub' => 'Members · Views · Reactions',
                            'brand' => 'brand-tg',
                            'svg' =>
                                '<svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M9.4 16.3 9.2 19c.3 0 .5-.1.7-.3l1.6-1.5 3.4 2.5c.6.3 1.1.2 1.3-.6l2.4-11.3c.2-.9-.3-1.3-.9-1l-14.1 5.4c-1 .4-1 .9-.2 1.2l3.6 1.1L15.4 9c.4-.3.8-.1.5.2L9.4 16.3z"/></svg>',
                        ],
                        [
                            'k' => 'sp',
                            'name' => 'Spotify',
                            'tag' => '38 services',
                            'from' => '45,000 ₫',
                            'sub' => 'Plays · Listeners · Saves',
                            'brand' => 'brand-sp',
                            'svg' =>
                                '<svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm4.6 14.4c-.2.3-.6.4-.9.2-2.5-1.5-5.6-1.9-9.3-1-.3.1-.7-.1-.8-.5-.1-.3.1-.7.5-.8 4-.9 7.5-.5 10.3 1.2.3.2.4.6.2.9zm1.2-2.7c-.2.4-.7.5-1.1.3-2.8-1.7-7.1-2.2-10.4-1.2-.4.1-.9-.1-1-.5-.1-.4.1-.9.5-1 3.8-1.2 8.5-.6 11.8 1.4.3.2.4.7.2 1zm.1-2.9C14.5 8.8 8.9 8.6 5.7 9.6c-.5.2-1.1-.1-1.2-.6-.2-.5.1-1.1.6-1.2 3.7-1.1 9.8-.9 13.7 1.4.5.3.6.9.4 1.4-.3.4-1 .5-1.3.2z"/></svg>',
                        ],
                        [
                            'k' => 'x',
                            'name' => 'X · Twitter',
                            'tag' => '48 services',
                            'from' => '5,500 ₫',
                            'sub' => 'Followers · Reposts · Likes',
                            'brand' => 'brand-x',
                            'svg' =>
                                '<svg width="20" height="20" viewBox="0 0 24 24" fill="#fff"><path d="M18.2 2h3.4l-7.4 8.5L23 22h-6.8l-5.3-7-6.1 7H1.4l7.9-9L1 2h7l4.8 6.3L18.2 2zm-1.2 17.7h1.9L6.6 4.2H4.6L17 19.7z"/></svg>',
                        ],
                        [
                            'k' => 'th',
                            'name' => 'Threads',
                            'tag' => '24 services',
                            'from' => '8,500 ₫',
                            'sub' => 'Followers · Likes · Reposts',
                            'brand' => 'brand-th',
                            'svg' =>
                                '<svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M17.6 11.1c-.1 0-.2-.1-.3-.1-.2-3.5-2.1-5.5-5.3-5.5-1.9 0-3.6.8-4.6 2.3l1.8 1.2c.7-1.1 1.8-1.3 2.8-1.3 1.1 0 2 .3 2.5 1 .4.4.6 1.1.7 1.9-.7-.1-1.5-.2-2.3-.2-2.7 0-4.4 1.1-4.4 3.4 0 1.1.5 2 1.3 2.7.9.7 2 1 3.4.8 1.9-.2 3.3-1.4 3.8-3 .3.6.5 1.3.5 2.1 0 2.5-1.1 5.1-5.6 5.1-2.6 0-4.4-1-5.5-2.9-1.1-1.9-1.1-4.5-1.1-6.5 0-2 0-4.6 1.1-6.5C7.7 3.5 9.5 2.5 12.1 2.5c2.9 0 5 1.2 6.2 3.6.6 1.1.9 2.3 1 3.6.4.2.7.7.7 1.2 0 .7-.5 1.3-1.2 1.3 0 .2-.1.5-.3.7-.1.2-.5.2-.9 0zM12 13.7c-.6 0-1.2.2-1.7.4-.5.3-.7.7-.7 1.2 0 .5.4 1.2 1.9 1 1.4-.1 2.4-1.1 2.5-2.4-.6-.1-1.3-.2-2-.2z"/></svg>',
                        ],
                        [
                            'k' => 'li',
                            'name' => 'LinkedIn',
                            'tag' => '32 services',
                            'from' => '68,000 ₫',
                            'sub' => 'Connections · Post views',
                            'brand' => 'brand-li',
                            'svg' =>
                                '<svg width="20" height="20" viewBox="0 0 24 24" fill="#fff"><path d="M20.5 2h-17C2.7 2 2 2.7 2 3.5v17c0 .8.7 1.5 1.5 1.5h17c.8 0 1.5-.7 1.5-1.5v-17c0-.8-.7-1.5-1.5-1.5zM8 19H5V9h3v10zM6.5 7.7C5.6 7.7 5 7 5 6.2s.6-1.5 1.5-1.5c.8 0 1.5.7 1.5 1.5s-.7 1.5-1.5 1.5zM19 19h-3v-5.3c0-1.4-.5-2-1.5-2-1 0-1.6.7-1.6 2V19h-3V9h2.8v1.3c.5-.7 1.3-1.5 2.8-1.5s2.5 1 2.5 3V19z"/></svg>',
                        ],
                        [
                            'k' => 'tw',
                            'name' => 'Twitch',
                            'tag' => '28 services',
                            'from' => '42,000 ₫',
                            'sub' => 'Followers · Viewers · Bits',
                            'brand' => 'brand-tw',
                            'svg' =>
                                '<svg width="20" height="20" viewBox="0 0 24 24" fill="#fff"><path d="M4.3 2 2.5 6.4v14.3H8V24h3.2l3.3-3.3H19l5-5V2H4.3zm17 12.3-3.3 3.3h-5.4l-3.3 3.3v-3.3H5.6V4.3h15.7v10z"/><path d="M17.6 7.6h-2v5.7h2zm-5.7 0h-2v5.7h2z"/></svg>',
                        ],
                        [
                            'k' => 'sc',
                            'name' => 'SoundCloud',
                            'tag' => '22 services',
                            'from' => '38,000 ₫',
                            'sub' => 'Plays · Likes · Reposts',
                            'brand' => 'brand-sc',
                            'svg' =>
                                '<svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M1.2 14.3v3.4c.1.2.3.4.5.4s.4-.2.5-.4v-3.4c-.1-.2-.3-.4-.5-.4s-.4.2-.5.4zm2.2-1v4.4c.1.2.3.4.5.4s.4-.2.5-.4v-4.4c-.1-.2-.3-.4-.5-.4s-.4.2-.5.4zm2.3-1v5.4c.1.3.3.4.5.4s.4-.2.5-.4v-5.4c-.1-.3-.3-.4-.5-.4s-.4.2-.5.4zm2.3-.7v6.1c.1.3.3.4.5.4s.4-.2.5-.4v-6.1c-.1-.3-.3-.4-.5-.4s-.4.2-.5.4zm2.4-.3v6.4c.1.3.3.4.5.4s.4-.2.5-.4v-6.4c-.1-.3-.3-.4-.5-.4s-.4.2-.5.4zm2.3 0v6.4c.1.3.3.4.5.4s.4-.2.5-.4v-6.4c-.1-.3-.3-.4-.5-.4s-.4.2-.5.4zm2.4-1v7.4c.1.3.3.4.5.4s.4-.2.5-.4v-7.4c-.1-.3-.3-.4-.5-.4s-.4.2-.5.4zm2.3-2.4v9.7c.1.4.4.6.6.6s.4-.2.6-.6V8c-.1-.4-.4-.6-.6-.6s-.4.2-.6.6zm2.7-2c-.4 0-.7.3-.7.7v11c0 .4.3.7.7.7h2.5c1.7 0 3-1.4 3-3 0-1.7-1.4-3-3-3-.4 0-.8.1-1.2.2V6.5c0-.4-.3-.7-.7-.7z"/></svg>',
                        ],
                        [
                            'k' => 'pi',
                            'name' => 'Pinterest',
                            'tag' => '18 services',
                            'from' => '52,000 ₫',
                            'sub' => 'Saves · Followers · Boards',
                            'brand' => 'brand-pi',
                            'svg' =>
                                '<svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M12 2C6.5 2 2 6.5 2 12c0 4.2 2.6 7.8 6.3 9.3-.1-.8-.2-2 0-2.8.2-.7 1.2-4.6 1.2-4.6s-.3-.6-.3-1.5c0-1.4.8-2.5 1.9-2.5.9 0 1.3.7 1.3 1.5 0 .9-.6 2.3-.9 3.6-.3 1.1.5 1.9 1.6 1.9 1.9 0 3.4-2 3.4-5 0-2.6-1.9-4.4-4.5-4.4-3.1 0-4.9 2.3-4.9 4.7 0 .9.4 1.9.8 2.5.1.1.1.2.1.3-.1.3-.3 1.1-.3 1.3 0 .2-.2.2-.4.1-1.4-.7-2.3-2.7-2.3-4.4 0-3.6 2.6-6.8 7.5-6.8 3.9 0 7 2.8 7 6.5 0 3.9-2.5 7.1-5.9 7.1-1.2 0-2.3-.6-2.6-1.3l-.7 2.7c-.3 1-1 2.3-1.4 3 1 .3 2.1.5 3.3.5 5.5 0 10-4.5 10-10S17.5 2 12 2z"/></svg>',
                        ],
                        [
                            'k' => 'dc',
                            'name' => 'Discord',
                            'tag' => '14 services',
                            'from' => '88,000 ₫',
                            'sub' => 'Server boosts · Members',
                            'brand' => 'brand-dc',
                            'svg' =>
                                '<svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M19.2 4.5C17.8 3.8 16.3 3.4 14.8 3.1c-.2.3-.4.7-.5 1-1.5-.2-3-.2-4.5 0-.1-.4-.3-.7-.5-1-1.6.3-3 .7-4.4 1.4C2.1 8.9 1.4 13.3 1.7 17.5c1.7 1.3 3.4 2 5 2.5.4-.6.8-1.2 1.1-1.8-.6-.2-1.2-.5-1.7-.9.1-.1.3-.2.4-.3 3.4 1.6 7.1 1.6 10.5 0 .1.1.3.2.4.3-.5.4-1.1.7-1.7.9.3.6.7 1.3 1.1 1.8 1.6-.5 3.3-1.3 5-2.5.4-4.9-.7-9.2-3.6-13zM8.5 14.8c-1 0-1.9-.9-1.9-2.1s.8-2.1 1.9-2.1 1.9.9 1.9 2.1-.8 2.1-1.9 2.1zm7.1 0c-1 0-1.9-.9-1.9-2.1s.8-2.1 1.9-2.1 1.9.9 1.9 2.1-.8 2.1-1.9 2.1z"/></svg>',
                        ],
                        [
                            'k' => 'sn',
                            'name' => 'Snapchat',
                            'tag' => '12 services',
                            'from' => '95,000 ₫',
                            'sub' => 'Followers · Views · Score',
                            'brand' => 'brand-sn',
                            'svg' =>
                                '<svg width="22" height="22" viewBox="0 0 24 24"><path fill="#0a0a0a" d="M12 2C8 2 6.5 4.9 6.5 7.5c0 .5 0 .9.1 1.4 0 .2 0 .4-.1.5-.2.3-.7.4-1 .4-.8.1-1.4.4-1.4.9 0 .1 0 .3.1.4.4 1 1.7 1.1 2.4 1.4.2.1.3.3.2.5-.2.7-1.4 2.4-3.2 2.7-.4.1-.6.4-.5.7.2 1 2.6 1.2 2.8 1.4.1.1.2.3.2.4.1.4.3 1.1.7 1.3.6.3 1.2.1 1.9 0 .8-.2 1.7-.2 2.4.3.7.5 1.5 1.1 2.9 1.1s2.2-.6 2.9-1.1c.7-.5 1.6-.5 2.4-.3.7.1 1.3.3 1.9 0 .4-.2.7-.9.7-1.3 0-.2.1-.3.2-.4.2-.1 2.5-.4 2.8-1.4.1-.3-.1-.6-.5-.7-1.8-.3-3-2-3.2-2.7-.1-.2 0-.4.2-.5.7-.3 2-.4 2.4-1.4 0-.1.1-.2.1-.4 0-.5-.6-.8-1.4-.9-.3-.1-.8-.1-1-.4-.1-.2-.1-.4-.1-.5.1-.4.1-.9.1-1.4C17.5 4.9 16 2 12 2z"/></svg>',
                        ],
                    ];
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 sm:gap-3 reveal">
                    @php
                        $networkGifs = [
                            'ig' => '/storage/images/instagram.gif',
                            'tt' => '/storage/images/tiktok.gif',
                            'yt' => '/storage/images/youtube.gif',
                            'fb' => '/storage/images/facebook.gif',
                            'tg' => '/storage/images/telegram.gif',
                            'x' => '/storage/images/x.gif',
                        ];
                    @endphp
                    @foreach ($networks as $n)
                        <a href="#" class="net-card card p-4 sm:p-5 group block">
                            <div class="flex items-start justify-between mb-3 sm:mb-5">
                                <div
                                    class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg {{ $n['brand'] }} overflow-hidden grid place-items-center">
                                    @if (isset($networkGifs[$n['k']]))
                                        <img src="{{ $networkGifs[$n['k']] }}" alt="{{ $n['name'] }}"
                                            class="w-full h-full object-cover" loading="lazy" />
                                    @else
                                        {!! $n['svg'] !!}
                                    @endif
                                </div>
                                <span
                                    class="font-mono text-[10px] sm:text-[10.5px] text-muted uppercase tracking-wider">{{ $n['tag'] }}</span>
                            </div>
                            <h3 class="font-semibold text-[14px] sm:text-[15.5px] tracking-tight">{{ $n['name'] }}
                            </h3>
                            <p class="text-[11.5px] sm:text-[12.5px] text-muted mt-0.5">{{ $n['sub'] }}</p>
                            <div
                                class="mt-4 sm:mt-5 pt-3 sm:pt-4 border-t border-line flex items-center justify-between text-[11px] sm:text-[12px]">
                                <span class="text-muted">from <span
                                        class="text-ink font-medium tnum">{{ $n['from'] }}</span> / 1K</span>
                                <span class="text-indigo opacity-0 group-hover:opacity-100 transition">→</span>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Bottom note -->
                <div class="mt-8 reveal flex flex-wrap items-center justify-between gap-4 px-5 py-4 card-paper">
                    <p class="text-[13px] text-sub">
                        <span class="ital text-[15px]">More</span> networks on the roadmap — Kick, Bluesky, Lemon8, VK.
                    </p>
                    <a href="#" class="lnk text-[13px]">Request a network <span class="arr">→</span></a>
                </div>
            </section>

            <!-- ============ 03 · CATALOGUE — interactive tabs ============ -->
            <section id="platforms" class="py-24 lg:py-28 border-t border-line">
                <div class="grid grid-cols-12 gap-6 items-start mb-12 reveal">
                    <div class="col-span-12 md:col-span-5">
                        <p class="kicker mb-3">03 / Catalogue</p>
                        <h2 class="text-h2 font-medium grad-text">Rate cards by<br /><span
                                class="ital">network.</span></h2>
                    </div>
                    <div class="col-span-12 md:col-span-7 md:pl-8 md:border-l border-line">
                        <p class="text-[15px] leading-relaxed text-sub">Every service is tested for retention, priced
                            per 1,000 units, and tagged with its source — real / HQ / mixed. Click a tab to inspect that
                            network&rsquo;s top services.</p>
                    </div>
                </div>

                <div x-data="{ tab: 'ig' }" class="reveal">
                    <div class="flex flex-wrap gap-2 mb-6">
                        @php
                            $tabs = [
                                ['k' => 'ig', 'n' => 'Instagram', 'b' => 'brand-ig'],
                                ['k' => 'tt', 'n' => 'TikTok', 'b' => 'brand-tt'],
                                ['k' => 'yt', 'n' => 'YouTube', 'b' => 'brand-yt'],
                                ['k' => 'fb', 'n' => 'Facebook', 'b' => 'brand-fb'],
                                ['k' => 'tg', 'n' => 'Telegram', 'b' => 'brand-tg'],
                                ['k' => 'sp', 'n' => 'Spotify', 'b' => 'brand-sp'],
                                ['k' => 'x', 'n' => 'X · Twitter', 'b' => 'brand-x'],
                                ['k' => 'th', 'n' => 'Threads', 'b' => 'brand-th'],
                            ];
                            $tabGifs = [
                                'ig' => '/storage/images/instagram.gif',
                                'tt' => '/storage/images/tiktok.gif',
                                'yt' => '/storage/images/youtube.gif',
                                'fb' => '/storage/images/facebook.gif',
                                'tg' => '/storage/images/telegram.gif',
                                'x' => '/storage/images/x.gif',
                            ];
                        @endphp
                        @foreach ($tabs as $t)
                            <button @click="tab = '{{ $t['k'] }}'"
                                :class="tab === '{{ $t['k'] }}' ? 'chip active' : 'chip'">
                                @if (isset($tabGifs[$t['k']]))
                                    <span class="w-4 h-4 rounded-sm overflow-hidden flex-shrink-0"><img
                                            src="{{ $tabGifs[$t['k']] }}" alt="{{ $t['n'] }}"
                                            class="w-full h-full object-cover" /></span>
                                @else
                                    <span class="w-3 h-3 rounded-sm {{ $t['b'] }}"></span>
                                @endif
                                {{ $t['n'] }}
                            </button>
                        @endforeach
                    </div>

                    @php
                        $panels = [
                            'ig' => [
                                'title' => 'Instagram',
                                'tag' => 'Largest catalogue · 92 services',
                                'desc' =>
                                    'Followers (real / mixed / HQ), Reels views, Story views, post likes, comments, save signals.',
                                'rows' => [
                                    ['Followers — real tier', '5–10K/day', '30 days', '38,000 ₫'],
                                    ['Followers — HQ', '15K/day', '15 days', '22,000 ₫'],
                                    ['Reels Views', 'instant', '—', '14,000 ₫'],
                                    ['Story Views', 'instant', '—', '11,000 ₫'],
                                    ['Post Likes', 'instant', '30 days', '9,500 ₫'],
                                    ['Comments — custom', '2–6h', '—', '420,000 ₫'],
                                ],
                            ],
                            'tt' => [
                                'title' => 'TikTok',
                                'tag' => 'Highest volume · 78 services',
                                'desc' =>
                                    'Video views, follows, likes, shares, saves, comment seeding, hashtag campaigns.',
                                'rows' => [
                                    ['Video Views', 'instant', '—', '12,000 ₫'],
                                    ['Followers — real', '2–5K/day', '30 days', '56,000 ₫'],
                                    ['Followers — HQ', '10K/day', '15 days', '28,000 ₫'],
                                    ['Likes', 'instant', '30 days', '11,000 ₫'],
                                    ['Shares', 'instant', '—', '18,000 ₫'],
                                    ['Saves', 'instant', '—', '24,000 ₫'],
                                ],
                            ],
                            'yt' => [
                                'title' => 'YouTube',
                                'tag' => 'Slowest, most durable · 64 services',
                                'desc' =>
                                    'Watch time (monetisable), subscribers, views (organic-paced), likes, comments, shorts.',
                                'rows' => [
                                    ['Watch Time — 4h videos', '4h/day', 'lifetime', '95,000 ₫'],
                                    ['Subscribers', '1–3K/day', '60 days', '180,000 ₫'],
                                    ['Views (organic)', '5K/day', '30 days', '42,000 ₫'],
                                    ['Shorts Views', 'instant', '—', '18,000 ₫'],
                                    ['Likes', 'instant', '30 days', '15,000 ₫'],
                                    ['Custom Comments', '24h', '—', '680,000 ₫'],
                                ],
                            ],
                            'fb' => [
                                'title' => 'Facebook',
                                'tag' => 'For brand pages',
                                'desc' =>
                                    'Page likes, follows, reactions, video views, group members, event responses.',
                                'rows' => [
                                    ['Page Likes', '2K/day', '30 days', '64,000 ₫'],
                                    ['Reactions', 'instant', '—', '12,000 ₫'],
                                    ['Video Views', 'instant', '—', '9,000 ₫'],
                                    ['Group Members', '1K/day', '30 days', '120,000 ₫'],
                                    ['Followers', '3K/day', '30 days', '52,000 ₫'],
                                    ['Shares', 'instant', '—', '22,000 ₫'],
                                ],
                            ],
                            'tg' => [
                                'title' => 'Telegram',
                                'tag' => 'Channels &amp; groups',
                                'desc' => 'Real members (geo-targeted), post views, reactions, vote bot upvotes.',
                                'rows' => [
                                    ['Members — real', '5K/day', '30 days', '78,000 ₫'],
                                    ['Members — geo VN', '2K/day', '15 days', '140,000 ₫'],
                                    ['Post Views', 'instant', '—', '4,000 ₫'],
                                    ['Reactions', 'instant', '—', '9,500 ₫'],
                                    ['Vote Upvotes', 'instant', '—', '12,000 ₫'],
                                    ['Auto Views — 1mo', '30 days', '—', '38,000 ₫'],
                                ],
                            ],
                            'sp' => [
                                'title' => 'Spotify',
                                'tag' => 'For labels &amp; artists',
                                'desc' => 'Plays (royalty-eligible), saves, monthly listeners, playlist follows.',
                                'rows' => [
                                    ['Plays — royalty eligible', 'organic-paced', '30 days', '220,000 ₫'],
                                    ['Saves', 'instant', '—', '45,000 ₫'],
                                    ['Monthly Listeners', '3–7 days', '—', '180,000 ₫'],
                                    ['Followers', '2K/day', '30 days', '85,000 ₫'],
                                    ['Playlist Follows', 'instant', '—', '38,000 ₫'],
                                    ['Premium Plays', '7 days', '30 days', '340,000 ₫'],
                                ],
                            ],
                            'x' => [
                                'title' => 'X · Twitter',
                                'tag' => 'Reposts &amp; replies',
                                'desc' =>
                                    'Followers, reposts, likes, bookmarks, replies, video views, impression boost.',
                                'rows' => [
                                    ['Followers', '2K/day', '30 days', '82,000 ₫'],
                                    ['Reposts', 'instant', '—', '24,000 ₫'],
                                    ['Likes', 'instant', '30 days', '12,000 ₫'],
                                    ['Bookmarks', 'instant', '—', '18,000 ₫'],
                                    ['Replies — custom', '12h', '—', '580,000 ₫'],
                                    ['Impressions', 'instant', '—', '5,500 ₫'],
                                ],
                            ],
                            'th' => [
                                'title' => 'Threads',
                                'tag' => 'Newest network',
                                'desc' =>
                                    'Followers, post likes, replies, reposts. Limited services as Meta opens APIs.',
                                'rows' => [
                                    ['Followers', '1–2K/day', '—', '72,000 ₫'],
                                    ['Likes', 'instant', '—', '14,000 ₫'],
                                    ['Reposts', 'instant', '—', '22,000 ₫'],
                                    ['Replies — custom', '24h', '—', '620,000 ₫'],
                                    ['Views', 'instant', '—', '8,500 ₫'],
                                    ['Profile Visits', 'instant', '—', '11,000 ₫'],
                                ],
                            ],
                        ];
                    @endphp

                    @foreach ($panels as $k => $p)
                        <div x-show="tab === '{{ $k }}'" x-cloak class="card overflow-hidden">
                            <div
                                class="p-4 sm:p-6 md:p-7 border-b border-line flex items-start justify-between gap-3 sm:gap-6 flex-wrap">
                                <div class="min-w-0">
                                    <h3 class="text-xl sm:text-2xl font-semibold tracking-tight">{{ $p['title'] }}
                                    </h3>
                                    <p class="mt-1 sm:mt-1.5 text-[11px] sm:text-[12.5px] font-mono text-muted">
                                        {!! $p['tag'] !!}</p>
                                    <p class="mt-2 sm:mt-3 text-[13px] sm:text-[14px] max-w-2xl text-sub">
                                        {{ $p['desc'] }}</p>
                                </div>
                                <a href="#" class="btn btn-ghost btn-sm whitespace-nowrap">View catalogue →</a>
                            </div>

                            <div
                                class="hidden md:grid grid-cols-12 px-6 md:px-7 py-2.5 border-b border-line kicker kicker-muted">
                                <div class="col-span-5">Service</div>
                                <div class="col-span-2">Speed</div>
                                <div class="col-span-2">Refill</div>
                                <div class="col-span-2 text-right">Rate / 1K</div>
                                <div class="col-span-1"></div>
                            </div>
                            @foreach ($p['rows'] as $r)
                                <div class="grid grid-cols-12 gap-y-1 px-3 sm:px-6 md:px-7 py-3 border-b border-line last:border-b-0 items-center text-[12px] sm:text-[13.5px]"
                                    style="transition: background .15s;"
                                    onmouseover="this.style.background='var(--paper2)'"
                                    onmouseout="this.style.background='transparent'">
                                    <div class="col-span-12 md:col-span-5 font-medium">{{ $r[0] }}</div>
                                    <div
                                        class="col-span-6 sm:col-span-4 md:col-span-2 font-mono text-[11px] sm:text-[12px] text-muted">
                                        <span class="md:hidden text-faint">Speed: </span>{{ $r[1] }}
                                    </div>
                                    <div
                                        class="col-span-6 sm:col-span-4 md:col-span-2 font-mono text-[11px] sm:text-[12px] text-muted">
                                        <span class="md:hidden text-faint">Refill: </span>{{ $r[2] }}
                                    </div>
                                    <div
                                        class="col-span-6 sm:col-span-4 md:col-span-2 md:text-right tnum font-medium text-[11px] sm:text-[12px]">
                                        <span class="md:hidden text-faint font-mono">Rate:
                                        </span>{{ $r[3] }}
                                    </div>
                                    <div class="col-span-6 sm:col-span-12 md:col-span-1 md:text-right mt-0 md:mt-0">
                                        <a href="#"
                                            class="text-indigo text-[12px] sm:text-[12.5px] font-medium lnk">Order
                                            <span class="arr">→</span></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- ============ 04 · FEATURES — alternating layout ============ -->
            <section id="features" class="py-24 lg:py-28 border-t border-line">
                <div class="grid grid-cols-12 gap-6 mb-14 reveal">
                    <div class="col-span-12 md:col-span-5">
                        <p class="kicker mb-3">04 / Features</p>
                        <h2 class="text-h2 font-medium grad-text">A panel that thinks<br />like an <span
                                class="ital">operator.</span></h2>
                    </div>
                    <div class="col-span-12 md:col-span-7 md:pl-8 md:border-l border-line">
                        <p class="text-[15px] leading-relaxed text-sub">Each feature is designed around the day-to-day
                            reality of running a paid social desk — order flow, observability, and refill economics.</p>
                    </div>
                </div>

                <!-- Drip scheduling -->
                <div class="grid grid-cols-12 gap-8 items-center py-10 border-t border-line reveal">
                    <div class="col-span-12 md:col-span-5">
                        <p class="kicker mb-3">i · Drip scheduling</p>
                        <h3 class="text-h3 font-semibold mb-3">Split a 100K order into <span
                                class="ital">organic-shaped drips.</span></h3>
                        <p class="text-[14px] leading-relaxed text-sub">Schedule delivery across hours or days, with
                            random jitter. Matches platform growth curves — no suspicious spikes that trigger detection.
                        </p>
                        <ul class="mt-5 space-y-1.5 text-[12.5px] font-mono text-sub">
                            <li>· Configurable window: 1h – 30d</li>
                            <li>· Jitter: 0.0 – 0.5 (±50%)</li>
                            <li>· Pause / resume mid-order</li>
                        </ul>
                    </div>
                    <div class="col-span-12 md:col-span-7">
                        <div class="card p-5">
                            <div class="flex items-center justify-between mb-4 text-[12px]">
                                <span class="text-muted">Drip plan · 100,000 over 24h</span>
                                <span class="font-mono text-ink">24 chunks · jitter 0.3</span>
                            </div>
                            <div class="flex items-end gap-1 h-20">
                                @php
                                    $heights = [
                                        38,
                                        52,
                                        44,
                                        68,
                                        71,
                                        49,
                                        58,
                                        73,
                                        82,
                                        66,
                                        84,
                                        70,
                                        92,
                                        88,
                                        76,
                                        62,
                                        58,
                                        71,
                                        80,
                                        68,
                                        54,
                                        46,
                                        40,
                                        36,
                                    ];
                                @endphp
                                @foreach ($heights as $h)
                                    <div class="flex-1 rounded-t-sm"
                                        style="height: {{ $h }}%; background: linear-gradient(to top, var(--indigo), color-mix(in srgb, var(--indigo) 50%, transparent));">
                                    </div>
                                @endforeach
                            </div>
                            <div class="grid grid-cols-4 mt-2 text-[10.5px] font-mono text-muted">
                                <span>00h</span><span class="text-center">06h</span><span
                                    class="text-center">12h</span><span class="text-right">24h</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Refill engine -->
                <div class="grid grid-cols-12 gap-8 items-center py-10 border-t border-line reveal">
                    <div class="col-span-12 md:col-span-7 md:order-1 order-2">
                        <div class="card p-3 sm:p-5 space-y-2">
                            <div
                                class="flex flex-wrap items-center justify-between gap-2 text-[12px] sm:text-[12.5px] px-2.5 sm:px-3.5 py-2 sm:py-2.5 rounded-lg border border-line">
                                <span class="font-mono text-muted">T+0h</span>
                                <span class="tnum">+10,000</span>
                                <span class="pill"><span class="dot dot-forest"></span>delivered</span>
                            </div>
                            <div
                                class="flex flex-wrap items-center justify-between gap-2 text-[12px] sm:text-[12.5px] px-2.5 sm:px-3.5 py-2 sm:py-2.5 rounded-lg border border-line">
                                <span class="font-mono text-muted">T+72h</span>
                                <span class="tnum text-crimson">–214</span>
                                <span class="pill"><span class="dot dot-saffron"></span>drop detected</span>
                            </div>
                            <div class="flex flex-wrap items-center justify-between gap-2 text-[12px] sm:text-[12.5px] px-2.5 sm:px-3.5 py-2 sm:py-2.5 rounded-lg border border-line"
                                style="background: var(--indigo50);">
                                <span class="font-mono text-muted">T+72h 04m</span>
                                <span class="tnum text-forest">+214</span>
                                <span class="pill"
                                    style="background: var(--surface); border-color: var(--indigo); color: var(--indigo);">
                                    <span class="dot dot-indigo"></span>auto-refilled
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 md:col-span-5 md:order-2 order-1">
                        <p class="kicker mb-3">ii · Refill engine</p>
                        <h3 class="text-h3 font-semibold mb-3">Detects drops. <span class="ital">Refills
                                automatically.</span></h3>
                        <p class="text-[14px] leading-relaxed text-sub">Polls every 6h during the refill window. If the
                            count dips below the contract floor, fires a refill before your customer notices.</p>
                        <ul class="mt-5 space-y-1.5 text-[12.5px] font-mono text-sub">
                            <li>· 6-hour poll cadence</li>
                            <li>· Configurable per-service window</li>
                            <li>· Pro-rata refund if refill impossible</li>
                        </ul>
                    </div>
                </div>

                <!-- 3 smaller -->
                <div class="grid grid-cols-12 gap-6 py-10 border-t border-line reveal">
                    <div class="col-span-12 md:col-span-4">
                        <p class="kicker mb-3">iii · Multi-link</p>
                        <h3 class="text-h3 font-semibold mb-2">Paste 1, post 500.</h3>
                        <p class="text-[13.5px] leading-relaxed text-sub">Bulk-paste up to 500 links per order.
                            Quantity-per-link override for agencies running clients in parallel.</p>
                        <div
                            class="mt-4 font-mono text-[11.5px] rounded-md p-3 leading-relaxed text-muted bg-paper2 border border-line">
                            tiktok.com/@studio/video/7384...<br />
                            tiktok.com/@studio/video/7385...<br />
                            tiktok.com/@studio/video/7386...<br />
                            <span class="text-faint">+ 47 more</span>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-4">
                        <p class="kicker mb-3">iv · Webhooks</p>
                        <h3 class="text-h3 font-semibold mb-2">Status pushed to you.</h3>
                        <p class="text-[13.5px] leading-relaxed text-sub">Subscribe to <code
                                class="font-mono text-indigo">order.*</code> events. Retries with backoff, signed with
                            HMAC.</p>
                        <div class="mt-4 space-y-1 text-[11.5px] font-mono">
                            <div><span class="text-forest">●</span> order.created</div>
                            <div><span class="text-saffron">●</span> order.processing</div>
                            <div><span class="text-forest">●</span> order.completed</div>
                            <div><span class="text-crimson">●</span> order.partial</div>
                            <div><span class="text-indigo">●</span> order.refill.fired</div>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-4">
                        <p class="kicker mb-3">v · Wallet</p>
                        <h3 class="text-h3 font-semibold mb-2">Top-up in seconds.</h3>
                        <p class="text-[13.5px] leading-relaxed text-sub">VietQR, MoMo, ZaloPay, USDT-TRC20,
                            international cards. Credits hit the wallet under a minute.</p>
                        <div class="mt-4 flex flex-wrap gap-1.5">
                            <span class="chip" style="cursor:default">VietQR</span>
                            <span class="chip" style="cursor:default">MoMo</span>
                            <span class="chip" style="cursor:default">ZaloPay</span>
                            <span class="chip" style="cursor:default">USDT</span>
                            <span class="chip" style="cursor:default">Visa</span>
                        </div>
                    </div>
                </div>

                <!-- Capability grid — SMM v2 mechanics -->
                <div class="pt-12 mt-12 border-t border-line reveal">
                    <div class="flex items-end justify-between gap-3 mb-6">
                        <p class="kicker">vi · More in v2</p>
                        <span class="text-[12px] font-mono text-muted">everything an operator needs</span>
                    </div>
                    @php
                        $caps = [
                            [
                                'Auto-refill & subscriptions',
                                'Recurring top-ups and standing refill contracts per service. Set it once, forget it.',
                            ],
                            [
                                'Mass order',
                                'Paste up to 500 links in one request, per-link quantity overrides, CSV import.',
                            ],
                            [
                                'Partial & cancel',
                                'Cancel while queued or under 25% delivered. Partial deliveries refund pro-rata in minutes.',
                            ],
                            ['Multi-currency wallet', 'One balance, charged in VND, USD or USDT-TRC20. No manual FX.'],
                            [
                                'Affiliate & reseller',
                                'Referral links, tiered commissions, payout ledger — all in-panel.',
                            ],
                            [
                                'Child-panel / white-label',
                                'Spin up a branded sub-panel with its own rate cards and customer wallets.',
                            ],
                        ];
                    @endphp
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($caps as $i => $c)
                            <div class="card-paper p-5 glow-hover">
                                <div class="flex items-center gap-2.5 mb-2">
                                    <span
                                        class="font-mono text-[11px] text-indigo tnum">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <h4 class="font-semibold text-[14.5px] tracking-tight">{{ $c[0] }}</h4>
                                </div>
                                <p class="text-[13px] leading-relaxed text-sub">{{ $c[1] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- ============ 05 · WORKFLOW ============ -->
            <section id="workflow" class="py-24 lg:py-28 border-t border-line">
                <div class="grid grid-cols-12 gap-6 mb-14 reveal">
                    <div class="col-span-12 md:col-span-5">
                        <p class="kicker mb-3">05 / Workflow</p>
                        <h2 class="text-h2 font-medium grad-text">Four steps,<br />from paste to <span
                                class="ital">delivered.</span></h2>
                    </div>
                    <div class="col-span-12 md:col-span-7 md:pl-8 md:border-l border-line">
                        <p class="text-[15px] leading-relaxed text-sub">A linear flow — built so an operator can place
                            their first real order within five minutes of signing in.</p>
                    </div>
                </div>

                <div class="relative reveal">
                    <div class="absolute left-[15px] top-2 bottom-2 w-px hidden md:block"
                        style="background: var(--line);"></div>

                    @php
                        $steps = [
                            [
                                '01',
                                'Create a panel',
                                'Email and password. No KYC for personal tier. A sandbox API key is generated the moment you sign in.',
                                '30 seconds',
                            ],
                            [
                                '02',
                                'Fund the wallet',
                                'VietQR auto-credit in seconds. USDT-TRC20 for international operators. Credits never expire.',
                                '~60 seconds',
                            ],
                            [
                                '03',
                                'Place an order',
                                'Paste a link — or 500. Pick a service, set quantity, optional drip schedule. Receipt with ETA is yours.',
                                '~90 seconds',
                            ],
                            [
                                '04',
                                'Watch it land',
                                'Live progress in the dashboard. Webhook events to your endpoint. Auto-refill if the count drifts.',
                                'live',
                            ],
                        ];
                    @endphp
                    @foreach ($steps as $s)
                        <div class="grid grid-cols-12 gap-6 py-8 md:py-10 relative">
                            <div class="col-span-12 md:col-span-1 relative">
                                <div class="w-8 h-8 rounded-full grid place-items-center text-[12px] font-mono tnum relative z-10"
                                    style="background: var(--ink); color: var(--paper);">{{ $s[0] }}</div>
                            </div>
                            <div class="col-span-12 md:col-span-6">
                                <h3 class="text-h3 font-semibold mb-2">{{ $s[1] }}</h3>
                                <p class="text-[14px] leading-relaxed text-sub">{{ $s[2] }}</p>
                            </div>
                            <div class="col-span-12 md:col-span-5 md:text-right">
                                <span class="pill"><span class="dot"></span>{{ $s[3] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- ============ 06 · DASHBOARD ============ -->
            <section id="dashboard" class="py-24 lg:py-28 border-t border-line">
                <div class="grid grid-cols-12 gap-6 mb-12 reveal">
                    <div class="col-span-12 md:col-span-5">
                        <p class="kicker mb-3">06 / Dashboard</p>
                        <h2 class="text-h2 font-medium grad-text">A panel that respects<br />your <span
                                class="ital">time.</span></h2>
                    </div>
                    <div class="col-span-12 md:col-span-7 md:pl-8 md:border-l border-line">
                        <p class="text-[15px] leading-relaxed text-sub">Built around the three things every operator
                            does in a day: place orders, watch them land, answer customer questions.</p>
                    </div>
                </div>

                <!-- Dashboard mock — always dark for contrast -->
                <div class="reveal">
                    <div class="rounded-2xl overflow-hidden border"
                        style="background: #0e0e0c; color: #f1efe9; border-color: var(--line);">
                        <div class="flex items-center gap-2 px-4 h-10 border-b"
                            style="border-color: rgba(255,255,255,.08);">
                            <span class="w-2.5 h-2.5 rounded-full" style="background:#ff5f57;"></span>
                            <span class="w-2.5 h-2.5 rounded-full" style="background:#febc2e;"></span>
                            <span class="w-2.5 h-2.5 rounded-full" style="background:#28c840;"></span>
                            <span class="ml-3 font-mono text-[11px]"
                                style="color:rgba(255,255,255,.4);">{{ getDomain() }} / orders</span>
                            <span class="ml-auto inline-flex items-center gap-1.5 text-[11px]"
                                style="color:rgba(255,255,255,.6);">
                                <span class="w-1.5 h-1.5 rounded-full" style="background:#4dd58f;"></span> Live
                            </span>
                        </div>

                        <div class="grid grid-cols-12" style="--divider:rgba(255,255,255,.08);">
                            <aside class="hidden lg:block col-span-3 p-5 text-[13px]"
                                style="border-right: 1px solid var(--divider);">
                                <p class="font-mono text-[11px] uppercase tracking-wider mb-4"
                                    style="color:rgba(255,255,255,.4);">Workspace</p>
                                <ul class="space-y-1.5" style="color:rgba(255,255,255,.6);">
                                    <li class="flex items-center justify-between px-2.5 py-1.5 rounded-md"
                                        style="background:rgba(255,255,255,.05); color:#fff;"><span>●
                                            Orders</span><span class="text-xs"
                                            style="color:rgba(255,255,255,.4);">⌘1</span></li>
                                    <li class="flex items-center justify-between px-2.5 py-1.5 rounded-md"><span>○
                                            Dashboard</span><span class="text-xs"
                                            style="color:rgba(255,255,255,.3);">⌘2</span></li>
                                    <li class="flex items-center justify-between px-2.5 py-1.5 rounded-md"><span>○
                                            Services</span><span class="text-xs"
                                            style="color:rgba(255,255,255,.3);">⌘3</span></li>
                                    <li class="flex items-center justify-between px-2.5 py-1.5 rounded-md"><span>○ API
                                            keys</span><span class="text-xs"
                                            style="color:rgba(255,255,255,.3);">⌘4</span></li>
                                    <li class="flex items-center justify-between px-2.5 py-1.5 rounded-md"><span>○
                                            Webhooks</span><span class="text-xs"
                                            style="color:rgba(255,255,255,.3);">⌘5</span></li>
                                    <li class="flex items-center justify-between px-2.5 py-1.5 rounded-md"><span>○
                                            Wallet</span><span class="text-xs"
                                            style="color:rgba(255,255,255,.3);">⌘6</span></li>
                                </ul>

                                <p class="font-mono text-[11px] uppercase tracking-wider mt-7 mb-3"
                                    style="color:rgba(255,255,255,.4);">Saved filters</p>
                                <ul class="space-y-1 text-[12.5px]" style="color:rgba(255,255,255,.6);">
                                    <li class="px-2.5 py-1">★ Today · processing</li>
                                    <li class="px-2.5 py-1">★ Refill candidates</li>
                                    <li class="px-2.5 py-1">★ Client: Studio Brick</li>
                                </ul>
                            </aside>

                            <div class="col-span-12 lg:col-span-9 p-5 lg:p-7">
                                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-5">
                                    <h3 class="text-base sm:text-lg font-semibold">Orders</h3>
                                    <span
                                        class="inline-flex items-center gap-1.5 text-[11px] sm:text-[12px] px-2 py-0.5 rounded-full"
                                        style="color:rgba(255,255,255,.6); border:1px solid rgba(255,255,255,.1);">
                                        <span class="w-1.5 h-1.5 rounded-full" style="background:#4dd58f;"></span> 14
                                        active
                                    </span>
                                    <div class="ml-auto flex flex-wrap items-center gap-1.5 sm:gap-2">
                                        <button class="text-[11px] sm:text-[12.5px] px-2 sm:px-2.5 py-1 rounded"
                                            style="border: 1px solid rgba(255,255,255,.15);">Filter</button>
                                        <button class="hidden sm:inline-block text-[12.5px] px-2.5 py-1 rounded"
                                            style="border: 1px solid rgba(255,255,255,.15);">Export</button>
                                        <button
                                            class="text-[11px] sm:text-[12.5px] px-2 sm:px-2.5 py-1 rounded font-medium"
                                            style="background:#f1efe9; color:#0e0e0c;">+ New</button>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
                                    @php
                                        $kpis = [
                                            ['In progress', '14', '↑ 4 vs yesterday', '#4dd58f'],
                                            ['Delivered · 24h', '128', 'avg 4m 12s', 'rgba(255,255,255,.6)'],
                                            ['Refill ratio', '2.7%', '↓ 0.4 pt', '#4dd58f'],
                                            ['Wallet', '12.48M ₫', 'Auto-top-up', 'rgba(255,255,255,.6)'],
                                        ];
                                    @endphp
                                    @foreach ($kpis as $k)
                                        <div class="rounded-lg p-3.5" style="border:1px solid rgba(255,255,255,.1);">
                                            <p class="text-[11px] uppercase tracking-wider"
                                                style="color:rgba(255,255,255,.4);">{{ $k[0] }}</p>
                                            <p class="text-xl font-semibold tnum mt-1">{{ $k[1] }}</p>
                                            <p class="text-[11px] mt-1" style="color:{{ $k[3] }};">
                                                {{ $k[2] }}</p>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="overflow-x-auto -mx-1 px-1">
                                    <div class="rounded-lg overflow-hidden min-w-[520px]"
                                        style="border:1px solid rgba(255,255,255,.1);">
                                        <div class="grid grid-cols-12 px-4 py-2.5 font-mono text-[10.5px] uppercase tracking-wider"
                                            style="background:rgba(255,255,255,.03); border-bottom:1px solid rgba(255,255,255,.1); color:rgba(255,255,255,.4);">
                                            <div class="col-span-3">Order</div>
                                            <div class="col-span-3">Service</div>
                                            <div class="col-span-2">Qty</div>
                                            <div class="col-span-2">Progress</div>
                                            <div class="col-span-2">Status</div>
                                        </div>
                                        @php
                                            $orders = [
                                                ['ord_482910', 'TikTok views', '50,000', '82', 'processing', '#f7a14c'],
                                                ['ord_482908', 'IG followers', '2,500', '100', 'completed', '#4dd58f'],
                                                [
                                                    'ord_482903',
                                                    'YouTube watch time',
                                                    '4,000h',
                                                    '12',
                                                    'queued',
                                                    '#8e7bff',
                                                ],
                                                [
                                                    'ord_482899',
                                                    'Telegram members',
                                                    '5,000',
                                                    '64',
                                                    'processing',
                                                    '#f7a14c',
                                                ],
                                                [
                                                    'ord_482894',
                                                    'IG reels views',
                                                    '120,000',
                                                    '100',
                                                    'completed',
                                                    '#4dd58f',
                                                ],
                                                [
                                                    'ord_482890',
                                                    'YT subscribers',
                                                    '1,200',
                                                    '38',
                                                    'processing',
                                                    '#f7a14c',
                                                ],
                                            ];
                                        @endphp
                                        @foreach ($orders as $o)
                                            <div class="grid grid-cols-12 px-4 py-3 items-center text-[13px]"
                                                style="border-bottom: 1px solid rgba(255,255,255,.08);">
                                                <div class="col-span-3 font-mono" style="color:rgba(255,255,255,.5);">
                                                    {{ $o[0] }}</div>
                                                <div class="col-span-3">{{ $o[1] }}</div>
                                                <div class="col-span-2 tnum" style="color:rgba(255,255,255,.8);">
                                                    {{ $o[2] }}</div>
                                                <div class="col-span-2">
                                                    <div class="h-1.5 rounded-full overflow-hidden"
                                                        style="background:rgba(255,255,255,.1);">
                                                        <div class="h-full"
                                                            style="width: {{ $o[3] }}%; background: {{ $o[5] }};">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-2">
                                                    <span
                                                        class="inline-flex items-center gap-1.5 text-[11.5px] px-2 py-0.5 rounded-full"
                                                        style="color:rgba(255,255,255,.8); border: 1px solid rgba(255,255,255,.1);">
                                                        <span class="w-1.5 h-1.5 rounded-full"
                                                            style="background: {{ $o[5] }};"></span>
                                                        {{ $o[4] }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ============ 07 · API ============ -->
            <section id="api" class="py-24 lg:py-28 border-t border-line">
                <div class="grid grid-cols-12 gap-6 mb-12 reveal">
                    <div class="col-span-12 md:col-span-5">
                        <p class="kicker mb-3">07 / API</p>
                        <h2 class="text-h2 font-medium grad-text">REST API,<br />documented <span
                                class="ital">honestly.</span></h2>
                    </div>
                    <div class="col-span-12 md:col-span-7 md:pl-8 md:border-l border-line">
                        <p class="text-[15px] leading-relaxed text-sub">One key, six endpoints, idempotent by design.
                            Webhooks for every status transition. Sandbox mirrors production with fake delivery in real
                            time.</p>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-8 items-start reveal">
                    <div class="col-span-12 lg:col-span-5">
                        <div class="card overflow-hidden">
                            <div class="px-5 py-4 border-b border-line">
                                <p class="kicker">Endpoints · v2</p>
                            </div>
                            @php
                                $endpoints = [
                                    ['POST', '/v2/order', 'place an order', 'indigo'],
                                    ['GET', '/v2/status', 'query progress', 'forest'],
                                    ['POST', '/v2/refill', 'request refill', 'indigo'],
                                    ['POST', '/v2/cancel', 'partial refund', 'indigo'],
                                    ['GET', '/v2/services', 'catalogue snapshot', 'forest'],
                                    ['GET', '/v2/balance', 'wallet state', 'forest'],
                                ];
                            @endphp
                            @foreach ($endpoints as $e)
                                <div class="flex items-center gap-3 px-5 py-3 border-b border-line last:border-b-0"
                                    onmouseover="this.style.background='var(--paper2)'"
                                    onmouseout="this.style.background='transparent'">
                                    <span
                                        class="font-mono text-[10.5px] font-medium w-10 text-{{ $e[3] }}">{{ $e[0] }}</span>
                                    <span class="font-mono text-[12.5px] flex-1">{{ $e[1] }}</span>
                                    <span class="text-[12px] text-muted">{{ $e[2] }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex gap-2">
                            <a href="#" class="btn btn-indigo">Read full docs ↗</a>
                            <a href="#" class="btn btn-ghost">Sandbox key</a>
                        </div>

                        <div class="mt-6 flex items-center gap-4 text-[12px] font-mono text-muted">
                            <span class="inline-flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full"
                                    style="background: var(--forest)"></span> 99.98% up</span>
                            <span>·</span>
                            <span>60 req/min</span>
                            <span>·</span>
                            <span>HMAC webhooks</span>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-7" x-data="{ lang: 'curl' }">
                        <div class="code overflow-hidden">
                            <div class="flex flex-wrap items-center gap-1 px-3 sm:px-5 py-3"
                                style="border-bottom: 1px solid rgba(255,255,255,.08);">
                                <button @click="lang='curl'"
                                    :class="lang === 'curl' ? 'text-white bg-white/5' : ''"
                                    class="px-2 sm:px-3 py-1 rounded-md text-[11px] sm:text-[12px] font-mono"
                                    style="color: rgba(255,255,255,.45);">cURL</button>
                                <button @click="lang='node'"
                                    :class="lang === 'node' ? 'text-white bg-white/5' : ''"
                                    class="px-2 sm:px-3 py-1 rounded-md text-[11px] sm:text-[12px] font-mono"
                                    style="color: rgba(255,255,255,.45);">Node</button>
                                <button @click="lang='python'"
                                    :class="lang === 'python' ? 'text-white bg-white/5' : ''"
                                    class="px-2 sm:px-3 py-1 rounded-md text-[11px] sm:text-[12px] font-mono"
                                    style="color: rgba(255,255,255,.45);">Python</button>
                                <button @click="lang='php'"
                                    :class="lang === 'php' ? 'text-white bg-white/5' : ''"
                                    class="px-2 sm:px-3 py-1 rounded-md text-[11px] sm:text-[12px] font-mono"
                                    style="color: rgba(255,255,255,.45);">PHP</button>
                                <span class="hidden sm:inline ml-auto font-mono text-[10.5px] uppercase tracking-wider"
                                    style="color: rgba(255,255,255,.4);">POST /v2/order</span>
                            </div>

                            <div class="p-5 md:p-6">
                                <pre x-show="lang==='curl'" x-cloak class="overflow-x-auto"><span class="c">// Place a TikTok views order — 25,000 units</span>
<span class="k">curl</span> -X POST https://{{ getDomain() }}/v2/order \
  -H <span class="s">"Authorization: Bearer sk_live_..."</span> \
  -H <span class="s">"Content-Type: application/json"</span> \
  -d <span class="s">'{
    "service":  <span class="n">2103</span>,
    "link":     "https://tiktok.com/@studio/video/7384...",
    "quantity": <span class="n">25000</span>,
    "drip":     { "hours": <span class="n">24</span>, "jitter": <span class="n">0.3</span> }
  }'</span>

<span class="c">// → 201 Created</span>
{
  <span class="p">"order"</span>:    <span class="n">482910</span>,
  <span class="p">"charge"</span>:   <span class="s">"300000"</span>,
  <span class="p">"currency"</span>: <span class="s">"VND"</span>,
  <span class="p">"status"</span>:   <span class="s">"in_progress"</span>
}</pre>

                                <pre x-show="lang==='node'" x-cloak class="overflow-x-auto"><span class="c">// npm i @{{ getDomain() }}/sdk</span>
<span class="k">import</span> { {{ getDomain() }} } <span class="k">from</span> <span class="s">'@{{ getDomain() }}/sdk'</span>;

<span class="k">const</span> sb = <span class="k">new</span> <span class="p">{{ getDomain() }}</span>({ key: process.env.<span class="p">SB_KEY</span> });

<span class="k">const</span> order = <span class="k">await</span> sb.orders.create({
  service:  <span class="n">2103</span>,
  link:     <span class="s">'https://tiktok.com/@studio/video/7384...'</span>,
  quantity: <span class="n">25000</span>,
  drip:     { hours: <span class="n">24</span>, jitter: <span class="n">0.3</span> },
});</pre>

                                <pre x-show="lang==='python'" x-cloak class="overflow-x-auto"><span class="c"># pip install {{ getDomain() }}</span>
<span class="k">from</span> {{ getDomain() }} <span class="k">import</span> {{ getDomain() }}

sb = {{ getDomain() }}(key=<span class="s">"sk_live_..."</span>)

order = sb.orders.create(
    service=<span class="n">2103</span>,
    link=<span class="s">"https://tiktok.com/@studio/video/7384..."</span>,
    quantity=<span class="n">25000</span>,
    drip={<span class="s">"hours"</span>: <span class="n">24</span>, <span class="s">"jitter"</span>: <span class="n">0.3</span>},
)</pre>

                                <pre x-show="lang==='php'" x-cloak class="overflow-x-auto"><span class="c">// composer require {{ getDomain() }}/sdk</span>
<span class="k">use</span> {{ getDomain() }}\Client;

<span class="p">$sb</span> = <span class="k">new</span> Client([<span class="s">'key'</span> => <span class="p">$_ENV</span>[<span class="s">'SB_KEY'</span>]]);

<span class="p">$order</span> = <span class="p">$sb</span>->orders->create([
    <span class="s">'service'</span>  => <span class="n">2103</span>,
    <span class="s">'link'</span>     => <span class="s">'https://tiktok.com/@studio/video/7384...'</span>,
    <span class="s">'quantity'</span> => <span class="n">25000</span>,
    <span class="s">'drip'</span>     => [<span class="s">'hours'</span> => <span class="n">24</span>, <span class="s">'jitter'</span> => <span class="n">0.3</span>],
]);</pre>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- API v1 → v2 comparison -->
                <div class="mt-12 reveal">
                    <div class="flex flex-wrap items-end justify-between gap-3 mb-5">
                        <div>
                            <p class="kicker mb-2">Changelog · v1 → v2</p>
                            <h3 class="text-h3 font-semibold">What <span class="ital">v2</span> changes.</h3>
                        </div>
                        <span class="pill"><span class="dot dot-indigo"></span>v2.0 · stable</span>
                    </div>
                    @php
                        $apiCompare = [
                            ['Rate limit', '30 req/min', '60 req/min · raisable'],
                            ['Multi-link per request', 'single link', 'up to 500 links'],
                            ['Webhooks', '—', 'order.* · HMAC-signed'],
                            ['Idempotency keys', '—', 'Idempotency-Key header'],
                            ['Refill status endpoint', '—', 'GET /v2/refill/{id}'],
                            ['Partial cancel + refund', 'manual ticket', 'POST /v2/cancel · pro-rata'],
                            ['Sandbox key', '—', 'live on signup'],
                            ['Drip scheduling via API', '—', 'drip{ hours, jitter }'],
                            ['Multi-currency charge', 'VND only', 'VND · USD · USDT'],
                        ];
                    @endphp
                    <div class="card overflow-hidden">
                        <div
                            class="hidden md:grid grid-cols-12 px-6 md:px-7 py-2.5 border-b border-line kicker kicker-muted">
                            <div class="col-span-6">Capability</div>
                            <div class="col-span-3">API v1</div>
                            <div class="col-span-3">API v2</div>
                        </div>
                        @foreach ($apiCompare as $row)
                            <div class="grid grid-cols-12 gap-y-1 px-6 md:px-7 py-3 border-b border-line last:border-b-0 items-center text-[13.5px]"
                                style="transition: background .15s;"
                                onmouseover="this.style.background='var(--paper2)'"
                                onmouseout="this.style.background='transparent'">
                                <div class="col-span-12 md:col-span-6 font-medium">{{ $row[0] }}</div>
                                <div class="col-span-6 md:col-span-3 text-[12.5px] text-muted"><span
                                        class="md:hidden text-faint font-mono">v1 · </span>{{ $row[1] }}</div>
                                <div class="col-span-6 md:col-span-3 text-[12.5px]"><span
                                        class="md:hidden text-faint font-mono">v2 · </span><span
                                        class="text-ink font-medium">{{ $row[2] }}</span></div>
                            </div>
                        @endforeach
                    </div>
                    <p class="mt-3 text-[12px] font-mono text-muted">v1 remains available until 2026-12-31 · migration
                        guide in docs.</p>
                </div>
            </section>

            <!-- ============ 08 · PRICING ============ -->
            <section id="pricing" class="py-24 lg:py-28 border-t border-line">
                <div class="grid grid-cols-12 gap-6 mb-14 reveal">
                    <div class="col-span-12 md:col-span-5">
                        <p class="kicker mb-3">08 / Pricing</p>
                        <h2 class="text-h2 font-medium grad-text">Pay for what<br />you <span
                                class="ital">ship.</span></h2>
                    </div>
                    <div class="col-span-12 md:col-span-7 md:pl-8 md:border-l border-line">
                        <p class="text-[15px] leading-relaxed text-sub">All plans share the same API, SLA and refill
                            guarantee. Volume tiers auto-discount up to 22% — applied to your wallet, never billed back.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-4 reveal">
                    <div class="col-span-12 lg:col-span-4 card p-7 glow-hover">
                        <div class="flex items-center justify-between mb-3">
                            <p class="kicker">Starter</p>
                            <span class="pill">Pay as you go</span>
                        </div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-stat font-semibold tracking-tightest tnum">0₫</span>
                            <span class="text-muted text-sm">/ month</span>
                        </div>
                        <p class="text-[13.5px] mt-2 text-sub">Top-up wallet, pay per order.</p>
                        <a href="#" class="btn btn-ghost w-full justify-center mt-6">Start free</a>
                        <ul class="mt-7 space-y-2.5 text-[13.5px] text-sub">
                            <li class="flex gap-2.5"><span class="text-forest mt-0.5">✓</span> 100 orders / month</li>
                            <li class="flex gap-2.5"><span class="text-forest mt-0.5">✓</span> All 14 networks
                                unlocked</li>
                            <li class="flex gap-2.5"><span class="text-forest mt-0.5">✓</span> Email support · 24h SLA
                            </li>
                            <li class="flex gap-2.5"><span class="text-forest mt-0.5">✓</span> Refill guarantee · 30d
                            </li>
                            <li class="flex gap-2.5 opacity-40"><span class="mt-0.5">—</span> API access</li>
                            <li class="flex gap-2.5 opacity-40"><span class="mt-0.5">—</span> Drip scheduling</li>
                        </ul>
                    </div>

                    <div class="col-span-12 lg:col-span-4 rounded-2xl p-7 relative overflow-hidden lg:scale-[1.02] lg:-my-2"
                        style="background: linear-gradient(180deg, #2a1cc4 0%, #1a0f8a 100%); color: #ffffff; box-shadow: 0 24px 60px -20px rgba(61,43,255,.45), 0 0 0 1px rgba(255,255,255,.06) inset;">
                        <div class="absolute -top-16 -right-16 w-56 h-56 rounded-full blur-3xl"
                            style="background: rgba(192,132,252,.45);"></div>
                        <div class="absolute -bottom-20 -left-12 w-48 h-48 rounded-full blur-3xl"
                            style="background: rgba(124,92,255,.35);"></div>
                        <div class="relative">
                            <div class="flex items-center justify-between mb-3">
                                <p class="font-mono text-[11px] uppercase tracking-[0.08em] font-medium"
                                    style="color: #c4b3ff;">Studio</p>
                                <span
                                    class="inline-flex items-center gap-1.5 text-[11px] px-2.5 py-1 rounded-full font-medium"
                                    style="background: rgba(255,255,255,.14); color: #fff; border: 1px solid rgba(255,255,255,.2); backdrop-filter: blur(8px);">
                                    <span class="w-1.5 h-1.5 rounded-full"
                                        style="background: #3ddc97; box-shadow: 0 0 0 3px rgba(61,220,151,.2);"></span>
                                    Most popular
                                </span>
                            </div>
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-stat font-semibold tracking-tightest tnum">299K</span>
                                <span class="text-sm" style="color: rgba(255,255,255,.7);">₫ / month</span>
                            </div>
                            <p class="text-[13.5px] mt-2" style="color: rgba(255,255,255,.75);">For studios &amp;
                                agencies running 10+ campaigns/month.</p>
                            <a href="/signin"
                                class="mt-7 w-full justify-center flex items-center gap-2 h-11 rounded-lg text-[14px] font-medium transition hover:-translate-y-0.5"
                                style="background: #ffffff; color: #0e0e0c; box-shadow: 0 8px 24px -8px rgba(0,0,0,.3);">
                                Start 14-day trial
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5">
                                    <path d="M5 12h14M13 5l7 7-7 7" />
                                </svg>
                            </a>
                            <p class="text-center mt-3 text-[11.5px]" style="color: rgba(255,255,255,.5);">No credit
                                card · cancel anytime</p>
                            <div class="mt-7 pt-6" style="border-top: 1px solid rgba(255,255,255,.1);">
                                <ul class="space-y-2.5 text-[13.5px]" style="color: rgba(255,255,255,.88);">
                                    <li class="flex gap-2.5"><span style="color:#3ddc97" class="mt-0.5">✓</span>
                                        Unlimited orders &amp; webhooks</li>
                                    <li class="flex gap-2.5"><span style="color:#3ddc97" class="mt-0.5">✓</span> REST
                                        API + sandbox key</li>
                                    <li class="flex gap-2.5"><span style="color:#3ddc97" class="mt-0.5">✓</span> Drip
                                        scheduling + jitter</li>
                                    <li class="flex gap-2.5"><span style="color:#3ddc97" class="mt-0.5">✓</span>
                                        Multi-link · 500 per request</li>
                                    <li class="flex gap-2.5"><span style="color:#3ddc97" class="mt-0.5">✓</span>
                                        Priority support · 8m SLA</li>
                                    <li class="flex gap-2.5"><span style="color:#3ddc97" class="mt-0.5">✓</span> Auto
                                        volume discount up to 22%</li>
                                    <li class="flex gap-2.5"><span style="color:#3ddc97" class="mt-0.5">✓</span> All
                                        14 networks · 620+ services</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-12 lg:col-span-4 card p-7 glow-hover">
                        <div class="flex items-center justify-between mb-3">
                            <p class="kicker">Reseller</p>
                            <span class="pill">White-label</span>
                        </div>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-stat font-semibold tracking-tightest tnum">599K</span>
                            <span class="text-muted text-sm">/ month</span>
                        </div>
                        <p class="text-[13.5px] mt-2 text-sub">Run your own panel brand.</p>
                        <a href="#" class="btn btn-ghost w-full justify-center mt-6">Contact sales</a>
                        <ul class="mt-7 space-y-2.5 text-[13.5px] text-sub">
                            <li class="flex gap-2.5"><span class="text-forest mt-0.5">✓</span> Sub-domain + custom CSS
                            </li>
                            <li class="flex gap-2.5"><span class="text-forest mt-0.5">✓</span> Customer wallets &amp;
                                ledger</li>
                            <li class="flex gap-2.5"><span class="text-forest mt-0.5">✓</span> Per-client rate cards
                            </li>
                            <li class="flex gap-2.5"><span class="text-forest mt-0.5">✓</span> IP allowlist + mTLS
                            </li>
                            <li class="flex gap-2.5"><span class="text-forest mt-0.5">✓</span> Dedicated CSM</li>
                            <li class="flex gap-2.5"><span class="text-forest mt-0.5">✓</span> 22% wholesale discount
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- ============ 09 · CUSTOMERS ============ -->
            <section id="customers" class="py-24 lg:py-28 border-t border-line">
                <div class="grid grid-cols-12 gap-6 mb-14 reveal">
                    <div class="col-span-12 md:col-span-5">
                        <p class="kicker mb-3">09 / Customers</p>
                        <h2 class="text-h2 font-medium grad-text">Stories from<br />the <span
                                class="ital">desk.</span></h2>
                    </div>
                    <div class="col-span-12 md:col-span-7 md:pl-8 md:border-l border-line">
                        <p class="text-[15px] leading-relaxed text-sub">Three operators who moved their day-to-day to
                            {{ getDomain() }}. Their numbers, in their own words.</p>
                    </div>
                </div>

                <div class="card p-8 lg:p-10 mb-6 reveal">
                    <div class="grid grid-cols-12 gap-8 items-center">
                        <div class="col-span-12 md:col-span-4">
                            <p class="kicker mb-3">Featured</p>
                            <p class="text-stat font-semibold tracking-tightest tnum text-indigo">2.7%</p>
                            <p class="mt-2 text-[12px] text-muted uppercase tracking-wider">Refill ratio · down from
                                18%</p>
                            <p class="mt-6 font-semibold text-lg">STUDIO BRICK</p>
                            <p class="text-[12.5px] text-muted">Creative agency · Hanoi</p>
                        </div>
                        <div class="col-span-12 md:col-span-8">
                            <blockquote class="text-2xl font-medium tracking-tight leading-snug">
                                <span class="ital text-3xl">“</span>We moved three client portfolios over and our
                                refill ratio dropped from 18% to under 3%. The dashboard is the first one I
                                haven&rsquo;t asked our team to rebuild.<span class="ital text-3xl">”</span>
                            </blockquote>
                            <div class="mt-6 flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full"
                                    style="background: linear-gradient(135deg, var(--indigo), var(--saffron));"></div>
                                <div class="text-[13px]">
                                    <p class="font-medium">Linh Hà</p>
                                    <p class="text-muted">Founder, Studio Brick</p>
                                </div>
                                <a href="#" class="ml-auto lnk text-[13px]">Full case study <span
                                        class="arr">→</span></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-12 gap-4">
                    <article class="col-span-12 md:col-span-6 card p-7 reveal glow-hover">
                        <div class="flex items-center justify-between mb-5">
                            <span class="font-semibold tracking-tight">NORTHLIGHT</span>
                            <span class="kicker kicker-muted">Music label · Saigon</span>
                        </div>
                        <p class="text-stat font-semibold tracking-tightest tnum text-indigo">1.4×</p>
                        <p class="text-[12px] text-muted uppercase tracking-wider mt-1">ROAS · Spotify campaigns</p>
                        <blockquote class="text-[14.5px] leading-relaxed text-ink mt-6">“The royalty-eligible Spotify
                            tier paid for itself in the first single. Our distributor stopped asking about source
                            quality.”</blockquote>
                        <div class="mt-6 flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full"
                                style="background: linear-gradient(135deg, var(--forest), var(--indigo));"></div>
                            <div class="text-[12.5px]">
                                <p class="font-medium">Tâm Nguyễn</p>
                                <p class="text-muted">A&amp;R lead</p>
                            </div>
                        </div>
                    </article>

                    <article class="col-span-12 md:col-span-6 card p-7 reveal glow-hover">
                        <div class="flex items-center justify-between mb-5">
                            <span class="font-semibold tracking-tight">plainwork™</span>
                            <span class="kicker kicker-muted">White-label · Da Nang</span>
                        </div>
                        <p class="text-stat font-semibold tracking-tightest tnum text-indigo">2,100</p>
                        <p class="text-[12px] text-muted uppercase tracking-wider mt-1">Active sub-resellers</p>
                        <blockquote class="text-[14.5px] leading-relaxed text-ink mt-6">“The white-label sub-domain
                            plus the customer ledger gave us a real product in three weeks. We dropped our previous
                            backend.”</blockquote>
                        <div class="mt-6 flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full"
                                style="background: linear-gradient(135deg, var(--saffron), var(--crimson));"></div>
                            <div class="text-[12.5px]">
                                <p class="font-medium">Đăng Vũ</p>
                                <p class="text-muted">Co-founder</p>
                            </div>
                        </div>
                    </article>
                </div>
            </section>

            <!-- ============ 10 · FAQ ============ -->
            <section id="faq" class="py-24 lg:py-28 border-t border-line">
                <div class="grid grid-cols-12 gap-6 mb-12 reveal">
                    <div class="col-span-12 md:col-span-5">
                        <p class="kicker mb-3">10 / Notes</p>
                        <h2 class="text-h2 font-medium grad-text">Answers,<br />on the <span
                                class="ital">record.</span></h2>
                    </div>
                    <div class="col-span-12 md:col-span-7 md:pl-8 md:border-l border-line">
                        <p class="text-[15px] leading-relaxed text-sub">The questions operators ask most often, in the
                            first week. If yours isn&rsquo;t here — <a href="#"
                                class="text-indigo underline-offset-4 hover:underline">drop us a line</a>.</p>
                    </div>
                </div>

                <div class="card divide-y divide-line reveal" x-data="{ active: 0 }">
                    <template
                        x-for="(item, i) in [
            { q: 'Are the followers and views real?',                  a: 'For flagship tiers (TikTok views, IG real followers, YouTube watch time) — yes, sourced from real accounts. Each service page declares its source: real, HQ, or mixed. We do not blur the line.' },
            { q: 'How does the refill guarantee actually work?',        a: 'We poll the count every 6 hours during the refill window declared on each service. If the count dips below the contract floor, we fire a refill automatically — no ticket needed. Refunds happen in minutes if a refill is impossible.' },
            { q: 'Do you support drip scheduling for organic growth?',  a: 'Yes. The Studio plan and up can split any order into N chunks across a chosen duration, with random jitter. Most operators use 24–72h windows for follower campaigns.' },
            { q: 'How fast is the REST API?',                            a: 'p95 latency is 80–120ms in VN, 150–220ms internationally. Rate limit is 60 req/min per key, raisable for Reseller tier. Webhooks retry with exponential backoff for 24h.' },
            { q: 'Can I cancel an order in progress?',                  a: 'Yes, while status is queued or below 25% delivered. Partial deliveries refund pro-rata to your wallet in minutes.' },
            { q: 'What does the white-label panel include?',             a: 'A sub-domain you point at our edge, custom branding, customer wallets, per-customer rate cards, and a discount table you control. The API remains hosted by us.' },
            { q: 'Which payment methods are supported?',                a: 'VietQR (auto-credit), MoMo, ZaloPay, PayOS, USDT (TRC-20), and Stripe for international cards. Bank transfers are matched by reference within ~60s.' },
            { q: 'Is there a contract or minimum spend?',                a: 'No. Subscriptions are month-to-month, and downgrades take effect on the next billing cycle without penalty.' },
          ]"
                        :key="i">
                        <div>
                            <button @click="active === i ? active = null : active = i" :aria-expanded="active === i"
                                class="w-full px-6 py-5 flex items-center gap-4 text-left">
                                <span class="font-mono text-[11.5px] text-muted tnum"
                                    x-text="String(i + 1).padStart(2,'0')"></span>
                                <span class="flex-1 text-[15px] font-medium" x-text="item.q"></span>
                                <span class="transition-transform text-lg text-muted"
                                    :class="active === i ? 'rotate-45 text-indigo' : ''">+</span>
                            </button>
                            <div x-show="active === i" x-collapse x-cloak>
                                <p class="px-6 pb-6 pl-[3.6rem] text-[14px] leading-relaxed max-w-2xl text-sub"
                                    x-text="item.a"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </section>

        </main>
    </div>

    <!-- ============ FULL-BLEED CTA ============ -->
    <section class="relative overflow-hidden" style="background: #0e0e0c; color: #f1efe9;">
        <div class="absolute inset-0 opacity-30"
            style="background-image: linear-gradient(to right, rgba(255,255,255,.04) 1px, transparent 1px), linear-gradient(to bottom, rgba(255,255,255,.04) 1px, transparent 1px); background-size: 48px 48px;">
        </div>
        <div class="absolute -bottom-32 left-1/2 -translate-x-1/2 w-[600px] h-[600px] rounded-full blur-3xl"
            style="background: color-mix(in srgb, var(--indigo) 20%, transparent);"></div>

        <div
            class="relative max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-10 py-16 sm:py-20 md:py-24 lg:py-32 grid grid-cols-12 gap-8 lg:items-end">
            <div class="col-span-12 lg:col-span-8">
                <p class="kicker mb-5" style="color: color-mix(in srgb, var(--indigo) 70%, white);">Begin</p>
                <h2 class="text-hero font-medium tracking-tightest">
                    Open a panel.<br />
                    Ship your first order <span class="ital"
                        style="color: color-mix(in srgb, var(--indigo) 70%, white);">in minutes.</span>
                </h2>
                <p class="mt-6 max-w-xl text-[15px]" style="opacity:.7;">Free account. No credit card. A sandbox API
                    key is generated the moment you sign in — start integrating before you spend a single ₫.</p>
            </div>
            <div class="col-span-12 lg:col-span-4 flex flex-col gap-3">
                <a href="#"
                    class="h-12 rounded-lg flex items-center justify-center gap-2 font-medium transition hover:-translate-y-0.5"
                    style="background: #f1efe9; color: #0e0e0c;">
                    Start free →
                </a>
                <a href="#"
                    class="h-12 rounded-lg flex items-center justify-center gap-2 transition hover:-translate-y-0.5"
                    style="border: 1px solid rgba(255,255,255,.2); color: #f1efe9;">
                    Talk to sales
                </a>
                <div class="mt-3 flex items-center justify-center gap-3 text-[11.5px] font-mono"
                    style="color: rgba(255,255,255,.5);">
                    <span>● No card</span>
                    <span>·</span>
                    <span>● Cancel anytime</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER ============ -->
    <footer class="border-t border-line pt-12 sm:pt-16 pb-8 bg-paper2">
        <div class="max-w-[1480px] mx-auto px-4 sm:px-6 lg:px-10">
            <div class="grid grid-cols-12 gap-8">
                <div class="col-span-12 md:col-span-4">
                    <a href="#" class="flex items-center gap-2 font-semibold tracking-tight text-[15px] mb-4">
                        @if (!empty($config->logo))
                            <img src="{{ $config->logo }}" alt="{{ getDomain() }}"
                                class="w-6 h-6 rounded-md object-contain" />
                        @endif
                        {{ getDomain() }}
                    </a>
                    <p class="text-[13.5px] max-w-xs leading-relaxed text-sub">SMM panel for studios, agencies and
                        resellers. Independently held, made in Hanoi.</p>

                    <div class="mt-6 inline-flex items-center gap-2 text-[12.5px] font-mono text-muted">
                        <span class="w-1.5 h-1.5 rounded-full" style="background: var(--forest)"></span>
                        All systems operational
                    </div>
                </div>

                <div class="col-span-6 md:col-span-2">
                    <p class="kicker kicker-muted mb-4">Product</p>
                    <ul class="space-y-2.5 text-[13.5px] text-sub">
                        <li><a href="#networks" class="hover:text-ink">Networks</a></li>
                        <li><a href="#platforms" class="hover:text-ink">Catalogue</a></li>
                        <li><a href="#features" class="hover:text-ink">Features</a></li>
                        <li><a href="#api" class="hover:text-ink">API</a></li>
                        <li><a href="#pricing" class="hover:text-ink">Pricing</a></li>
                    </ul>
                </div>

                <div class="col-span-6 md:col-span-2">
                    <p class="kicker kicker-muted mb-4">Resources</p>
                    <ul class="space-y-2.5 text-[13.5px] text-sub">
                        <li><a href="#" class="hover:text-ink">Documentation</a></li>
                        <li><a href="#" class="hover:text-ink">API reference</a></li>
                        <li><a href="#" class="hover:text-ink">Changelog</a></li>
                        <li><a href="#" class="hover:text-ink">Status page ↗</a></li>
                    </ul>
                </div>

                <div class="col-span-6 md:col-span-2">
                    <p class="kicker kicker-muted mb-4">Company</p>
                    <ul class="space-y-2.5 text-[13.5px] text-sub">
                        <li><a href="#" class="hover:text-ink">About</a></li>
                        <li><a href="#customers" class="hover:text-ink">Customers</a></li>
                        <li><a href="#" class="hover:text-ink">Careers</a></li>
                        <li><a href="#" class="hover:text-ink">Contact</a></li>
                    </ul>
                </div>

                <div class="col-span-6 md:col-span-2">
                    <p class="kicker kicker-muted mb-4">Legal</p>
                    <ul class="space-y-2.5 text-[13.5px] text-sub">
                        <li><a href="#" class="hover:text-ink">Terms</a></li>
                        <li><a href="#" class="hover:text-ink">Privacy</a></li>
                        <li><a href="#" class="hover:text-ink">DPA</a></li>
                        <li><a href="#" class="hover:text-ink">Acceptable use</a></li>
                    </ul>
                </div>
            </div>

            <div
                class="mt-14 pt-6 border-t border-line flex flex-col md:flex-row items-center justify-between gap-3 text-[12px] text-muted">
                <span>© 2026 {{ getDomain() }}. All rights reserved.</span>
                <span class="font-mono">v2.0 · build 4821 · Hanoi</span>
            </div>
        </div>
    </footer>

    <script>
        // Theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('sb-theme', 'light');
                document.querySelector('meta[name="theme-color"]').setAttribute('content', '#f8f7f4');
            } else {
                html.classList.add('dark');
                localStorage.setItem('sb-theme', 'dark');
                document.querySelector('meta[name="theme-color"]').setAttribute('content', '#0a0b0d');
            }
        }
        // Follow system if user hasn't explicitly chosen
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('sb-theme')) {
                document.documentElement.classList.toggle('dark', e.matches);
            }
        });
        // Set initial theme-color meta on load
        if (document.documentElement.classList.contains('dark')) {
            document.querySelector('meta[name="theme-color"]').setAttribute('content', '#0a0b0d');
        }

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
                threshold: 0.08,
                rootMargin: '0px 0px -4% 0px'
            });
            document.querySelectorAll('.reveal').forEach((el) => io.observe(el));
        });
    </script>
</body>

</html>
