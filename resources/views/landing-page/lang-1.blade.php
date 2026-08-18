<!DOCTYPE html>
<html lang="vi" id="html-root">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $config->title ?? 'NexaSMM' }} — Social Media Marketing Panel</title>
    <meta name="description" content="{{ $config->description ?? 'SMM Panel hàng đầu Việt Nam' }}">
    <meta name="keywords" content="{{ $config->keywords ?? 'smm panel, social media marketing' }}">
    <link rel="icon" href="{{ $config->favicon ? asset($config->favicon) : '/assets/media/favicon.ico' }}">
    <meta property="og:title" content="{{ $config->title ?? 'NexaSMM' }}">
    <meta property="og:description" content="{{ $config->description ?? 'SMM Panel hàng đầu Việt Nam' }}">
    @if ($config->og_image)
        <meta property="og:image" content="{{ asset($config->og_image) }}">
    @endif
    {{-- Anti-flash: apply theme BEFORE any CSS renders --}}
    <script>
        (function(){
            var t=localStorage.getItem('data-bs-theme')||'light';
            document.documentElement.setAttribute('data-bs-theme',t);
            document.documentElement.style.background = t==='dark' ? '#020617' : '#f1f5f9';
        })();
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --c-cyan: #00f5ff;
            --c-violet: #7c3aed;
            --font-main: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;

            /* Light theme — default */
            --c-dark: #f8fafc;
            --c-card: rgba(0, 0, 0, 0.03);
            --c-border: rgba(0, 150, 180, 0.18);
            --c-bg: #f1f5f9;
            --c-text: #1e293b;
            --c-text-muted: #64748b;
            --c-text-body: #334155;
            --c-text-label: #475569;
            --c-text-heading: #0f172a;
            --c-nav-bg: rgba(248, 250, 252, 0.9);
            --c-nav-border: rgba(0, 150, 180, 0.15);
            --c-nav-link: #334155;
            --c-nav-link-hover: #0f172a;
            --c-scrollbar-track: #e2e8f0;
            --c-scrollbar-thumb: #94a3b8;
            --c-btn-ghost-color: #334155;
            --c-btn-ghost-hover-bg: rgba(0, 0, 0, 0.06);
            --c-btn-outline-border: rgba(0, 150, 180, 0.3);
            --c-btn-outline-bg: rgba(0, 0, 0, 0.02);
            --c-btn-outline-color: #334155;
            --c-lang-border: rgba(0, 150, 180, 0.3);
            --c-lang-bg: rgba(0, 150, 180, 0.07);
            --c-lang-bg-hover: rgba(0, 150, 180, 0.13);
            --c-lang-border-hover: rgba(0, 150, 180, 0.5);
            --c-lang-color: #334155;
            --c-lang-color-hover: #0f172a;
            --c-lang-opt-bg: #ffffff;
            --c-lang-opt-color: #1e293b;
        }

        [data-bs-theme="dark"] {
            --c-dark: #020617;
            --c-card: rgba(255, 255, 255, 0.04);
            --c-border: rgba(0, 245, 255, 0.15);
            --c-bg: #020617;
            --c-text: #e2e8f0;
            --c-text-muted: #64748b;
            --c-text-body: #cbd5e1;
            --c-text-label: #94a3b8;
            --c-text-heading: #f1f5f9;
            --c-nav-bg: rgba(2, 6, 23, 0.7);
            --c-nav-border: rgba(0, 245, 255, 0.15);
            --c-nav-link: #94a3b8;
            --c-nav-link-hover: #f1f5f9;
            --c-scrollbar-track: #0f172a;
            --c-scrollbar-thumb: #334155;
            --c-btn-ghost-color: #94a3b8;
            --c-btn-ghost-hover-bg: rgba(255, 255, 255, 0.05);
            --c-btn-outline-border: rgba(0, 245, 255, 0.2);
            --c-btn-outline-bg: rgba(255, 255, 255, 0.03);
            --c-btn-outline-color: #cbd5e1;
            --c-lang-border: rgba(0, 245, 255, 0.2);
            --c-lang-bg: rgba(0, 245, 255, 0.05);
            --c-lang-bg-hover: rgba(0, 245, 255, 0.09);
            --c-lang-border-hover: rgba(0, 245, 255, 0.4);
            --c-lang-color: #94a3b8;
            --c-lang-color-hover: #e2e8f0;
            --c-lang-opt-bg: #0d1526;
            --c-lang-opt-color: #e2e8f0;
        }

        [data-bs-theme="light"] {
            --c-dark: #f8fafc;
            --c-card: rgba(0, 0, 0, 0.03);
            --c-border: rgba(0, 150, 180, 0.18);
            --c-bg: #f1f5f9;
            --c-text: #1e293b;
            --c-text-muted: #64748b;
            --c-text-body: #334155;
            --c-text-label: #475569;
            --c-text-heading: #0f172a;
            --c-nav-bg: rgba(248, 250, 252, 0.9);
            --c-nav-border: rgba(0, 150, 180, 0.15);
            --c-nav-link: #334155;
            --c-nav-link-hover: #0f172a;
            --c-scrollbar-track: #e2e8f0;
            --c-scrollbar-thumb: #94a3b8;
            --c-btn-ghost-color: #334155;
            --c-btn-ghost-hover-bg: rgba(0, 0, 0, 0.06);
            --c-btn-outline-border: rgba(0, 150, 180, 0.3);
            --c-btn-outline-bg: rgba(0, 0, 0, 0.02);
            --c-btn-outline-color: #334155;
            --c-lang-border: rgba(0, 150, 180, 0.3);
            --c-lang-bg: rgba(0, 150, 180, 0.07);
            --c-lang-bg-hover: rgba(0, 150, 180, 0.13);
            --c-lang-border-hover: rgba(0, 150, 180, 0.5);
            --c-lang-color: #334155;
            --c-lang-color-hover: #0f172a;
            --c-lang-opt-bg: #ffffff;
            --c-lang-opt-color: #1e293b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-main);
            font-feature-settings: 'cv02', 'cv03', 'cv04', 'cv11';
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background: var(--c-bg);
            color: var(--c-text);
            overflow-x: hidden;
            letter-spacing: -0.01em;
            opacity: 0;
            transition: opacity 0.3s ease, background 0.3s ease, color 0.3s ease;
        }

        body.ready {
            opacity: 1;
        }

        h1,
        h2,
        h3 {
            font-family: var(--font-main);
            letter-spacing: -0.03em;
            font-weight: 800;
        }

        #canvas-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .above {
            position: relative;
            z-index: 1;
        }

        /* Navbar */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            backdrop-filter: blur(18px);
            background: var(--c-nav-bg);
            border-bottom: 1px solid var(--c-nav-border);
            transition: background 0.3s ease, border-color 0.3s ease;
        }

        /* Glowing text */
        .glow-text {
            text-shadow: 0 0 40px rgba(0, 245, 255, 0.5), 0 0 80px rgba(124, 58, 237, 0.3);
        }

        [data-bs-theme="light"] .glow-text {
            text-shadow: none;
        }

        .glow-btn {
            box-shadow: 0 0 20px rgba(0, 245, 255, 0.35), inset 0 0 20px rgba(0, 245, 255, 0.05);
            transition: box-shadow 0.3s, transform 0.2s;
        }

        .glow-btn:hover {
            box-shadow: 0 0 35px rgba(0, 245, 255, 0.6), inset 0 0 30px rgba(0, 245, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Cards */
        .glass-card {
            background: var(--c-card);
            border: 1px solid var(--c-border);
            backdrop-filter: blur(12px);
            transition: border-color 0.3s, transform 0.3s, box-shadow 0.3s;
        }

        .glass-card:hover {
            border-color: rgba(0, 245, 255, 0.4);
            transform: translateY(-6px);
            box-shadow: 0 20px 60px rgba(0, 245, 255, 0.1);
        }

        /* Gradient text */
        .grad-text {
            background: linear-gradient(135deg, #00f5ff 0%, #a78bfa 50%, #f472b6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Stat counter animation */
        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-num {
            animation: countUp 1s ease forwards;
        }

        /* Horizontal scroll ticker */
        .ticker-wrap {
            overflow: hidden;
        }

        .ticker {
            display: flex;
            gap: 3rem;
            animation: ticker-scroll 20s linear infinite;
            white-space: nowrap;
        }

        @keyframes ticker-scroll {
            0% {
                transform: translateX(0)
            }

            100% {
                transform: translateX(-50%)
            }
        }

        /* Pulse ring */
        .pulse-ring::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid rgba(0, 245, 255, 0.4);
            animation: pulse-expand 2s ease-out infinite;
        }

        @keyframes pulse-expand {
            0% {
                transform: scale(1);
                opacity: 1
            }

            100% {
                transform: scale(1.6);
                opacity: 0
            }
        }

        /* Pricing highlight */
        .price-popular {
            background: linear-gradient(135deg, rgba(0, 245, 255, 0.12), rgba(124, 58, 237, 0.12));
            border-color: rgba(0, 245, 255, 0.5) !important;
        }

        /* Progress bar */
        .progress-bar {
            height: 4px;
            border-radius: 2px;
            background: linear-gradient(90deg, #00f5ff, #7c3aed);
            box-shadow: 0 0 10px rgba(0, 245, 255, 0.5);
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--c-scrollbar-track);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--c-scrollbar-thumb);
            border-radius: 3px;
        }

        /* Mobile menu */
        #mobile-menu {
            display: none;
            animation: slideDown 0.2s ease;
            background: var(--c-nav-bg);
        }

        #mobile-menu.open {
            display: block;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .mobile-nav-link {
            color: var(--c-nav-link);
            transition: color 0.2s, background 0.2s;
        }

        .mobile-nav-link:hover {
            color: var(--c-nav-link-hover);
            background: var(--c-btn-ghost-hover-bg);
        }

        /* Mobile lang buttons */
        .mobile-lang-btn {
            color: var(--c-text-body);
            border: 1px solid var(--c-lang-border);
            background: var(--c-lang-bg);
            transition: all 0.2s;
            font-family: var(--font-main);
        }

        .mobile-lang-btn:hover {
            border-color: var(--c-lang-border-hover);
            background: var(--c-lang-bg-hover);
            color: var(--c-text-heading);
        }

        .mobile-lang-btn.active {
            border-color: rgba(99, 102, 241, 0.5) !important;
            color: #6366f1 !important;
            background: rgba(99, 102, 241, 0.08) !important;
            font-weight: 600;
        }

        [data-bs-theme="light"] .mobile-lang-btn.active {
            color: #4f46e5 !important;
            border-color: rgba(79, 70, 229, 0.4) !important;
            background: rgba(99, 102, 241, 0.07) !important;
        }

        /* Fade in */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Text colors */
        .text-body {
            color: var(--c-text-body);
        }

        .text-muted {
            color: var(--c-text-muted);
        }

        .text-heading {
            color: var(--c-text-heading);
        }

        .text-label {
            color: var(--c-text-label);
        }

        /* Button base */
        .btn-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid var(--c-btn-outline-border);
            background: var(--c-btn-outline-bg);
            color: var(--c-btn-outline-color);
            cursor: pointer;
            transition: all 0.25s;
            text-decoration: none;
            letter-spacing: -0.01em;
        }

        .btn-outline:hover {
            border-color: rgba(0, 245, 255, 0.45);
            color: var(--c-text-heading);
            background: rgba(0, 245, 255, 0.06);
            transform: translateY(-1px);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 24px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            background: #6366f1;
            color: #fff;
            cursor: pointer;
            transition: all 0.22s;
            text-decoration: none;
            letter-spacing: -0.01em;
            border: 1px solid rgba(99, 102, 241, 0.4);
            box-shadow: 0 2px 12px rgba(99, 102, 241, 0.35);
        }

        .btn-primary:hover {
            background: #4f46e5;
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.5);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);
        }

        /* Full-width variant */
        .btn-primary.w-full,
        .btn-outline.w-full {
            width: 100%;
            justify-content: center;
            padding-top: 13px;
            padding-bottom: 13px;
            border-radius: 14px;
            font-size: 13px;
        }

        .btn-ghost {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 20px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            background: transparent;
            color: var(--c-btn-ghost-color);
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            border: none;
            white-space: nowrap;
        }

        .btn-ghost:hover {
            color: var(--c-text-heading);
            background: var(--c-btn-ghost-hover-bg);
        }

        /* ── Lang switcher ─────────────────────────────── */
        .ls-wrap {
            position: relative;
            display: inline-block;
        }

        .ls-trigger {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            height: 36px;
            padding: 0 10px;
            border-radius: 10px;
            border: none;
            background: transparent;
            color: var(--c-text-heading);
            font-size: 11px;
            font-weight: 600;
            font-family: var(--font-main);
            cursor: pointer;
            white-space: nowrap;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            transition: background 0.15s;
            outline: none;
            user-select: none;
            list-style: none;
        }

        .ls-trigger::-webkit-details-marker { display: none; }

        .ls-trigger:hover {
            background: var(--c-lang-bg-hover);
        }

        .ls-wrap[open] .ls-trigger {
            background: var(--c-lang-bg);
        }

        .ls-trigger img {
            width: 18px;
            height: 14px;
            border-radius: 3px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.1);
        }

        .ls-chev {
            width: 12px;
            height: 12px;
            opacity: 0.5;
            flex-shrink: 0;
            transition: transform 0.18s, opacity 0.15s;
            pointer-events: none;
            color: var(--c-text-muted);
        }

        .ls-wrap[open] .ls-chev {
            transform: rotate(180deg);
            opacity: 1;
            color: #6366f1;
        }

        .ls-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 220px;
            background: var(--c-lang-opt-bg);
            border: 1px solid var(--c-lang-border);
            border-radius: 16px;
            box-shadow: 0 20px 48px rgba(15,23,42,0.12);
            overflow: hidden;
            z-index: 9999;
            animation: lsIn 0.15s ease;
        }

        @keyframes lsIn {
            from { opacity: 0; transform: translateY(-6px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .ls-header {
            padding: 10px 16px;
            border-bottom: 1px solid var(--c-lang-border);
            background: var(--c-lang-bg);
        }

        .ls-header p {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--c-text-muted);
            font-family: var(--font-main);
            margin: 0;
        }

        .ls-list {
            padding: 6px;
            max-height: 280px;
            overflow-y: auto;
        }

        .ls-opt {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 8px 10px;
            border-radius: 8px;
            border: none;
            background: none;
            font-size: 13px;
            font-weight: 400;
            color: var(--c-text-body);
            font-family: var(--font-main);
            cursor: pointer;
            text-align: left;
            transition: background 0.12s, color 0.12s;
            position: relative;
        }

        /* Prevent child elements from being click target */
        .ls-opt img,
        .ls-opt span,
        .ls-opt svg {
            pointer-events: none;
        }

        .ls-opt:hover {
            background: rgba(99, 102, 241, 0.1);
            color: var(--c-text-heading);
        }

        .ls-opt:active {
            background: rgba(99, 102, 241, 0.18);
        }

        .ls-opt.active {
            background: rgba(99,102,241,0.1);
            color: #6366f1;
            font-weight: 600;
        }

        [data-bs-theme="light"] .ls-opt.active {
            background: rgba(99,102,241,0.08);
            color: #4f46e5;
        }

        .ls-opt img {
            width: 18px;
            height: 14px;
            border-radius: 3px;
            object-fit: cover;
            flex-shrink: 0;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.08);
        }

        .ls-opt span { flex: 1; }

        .ls-opt-check {
            width: 14px;
            height: 14px;
            color: #6366f1;
            opacity: 0;
            flex-shrink: 0;
        }

        .ls-opt.active .ls-opt-check { opacity: 1; }

        /* Platform card text */
        .platform-name {
            color: var(--c-text-heading);
        }

        .platform-sub {
            color: var(--c-text-muted);
        }

        /* Violet variant for Enterprise */
        .btn-violet {
            color: #a78bfa;
            border-color: rgba(167, 139, 250, 0.3);
        }

        .btn-violet:hover {
            color: #c4b5fd;
            border-color: rgba(167, 139, 250, 0.6);
            background: rgba(167, 139, 250, 0.08);
        }

        [data-bs-theme="light"] .btn-violet {
            color: #7c3aed;
            border-color: rgba(124, 58, 237, 0.3);
        }

        [data-bs-theme="light"] .btn-violet:hover {
            color: #6d28d9;
            border-color: rgba(124, 58, 237, 0.5);
            background: rgba(124, 58, 237, 0.07);
        }
        nav a.nav-link {
            position: relative;
            padding-bottom: 2px;
            color: var(--c-nav-link);
            transition: color 0.2s;
        }

        nav a.nav-link:hover {
            color: var(--c-nav-link-hover);
        }

        nav a.nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: var(--c-cyan);
            transition: width 0.2s;
        }

        nav a.nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>

<body>

    <canvas id="canvas-bg"></canvas>

    <!-- NAVBAR -->
    <!-- NAVBAR -->
    <nav class="above">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between gap-6">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 flex-shrink-0">
                @if ($config->logo_square)
                    <img src="{{ asset($config->logo_square) }}" alt="{{ $config->title }}"
                        class="w-9 h-9 rounded-xl object-contain">
                @else
                    <div class="w-9 h-9 rounded-2xl flex items-center justify-center flex-shrink-0"
                        style="background:linear-gradient(135deg,#00f5ff,#7c3aed);">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" fill="white" />
                        </svg>
                    </div>
                @endif
                <span class="text-2xl font-black tracking-tighter"
                    style="letter-spacing:-0.05em; color: var(--c-text-heading);">{{ $config->title ?? 'NexaSMM' }}</span>
            </a>

            {{-- Desktop nav links --}}
            <ul class="hidden md:flex items-center gap-6 text-sm font-medium flex-shrink-0" style="white-space:nowrap;">
                <li><a href="#services" class="nav-link" data-i18n="nav.services">Dịch vụ</a></li>
                <li><a href="#platforms" class="nav-link" data-i18n="nav.platforms">Nền tảng</a></li>
                <li><a href="#pricing" class="nav-link" data-i18n="nav.pricing">Bảng giá</a></li>
                <li><a href="#stats" class="nav-link" data-i18n="nav.stats">Thống kê</a></li>
                <li><a href="#faq" class="nav-link">FAQ</a></li>
            </ul>

            {{-- Right side Desktop --}}
            <div class="hidden md:flex items-center gap-3 flex-shrink-0">

                <!-- Theme Toggle -->
                <button id="theme-btn" type="button" onclick="toggleTheme()" title="Toggle theme" style="
                    display:inline-flex;align-items:center;justify-content:center;
                    width:36px;height:36px;border-radius:10px;border:none;
                    background:var(--c-lang-bg);color:var(--c-text-heading);
                    cursor:pointer;transition:background 0.15s,color 0.15s;flex-shrink:0;
                " onmouseover="this.style.background='var(--c-lang-bg-hover)'" onmouseout="this.style.background='var(--c-lang-bg)'">
                    <!-- Sun icon (shown in dark mode) -->
                    <svg id="icon-sun" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                        <circle cx="12" cy="12" r="5"/><path stroke-linecap="round" d="M12 2v2M12 20v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M2 12h2M20 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                    </svg>
                    <!-- Moon icon (shown in light mode) -->
                    <svg id="icon-moon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                    </svg>
                </button>

                <!-- Language Switcher -->
                <details class="ls-wrap" id="ls-wrap">
                    <summary class="ls-trigger" id="ls-trigger">
                        <img id="ls-flag" src="https://cdn.whoispanel.com/admin/media/flags/vietnam.svg" alt="">
                        <span id="ls-code">VI</span>
                        <svg class="ls-chev" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
                        </svg>
                    </summary>
                    <div class="ls-dropdown" id="ls-dropdown">
                        <div class="ls-header"><p>Language</p></div>
                        <div class="ls-list">
                            <button class="ls-opt active" id="ls-opt-vi" data-lang="vi" type="button" onclick="lsSelect('vi')">
                                <img src="https://cdn.whoispanel.com/admin/media/flags/vietnam.svg" alt="VI">
                                <span>Tiếng Việt</span>
                                <svg class="ls-opt-check" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg>
                            </button>
                            <button class="ls-opt" id="ls-opt-en" data-lang="en" type="button" onclick="lsSelect('en')">
                                <img src="https://cdn.whoispanel.com/admin/media/flags/united-states.svg" alt="EN">
                                <span>English</span>
                                <svg class="ls-opt-check" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 6L9 17l-5-5"/></svg>
                            </button>
                        </div>
                    </div>
                </details>

                <!-- Buttons -->
                <a href="{{ route('login') }}" class="btn-ghost px-5 py-2.5 text-sm font-medium">
                    Đăng nhập
                </a>

                <a href="{{ route('signup') }}" class="btn-primary px-7 py-3 text-sm font-bold shadow-lg">
                    Bắt đầu ngay
                </a>
            </div>

            <!-- Mobile Hamburger -->
            <button id="menu-btn" class="md:hidden transition p-2" style="color: var(--c-nav-link);"
                onclick="toggleMenu()">
                <svg width="26" height="26" fill="none" stroke="currentColor" stroke-width="2.2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden px-6 pb-8 border-t" style="border-color: var(--c-nav-border);">
            <ul class="flex flex-col gap-1 pt-5 text-base">
                <li><a href="#services" onclick="toggleMenu()"
                        class="mobile-nav-link block py-3 px-4 rounded-2xl" data-i18n="nav.services">Dịch vụ</a></li>
                <li><a href="#platforms" onclick="toggleMenu()"
                        class="mobile-nav-link block py-3 px-4 rounded-2xl" data-i18n="nav.platforms">Nền tảng</a></li>
                <li><a href="#pricing" onclick="toggleMenu()"
                        class="mobile-nav-link block py-3 px-4 rounded-2xl" data-i18n="nav.pricing">Bảng giá</a></li>
                <li><a href="#stats" onclick="toggleMenu()"
                        class="mobile-nav-link block py-3 px-4 rounded-2xl" data-i18n="nav.stats">Thống kê</a></li>
                <li><a href="#faq" onclick="toggleMenu()"
                        class="mobile-nav-link block py-3 px-4 rounded-2xl">FAQ</a></li>

                <!-- Mobile Language -->
                <li class="pt-6 pb-2">
                    <div class="text-xs uppercase tracking-widest mb-3 px-1" style="color: var(--c-text-muted);">Ngôn ngữ</div>
                    <div class="grid grid-cols-2 gap-3">
                        <button onclick="setLang('vi')" id="opt-vi-m"
                            class="mobile-lang-btn flex items-center justify-center gap-2 py-4 rounded-2xl font-semibold text-sm">
                            <img src="https://cdn.whoispanel.com/admin/media/flags/vietnam.svg" alt="VI"
                                class="w-6 h-4 rounded" style="box-shadow:0 1px 3px rgba(0,0,0,0.2);">
                            Tiếng Việt
                        </button>
                        <button onclick="setLang('en')" id="opt-en-m"
                            class="mobile-lang-btn flex items-center justify-center gap-2 py-4 rounded-2xl font-semibold text-sm">
                            <img src="https://cdn.whoispanel.com/admin/media/flags/united-states.svg" alt="EN"
                                class="w-6 h-4 rounded" style="box-shadow:0 1px 3px rgba(0,0,0,0.2);">
                            English
                        </button>
                    </div>
                </li>

                <li class="pt-4">
                    <a href="{{ route('signup') }}"
                        class="btn-primary w-full py-4 text-base font-bold justify-center">
                        Bắt đầu ngay miễn phí
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- HERO -->
    <section class="above min-h-screen flex items-center justify-center px-6 pt-24 pb-16">
        <div class="max-w-5xl mx-auto text-center">
            <div
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card text-xs font-medium text-cyan-400 mb-8 fade-in">
                <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                <span data-i18n="hero.badge">Hệ thống hoạt động 24/7 — Tốc độ giao hàng #1 Việt Nam</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black leading-[1.05] mb-6 fade-in text-heading"
                style="letter-spacing:-0.04em;">
                <span data-i18n="hero.title1">Tăng trưởng</span> <span class="grad-text glow-text">Social
                    Media</span><br>
                <span data-i18n="hero.title2">với tốc độ ánh sáng</span>
            </h1>
            <p class="text-lg text-body max-w-2xl mx-auto mb-10 fade-in" data-i18n="hero.desc">
                Nền tảng SMM Panel hàng đầu — Followers, Likes, Views, Comments trên mọi mạng xã hội.
                API tích hợp, giá cạnh tranh, giao hàng tự động tức thì.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center fade-in">
                <a href="#pricing" class="btn-primary" data-i18n="hero.cta1">Xem bảng giá →</a>
                <a href="{{ route('signup') }}" class="btn-outline" data-i18n="hero.cta2">Đăng ký miễn phí</a>
            </div>
            <!-- Mini stats row -->
            <div class="grid grid-cols-3 gap-6 max-w-xl mx-auto mt-16 fade-in">
                <div class="text-center">
                    <div class="text-3xl font-extrabold grad-text">500K+</div>
                    <div class="text-xs text-muted mt-1" data-i18n="hero.stat1">Đơn hoàn thành</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-extrabold grad-text">12K+</div>
                    <div class="text-xs text-muted mt-1" data-i18n="hero.stat2">Khách hàng tin dùng</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-extrabold grad-text">99.8%</div>
                    <div class="text-xs text-muted mt-1" data-i18n="hero.stat3">Uptime đảm bảo</div>
                </div>
            </div>
        </div>
    </section>

    <!-- TICKER -->
    <div class="above py-4 border-y" style="border-color:var(--c-border);">
        <div class="ticker-wrap">
            <div class="ticker">
                <span class="text-cyan-400 text-sm font-medium">⚡ Giao hàng tức thì</span>
                <span class="text-slate-500 text-sm">•</span>
                <span class="text-violet-400 text-sm font-medium">🔒 Bảo mật tuyệt đối</span>
                <span class="text-slate-500 text-sm">•</span>
                <span class="text-pink-400 text-sm font-medium">💳 Thanh toán linh hoạt</span>
                <span class="text-slate-500 text-sm">•</span>
                <span class="text-cyan-400 text-sm font-medium">🌍 Hỗ trợ 50+ nền tảng</span>
                <span class="text-slate-500 text-sm">•</span>
                <span class="text-violet-400 text-sm font-medium">📊 API dành cho reseller</span>
                <span class="text-slate-500 text-sm">•</span>
                <span class="text-pink-400 text-sm font-medium">🎯 Chất lượng cao nhất</span>
                <span class="text-slate-500 text-sm">•</span>
                <span class="text-cyan-400 text-sm font-medium">⚡ Giao hàng tức thì</span>
                <span class="text-slate-500 text-sm">•</span>
                <span class="text-violet-400 text-sm font-medium">🔒 Bảo mật tuyệt đối</span>
                <span class="text-slate-500 text-sm">•</span>
                <span class="text-pink-400 text-sm font-medium">💳 Thanh toán linh hoạt</span>
                <span class="text-slate-500 text-sm">•</span>
                <span class="text-cyan-400 text-sm font-medium">🌍 Hỗ trợ 50+ nền tảng</span>
                <span class="text-slate-500 text-sm">•</span>
                <span class="text-violet-400 text-sm font-medium">📊 API dành cho reseller</span>
                <span class="text-slate-500 text-sm">•</span>
                <span class="text-pink-400 text-sm font-medium">🎯 Chất lượng cao nhất</span>
            </div>
        </div>
    </div>

    <!-- PLATFORMS -->
    <section id="platforms" class="above py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 fade-in">
                <div class="text-xs text-cyan-400 font-semibold tracking-widest uppercase mb-3"
                    data-i18n="platforms.label">Hỗ trợ đa nền tảng</div>
                <h2 class="text-4xl md:text-5xl font-black text-heading" style="letter-spacing:-0.04em;"><span
                        data-i18n="platforms.title1">Tất cả mạng xã hội</span><br><span class="grad-text"
                        data-i18n="platforms.title2">trong một nơi</span></h2>
            </div>
            <div class="grid grid-cols-3 md:grid-cols-6 gap-4 fade-in">
                <!-- Platform cards -->
                <div class="glass-card rounded-2xl p-5 flex flex-col items-center gap-3 cursor-pointer">
                    <img src="https://cdn.mypanel.link/4cgr8h/15z7egnk0elz7gzm.gif" alt="Instagram" class="w-12 h-12 rounded-xl object-cover">
                    <span class="text-sm font-semibold platform-name">Instagram</span>
                    <span class="text-xs platform-sub">Followers, Likes</span>
                </div>
                <div class="glass-card rounded-2xl p-5 flex flex-col items-center gap-3 cursor-pointer">
                    <img src="https://cdn.mypanel.link/4cgr8h/9rjnzbd98rt8s5we.gif" alt="Facebook" class="w-12 h-12 rounded-xl object-cover">
                    <span class="text-sm font-semibold platform-name">Facebook</span>
                    <span class="text-xs platform-sub">Page Likes, Views</span>
                </div>
                <div class="glass-card rounded-2xl p-5 flex flex-col items-center gap-3 cursor-pointer">
                    <img src="https://cdn.mypanel.link/4cgr8h/ewzs0f9k8ic2932y.gif" alt="TikTok" class="w-12 h-12 rounded-xl object-cover">
                    <span class="text-sm font-semibold platform-name">TikTok</span>
                    <span class="text-xs platform-sub">Followers, Views</span>
                </div>
                <div class="glass-card rounded-2xl p-5 flex flex-col items-center gap-3 cursor-pointer">
                    <img src="https://cdn.mypanel.link/sw177w/3y6jfcfgmm14jned.gif" alt="YouTube" class="w-12 h-12 rounded-xl object-cover">
                    <span class="text-sm font-semibold platform-name">YouTube</span>
                    <span class="text-xs platform-sub">Views, Subscribers</span>
                </div>
                <div class="glass-card rounded-2xl p-5 flex flex-col items-center gap-3 cursor-pointer">
                    <img src="https://cdn.mypanel.link/sw177w/7ea6iam2aygm0qws.gif" alt="Twitter/X" class="w-12 h-12 rounded-xl object-cover">
                    <span class="text-sm font-semibold platform-name">Twitter/X</span>
                    <span class="text-xs platform-sub">Followers, Likes</span>
                </div>
                <div class="glass-card rounded-2xl p-5 flex flex-col items-center gap-3 cursor-pointer">
                    <img src="https://cdn.mypanel.link/sw177w/7ea6iam2aygm0qws.gif" alt="Telegram" class="w-12 h-12 rounded-xl object-cover">
                    <span class="text-sm font-semibold platform-name">Telegram</span>
                    <span class="text-xs platform-sub">Members, Views</span>
                </div>
            </div>
            <p class="text-center text-sm text-muted mt-6" data-i18n="platforms.more">và 44+ nền tảng khác: Spotify,
                SoundCloud, LinkedIn, Pinterest, Twitch...</p>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="above py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 fade-in">
                <div class="text-xs text-cyan-400 font-semibold tracking-widest uppercase mb-3"
                    data-i18n="services.label">Dịch vụ nổi bật</div>
                <h2 class="text-4xl md:text-5xl font-black text-heading" style="letter-spacing:-0.04em;"><span
                        data-i18n="services.title1">Mọi thứ bạn cần</span><br><span class="grad-text"
                        data-i18n="services.title2">để viral</span></h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="glass-card rounded-2xl p-7 fade-in">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5"
                        style="background:rgba(0,245,255,0.1);">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" stroke="#00f5ff" stroke-width="2"
                                stroke-linecap="round" />
                            <circle cx="9" cy="7" r="4" stroke="#00f5ff" stroke-width="2" />
                            <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" stroke="#00f5ff"
                                stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-heading mb-3" data-i18n="svc.followers.title">Followers &
                        Subscribers</h3>
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.followers.desc">Tăng lượng theo
                        dõi thực chất, chất lượng cao. Profile không ảo, không bot — chạy từ traffic thật.</p>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-label" data-i18n="svc.speed">Tốc độ giao hàng</span>
                            <span class="text-cyan-400 font-semibold">1K/ngày</span>
                        </div>
                        <div class="progress-bar" style="width:85%"></div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-label" data-i18n="svc.drop">Tỷ lệ rớt</span>
                            <span class="text-green-400 font-semibold">&lt; 2%</span>
                        </div>
                        <div class="progress-bar" style="width:95%;background:linear-gradient(90deg,#22c55e,#16a34a)">
                        </div>
                    </div>
                    <div class="mt-5 text-xs font-semibold text-cyan-400" data-i18n="svc.followers.price">Từ 5,000đ /
                        1000</div>
                </div>

                <div class="glass-card rounded-2xl p-7 fade-in" style="animation-delay:0.1s">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5"
                        style="background:rgba(124,58,237,0.1);">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <path
                                d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"
                                stroke="#a78bfa" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-heading mb-3" data-i18n="svc.likes.title">Likes & Reactions</h3>
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.likes.desc">Tương tác cực nhanh,
                        bắt đầu trong 0–5 phút. Hỗ trợ tất cả loại bài đăng, Reel, Story.</p>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-label" data-i18n="svc.startspeed">Tốc độ bắt đầu</span>
                            <span class="text-violet-400 font-semibold">&lt; 5 phút</span>
                        </div>
                        <div class="progress-bar" style="width:98%;background:linear-gradient(90deg,#7c3aed,#a78bfa)">
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-label" data-i18n="svc.quality">Chất lượng</span>
                            <span class="text-violet-400 font-semibold">Premium</span>
                        </div>
                        <div class="progress-bar" style="width:90%;background:linear-gradient(90deg,#7c3aed,#a78bfa)">
                        </div>
                    </div>
                    <div class="mt-5 text-xs font-semibold text-violet-400" data-i18n="svc.likes.price">Từ 2,000đ /
                        1000</div>
                </div>

                <div class="glass-card rounded-2xl p-7 fade-in" style="animation-delay:0.2s">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5"
                        style="background:rgba(244,114,182,0.1);">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <polygon points="23 7 16 12 23 17 23 7" stroke="#f472b6" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <rect x="1" y="5" width="15" height="14" rx="2" ry="2"
                                stroke="#f472b6" stroke-width="2" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-heading mb-3" data-i18n="svc.views.title">Views & Impressions
                    </h3>
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.views.desc">Lượt xem video,
                        Reels, Stories thực — tăng độ phủ sóng và thuật toán đề xuất của bạn.</p>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-label" data-i18n="svc.maxvol">Volume tối đa</span>
                            <span class="text-pink-400 font-semibold">10M+ views</span>
                        </div>
                        <div class="progress-bar" style="width:92%;background:linear-gradient(90deg,#ec4899,#f472b6)">
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="text-label" data-i18n="svc.retention">Giữ chân</span>
                            <span class="text-pink-400 font-semibold">60%+</span>
                        </div>
                        <div class="progress-bar" style="width:78%;background:linear-gradient(90deg,#ec4899,#f472b6)">
                        </div>
                    </div>
                    <div class="mt-5 text-xs font-semibold text-pink-400" data-i18n="svc.views.price">Từ 1,000đ / 1000
                    </div>
                </div>

                <div class="glass-card rounded-2xl p-7 fade-in">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5"
                        style="background:rgba(234,179,8,0.1);">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" stroke="#eab308"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-heading mb-3" data-i18n="svc.comments.title">Comments</h3>
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.comments.desc">Bình luận thật, đa
                        dạng nội dung. Tùy chỉnh ngôn ngữ và nội dung theo yêu cầu.</p>
                    <div class="mt-5 text-xs font-semibold text-yellow-400" data-i18n="svc.comments.price">Từ 15,000đ
                        / 100</div>
                </div>

                <div class="glass-card rounded-2xl p-7 fade-in" style="animation-delay:0.1s">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5"
                        style="background:rgba(20,184,166,0.1);">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18" stroke="#14b8a6" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <polyline points="17 6 23 6 23 12" stroke="#14b8a6" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-heading mb-3" data-i18n="svc.api.title">API Reseller</h3>
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.api.desc">Tích hợp API vào hệ
                        thống của bạn. Tài liệu đầy đủ, hỗ trợ JSON, tự động hóa hoàn toàn.</p>
                    <div class="mt-5 text-xs font-semibold text-teal-400" data-i18n="svc.api.price">Miễn phí khi nạp
                        tiền</div>
                </div>

                <div class="glass-card rounded-2xl p-7 fade-in" style="animation-delay:0.2s">
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5"
                        style="background:rgba(239,68,68,0.1);">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="#ef4444" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-heading mb-3" data-i18n="svc.refill.title">Refill Guarantee</h3>
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.refill.desc">Bảo hành 30–365 ngày
                        tùy gói. Tự động refill nếu rớt followers mà không cần liên hệ.</p>
                    <div class="mt-5 text-xs font-semibold text-red-400" data-i18n="svc.refill.price">Bảo hành suốt 1
                        năm</div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS SECTION -->
    <section id="stats" class="above py-24 px-6" style="background:rgba(255,255,255,0.02);">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-6 text-center fade-in">
                <div class="glass-card rounded-2xl p-8">
                    <div class="text-5xl font-extrabold grad-text mb-2" data-target="{{ $totalOrders ?? 500000 }}">0
                    </div>
                    <div class="text-sm text-body" data-i18n="stats.orders">Đơn hàng hoàn thành</div>
                </div>
                <div class="glass-card rounded-2xl p-8">
                    <div class="text-5xl font-extrabold grad-text mb-2" data-target="12000">0</div>
                    <div class="text-sm text-body" data-i18n="stats.users">Khách hàng đang dùng</div>
                </div>
                <div class="glass-card rounded-2xl p-8">
                    <div class="text-5xl font-extrabold grad-text mb-2" data-target="{{ $totalServices ?? 50 }}">0
                    </div>
                    <div class="text-sm text-body" data-i18n="stats.services">Dịch vụ hỗ trợ</div>
                </div>
                <div class="glass-card rounded-2xl p-8">
                    <div class="text-5xl font-extrabold grad-text mb-2" data-target="998">0</div>
                    <div class="text-sm text-body" data-i18n="stats.uptime">% Uptime / năm</div>
                </div>
            </div>
        </div>
    </section>

    <!-- PRICING -->
    <section id="pricing" class="above py-24 px-6">
        <div class="max-w-5xl mx-auto">
            <div class="text-center mb-16 fade-in">
                <div class="text-xs text-cyan-400 font-semibold tracking-widest uppercase mb-3"
                    data-i18n="pricing.label">Bảng giá</div>
                <h2 class="text-4xl md:text-5xl font-black text-heading" style="letter-spacing:-0.04em;"><span
                        data-i18n="pricing.title1">Giá cạnh tranh</span><br><span class="grad-text"
                        data-i18n="pricing.title2">minh bạch 100%</span></h2>
                <p class="text-body mt-4 text-sm" data-i18n="pricing.sub">Không phí ẩn. Nạp ngay — dùng ngay.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="glass-card rounded-2xl p-8 fade-in">
                    <div class="text-xs text-muted uppercase tracking-widest mb-3">Starter</div>
                    <div class="text-4xl font-extrabold text-heading mb-1">50K <span
                            class="text-base font-normal text-muted">VNĐ</span></div>
                    <div class="text-xs text-muted mb-6" data-i18n="pricing.starter.sub">Nạp tối thiểu để bắt đầu
                    </div>
                    <ul class="space-y-3 text-sm text-body mb-8">
                        <li class="flex items-center gap-2"><span class="text-cyan-400">✓</span> <span
                                data-i18n="pricing.starter.f1">Truy cập 500+ dịch vụ</span></li>
                        <li class="flex items-center gap-2"><span class="text-cyan-400">✓</span> <span
                                data-i18n="pricing.starter.f2">Giao hàng tức thì</span></li>
                        <li class="flex items-center gap-2"><span class="text-cyan-400">✓</span> <span
                                data-i18n="pricing.starter.f3">Hỗ trợ chat 24/7</span></li>
                        <li class="flex items-center gap-2"><span class="text-muted">✗</span> <span
                                class="text-muted">API access</span></li>
                        <li class="flex items-center gap-2"><span class="text-muted">✗</span> <span
                                class="text-muted" data-i18n="pricing.starter.f5">Giá reseller</span></li>
                    </ul>
                    <a href="{{ route('signup') }}" class="btn-outline w-full text-center" data-i18n="pricing.topup">Nạp ngay</a>
                </div>

                <div class="rounded-2xl p-8 price-popular glass-card fade-in relative" style="animation-delay:0.1s">
                    <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full text-xs font-bold"
                        style="background:#6366f1;color:#fff;"
                        data-i18n="pricing.popular">⭐ Phổ biến nhất</div>
                    <div class="text-xs text-cyan-400 uppercase tracking-widest mb-3">Pro</div>
                    <div class="text-4xl font-extrabold text-heading mb-1">500K <span
                            class="text-base font-normal text-muted">VNĐ</span></div>
                    <div class="text-xs text-muted mb-6" data-i18n="pricing.pro.sub">Giá reseller unlock từ 500K</div>
                    <ul class="space-y-3 text-sm text-body mb-8">
                        <li class="flex items-center gap-2"><span class="text-cyan-400">✓</span> <span
                                data-i18n="pricing.pro.f1">Tất cả dịch vụ Starter</span></li>
                        <li class="flex items-center gap-2"><span class="text-cyan-400">✓</span> <span
                                data-i18n="pricing.pro.f2">Giảm giá 20–40%</span></li>
                        <li class="flex items-center gap-2"><span class="text-cyan-400">✓</span> <span
                                data-i18n="pricing.pro.f3">API full access</span></li>
                        <li class="flex items-center gap-2"><span class="text-cyan-400">✓</span> <span
                                data-i18n="pricing.pro.f4">Ưu tiên hỗ trợ</span></li>
                        <li class="flex items-center gap-2"><span class="text-muted">✗</span> <span
                                class="text-muted">White-label panel</span></li>
                    </ul>
                    <a href="{{ route('signup') }}" class="btn-primary w-full text-center" data-i18n="pricing.topup_pro">Nạp ngay ↗</a>
                </div>

                <div class="glass-card rounded-2xl p-8 fade-in" style="animation-delay:0.2s">
                    <div class="text-xs text-muted uppercase tracking-widest mb-3">Enterprise</div>
                    <div class="text-4xl font-extrabold text-heading mb-1">2M+ <span
                            class="text-base font-normal text-muted">VNĐ</span></div>
                    <div class="text-xs text-muted mb-6" data-i18n="pricing.ent.sub">Dành cho đại lý lớn</div>
                    <ul class="space-y-3 text-sm text-body mb-8">
                        <li class="flex items-center gap-2"><span class="text-violet-400">✓</span> <span
                                data-i18n="pricing.ent.f1">Giá tốt nhất thị trường</span></li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">✓</span> <span>White-label
                                panel</span></li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">✓</span> <span
                                data-i18n="pricing.ent.f3">Account manager riêng</span></li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">✓</span> <span>SLA 99.9%
                                uptime</span></li>
                        <li class="flex items-center gap-2"><span class="text-violet-400">✓</span> <span>Invoice &
                                VAT</span></li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn-outline w-full text-center btn-violet"
                        data-i18n="pricing.contact">Liên hệ ngay</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="above py-24 px-6" style="background:rgba(255,255,255,0.02);">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-4xl font-extrabold text-heading"><span data-i18n="faq.title1">Câu hỏi</span> <span
                        class="grad-text" data-i18n="faq.title2">thường gặp</span></h2>
            </div>
            <div class="space-y-3 fade-in" id="faq-list">
                <div class="faq-item glass-card rounded-xl overflow-hidden">
                    <button
                        class="faq-q w-full text-left px-6 py-4 font-semibold text-sm text-heading flex justify-between items-center"
                        onclick="toggleFaq(this)">
                        <span data-i18n="faq.q1">SMM Panel là gì và hoạt động như thế nào?</span>
                        <svg class="faq-icon w-4 h-4 text-cyan-400 transition-transform" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-ans hidden px-6 pb-4 text-sm text-body leading-relaxed" data-i18n="faq.a1">
                        SMM Panel là nền tảng cung cấp dịch vụ tăng tương tác mạng xã hội tự động. Bạn đặt đơn, cung cấp
                        link, hệ thống tự xử lý và giao dịch vụ mà không cần can thiệp thủ công.
                    </div>
                </div>
                <div class="faq-item glass-card rounded-xl overflow-hidden">
                    <button
                        class="faq-q w-full text-left px-6 py-4 font-semibold text-sm text-heading flex justify-between items-center"
                        onclick="toggleFaq(this)">
                        <span data-i18n="faq.q2">Dịch vụ có an toàn cho tài khoản của tôi không?</span>
                        <svg class="faq-icon w-4 h-4 text-cyan-400 transition-transform" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-ans hidden px-6 pb-4 text-sm text-body leading-relaxed" data-i18n="faq.a2">
                        Chúng tôi dùng phương pháp giao hàng tự nhiên, không yêu cầu mật khẩu. Gói chất lượng cao sử
                        dụng tài khoản thật, giảm thiểu rủi ro vi phạm chính sách nền tảng.
                    </div>
                </div>
                <div class="faq-item glass-card rounded-xl overflow-hidden">
                    <button
                        class="faq-q w-full text-left px-6 py-4 font-semibold text-sm text-heading flex justify-between items-center"
                        onclick="toggleFaq(this)">
                        <span data-i18n="faq.q3">Tôi có thể tích hợp API vào hệ thống của mình không?</span>
                        <svg class="faq-icon w-4 h-4 text-cyan-400 transition-transform" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-ans hidden px-6 pb-4 text-sm text-body leading-relaxed" data-i18n="faq.a3">
                        Có! API RESTful đầy đủ với tài liệu chi tiết. Hỗ trợ đặt đơn, kiểm tra trạng thái, lấy danh sách
                        dịch vụ và quản lý số dư — tương thích mọi ngôn ngữ lập trình.
                    </div>
                </div>
                <div class="faq-item glass-card rounded-xl overflow-hidden">
                    <button
                        class="faq-q w-full text-left px-6 py-4 font-semibold text-sm text-heading flex justify-between items-center"
                        onclick="toggleFaq(this)">
                        <span data-i18n="faq.q4">Phương thức thanh toán được hỗ trợ?</span>
                        <svg class="faq-icon w-4 h-4 text-cyan-400 transition-transform" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-ans hidden px-6 pb-4 text-sm text-body leading-relaxed" data-i18n="faq.a4">
                        Hỗ trợ: MoMo, ZaloPay, ViettelPay, chuyển khoản ngân hàng, thẻ Visa/Mastercard, USDT/Crypto. Nạp
                        tiền tự động xác nhận trong vòng 1–5 phút.
                    </div>
                </div>
                <div class="faq-item glass-card rounded-xl overflow-hidden">
                    <button
                        class="faq-q w-full text-left px-6 py-4 font-semibold text-sm text-heading flex justify-between items-center"
                        onclick="toggleFaq(this)">
                        <span data-i18n="faq.q5">Nếu đơn hàng không hoàn thành, tôi có được hoàn tiền không?</span>
                        <svg class="faq-icon w-4 h-4 text-cyan-400 transition-transform" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-ans hidden px-6 pb-4 text-sm text-body leading-relaxed" data-i18n="faq.a5">
                        Có. Đơn hàng không hoàn thành hoặc thất bại sẽ được hoàn tiền tự động vào số dư tài khoản trong
                        24 giờ. Liên hệ hỗ trợ nếu cần xử lý sớm hơn.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="above py-24 px-6">
        <div class="max-w-3xl mx-auto text-center fade-in">
            <div class="glass-card rounded-3xl p-12" style="border-color:rgba(0,245,255,0.2);">
                <div class="relative inline-block mb-6">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center pulse-ring relative"
                        style="background:linear-gradient(135deg,rgba(0,245,255,0.2),rgba(124,58,237,0.2));border:1px solid rgba(0,245,255,0.3);">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" fill="url(#g1)" />
                            <defs>
                                <linearGradient id="g1" x1="0" y1="0" x2="1"
                                    y2="1">
                                    <stop offset="0%" stop-color="#00f5ff" />
                                    <stop offset="100%" stop-color="#7c3aed" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
                <h2 class="text-4xl font-extrabold text-heading mb-4"><span data-i18n="cta.title1">Sẵn sàng tăng
                        tốc</span><br><span class="grad-text" data-i18n="cta.title2">social media?</span></h2>
                <p class="text-body mb-8 text-sm" data-i18n="cta.sub">Đăng ký miễn phí trong 30 giây. Không cần thẻ
                    tín dụng.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('signup') }}" class="btn-primary" data-i18n="cta.btn1">Tạo tài khoản miễn phí
                        →</a>
                    <a href="{{ route('login') }}" class="btn-outline" data-i18n="cta.btn2">Đăng nhập</a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="above border-t py-12 px-6 text-sm text-slate-500" style="border-color:var(--c-border);">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                            style="background:linear-gradient(135deg,#00f5ff,#7c3aed);">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" fill="white" />
                            </svg>
                        </div>
                        <span class="font-black text-white tracking-tight"
                            style="letter-spacing:-0.04em;">NexaSMM</span>
                    </div>
                    <p class="text-xs leading-relaxed text-muted" data-i18n="footer.desc">Nền tảng SMM Panel hàng đầu
                        Việt Nam. Giao hàng nhanh, giá tốt, hỗ trợ 24/7.</p>
                </div>
                <div>
                    <div class="font-semibold text-heading mb-4" data-i18n="footer.services">Dịch vụ</div>
                    <ul class="space-y-2 text-xs text-muted">
                        <li>Instagram</li>
                        <li>Facebook</li>
                        <li>TikTok</li>
                        <li>YouTube</li>
                    </ul>
                </div>
                <div>
                    <div class="font-semibold text-heading mb-4" data-i18n="footer.support">Hỗ trợ</div>
                    <ul class="space-y-2 text-xs text-muted">
                        <li data-i18n="footer.api">Tài liệu API</li>
                        <li data-i18n="footer.guide">Hướng dẫn đặt đơn</li>
                        <li data-i18n="footer.refund">Chính sách hoàn tiền</li>
                        <li data-i18n="footer.contact">Liên hệ</li>
                    </ul>
                </div>
                <div>
                    <div class="font-semibold text-heading mb-4" data-i18n="footer.contact_title">Liên hệ</div>
                    <ul class="space-y-2 text-xs text-muted">
                        <li>📧 {{ $config->email ?? 'support@panel.vn' }}</li>
                        <li>💬 Telegram: {{ $config->telegram ?? 'support@panel.vn' }}</li>
                        <li data-i18n="footer.support_time">⏰ Hỗ trợ: 24/7</li>
                    </ul>
                </div>
            </div>
            <div class="border-t pt-6 flex flex-col md:flex-row justify-between items-center gap-4"
                style="border-color:var(--c-border);">
                <div class="text-xs text-muted">© {{ date('Y') }} {{ $config->title ?? 'NexaSMM' }}. All rights
                    reserved.</div>
                <div class="flex gap-4 text-xs text-muted"><a href="#" class="hover:text-white transition"
                        data-i18n="footer.terms">Điều khoản</a><a href="#" class="hover:text-white transition"
                        data-i18n="footer.privacy">Bảo mật</a></div>
            </div>
        </div>
    </footer>

    <script>
        // ── THREE.JS BACKGROUND ──────────────────────────────────────────────────────
        (function() {
            const canvas = document.getElementById('canvas-bg');
            const renderer = new THREE.WebGLRenderer({
                canvas,
                alpha: true,
                antialias: true
            });
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            renderer.setSize(window.innerWidth, window.innerHeight);

            const scene = new THREE.Scene();
            const camera = new THREE.PerspectiveCamera(60, window.innerWidth / window.innerHeight, 0.1, 1000);
            camera.position.set(0, 0, 18);

            // Particle field
            const particleCount = 1800;
            const positions = new Float32Array(particleCount * 3);
            const colors = new Float32Array(particleCount * 3);
            const sizes = new Float32Array(particleCount);

            const palette = [
                new THREE.Color('#00f5ff'),
                new THREE.Color('#7c3aed'),
                new THREE.Color('#f472b6'),
                new THREE.Color('#1e40af'),
            ];

            for (let i = 0; i < particleCount; i++) {
                positions[i * 3] = (Math.random() - 0.5) * 60;
                positions[i * 3 + 1] = (Math.random() - 0.5) * 60;
                positions[i * 3 + 2] = (Math.random() - 0.5) * 40;
                const c = palette[Math.floor(Math.random() * palette.length)];
                colors[i * 3] = c.r;
                colors[i * 3 + 1] = c.g;
                colors[i * 3 + 2] = c.b;
                sizes[i] = Math.random() * 2 + 0.5;
            }

            const pGeo = new THREE.BufferGeometry();
            pGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));
            pGeo.setAttribute('color', new THREE.BufferAttribute(colors, 3));
            pGeo.setAttribute('size', new THREE.BufferAttribute(sizes, 1));

            const pMat = new THREE.PointsMaterial({
                size: 0.12,
                vertexColors: true,
                transparent: true,
                opacity: 0.7,
                sizeAttenuation: true,
            });

            const particles = new THREE.Points(pGeo, pMat);
            scene.add(particles);

            // Floating geometric wireframes
            const geos = [
                new THREE.IcosahedronGeometry(2, 0),
                new THREE.OctahedronGeometry(1.5, 0),
                new THREE.TetrahedronGeometry(1.2, 0),
            ];
            const meshes = [];
            geos.forEach((g, i) => {
                const mat = new THREE.MeshBasicMaterial({
                    color: i === 0 ? 0x00f5ff : i === 1 ? 0x7c3aed : 0xf472b6,
                    wireframe: true,
                    transparent: true,
                    opacity: 0.15,
                });
                const m = new THREE.Mesh(g, mat);
                m.position.set((i - 1) * 10, (i % 2 === 0 ? 3 : -3), -5);
                meshes.push(m);
                scene.add(m);
            });

            // Grid floor
            const gridHelper = new THREE.GridHelper(80, 40, 0x00f5ff, 0x0f172a);
            gridHelper.material.opacity = 0.08;
            gridHelper.material.transparent = true;
            gridHelper.position.y = -12;
            gridHelper.rotation.x = 0.15;
            scene.add(gridHelper);

            // Mouse parallax
            let mouseX = 0,
                mouseY = 0;
            document.addEventListener('mousemove', e => {
                mouseX = (e.clientX / window.innerWidth - 0.5) * 2;
                mouseY = (e.clientY / window.innerHeight - 0.5) * 2;
            });

            let t = 0;

            function animate() {
                requestAnimationFrame(animate);
                t += 0.005;
                particles.rotation.y = t * 0.05 + mouseX * 0.03;
                particles.rotation.x = mouseY * 0.02;
                meshes.forEach((m, i) => {
                    m.rotation.x = t * (0.3 + i * 0.1);
                    m.rotation.y = t * (0.2 + i * 0.15);
                    m.position.y = Math.sin(t + i) * 2;
                });
                camera.position.x += (mouseX * 0.5 - camera.position.x) * 0.03;
                camera.position.y += (-mouseY * 0.3 - camera.position.y) * 0.03;
                renderer.render(scene, camera);
            }
            animate();

            window.addEventListener('resize', () => {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            });
        })();

        // ── SCROLL ANIMATIONS ─────────────────────────────────────────────────────────
        const obs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) e.target.classList.add('visible');
            });
        }, {
            threshold: 0.1
        });
        document.querySelectorAll('.fade-in').forEach(el => obs.observe(el));

        // ── COUNTER ANIMATION ─────────────────────────────────────────────────────────
        const counterObs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting && !e.target.dataset.done) {
                    e.target.dataset.done = '1';
                    const target = +e.target.dataset.target;
                    const isPercent = target === 998;
                    let cur = 0;
                    const step = Math.max(1, Math.floor(target / 80));
                    const timer = setInterval(() => {
                        cur = Math.min(cur + step, target);
                        if (isPercent) {
                            e.target.textContent = (cur / 10).toFixed(1) + '%';
                        } else if (target >= 1000) {
                            e.target.textContent = (cur / 1000).toFixed(0) + 'K+';
                        } else {
                            e.target.textContent = cur + '+';
                        }
                        if (cur >= target) clearInterval(timer);
                    }, 20);
                }
            });
        }, {
            threshold: 0.3
        });
        document.querySelectorAll('[data-target]').forEach(el => counterObs.observe(el));

        // ── FAQ TOGGLE ────────────────────────────────────────────────────────────────
        function toggleFaq(btn) {
            const ans = btn.nextElementSibling;
            const icon = btn.querySelector('.faq-icon');
            const isOpen = !ans.classList.contains('hidden');
            document.querySelectorAll('.faq-ans').forEach(a => a.classList.add('hidden'));
            document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = '');
            if (!isOpen) {
                ans.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            }
        }

        // ── MOBILE MENU ────────────────────────────────────────────────────────────────
        function toggleMenu() {
            var m = document.getElementById('mobile-menu');
            if (!m) return;
            m.classList.toggle('open');
        }

        // ── I18N ──────────────────────────────────────────────────────────────────────
        var LANG = {
            vi: {
                'nav.services': 'Dịch vụ',
                'nav.platforms': 'Nền tảng',
                'nav.pricing': 'Bảng giá',
                'nav.stats': 'Thống kê',
                'nav.login': 'Đăng nhập',
                'nav.start': 'Bắt đầu ngay',
                'hero.badge': 'Hệ thống hoạt động 24/7 — Tốc độ giao hàng #1 Việt Nam',
                'hero.title1': 'Tăng trưởng',
                'hero.title2': 'với tốc độ ánh sáng',
                'hero.desc': 'Nền tảng SMM Panel hàng đầu — Followers, Likes, Views, Comments trên mọi mạng xã hội. API tích hợp, giá cạnh tranh, giao hàng tự động tức thì.',
                'hero.cta1': 'Xem bảng giá →',
                'hero.cta2': 'Đăng ký miễn phí',
                'hero.stat1': 'Đơn hoàn thành',
                'hero.stat2': 'Khách hàng tin dùng',
                'hero.stat3': 'Uptime đảm bảo',
                'platforms.label': 'Hỗ trợ đa nền tảng',
                'platforms.title1': 'Tất cả mạng xã hội',
                'platforms.title2': 'trong một nơi',
                'platforms.more': 'và 44+ nền tảng khác: Spotify, SoundCloud, LinkedIn, Pinterest, Twitch...',
                'services.label': 'Dịch vụ nổi bật',
                'services.title1': 'Mọi thứ bạn cần',
                'services.title2': 'để viral',
                'svc.followers.title': 'Followers & Subscribers',
                'svc.followers.desc': 'Tăng lượng theo dõi thực chất, chất lượng cao. Profile không ảo, không bot — chạy từ traffic thật.',
                'svc.followers.price': 'Từ 5,000đ / 1000',
                'svc.likes.title': 'Likes & Reactions',
                'svc.likes.desc': 'Tương tác cực nhanh, bắt đầu trong 0–5 phút. Hỗ trợ tất cả loại bài đăng, Reel, Story.',
                'svc.likes.price': 'Từ 2,000đ / 1000',
                'svc.views.title': 'Views & Impressions',
                'svc.views.desc': 'Lượt xem video, Reels, Stories thực — tăng độ phủ sóng và thuật toán đề xuất của bạn.',
                'svc.views.price': 'Từ 1,000đ / 1000',
                'svc.comments.title': 'Comments',
                'svc.comments.desc': 'Bình luận thật, đa dạng nội dung. Tùy chỉnh ngôn ngữ và nội dung theo yêu cầu.',
                'svc.comments.price': 'Từ 15,000đ / 100',
                'svc.api.title': 'API Reseller',
                'svc.api.desc': 'Tích hợp API vào hệ thống của bạn. Tài liệu đầy đủ, hỗ trợ JSON, tự động hóa hoàn toàn.',
                'svc.api.price': 'Miễn phí khi nạp tiền',
                'svc.refill.title': 'Refill Guarantee',
                'svc.refill.desc': 'Bảo hành 30–365 ngày tùy gói. Tự động refill nếu rớt followers mà không cần liên hệ.',
                'svc.refill.price': 'Bảo hành suốt 1 năm',
                'svc.speed': 'Tốc độ giao hàng',
                'svc.drop': 'Tỷ lệ rớt',
                'svc.startspeed': 'Tốc độ bắt đầu',
                'svc.quality': 'Chất lượng',
                'svc.maxvol': 'Volume tối đa',
                'svc.retention': 'Giữ chân',
                'stats.orders': 'Đơn hàng hoàn thành',
                'stats.users': 'Khách hàng đang dùng',
                'stats.services': 'Dịch vụ hỗ trợ',
                'stats.uptime': '% Uptime / năm',
                'pricing.label': 'Bảng giá',
                'pricing.title1': 'Giá cạnh tranh',
                'pricing.title2': 'minh bạch 100%',
                'pricing.sub': 'Không phí ẩn. Nạp ngay — dùng ngay.',
                'pricing.starter.sub': 'Nạp tối thiểu để bắt đầu',
                'pricing.starter.f1': 'Truy cập 500+ dịch vụ',
                'pricing.starter.f2': 'Giao hàng tức thì',
                'pricing.starter.f3': 'Hỗ trợ chat 24/7',
                'pricing.starter.f5': 'Giá reseller',
                'pricing.popular': '⭐ Phổ biến nhất',
                'pricing.pro.sub': 'Giá reseller unlock từ 500K',
                'pricing.pro.f1': 'Tất cả dịch vụ Starter',
                'pricing.pro.f2': 'Giảm giá 20–40%',
                'pricing.pro.f3': 'API full access',
                'pricing.pro.f4': 'Ưu tiên hỗ trợ',
                'pricing.ent.sub': 'Dành cho đại lý lớn',
                'pricing.ent.f1': 'Giá tốt nhất thị trường',
                'pricing.ent.f3': 'Account manager riêng',
                'pricing.topup': 'Nạp ngay',
                'pricing.topup_pro': 'Nạp ngay ↗',
                'pricing.contact': 'Liên hệ ngay',
                'faq.title1': 'Câu hỏi',
                'faq.title2': 'thường gặp',
                'faq.q1': 'SMM Panel là gì và hoạt động như thế nào?',
                'faq.a1': 'SMM Panel là nền tảng cung cấp dịch vụ tăng tương tác mạng xã hội tự động. Bạn đặt đơn, cung cấp link, hệ thống tự xử lý và giao dịch vụ mà không cần can thiệp thủ công.',
                'faq.q2': 'Dịch vụ có an toàn cho tài khoản của tôi không?',
                'faq.a2': 'Chúng tôi dùng phương pháp giao hàng tự nhiên, không yêu cầu mật khẩu. Gói chất lượng cao sử dụng tài khoản thật, giảm thiểu rủi ro vi phạm chính sách nền tảng.',
                'faq.q3': 'Tôi có thể tích hợp API vào hệ thống của mình không?',
                'faq.a3': 'Có! API RESTful đầy đủ với tài liệu chi tiết. Hỗ trợ đặt đơn, kiểm tra trạng thái, lấy danh sách dịch vụ và quản lý số dư — tương thích mọi ngôn ngữ lập trình.',
                'faq.q4': 'Phương thức thanh toán được hỗ trợ?',
                'faq.a4': 'Hỗ trợ: MoMo, ZaloPay, ViettelPay, chuyển khoản ngân hàng, thẻ Visa/Mastercard, USDT/Crypto. Nạp tiền tự động xác nhận trong vòng 1–5 phút.',
                'faq.q5': 'Nếu đơn hàng không hoàn thành, tôi có được hoàn tiền không?',
                'faq.a5': 'Có. Đơn hàng không hoàn thành hoặc thất bại sẽ được hoàn tiền tự động vào số dư tài khoản trong 24 giờ. Liên hệ hỗ trợ nếu cần xử lý sớm hơn.',
                'cta.title1': 'Sẵn sàng tăng tốc',
                'cta.title2': 'social media?',
                'cta.sub': 'Đăng ký miễn phí trong 30 giây. Không cần thẻ tín dụng.',
                'cta.btn1': 'Tạo tài khoản miễn phí →',
                'cta.btn2': 'Đăng nhập',
                'footer.desc': 'Nền tảng SMM Panel hàng đầu Việt Nam. Giao hàng nhanh, giá tốt, hỗ trợ 24/7.',
                'footer.services': 'Dịch vụ',
                'footer.support': 'Hỗ trợ',
                'footer.contact_title': 'Liên hệ',
                'footer.api': 'Tài liệu API',
                'footer.guide': 'Hướng dẫn đặt đơn',
                'footer.refund': 'Chính sách hoàn tiền',
                'footer.contact': 'Liên hệ',
                'footer.support_time': '⏰ Hỗ trợ: 24/7',
                'footer.terms': 'Điều khoản',
                'footer.privacy': 'Bảo mật',
            },
            en: {
                'nav.services': 'Services',
                'nav.platforms': 'Platforms',
                'nav.pricing': 'Pricing',
                'nav.stats': 'Stats',
                'nav.login': 'Sign In',
                'nav.start': 'Get Started',
                'hero.badge': 'System running 24/7 — #1 Delivery Speed in Vietnam',
                'hero.title1': 'Grow your',
                'hero.title2': 'at the speed of light',
                'hero.desc': 'The leading SMM Panel — Followers, Likes, Views, Comments on every social network. Integrated API, competitive pricing, instant automated delivery.',
                'hero.cta1': 'View Pricing →',
                'hero.cta2': 'Sign Up Free',
                'hero.stat1': 'Orders Completed',
                'hero.stat2': 'Trusted Customers',
                'hero.stat3': 'Uptime Guaranteed',
                'platforms.label': 'Multi-platform Support',
                'platforms.title1': 'All social networks',
                'platforms.title2': 'in one place',
                'platforms.more': 'and 44+ more: Spotify, SoundCloud, LinkedIn, Pinterest, Twitch...',
                'services.label': 'Featured Services',
                'services.title1': 'Everything you need',
                'services.title2': 'to go viral',
                'svc.followers.title': 'Followers & Subscribers',
                'svc.followers.desc': 'High-quality, genuine followers. No fake profiles, no bots — powered by real traffic.',
                'svc.followers.price': 'From $0.20 / 1000',
                'svc.likes.title': 'Likes & Reactions',
                'svc.likes.desc': 'Ultra-fast engagement, starting in 0–5 minutes. Supports all post types, Reels, Stories.',
                'svc.likes.price': 'From $0.08 / 1000',
                'svc.views.title': 'Views & Impressions',
                'svc.views.desc': 'Real video, Reels, Stories views — boost your reach and recommendation algorithm.',
                'svc.views.price': 'From $0.04 / 1000',
                'svc.comments.title': 'Comments',
                'svc.comments.desc': 'Real comments, diverse content. Customize language and content on request.',
                'svc.comments.price': 'From $0.60 / 100',
                'svc.api.title': 'API Reseller',
                'svc.api.desc': 'Integrate our API into your system. Full documentation, JSON support, fully automated.',
                'svc.api.price': 'Free with deposit',
                'svc.refill.title': 'Refill Guarantee',
                'svc.refill.desc': '30–365 day warranty depending on package. Auto-refill if followers drop, no contact needed.',
                'svc.refill.price': '1-year warranty',
                'svc.speed': 'Delivery Speed',
                'svc.drop': 'Drop Rate',
                'svc.startspeed': 'Start Speed',
                'svc.quality': 'Quality',
                'svc.maxvol': 'Max Volume',
                'svc.retention': 'Retention',
                'stats.orders': 'Orders Completed',
                'stats.users': 'Active Customers',
                'stats.services': 'Services Supported',
                'stats.uptime': '% Uptime / year',
                'pricing.label': 'Pricing',
                'pricing.title1': 'Competitive pricing',
                'pricing.title2': '100% transparent',
                'pricing.sub': 'No hidden fees. Deposit now — use now.',
                'pricing.starter.sub': 'Minimum deposit to start',
                'pricing.starter.f1': 'Access 500+ services',
                'pricing.starter.f2': 'Instant delivery',
                'pricing.starter.f3': '24/7 chat support',
                'pricing.starter.f5': 'Reseller pricing',
                'pricing.popular': '⭐ Most Popular',
                'pricing.pro.sub': 'Reseller pricing unlocked from $20',
                'pricing.pro.f1': 'All Starter services',
                'pricing.pro.f2': '20–40% discount',
                'pricing.pro.f3': 'Full API access',
                'pricing.pro.f4': 'Priority support',
                'pricing.ent.sub': 'For large agencies',
                'pricing.ent.f1': 'Best market pricing',
                'pricing.ent.f3': 'Dedicated account manager',
                'pricing.topup': 'Deposit Now',
                'pricing.topup_pro': 'Deposit Now ↗',
                'pricing.contact': 'Contact Us',
                'faq.title1': 'Frequently',
                'faq.title2': 'Asked Questions',
                'faq.q1': 'What is an SMM Panel and how does it work?',
                'faq.a1': 'An SMM Panel is a platform that provides automated social media engagement services. You place an order, provide a link, and the system processes and delivers the service without manual intervention.',
                'faq.q2': 'Is the service safe for my account?',
                'faq.a2': 'We use natural delivery methods and never require your password. Premium packages use real accounts, minimizing the risk of platform policy violations.',
                'faq.q3': 'Can I integrate the API into my system?',
                'faq.a3': 'Yes! Full RESTful API with detailed documentation. Supports order placement, status checking, service listing and balance management — compatible with any programming language.',
                'faq.q4': 'What payment methods are supported?',
                'faq.a4': 'Supported: MoMo, ZaloPay, ViettelPay, bank transfer, Visa/Mastercard, USDT/Crypto. Deposits are automatically confirmed within 1–5 minutes.',
                'faq.q5': 'If my order is not completed, will I get a refund?',
                'faq.a5': 'Yes. Incomplete or failed orders are automatically refunded to your account balance within 24 hours. Contact support if you need faster processing.',
                'cta.title1': 'Ready to accelerate your',
                'cta.title2': 'social media?',
                'cta.sub': 'Sign up free in 30 seconds. No credit card required.',
                'cta.btn1': 'Create Free Account →',
                'cta.btn2': 'Sign In',
                'footer.desc': 'The leading SMM Panel platform. Fast delivery, great prices, 24/7 support.',
                'footer.services': 'Services',
                'footer.support': 'Support',
                'footer.contact_title': 'Contact',
                'footer.api': 'API Documentation',
                'footer.guide': 'Order Guide',
                'footer.refund': 'Refund Policy',
                'footer.contact': 'Contact Us',
                'footer.support_time': '⏰ Support: 24/7',
                'footer.terms': 'Terms',
                'footer.privacy': 'Privacy',
            }
        };

        var currentLang = localStorage.getItem('landing_lang') || 'vi';

        var LANG_META = {
            vi: {
                flag: 'https://cdn.whoispanel.com/admin/media/flags/vietnam.svg',
                name: 'Tiếng Việt'
            },
            en: {
                flag: 'https://cdn.whoispanel.com/admin/media/flags/united-states.svg',
                name: 'English'
            }
        };

        function setLang(lang) {
            currentLang = lang;
            localStorage.setItem('landing_lang', lang);

            var root = document.getElementById('html-root');
            if (root) root.lang = lang;

            // Cập nhật trigger display
            var meta = LANG_META[lang];
            var flagEl = document.getElementById('ls-flag');
            var codeEl = document.getElementById('ls-code');
            if (flagEl) flagEl.src = meta.flag;
            if (codeEl) codeEl.textContent = lang.toUpperCase();

            // Active state desktop options
            document.querySelectorAll('#ls-dropdown .ls-opt').forEach(function(opt) {
                opt.classList.toggle('active', opt.getAttribute('data-lang') === lang);
            });

            // Active state mobile
            ['vi', 'en'].forEach(function(l) {
                var el = document.getElementById('opt-' + l + '-m');
                if (!el) return;
                el.classList.toggle('active', l === lang);
                el.style.borderColor = '';
                el.style.color = '';
            });

            // Close mobile menu
            var mob = document.getElementById('mobile-menu');
            if (mob && mob.classList.contains('open')) mob.classList.remove('open');

            // Translate
            document.querySelectorAll('[data-i18n]').forEach(function(el) {
                var key = el.getAttribute('data-i18n');
                var val = LANG[lang] && LANG[lang][key];
                if (!val) return;
                if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = val;
                else el.textContent = val;
            });
        }

        function lsSelect(lang) {
            var wrap = document.getElementById('ls-wrap');
            if (wrap) wrap.removeAttribute('open');
            setLang(lang);
        }

        function toggleTheme() {
            var current = document.documentElement.getAttribute('data-bs-theme') || 'light';
            var next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-bs-theme', next);
            localStorage.setItem('data-bs-theme', next);
            updateThemeIcon(next);
        }

        function updateThemeIcon(theme) {
            var sun  = document.getElementById('icon-sun');
            var moon = document.getElementById('icon-moon');
            if (!sun || !moon) return;
            if (theme === 'dark') {
                sun.style.display  = 'block';
                moon.style.display = 'none';
            } else {
                sun.style.display  = 'none';
                moon.style.display = 'block';
            }
        }

        // Wire up lang dropdown
        document.addEventListener('DOMContentLoaded', function() {

            // Đóng khi click ngoài
            document.addEventListener('click', function(e) {
                var wrap = document.getElementById('ls-wrap');
                if (wrap && !wrap.contains(e.target)) wrap.removeAttribute('open');
            });

            // Apply theme
            var savedTheme = localStorage.getItem('data-bs-theme') || 'light';
            document.documentElement.setAttribute('data-bs-theme', savedTheme);
            updateThemeIcon(savedTheme);

            setLang(currentLang);
            document.body.classList.add('ready');
        });
    </script>
</body>

</html>
