<!DOCTYPE html>
<html lang="vi" id="html-root">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $config->title ?? 'NexaSMM' }} — Social Media Marketing Panel</title>
    <meta name="description" content="{{ $config->description ?? 'Quản lý đơn hàng và dịch vụ mạng xã hội từ một bảng điều khiển.' }}">
    <meta name="keywords" content="{{ $config->keywords ?? 'smm panel, social media marketing' }}">
    @if (!empty($config->favicon))
        <link rel="icon" href="{{ asset('assets/media/' . $config->favicon) }}">
    @endif
    <meta property="og:title" content="{{ $config->title ?? 'NexaSMM' }}">
    <meta property="og:description" content="{{ $config->description ?? 'Quản lý đơn hàng và dịch vụ mạng xã hội từ một bảng điều khiển.' }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url('/') }}">
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --c-cyan: #00f5ff;
            --c-violet: #7c3aed;
            --font-main: 'Manrope', sans-serif;

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

        .mobile-menu-close {
            position: absolute;
            top: 24px;
            right: 24px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 1px solid var(--c-border);
            border-radius: 8px;
            background: var(--c-bg);
            color: var(--c-text-heading);
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

        .platform-card {
            min-width: 0;
            min-height: 154px;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 20px;
            color: inherit;
            text-decoration: none;
        }

        .platform-card-top {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .platform-icon-wrap {
            width: 52px;
            height: 52px;
            flex: 0 0 52px;
            display: grid;
            place-items: center;
            overflow: hidden;
            border: 1px solid var(--c-border);
            border-radius: 12px;
            background: #fff;
        }

        .platform-icon {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .platform-card .platform-name {
            font-size: 15px;
            line-height: 1.35;
            font-weight: 700;
        }

        .platform-card .platform-sub {
            font-size: 12px;
            line-height: 1.5;
        }

        .platform-card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-top: 12px;
            border-top: 1px solid var(--c-border);
            color: var(--c-text-muted);
            font-size: 11px;
            font-weight: 600;
        }

        .platform-card-arrow {
            color: var(--c-cyan);
            font-size: 16px;
            line-height: 1;
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

        :root {
            --c-cyan: #2f7d68;
            --c-violet: #2f7d68;
            --c-bg: #ffffff;
            --c-dark: #ffffff;
            --c-card: #f8fafc;
            --c-border: #e2e8f0;
            --c-text: #334155;
            --c-text-muted: #64748b;
            --c-text-body: #334155;
            --c-text-label: #475569;
            --c-text-heading: #111827;
            --c-nav-bg: rgba(255, 255, 255, 0.96);
            --c-nav-border: #e2e8f0;
            --c-nav-link: #475569;
            --c-nav-link-hover: #111827;
            --c-btn-outline-border: #cbd5e1;
            --c-btn-outline-bg: #ffffff;
            --c-btn-outline-color: #334155;
            --c-lang-border: #e2e8f0;
            --c-lang-bg: #f8fafc;
            --c-lang-bg-hover: #f1f5f9;
            --c-lang-color: #334155;
            --c-scrollbar-track: #f1f5f9;
            --c-scrollbar-thumb: #94a3b8;
        }

        [data-bs-theme="light"] {
            --c-bg: #ffffff;
            --c-dark: #ffffff;
            --c-card: #f8fafc;
            --c-border: #e2e8f0;
            --c-text: #334155;
            --c-text-muted: #64748b;
            --c-text-body: #334155;
            --c-text-label: #475569;
            --c-text-heading: #111827;
            --c-nav-bg: rgba(255, 255, 255, 0.96);
            --c-nav-border: #e2e8f0;
            --c-nav-link: #475569;
            --c-nav-link-hover: #111827;
            --c-btn-outline-border: #cbd5e1;
            --c-btn-outline-bg: #ffffff;
            --c-btn-outline-color: #334155;
            --c-lang-border: #e2e8f0;
            --c-lang-bg: #f8fafc;
            --c-lang-bg-hover: #f1f5f9;
            --c-lang-color: #334155;
            --c-scrollbar-track: #f1f5f9;
            --c-scrollbar-thumb: #94a3b8;
        }

        [data-bs-theme="dark"] {
            --c-bg: #000000;
            --c-dark: #000000;
            --c-card: #181818;
            --c-border: #313131;
            --c-text: #e5e5e5;
            --c-text-muted: #a3a3a3;
            --c-text-body: #d4d4d4;
            --c-text-label: #a3a3a3;
            --c-text-heading: #f5f5f5;
            --c-nav-bg: rgba(24, 24, 24, 0.96);
            --c-nav-border: #313131;
            --c-nav-link: #d4d4d4;
            --c-nav-link-hover: #ffffff;
            --c-btn-outline-border: #525252;
            --c-btn-outline-bg: #181818;
            --c-btn-outline-color: #e5e5e5;
            --c-lang-border: #313131;
            --c-lang-bg: #181818;
            --c-lang-bg-hover: #272727;
            --c-lang-color: #e5e5e5;
            --c-scrollbar-track: #181818;
            --c-scrollbar-thumb: #525252;
        }

        html {
            scroll-padding-top: 6rem;
        }

        * {
            letter-spacing: 0 !important;
        }

        .skip-link {
            position: fixed;
            z-index: 200;
            top: 8px;
            left: 8px;
            padding: 8px 12px;
            transform: translateY(-150%);
            border-radius: 8px;
            background: var(--c-text-heading);
            color: var(--c-bg);
        }

        .skip-link:focus {
            transform: translateY(0);
        }

        body {
            letter-spacing: 0;
            background: var(--c-bg);
        }

        .font-black,
        .font-extrabold {
            font-weight: 700 !important;
        }

        .text-cyan-400,
        .text-violet-400,
        .text-pink-400,
        .text-green-400,
        .text-teal-400,
        .text-yellow-400 {
            color: #2f7d68 !important;
        }

        .mobile-lang-btn.active,
        [data-bs-theme="light"] .mobile-lang-btn.active,
        [data-bs-theme="dark"] .mobile-lang-btn.active {
            color: #2f7d68 !important;
            border-color: rgba(47, 125, 104, 0.4) !important;
            background: rgba(47, 125, 104, 0.08) !important;
        }

        body.ready {
            opacity: 1;
        }

        #canvas-bg {
            display: none;
        }

        nav.above {
            position: fixed;
            z-index: 100;
            top: 16px;
            left: 16px;
            right: 16px;
            width: min(1400px, calc(100% - 32px));
            margin-inline: auto;
            border: 1px solid var(--c-nav-border);
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        nav.above > div:first-child {
            padding-block: 12px;
        }

        .nav-link::after {
            background: #2f7d68 !important;
        }

        .btn-primary,
        .btn-outline,
        .btn-ghost,
        .glass-card,
        .faq-item,
        .ls-opt {
            transition: color 250ms cubic-bezier(0.32, 0.72, 0, 1),
                background-color 250ms cubic-bezier(0.32, 0.72, 0, 1),
                border-color 250ms cubic-bezier(0.32, 0.72, 0, 1),
                box-shadow 250ms cubic-bezier(0.32, 0.72, 0, 1),
                transform 250ms cubic-bezier(0.32, 0.72, 0, 1);
        }

        .btn-primary {
            background: #2f7d68;
            border-color: #2f7d68;
            border-radius: 8px;
            box-shadow: none;
            font-size: 16px;
            font-weight: 600;
            padding: 8px 12px;
        }

        .btn-primary:hover {
            background: #246653;
            border-color: #246653;
            box-shadow: 0 8px 20px rgba(47, 125, 104, 0.18);
            transform: translateY(-1px);
        }

        .btn-outline {
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            padding: 8px 12px;
        }

        .btn-outline:hover,
        .btn-ghost:hover {
            transform: translateY(-1px);
        }

        .hero-section {
            padding: 144px 24px 64px;
        }

        .fade-in {
            opacity: 0;
            filter: blur(4px);
            transform: translateY(32px);
            transition: opacity 800ms cubic-bezier(0.32, 0.72, 0, 1),
                filter 800ms cubic-bezier(0.32, 0.72, 0, 1),
                transform 800ms cubic-bezier(0.32, 0.72, 0, 1);
        }

        .fade-in.visible {
            opacity: 1;
            filter: blur(0);
            transform: translateY(0);
        }

        .ticker {
            animation: none;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px 24px;
            white-space: normal;
        }

        #mobile-menu {
            position: fixed;
            z-index: 150;
            inset: 0;
            display: none;
            overflow-y: auto;
            padding-top: 80px;
            background: var(--c-nav-bg);
            backdrop-filter: blur(24px);
        }

        #mobile-menu.open {
            display: block;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: minmax(0, 0.9fr) minmax(480px, 1.1fr);
            align-items: center;
            gap: 64px;
            width: min(1200px, 100%);
            min-width: 0;
            margin-inline: auto;
        }

        .hero-copy {
            min-width: 0;
            text-align: left;
        }

        .hero-copy h1 {
            max-width: 680px;
            font-size: 48px;
            line-height: 1;
            font-weight: 700;
            letter-spacing: 0;
            text-wrap: balance;
        }

        .hero-copy .hero-description {
            max-width: 560px;
            text-wrap: pretty;
        }

        .hero-copy .hero-actions {
            justify-content: flex-start;
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
            color: #2f7d68;
            font-size: 14px;
            font-weight: 600;
        }

        .hero-kicker::before {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: currentColor;
            content: "";
        }

        .hero-heading-ink {
            display: block;
            color: var(--c-text-heading);
        }

        .hero-heading-accent {
            display: block;
            background-image: linear-gradient(90deg, #000000, #666666);
            background-clip: text;
            color: transparent;
            -webkit-text-fill-color: transparent;
        }

        [data-bs-theme="dark"] .hero-heading-accent {
            background-image: linear-gradient(90deg, #ffffff, #9b9b9b);
        }

        .hero-proof {
            display: flex;
            gap: 32px;
            margin-top: 40px;
        }

        .hero-proof-item {
            border-left: 2px solid #2f7d68;
            padding-left: 12px;
        }

        .hero-proof-value {
            color: var(--c-text-heading);
            font-size: 24px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        .hero-proof-label {
            color: var(--c-text-muted);
            font-size: 12px;
        }

        .product-preview {
            overflow: hidden;
            border: 1px solid var(--c-border);
            border-radius: 16px;
            background: var(--c-card);
            box-shadow: 0 24px 64px rgba(15, 23, 42, 0.12);
            min-width: 0;
            width: 100%;
        }

        .preview-topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 24px;
            border-bottom: 1px solid var(--c-border);
        }

        .preview-brand {
            color: var(--c-text-heading);
            font-size: 14px;
            font-weight: 700;
        }

        .preview-status {
            color: #2f7d68;
            font-size: 12px;
            font-weight: 600;
        }

        .preview-content {
            padding: 24px;
        }

        .preview-heading {
            margin-bottom: 16px;
            color: var(--c-text-heading);
            font-size: 20px;
            font-weight: 700;
        }

        .preview-columns {
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 16px;
        }

        .preview-order {
            display: grid;
            gap: 12px;
            padding: 16px;
            border: 1px solid var(--c-border);
            border-radius: 8px;
            background: var(--c-bg);
        }

        .preview-order-row {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 12px;
            color: var(--c-text-body);
            font-size: 12px;
        }

        .preview-order-row span,
        .preview-order-row strong {
            min-width: 0;
        }

        .preview-order-row strong {
            color: var(--c-text-heading);
            font-weight: 600;
            overflow-wrap: anywhere;
            text-align: right;
        }

        .preview-state {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #2f7d68;
            font-size: 12px;
            font-weight: 600;
        }

        .preview-side {
            display: grid;
            align-content: start;
            gap: 16px;
        }

        .preview-metric {
            padding: 16px;
            border-radius: 8px;
            background: var(--c-bg);
        }

        .preview-metric-label {
            color: var(--c-text-muted);
            font-size: 12px;
        }

        .preview-metric-value {
            margin-top: 4px;
            color: var(--c-text-heading);
            font-size: 24px;
            font-weight: 700;
        }

        .preview-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            align-self: center;
            gap: 7px;
            min-height: 42px;
            padding: 10px 14px;
            border-radius: 8px;
            background: #2f7d68;
            border: 1px solid #2f7d68;
            box-shadow: 0 6px 14px rgba(47, 125, 104, 0.18);
            color: white;
            font-size: 11px;
            font-weight: 600;
            text-align: center;
        }

        .preview-action::before {
            display: grid;
            width: 16px;
            height: 16px;
            place-items: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            content: "+";
            font-size: 13px;
            font-weight: 700;
            line-height: 1;
        }

        .section-heading {
            max-width: 680px;
            margin-inline: auto;
            text-wrap: balance;
        }

        .glass-card {
            border: 1px solid var(--c-border);
            border-radius: 8px;
            background: var(--c-card);
            backdrop-filter: none;
        }

        .glass-card:hover {
            border-color: #2f7d68;
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
        }

        #service-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        #services .space-y-2 {
            display: none;
        }

        #services .w-14.h-14 {
            border-radius: 8px;
            background: #e8f2ef !important;
        }

        #services svg,
        #services svg * {
            stroke: #2f7d68;
        }

        #services .glass-card > .mt-5 {
            color: #2f7d68 !important;
        }

        .final-cta .glass-card {
            border: 0;
            background: transparent;
        }

        .final-cta .pulse-ring {
            border-color: #2f7d68 !important;
            background: #e8f2ef !important;
        }

        .final-cta .pulse-ring svg path {
            fill: #2f7d68;
        }

        .final-cta .pulse-ring svg defs {
            display: none;
        }

        .grad-text,
        .glow-text {
            color: #2f7d68;
            background: none;
            -webkit-text-fill-color: currentColor;
            text-shadow: none;
        }

        .tagline-section {
            padding: 80px 24px;
            background: var(--c-card);
        }

        .tagline-line {
            display: block;
            color: var(--c-text-heading);
            font-size: 48px;
            font-weight: 600;
            line-height: 1;
            text-wrap: balance;
        }

        .tagline-word {
            display: inline-block;
            margin-right: 8px;
            opacity: 0.3;
            transform: translateY(8px);
            transition: opacity 800ms cubic-bezier(0.32, 0.72, 0, 1),
                transform 800ms cubic-bezier(0.32, 0.72, 0, 1);
        }

        .tagline-word.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .steps-section {
            padding: 80px 24px;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 32px;
            max-width: 1200px;
            margin: 48px auto 0;
        }

        .step-item {
            padding-top: 16px;
            border-top: 1px solid var(--c-border);
        }

        .step-number {
            color: #2f7d68;
            font-size: 14px;
            font-weight: 700;
            font-variant-numeric: tabular-nums;
        }

        .step-item h3 {
            margin: 16px 0 8px;
            color: var(--c-text-heading);
            font-size: 20px;
            font-weight: 700;
        }

        .step-item p {
            max-width: 360px;
            color: var(--c-text-muted);
            font-size: 14px;
            line-height: 1.5;
            text-wrap: pretty;
        }

        .faq-item {
            border-radius: 8px;
        }

        a:focus-visible,
        button:focus-visible,
        summary:focus-visible {
            outline: 3px solid #2f7d68;
            outline-offset: 3px;
        }

        @media (max-width: 1023px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 40px;
                max-width: 760px;
            }

            .hero-copy h1 {
                font-size: 48px;
            }
        }

        @media (max-width: 767px) {
            #menu-btn {
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
            }
        }

        @media (max-width: 639px) {
            nav.above {
                top: 8px;
                left: 8px;
                right: 8px;
                width: calc(100% - 16px);
            }

            .hero-section {
                padding: 96px 16px 24px;
            }

            .hero-grid {
                gap: 24px;
            }

            .hero-kicker {
                margin-bottom: 16px;
            }

            .hero-copy h1 {
                font-size: 30px;
                line-height: 1.1;
            }

            .hero-description {
                margin-top: 16px !important;
                margin-bottom: 24px !important;
            }

            .hero-proof {
                margin-top: 24px;
            }

            .hero-proof {
                gap: 16px;
            }

            .hero-proof-value {
                font-size: 20px;
            }

            .preview-content {
                padding: 8px;
            }

            .preview-topbar {
                padding: 8px 12px;
            }

            .preview-heading {
                margin-bottom: 8px;
                font-size: 16px;
            }

            .preview-order {
                gap: 8px;
                padding: 8px;
            }

            .preview-order-row:nth-child(2),
            .preview-order-row:nth-child(3) {
                display: none;
            }

            .preview-metric {
                padding: 8px;
            }

            .preview-columns {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .preview-side {
                grid-template-columns: 1fr 1fr;
            }

            .preview-action {
                min-height: 38px;
                padding: 8px 10px;
                font-size: 10px;
            }

            .preview-action::before {
                width: 14px;
                height: 14px;
                font-size: 12px;
            }

            .steps-grid {
                grid-template-columns: 1fr;
                gap: 24px;
                margin-top: 32px;
            }

            #service-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .tagline-section {
                padding: 64px 16px;
            }

            .tagline-line {
                font-size: 36px;
                line-height: 1.1;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        :root {
            --c-cyan: #28775f;
            --c-violet: #d38355;
            --c-bg: #f6f8f6;
            --c-card: #ffffff;
            --c-border: #e0e8e2;
            --c-text: #23332b;
            --c-text-body: #43554b;
            --c-text-muted: #6b7b71;
            --c-text-label: #58685e;
            --c-text-heading: #1d3026;
            --c-nav-bg: rgba(250, 252, 250, 0.94);
            --c-nav-border: #e0e8e2;
            --c-nav-link: #43554b;
            --c-nav-link-hover: #1d3026;
        }

        [data-bs-theme="dark"] {
            --c-cyan: #9bdfb2;
            --c-violet: #efb184;
            --c-bg: #0b1510;
            --c-card: #122019;
            --c-border: #294438;
            --c-text: #e8f2eb;
            --c-text-body: #c2d3c8;
            --c-text-muted: #92aa9b;
            --c-text-label: #aac0b1;
            --c-text-heading: #f3f8f4;
            --c-nav-bg: rgba(11, 21, 16, 0.94);
            --c-nav-border: #294438;
            --c-nav-link: #c2d3c8;
            --c-nav-link-hover: #ffffff;
        }

        body {
            letter-spacing: 0;
        }

        #canvas-bg {
            opacity: 0.16;
        }

        nav.above {
            box-shadow: 0 4px 22px rgba(28, 54, 40, 0.06);
        }

        .hero-section {
            padding-top: 152px;
            padding-bottom: 88px;
            background: #edf4ef;
        }

        [data-bs-theme="dark"] .hero-section {
            background: #0e1d15;
        }

        .hero-copy h1 {
            font-size: 56px;
            line-height: 1.06;
            font-weight: 800;
        }

        .hero-heading-accent {
            background-image: linear-gradient(90deg, #28775f, #567c57);
        }

        [data-bs-theme="dark"] .hero-heading-accent {
            background-image: linear-gradient(90deg, #8bd2a9, #c4df9c);
        }

        .hero-kicker {
            color: #28775f;
        }

        [data-bs-theme="dark"] .hero-kicker {
            color: #8bd2a9;
        }

        .hero-proof-item {
            border-color: #d38355;
        }

        .product-preview {
            border-radius: 8px;
            background: var(--c-card);
            box-shadow: 0 24px 64px rgba(28, 54, 40, 0.1);
        }

        [data-bs-theme="dark"] .product-preview {
            box-shadow: 0 24px 64px rgba(0, 0, 0, 0.3);
        }

        [data-bs-theme="dark"] .preview-action {
            background: #4e9367;
            border-color: #4e9367;
            box-shadow: 0 6px 14px rgba(0, 0, 0, 0.24);
        }

        .preview-order,
        .preview-metric {
            border-radius: 8px;
        }

        .preview-action {
            border-radius: 6px;
        }

        .ticker-wrap {
            padding-block: 4px;
        }

        .ticker {
            gap: 16px 32px;
        }

        #platforms,
        #services,
        #how-it-works,
        #stats,
        #pricing,
        #faq,
        .final-cta {
            padding-block: 88px;
        }

        #platforms {
            background: var(--c-bg);
        }

        #platforms > .max-w-6xl,
        #services > .max-w-6xl {
            max-width: 1360px;
        }

        #platforms .text-center,
        #services .text-center {
            margin-bottom: 48px;
        }

        .section-intro {
            max-width: 630px;
            margin: 16px auto 0;
            color: var(--c-text-muted);
            font-size: 15px;
            line-height: 1.7;
            text-wrap: pretty;
        }

        .section-intro.align-left {
            margin-left: 0;
            margin-right: 0;
        }

        .section-heading,
        #faq h2 {
            font-size: 40px;
            line-height: 1.15;
            font-weight: 800;
        }

        .grad-text {
            color: #28775f;
        }

        [data-bs-theme="dark"] .grad-text {
            color: #8bd2a9;
        }

        .platform-card {
            min-height: 274px;
            padding: 16px;
            border-radius: 8px;
            background: var(--c-card);
        }

        .platform-icon-wrap {
            width: 48px;
            height: 48px;
            flex-basis: 48px;
            border-radius: 8px;
            background: var(--c-card);
        }

        [data-bs-theme="dark"] .platform-icon-wrap {
            background: #f7fbf8;
            border-color: rgba(255, 255, 255, 0.18);
        }

        .platform-card-footer {
            padding-top: 10px;
        }

        .platform-summary {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 10px 14px;
            margin: 26px auto 0;
            color: var(--c-text-muted);
            font-size: 13px;
        }

        .platform-summary-item {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            min-height: 30px;
            padding: 5px 10px;
            border: 1px solid var(--c-border);
            border-radius: 999px;
            background: var(--c-card);
        }

        .platform-summary-item::before {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #28775f;
            content: "";
        }

        .platform-summary a {
            color: #28775f;
            font-weight: 700;
            text-decoration: none;
        }

        .platform-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: auto;
            padding-top: 14px;
        }

        .platform-intro {
            margin-top: 14px;
            color: var(--c-text-body);
            font-size: 12px;
            line-height: 1.6;
        }

        .platform-tag {
            min-width: 0;
            padding: 4px 7px;
            border: 1px solid var(--c-border);
            border-radius: 5px;
            color: var(--c-text-muted);
            font-size: 10px;
            font-weight: 650;
            line-height: 1.25;
        }

        [data-bs-theme="dark"] .platform-summary a {
            color: #9bdfb2;
        }

        #services .glass-card {
            display: flex;
            min-height: 270px;
            flex-direction: column;
            padding: 28px;
            border-radius: 8px;
            background: var(--c-card);
        }

        #services .w-14.h-14 {
            width: 48px;
            height: 48px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        #services h3 {
            font-size: 19px;
            line-height: 1.35;
        }

        .service-card-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: auto;
            padding-top: 16px;
            border-top: 1px solid var(--c-border);
            color: var(--c-text-muted);
            font-size: 11px;
        }

        .service-card-meta span {
            min-width: 0;
        }

        .service-card-meta strong {
            color: var(--c-text-heading);
            font-size: 11px;
            font-weight: 700;
            text-align: right;
        }

        #services .glass-card > .mt-5 {
            margin-top: 14px !important;
            padding-top: 0;
            border-top: 0;
        }

        [data-bs-theme="dark"] #services .w-14.h-14 {
            background: #1c3426 !important;
        }

        [data-bs-theme="dark"] #services svg,
        [data-bs-theme="dark"] #services svg * {
            stroke: #9bdfb2;
        }

        [data-bs-theme="dark"] .text-cyan-400,
        [data-bs-theme="dark"] .text-violet-400,
        [data-bs-theme="dark"] .text-pink-400,
        [data-bs-theme="dark"] .text-green-400,
        [data-bs-theme="dark"] .text-teal-400,
        [data-bs-theme="dark"] .text-yellow-400,
        [data-bs-theme="dark"] .text-red-400 {
            color: #9bdfb2 !important;
        }

        #how-it-works {
            background: #ffffff;
        }

        [data-bs-theme="dark"] #how-it-works {
            background: #07110d;
        }

        #how-it-works > div,
        #stats > div {
            max-width: 1120px;
        }

        .steps-grid {
            gap: 24px;
            margin-top: 40px;
        }

        .step-item {
            padding: 20px 18px 0 0;
        }

        .step-number {
            display: inline-flex;
            min-width: 38px;
            min-height: 30px;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            background: #edf4ef;
            color: #28775f;
        }

        [data-bs-theme="dark"] .step-number {
            background: #14291e;
            color: #8bd2a9;
        }

        #stats {
            background: #1e3d30;
            --c-text-heading: #ffffff;
            --c-text-body: #e4eee7;
            --c-text-muted: #bfd0c4;
            --c-border: rgba(255, 255, 255, 0.2);
        }

        .stats-intro {
            margin-bottom: 32px;
        }

        .stats-kicker {
            color: #b9dfc4;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0;
            text-transform: uppercase;
        }

        .stats-description {
            max-width: 580px;
            margin-top: 10px;
            color: #d6e5da;
            font-size: 15px;
            line-height: 1.65;
        }

        #stats .grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 40px;
        }

        #stats .step-item {
            padding: 0 0 0 20px;
            border-top: 0;
            border-left: 2px solid #e7a274;
        }

        #stats .step-item > div:first-child {
            font-size: 40px;
        }

        .tagline-section {
            padding: 72px 24px;
            background: #f0f4ef;
        }

        [data-bs-theme="dark"] .tagline-section {
            background: #0b1911;
        }

        .tagline-line {
            font-size: 42px;
            line-height: 1.16;
        }

        #pricing {
            background: #fff5ed;
        }

        [data-bs-theme="dark"] #pricing {
            background: #1b1713;
        }

        #pricing > div {
            max-width: 1120px;
            gap: 48px;
        }

        #pricing h2 {
            max-width: 520px;
            font-size: 40px;
            line-height: 1.15;
        }

        #pricing p {
            max-width: 520px;
            font-size: 16px;
            line-height: 1.7;
        }

        .pricing-points {
            display: grid;
            gap: 12px;
            margin: 0 0 24px;
            padding: 0;
            list-style: none;
        }

        .pricing-points li,
        .hero-points li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: var(--c-text-body);
            font-size: 14px;
            line-height: 1.5;
        }

        .pricing-points li::before,
        .hero-points li::before {
            display: grid;
            width: 20px;
            height: 20px;
            flex: 0 0 20px;
            place-items: center;
            border-radius: 50%;
            background: #dceee2;
            color: #28775f;
            content: "✓";
            font-size: 12px;
            font-weight: 800;
        }

        [data-bs-theme="dark"] .pricing-points li::before,
        [data-bs-theme="dark"] .hero-points li::before {
            background: #244531;
            color: #b5edc7;
        }

        #pricing .btn-primary {
            min-height: 46px;
        }

        #faq {
            background: var(--c-bg);
        }

        #faq .max-w-3xl {
            max-width: 760px;
        }

        #faq .faq-item {
            background: var(--c-card);
        }

        #faq .faq-q {
            min-height: 64px;
            gap: 20px;
        }

        #faq .faq-ans {
            max-width: 680px;
            padding-bottom: 20px;
        }

        .faq-intro {
            max-width: 580px;
            margin: 16px auto 0;
            color: var(--c-text-muted);
            font-size: 15px;
            line-height: 1.7;
        }

        .final-cta {
            background: #1e3d30;
            --c-text-heading: #ffffff;
            --c-text-body: #e4eee7;
            --c-text-muted: #bfd0c4;
        }

        .final-cta .glass-card {
            padding: 24px;
        }

        .final-cta .grad-text {
            color: #a7d7b5;
        }

        .final-cta .btn-primary {
            background: #ffffff;
            border-color: #ffffff;
            color: #1e3d30;
        }

        .final-cta .btn-primary:hover {
            background: #e8f2eb;
            border-color: #e8f2eb;
        }

        .final-cta .btn-outline {
            border-color: rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.06);
            color: #ffffff;
        }

        .final-cta .pulse-ring {
            box-shadow: none;
        }

        [data-bs-theme="dark"] .final-cta .pulse-ring {
            background: #244531 !important;
            border-color: #4c8b63 !important;
        }

        [data-bs-theme="dark"] .final-cta .pulse-ring svg path {
            fill: #b5edc7;
        }

        footer {
            background: #f6f8f6;
        }

        .hero-points {
            display: grid;
            gap: 10px;
            margin: 0 0 28px;
            padding: 0;
            list-style: none;
        }

        .hero-points li {
            color: var(--c-text-body);
        }

        .capability-section,
        .audience-section {
            padding: 88px 24px;
        }

        .capability-section {
            background: #ffffff;
        }

        [data-bs-theme="dark"] .capability-section {
            background: #0d1912;
        }

        .capability-layout {
            display: grid;
            grid-template-columns: minmax(0, 0.82fr) minmax(0, 1.18fr);
            align-items: start;
            gap: 56px;
            max-width: 1120px;
            margin-inline: auto;
        }

        .capability-copy {
            position: sticky;
            top: 112px;
        }

        .capability-copy .section-heading {
            margin-left: 0;
            margin-right: 0;
        }

        .capability-copy .btn-outline {
            margin-top: 28px;
            min-height: 44px;
        }

        .capability-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .capability-card {
            min-width: 0;
            min-height: 218px;
            padding: 24px;
            border: 1px solid var(--c-border);
            border-radius: 8px;
            background: var(--c-card);
        }

        .capability-card:nth-child(2),
        .capability-card:nth-child(3) {
            transform: translateY(28px);
        }

        .capability-card:nth-child(4) {
            transform: translateY(56px);
        }

        .capability-card:hover {
            border-color: #28775f;
            box-shadow: 0 14px 32px rgba(28, 54, 40, 0.08);
        }

        .capability-icon {
            display: grid;
            width: 44px;
            height: 44px;
            place-items: center;
            margin-bottom: 24px;
            border-radius: 8px;
            background: #e7f1e9;
            color: #28775f;
        }

        .capability-icon svg {
            width: 21px;
            height: 21px;
            stroke: currentColor;
        }

        .capability-card h3 {
            color: var(--c-text-heading);
            font-size: 17px;
            font-weight: 750;
            line-height: 1.35;
        }

        .capability-card p {
            margin-top: 8px;
            color: var(--c-text-muted);
            font-size: 13px;
            line-height: 1.65;
        }

        [data-bs-theme="dark"] .capability-icon {
            background: #203d2a;
            color: #aeeac1;
        }

        [data-bs-theme="dark"] .capability-card:hover {
            border-color: #76bf91;
            box-shadow: 0 14px 32px rgba(0, 0, 0, 0.2);
        }

        .audience-section {
            background: #eef4ef;
        }

        [data-bs-theme="dark"] .audience-section {
            background: #101e16;
        }

        .audience-header {
            max-width: 660px;
            margin-bottom: 40px;
        }

        .audience-header .section-heading {
            margin-left: 0;
            margin-right: 0;
        }

        .audience-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .audience-card {
            min-width: 0;
            padding: 26px;
            border-top: 2px solid #d38355;
            background: var(--c-card);
        }

        .audience-card:nth-child(2) {
            border-color: #28775f;
        }

        .audience-card:nth-child(3) {
            border-color: #6c8db5;
        }

        .audience-card-label {
            color: var(--c-text-muted);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0;
            text-transform: uppercase;
        }

        .audience-card h3 {
            margin-top: 12px;
            color: var(--c-text-heading);
            font-size: 22px;
            font-weight: 750;
            line-height: 1.25;
        }

        .audience-card p {
            margin-top: 12px;
            color: var(--c-text-body);
            font-size: 14px;
            line-height: 1.7;
        }

        [data-bs-theme="dark"] footer {
            background: #07110d;
        }

        @media (max-width: 1023px) {
            .hero-section {
                padding-top: 128px;
                padding-bottom: 64px;
            }

            .hero-copy h1 {
                font-size: 48px;
            }

            .capability-layout {
                grid-template-columns: 1fr;
                gap: 32px;
            }

            .capability-copy {
                position: static;
            }

            .capability-grid {
                max-width: 720px;
            }

            .capability-card:nth-child(2),
            .capability-card:nth-child(3),
            .capability-card:nth-child(4) {
                transform: none;
            }

            .audience-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .audience-card:last-child {
                grid-column: span 2;
            }

            #service-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 639px) {
            .hero-section {
                padding: 96px 16px 48px;
            }

            .hero-copy h1 {
                font-size: 34px;
                line-height: 1.12;
            }

            #platforms,
            #services,
            #how-it-works,
            #stats,
            #pricing,
            #faq,
            .final-cta,
            .capability-section,
            .audience-section {
                padding-block: 60px;
            }

            #platforms .text-center,
            #services .text-center {
                margin-bottom: 32px;
            }

            .section-heading,
            #faq h2,
            #pricing h2 {
                font-size: 30px;
            }

            .platform-card {
                min-height: 268px;
                padding: 12px;
                gap: 14px;
            }

            .platform-card-top {
                align-items: flex-start;
                gap: 10px;
            }

            .platform-icon-wrap {
                width: 40px;
                height: 40px;
                flex-basis: 40px;
            }

            .platform-card .platform-name {
                font-size: 14px;
            }

            .platform-card .platform-sub {
                font-size: 11px;
            }

            .platform-card-footer {
                font-size: 10px;
            }

            .platform-summary {
                gap: 8px;
                font-size: 12px;
            }

            .platform-summary-item {
                min-height: 28px;
                padding: 4px 8px;
            }

            #services .glass-card {
                min-height: 0;
                padding: 22px;
            }

            .service-card-meta {
                margin-top: 18px;
            }

            #stats .grid {
                gap: 24px;
            }

            #stats .step-item {
                padding-left: 12px;
            }

            #stats .step-item > div:first-child {
                font-size: 30px;
            }

            .tagline-section {
                padding: 52px 16px;
            }

            .tagline-line {
                font-size: 30px;
            }

            #pricing > div {
                gap: 24px;
            }

            .final-cta .glass-card {
                padding: 12px;
            }

            .section-intro,
            .faq-intro,
            .stats-description {
                font-size: 14px;
            }

            .capability-layout {
                gap: 28px;
            }

            .capability-grid,
            .audience-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .audience-card:last-child {
                grid-column: auto;
            }

            .capability-card {
                min-height: 0;
                padding: 20px;
            }

            .capability-icon {
                margin-bottom: 18px;
            }

            .audience-header {
                margin-bottom: 28px;
            }

            .audience-card {
                padding: 22px;
            }

            .audience-card h3 {
                font-size: 19px;
            }
        }
    </style>
</head>

<body>

    <a class="skip-link" href="#main-content">Bỏ qua đến nội dung</a>
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
                        style="background:#2f7d68;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" fill="white" />
                        </svg>
                    </div>
                @endif
                <span class="text-2xl font-bold"
                    style="letter-spacing:0; color: var(--c-text-heading);">{{ $config->title ?? 'NexaSMM' }}</span>
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
                    <span data-i18n="nav.login">Đăng nhập</span>
                </a>

                <a href="{{ route('signup') }}" class="btn-primary px-7 py-3 text-sm font-bold shadow-lg">
                    <span data-i18n="nav.start">Bắt đầu ngay</span>
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
            <button type="button" class="mobile-menu-close" aria-label="Close menu" onclick="toggleMenu()">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
                </svg>
            </button>
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
                        <span data-i18n="nav.start">Bắt đầu ngay</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <main id="main-content">
    <!-- HERO -->
    <section id="hero" class="above hero-section">
        <div class="hero-grid">
            <div class="hero-copy">
                <div class="hero-kicker fade-in" data-i18n="hero.badge">Quản lý dịch vụ mạng xã hội</div>
                <h1 class="fade-in text-heading">
                    <span class="hero-heading-ink" data-i18n="hero.title1">Vận hành tăng trưởng</span>
                    <span class="hero-heading-accent" data-i18n="hero.title2">từ một bảng điều khiển</span>
                </h1>
                <p class="hero-description text-lg text-body mt-6 mb-8 fade-in" data-i18n="hero.desc">
                    Tạo đơn, theo dõi tiến độ và quản lý số dư trên cùng một nền tảng. Bắt đầu với dịch vụ phù hợp, không cần tích hợp kỹ thuật.
                </p>
                <ul class="hero-points fade-in" aria-label="Lợi ích chính">
                    <li data-i18n="hero.point1">Xem điều kiện, giới hạn và giá trước khi tạo đơn.</li>
                    <li data-i18n="hero.point2">Chỉ cần liên kết công khai, không yêu cầu mật khẩu mạng xã hội.</li>
                    <li data-i18n="hero.point3">Theo dõi lịch sử và trạng thái đơn trong một màn hình.</li>
                </ul>
                <div class="hero-actions flex flex-col sm:flex-row gap-3 fade-in">
                    <a href="{{ route('signup') }}" class="btn-primary" data-i18n="hero.cta1">Tạo tài khoản miễn phí</a>
                </div>
                <a href="{{ route('login') }}" class="inline-block mt-4 text-sm text-muted" data-i18n="hero.cta2">Đã có tài khoản? Đăng nhập</a>
                <div class="hero-proof fade-in">
                    <div class="hero-proof-item">
                        <div class="hero-proof-value">{{ number_format($totalOrders ?? 0) }}</div>
                        <div class="hero-proof-label" data-i18n="hero.stat1">Đơn đã xử lý</div>
                    </div>
                    <div class="hero-proof-item">
                        <div class="hero-proof-value">{{ number_format($totalServices ?? 0) }}</div>
                        <div class="hero-proof-label" data-i18n="hero.stat2">Dịch vụ đang có</div>
                    </div>
                </div>
            </div>
            <aside class="product-preview fade-in" aria-label="Bản xem trước bảng điều khiển quản lý đơn hàng">
                <div class="preview-topbar">
                    <span class="preview-brand">{{ $config->title ?? 'Bảng điều khiển' }}</span>
                    <span class="preview-status" data-i18n="preview.status">● Hệ thống sẵn sàng</span>
                </div>
                <div class="preview-content">
                    <div class="preview-heading" data-i18n="preview.heading">Tổng quan đơn hàng</div>
                    <div class="preview-columns">
                        <div class="preview-order">
                            <div class="preview-order-row"><span data-i18n="preview.service">Dịch vụ</span><strong>Instagram · Followers</strong></div>
                            <div class="preview-order-row"><span data-i18n="preview.quantity">Số lượng</span><strong>1.000</strong></div>
                            <div class="preview-order-row"><span data-i18n="preview.order">Mã đơn</span><strong>#10482</strong></div>
                            <div class="preview-order-row"><span data-i18n="preview.progress">Tiến độ</span><span class="preview-state" data-i18n="preview.processing">● Đang xử lý</span></div>
                        </div>
                        <div class="preview-side">
                            <div class="preview-metric">
                                <div class="preview-metric-label" data-i18n="preview.active">Đơn đang chạy</div>
                                <div class="preview-metric-value">08</div>
                            </div>
                            <div class="preview-action" data-i18n="preview.action">Tạo đơn mới</div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </section>

    <!-- TICKER -->
    <div class="above py-4 border-y" style="border-color:var(--c-border);">
        <div class="ticker-wrap">
            <div class="ticker">
                <span class="text-sm font-medium" style="color:var(--c-text-body)" data-i18n="proof.item1">Theo dõi trạng thái đơn</span>
                <span class="text-sm text-muted">·</span>
                <span class="text-sm font-medium" style="color:var(--c-text-body)" data-i18n="proof.item2">Danh mục nhiều nền tảng</span>
                <span class="text-sm text-muted">·</span>
                <span class="text-sm font-medium" style="color:var(--c-text-body)" data-i18n="proof.item3">API cho nhà phân phối</span>
                <span class="text-sm text-muted">·</span>
                <span class="text-sm font-medium" style="color:var(--c-text-body)" data-i18n="proof.item4">Thông tin dịch vụ trước khi đặt</span>
            </div>
        </div>
    </div>

    <!-- PLATFORMS -->
    <section id="platforms" class="above py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 fade-in">
                <div class="text-xs text-cyan-400 font-semibold tracking-widest uppercase mb-3"
                    data-i18n="platforms.label">Hỗ trợ đa nền tảng</div>
                <h2 class="section-heading text-4xl font-bold text-heading"><span
                        data-i18n="platforms.title1">Tất cả mạng xã hội</span><br><span class="grad-text"
                        data-i18n="platforms.title2">trong một nơi</span></h2>
                <p class="section-intro" data-i18n="platforms.intro">Bắt đầu từ mạng xã hội phù hợp với mục tiêu của bạn, sau đó xem các nhóm dịch vụ và điều kiện đang được cung cấp.</p>
                <div class="platform-summary">
                    <span class="platform-summary-item" data-i18n="platforms.summary1">6 nền tảng phổ biến</span>
                    <span class="platform-summary-item" data-i18n="platforms.summary2">Nhiều mục tiêu đặt đơn</span>
                    <a href="{{ route('clients.services.index') }}" data-i18n="platforms.summaryCta">Xem toàn bộ danh mục ↗</a>
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 fade-in">
                <a href="{{ route('clients.services.index') }}" class="glass-card platform-card">
                    <div class="platform-card-top">
                        <span class="platform-icon-wrap"><img src="{{ asset('images/social/instagram.gif') }}" alt="" class="platform-icon" width="52" height="52" loading="lazy" decoding="async"></span>
                        <div><h3 class="platform-name">Instagram</h3><p class="platform-sub mt-1" data-i18n="platforms.instagram">Followers, likes &amp; views</p></div>
                    </div>
                    <p class="platform-intro" data-i18n="platforms.instagram.intro">Khám phá dịch vụ cho profile, bài đăng và video ngắn để xây dựng sự hiện diện nội dung nhất quán.</p>
                    <div class="platform-tags"><span class="platform-tag">Followers</span><span class="platform-tag">Likes</span><span class="platform-tag">Reels</span></div>
                    <div class="platform-card-footer"><span data-i18n="platforms.cta">Khám phá dịch vụ</span><span class="platform-card-arrow" aria-hidden="true">↗</span></div>
                </a>
                <a href="{{ route('clients.services.index') }}" class="glass-card platform-card">
                    <div class="platform-card-top">
                        <span class="platform-icon-wrap"><img src="{{ asset('images/social/facebook.gif') }}" alt="" class="platform-icon" width="52" height="52" loading="lazy" decoding="async"></span>
                        <div><h3 class="platform-name">Facebook</h3><p class="platform-sub mt-1" data-i18n="platforms.facebook">Page likes &amp; views</p></div>
                    </div>
                    <p class="platform-intro" data-i18n="platforms.facebook.intro">Tìm các nhóm dịch vụ cho fanpage, bài đăng và video để hỗ trợ hoạt động truyền thông của thương hiệu.</p>
                    <div class="platform-tags"><span class="platform-tag">Pages</span><span class="platform-tag">Reactions</span><span class="platform-tag">Views</span></div>
                    <div class="platform-card-footer"><span data-i18n="platforms.cta">Khám phá dịch vụ</span><span class="platform-card-arrow" aria-hidden="true">↗</span></div>
                </a>
                <a href="{{ route('clients.services.index') }}" class="glass-card platform-card">
                    <div class="platform-card-top">
                        <span class="platform-icon-wrap"><img src="{{ asset('images/social/tiktok.gif') }}" alt="" class="platform-icon" width="52" height="52" loading="lazy" decoding="async"></span>
                        <div><h3 class="platform-name">TikTok</h3><p class="platform-sub mt-1" data-i18n="platforms.tiktok">Followers, likes &amp; views</p></div>
                    </div>
                    <p class="platform-intro" data-i18n="platforms.tiktok.intro">Chọn dịch vụ phù hợp cho video ngắn, lượt xem và tương tác khi bạn muốn mở rộng độ phủ nội dung.</p>
                    <div class="platform-tags"><span class="platform-tag">Followers</span><span class="platform-tag">Likes</span><span class="platform-tag">Video views</span></div>
                    <div class="platform-card-footer"><span data-i18n="platforms.cta">Khám phá dịch vụ</span><span class="platform-card-arrow" aria-hidden="true">↗</span></div>
                </a>
                <a href="{{ route('clients.services.index') }}" class="glass-card platform-card">
                    <div class="platform-card-top">
                        <span class="platform-icon-wrap"><img src="{{ asset('images/social/youtube.gif') }}" alt="" class="platform-icon" width="52" height="52" loading="lazy" decoding="async"></span>
                        <div><h3 class="platform-name">YouTube</h3><p class="platform-sub mt-1" data-i18n="platforms.youtube">Views &amp; subscribers</p></div>
                    </div>
                    <p class="platform-intro" data-i18n="platforms.youtube.intro">Duyệt dịch vụ cho kênh, video dài và Shorts, với thông tin cần xem trước khi đặt đơn.</p>
                    <div class="platform-tags"><span class="platform-tag">Views</span><span class="platform-tag">Subscribers</span><span class="platform-tag">Shorts</span></div>
                    <div class="platform-card-footer"><span data-i18n="platforms.cta">Khám phá dịch vụ</span><span class="platform-card-arrow" aria-hidden="true">↗</span></div>
                </a>
                <a href="{{ route('clients.services.index') }}" class="glass-card platform-card">
                    <div class="platform-card-top">
                        <span class="platform-icon-wrap"><img src="{{ asset('images/social/x.gif') }}" alt="" class="platform-icon" width="52" height="52" loading="lazy" decoding="async"></span>
                        <div><h3 class="platform-name">X</h3><p class="platform-sub mt-1" data-i18n="platforms.x">Followers &amp; engagement</p></div>
                    </div>
                    <p class="platform-intro" data-i18n="platforms.x.intro">Xem các lựa chọn cho tài khoản và bài đăng, giúp bạn tìm nhóm dịch vụ phù hợp với hoạt động trên X.</p>
                    <div class="platform-tags"><span class="platform-tag">Followers</span><span class="platform-tag">Likes</span><span class="platform-tag">Reposts</span></div>
                    <div class="platform-card-footer"><span data-i18n="platforms.cta">Khám phá dịch vụ</span><span class="platform-card-arrow" aria-hidden="true">↗</span></div>
                </a>
                <a href="{{ route('clients.services.index') }}" class="glass-card platform-card">
                    <div class="platform-card-top">
                        <span class="platform-icon-wrap"><img src="{{ asset('images/social/telegram.gif') }}" alt="" class="platform-icon" width="52" height="52" loading="lazy" decoding="async"></span>
                        <div><h3 class="platform-name">Telegram</h3><p class="platform-sub mt-1" data-i18n="platforms.telegram">Members &amp; views</p></div>
                    </div>
                    <p class="platform-intro" data-i18n="platforms.telegram.intro">Khám phá dịch vụ cho nhóm, kênh và bài đăng khi bạn cần quản lý hoạt động cộng đồng trên Telegram.</p>
                    <div class="platform-tags"><span class="platform-tag">Members</span><span class="platform-tag">Post views</span><span class="platform-tag">Reactions</span></div>
                    <div class="platform-card-footer"><span data-i18n="platforms.cta">Khám phá dịch vụ</span><span class="platform-card-arrow" aria-hidden="true">↗</span></div>
                </a>
            </div>
            <p class="text-center text-sm text-muted mt-6" data-i18n="platforms.more">Khám phá thêm dịch vụ cho các nền tảng khác trong danh mục.</p>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="services" class="above py-24 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16 fade-in">
                <div class="text-xs text-cyan-400 font-semibold tracking-widest uppercase mb-3"
                    data-i18n="services.label">Dịch vụ nổi bật</div>
                <h2 class="section-heading text-4xl font-bold text-heading"><span
                        data-i18n="services.title1">Dịch vụ cho các</span><br><span class="grad-text"
                        data-i18n="services.title2">mục tiêu khác nhau</span></h2>
                <p class="section-intro" data-i18n="services.intro">Từ xây dựng cộng đồng đến phân phối nội dung, mỗi nhóm dịch vụ đều có thông tin cần thiết để bạn chọn đúng nhu cầu.</p>
            </div>
            <div id="service-grid" class="grid md:grid-cols-3 gap-6">
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
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.followers.desc">Chọn gói theo nền tảng, số lượng và thông tin khởi chạy phù hợp với mục tiêu của bạn.</p>
                    <div class="service-card-meta"><span data-i18n="svc.meta.goal">Mục tiêu phù hợp</span><strong data-i18n="svc.followers.meta">Tăng nhận diện profile</strong></div>
                    <div class="mt-5 text-xs font-semibold text-cyan-400" data-i18n="svc.followers.price">Xem giá trong danh mục dịch vụ</div>
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
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.likes.desc">Tìm gói tương tác cho bài đăng, video ngắn và nội dung trên các nền tảng được hỗ trợ.</p>
                    <div class="service-card-meta"><span data-i18n="svc.meta.goal">Mục tiêu phù hợp</span><strong data-i18n="svc.likes.meta">Tương tác nội dung</strong></div>
                    <div class="mt-5 text-xs font-semibold text-violet-400" data-i18n="svc.likes.price">Xem giá trong danh mục dịch vụ</div>
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
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.views.desc">Chọn dịch vụ xem video theo nền tảng và kiểm tra giới hạn số lượng trước khi tạo đơn.</p>
                    <div class="service-card-meta"><span data-i18n="svc.meta.goal">Mục tiêu phù hợp</span><strong data-i18n="svc.views.meta">Độ phủ nội dung</strong></div>
                    <div class="mt-5 text-xs font-semibold text-pink-400" data-i18n="svc.views.price">Xem giá trong danh mục dịch vụ</div>
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
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.comments.desc">Xem yêu cầu nội dung và tùy chọn của từng dịch vụ bình luận trước khi đặt.</p>
                    <div class="service-card-meta"><span data-i18n="svc.meta.goal">Mục tiêu phù hợp</span><strong data-i18n="svc.comments.meta">Tạo thảo luận</strong></div>
                    <div class="mt-5 text-xs font-semibold text-yellow-400" data-i18n="svc.comments.price">Xem giá trong danh mục dịch vụ</div>
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
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.api.desc">Kết nối nền tảng qua API và quản lý thao tác đặt đơn bằng tích hợp riêng.</p>
                    <div class="service-card-meta"><span data-i18n="svc.meta.goal">Mục tiêu phù hợp</span><strong data-i18n="svc.api.meta">Quy trình tích hợp</strong></div>
                    <div class="mt-5 text-xs font-semibold text-teal-400" data-i18n="svc.api.price">Tích hợp API cho nhà phân phối</div>
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
                    <p class="text-sm text-body mb-4 leading-relaxed" data-i18n="svc.refill.desc">Một số dịch vụ có tùy chọn nạp bù. Kiểm tra điều kiện áp dụng trong chi tiết gói.</p>
                    <div class="service-card-meta"><span data-i18n="svc.meta.goal">Mục tiêu phù hợp</span><strong data-i18n="svc.refill.meta">Kiểm tra điều kiện</strong></div>
                    <div class="mt-5 text-xs font-semibold text-red-400" data-i18n="svc.refill.price">Điều kiện tùy theo dịch vụ</div>
                </div>
            </div>
        </div>
    </section>

    <!-- PANEL CAPABILITIES -->
    <section id="panel-capabilities" class="above capability-section">
        <div class="capability-layout">
            <div class="capability-copy fade-in">
                <div class="text-xs text-cyan-400 font-semibold uppercase mb-3" data-i18n="capabilities.label">Mọi thứ trong một panel</div>
                <h2 class="section-heading text-heading" data-i18n="capabilities.title">Từ danh mục đến lịch sử đơn, mọi thông tin ở đúng nơi cần dùng.</h2>
                <p class="section-intro align-left" data-i18n="capabilities.intro">Giao diện được tổ chức cho các thao tác lặp lại: tìm dịch vụ, kiểm tra điều kiện, đặt đơn và xem lại tiến độ.</p>
                <a href="{{ route('signup') }}" class="btn-outline" data-i18n="capabilities.cta">Khám phá bảng điều khiển</a>
            </div>
            <div class="capability-grid">
                <article class="capability-card fade-in">
                    <span class="capability-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.9"><path d="M4 5.5h16M4 12h16M4 18.5h10" stroke-linecap="round"/><circle cx="18" cy="18.5" r="2.5"/></svg>
                    </span>
                    <h3 data-i18n="capabilities.catalog.title">Danh mục rõ ràng</h3>
                    <p data-i18n="capabilities.catalog.body">Duyệt dịch vụ theo nền tảng và xem thông tin phù hợp trước khi tạo đơn.</p>
                </article>
                <article class="capability-card fade-in">
                    <span class="capability-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.9"><path d="M5 4.5h14v15H5z"/><path d="M8 9h8M8 13h5" stroke-linecap="round"/></svg>
                    </span>
                    <h3 data-i18n="capabilities.orders.title">Theo dõi đơn hàng</h3>
                    <p data-i18n="capabilities.orders.body">Xem mã đơn, trạng thái và lịch sử trong cùng một khu vực quản lý.</p>
                </article>
                <article class="capability-card fade-in">
                    <span class="capability-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.9"><rect x="4" y="6" width="16" height="12" rx="2"/><path d="M4 10h16M8 14h3" stroke-linecap="round"/></svg>
                    </span>
                    <h3 data-i18n="capabilities.balance.title">Quản lý số dư</h3>
                    <p data-i18n="capabilities.balance.body">Kiểm tra phương thức nạp tiền và hoạt động tài khoản từ khu vực cá nhân.</p>
                </article>
                <article class="capability-card fade-in">
                    <span class="capability-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke-width="1.9"><path d="M8.5 7.5 5 12l3.5 4.5M15.5 7.5 19 12l-3.5 4.5M13.5 5 10.5 19" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </span>
                    <h3 data-i18n="capabilities.api.title">Workflow cho reseller</h3>
                    <p data-i18n="capabilities.api.body">Kết nối API khi quy trình của bạn cần tích hợp đặt đơn và theo dõi riêng.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- HOW IT WORKS -->
    <section id="how-it-works" class="above steps-section">
        <div class="max-w-6xl mx-auto">
            <div class="fade-in">
                <div class="text-xs text-cyan-400 font-semibold uppercase mb-3" data-i18n="steps.label">Bắt đầu đơn giản</div>
                <h2 class="section-heading text-4xl font-bold text-heading" data-i18n="steps.title">Từ lựa chọn dịch vụ đến theo dõi đơn</h2>
                <p class="section-intro align-left" data-i18n="steps.intro">Quy trình rõ ràng giúp bạn kiểm tra thông tin trước khi gửi đơn và chủ động theo dõi từng bước sau đó.</p>
            </div>
            <div class="steps-grid">
                <article class="step-item fade-in">
                    <span class="step-number">01</span>
                    <h3 data-i18n="steps.one.title">Chọn nền tảng và dịch vụ</h3>
                    <p data-i18n="steps.one.body">Tìm dịch vụ theo mạng xã hội, xem giá, tốc độ bắt đầu và điều kiện trước khi đặt.</p>
                </article>
                <article class="step-item fade-in">
                    <span class="step-number">02</span>
                    <h3 data-i18n="steps.two.title">Thêm liên kết và số lượng</h3>
                    <p data-i18n="steps.two.body">Nhập thông tin công khai cần thiết. Không chia sẻ mật khẩu tài khoản mạng xã hội.</p>
                </article>
                <article class="step-item fade-in">
                    <span class="step-number">03</span>
                    <h3 data-i18n="steps.three.title">Theo dõi tiến độ</h3>
                    <p data-i18n="steps.three.body">Xem trạng thái đơn trong bảng điều khiển và quản lý các đơn đã tạo tại một nơi.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- PROOF -->
    <section id="stats" class="above py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <div class="stats-intro fade-in">
                <div class="stats-kicker" data-i18n="stats.label">Tổng quan hệ thống</div>
                <p class="stats-description" data-i18n="stats.intro">Các con số dưới đây phản ánh dữ liệu hiện có trong panel và thay đổi theo danh mục dịch vụ đang hoạt động.</p>
            </div>
            <div class="grid sm:grid-cols-2 gap-8 fade-in">
                <div class="step-item">
                    <div class="text-5xl font-bold text-heading mb-2" data-target="{{ $totalOrders ?? 0 }}">0</div>
                    <div class="text-sm text-body" data-i18n="stats.orders">Đơn hàng đã ghi nhận</div>
                </div>
                <div class="step-item">
                    <div class="text-5xl font-bold text-heading mb-2" data-target="{{ $totalServices ?? 0 }}">0</div>
                    <div class="text-sm text-body" data-i18n="stats.services">Dịch vụ hiện có</div>
                </div>
            </div>
        </div>
    </section>

    <!-- TAGLINE REVEAL -->
    <section class="above tagline-section">
        <p class="max-w-4xl mx-auto text-left" aria-label="Tập trung tạo nội dung. Theo dõi tăng trưởng tại một nơi.">
            <span class="tagline-line" data-tagline-line>
                <span class="tagline-word" data-i18n="tagline.one">Tập</span><span class="tagline-word" data-i18n="tagline.two">trung</span><span class="tagline-word" data-i18n="tagline.three">tạo</span><span class="tagline-word" data-i18n="tagline.four">nội</span><span class="tagline-word" data-i18n="tagline.five">dung.</span>
            </span>
            <span class="tagline-line" data-tagline-line>
                <span class="tagline-word" data-i18n="tagline.six">Theo</span><span class="tagline-word" data-i18n="tagline.seven">dõi</span><span class="tagline-word" data-i18n="tagline.eight">tăng</span><span class="tagline-word" data-i18n="tagline.nine">trưởng</span><span class="tagline-word" data-i18n="tagline.ten">tại</span><span class="tagline-word" data-i18n="tagline.eleven">một</span><span class="tagline-word" data-i18n="tagline.twelve">nơi.</span>
            </span>
        </p>
    </section>

    <!-- WORKFLOWS -->
    <section id="audience" class="above audience-section">
        <div class="max-w-6xl mx-auto">
            <div class="audience-header fade-in">
                <div class="text-xs text-cyan-400 font-semibold uppercase mb-3" data-i18n="audience.label">Làm việc theo cách của bạn</div>
                <h2 class="section-heading text-heading" data-i18n="audience.title">Một quy trình gọn cho từng cách vận hành.</h2>
                <p class="section-intro align-left" data-i18n="audience.intro">Dù bạn tự quản lý kênh, phối hợp cùng đội ngũ hay vận hành cho khách hàng, panel vẫn tập trung vào thao tác và thông tin cần thiết.</p>
            </div>
            <div class="audience-grid">
                <article class="audience-card fade-in">
                    <div class="audience-card-label" data-i18n="audience.individual.label">Cá nhân</div>
                    <h3 data-i18n="audience.individual.title">Quản lý từng mục tiêu rõ ràng</h3>
                    <p data-i18n="audience.individual.body">Chọn dịch vụ theo nền tảng, kiểm tra thông tin và theo dõi các đơn đã tạo từ một tài khoản.</p>
                </article>
                <article class="audience-card fade-in">
                    <div class="audience-card-label" data-i18n="audience.team.label">Đội ngũ</div>
                    <h3 data-i18n="audience.team.title">Giữ tiến độ dễ theo dõi</h3>
                    <p data-i18n="audience.team.body">Tập trung thông tin đơn hàng, số dư và lịch sử để việc trao đổi nội bộ rõ ràng hơn.</p>
                </article>
                <article class="audience-card fade-in">
                    <div class="audience-card-label" data-i18n="audience.reseller.label">Reseller</div>
                    <h3 data-i18n="audience.reseller.title">Mở rộng bằng workflow riêng</h3>
                    <p data-i18n="audience.reseller.body">Dùng API và danh mục hiện có để kết nối panel với quy trình quản lý của bạn.</p>
                </article>
            </div>
        </div>
    </section>

    <!-- PRICE TRANSPARENCY -->
    <section id="pricing" class="above py-24 px-6">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-12 items-center">
            <div class="fade-in">
                <div class="text-xs text-cyan-400 font-semibold uppercase mb-3" data-i18n="pricing.label">Chi phí rõ ràng</div>
                <h2 class="text-4xl font-bold text-heading" data-i18n="pricing.title1">Xem giá trước khi tạo đơn</h2>
                <p class="section-intro align-left" data-i18n="pricing.intro">Chọn dịch vụ dựa trên thông tin hiển thị, không dựa trên phỏng đoán.</p>
            </div>
            <div class="fade-in">
                <p class="text-body mb-6" data-i18n="pricing.sub">Mỗi dịch vụ hiển thị mức giá và thông tin cần thiết trước khi bạn xác nhận. Không cần đoán chi phí.</p>
                <ul class="pricing-points">
                    <li data-i18n="pricing.point1">Giá và đơn vị được hiển thị trong danh mục dịch vụ.</li>
                    <li data-i18n="pricing.point2">Kiểm tra giới hạn và điều kiện trước khi tạo đơn.</li>
                    <li data-i18n="pricing.point3">Lịch sử nạp tiền và đơn hàng được quản lý trong tài khoản.</li>
                </ul>
                <a href="{{ route('signup') }}" class="btn-primary" data-i18n="pricing.topup">Xem dịch vụ và giá</a>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="above py-24 px-6">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-12 fade-in">
                <h2 class="text-4xl font-extrabold text-heading"><span data-i18n="faq.title1">Câu hỏi</span> <span
                        class="grad-text" data-i18n="faq.title2">thường gặp</span></h2>
                <p class="faq-intro" data-i18n="faq.intro">Tìm hiểu cách xem dịch vụ, tạo đơn và quản lý tài khoản trước khi bắt đầu.</p>
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
                        <span data-i18n="faq.q2">Làm thế nào để chọn dịch vụ phù hợp?</span>
                        <svg class="faq-icon w-4 h-4 text-cyan-400 transition-transform" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-ans hidden px-6 pb-4 text-sm text-body leading-relaxed" data-i18n="faq.a2">
                        So sánh thông tin, giới hạn và mức giá trên trang dịch vụ. Chỉ tạo đơn khi các điều kiện phù hợp với nhu cầu của bạn.
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
                        <span data-i18n="faq.q4">Xem phương thức nạp tiền ở đâu?</span>
                        <svg class="faq-icon w-4 h-4 text-cyan-400 transition-transform" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-ans hidden px-6 pb-4 text-sm text-body leading-relaxed" data-i18n="faq.a4">
                        Sau khi đăng nhập, mở trang Nạp tiền để xem các phương thức đang khả dụng cho tài khoản của bạn.
                    </div>
                </div>
                <div class="faq-item glass-card rounded-xl overflow-hidden">
                    <button
                        class="faq-q w-full text-left px-6 py-4 font-semibold text-sm text-heading flex justify-between items-center"
                        onclick="toggleFaq(this)">
                        <span data-i18n="faq.q5">Tôi cần trợ giúp với một đơn hàng?</span>
                        <svg class="faq-icon w-4 h-4 text-cyan-400 transition-transform" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-ans hidden px-6 pb-4 text-sm text-body leading-relaxed" data-i18n="faq.a5">
                        Mở mục đơn hàng để kiểm tra trạng thái và mã đơn, sau đó gửi thông tin đó cho bộ phận hỗ trợ.
                    </div>
                </div>
                <div class="faq-item glass-card rounded-xl overflow-hidden">
                    <button
                        class="faq-q w-full text-left px-6 py-4 font-semibold text-sm text-heading flex justify-between items-center"
                        onclick="toggleFaq(this)">
                        <span data-i18n="faq.q6">Đơn hàng bắt đầu khi nào?</span>
                        <svg class="faq-icon w-4 h-4 text-cyan-400 transition-transform" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="faq-ans hidden px-6 pb-4 text-sm text-body leading-relaxed" data-i18n="faq.a6">
                        Thời gian bắt đầu tùy theo dịch vụ. Hãy xem thông tin khởi chạy được hiển thị trong chi tiết dịch vụ trước khi tạo đơn.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="above final-cta py-24 px-6">
        <div class="max-w-3xl mx-auto text-center fade-in">
            <div class="glass-card rounded-3xl p-12" style="border-color:rgba(0,245,255,0.2);">
                <div class="relative inline-block mb-6">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center pulse-ring relative"
                        style="background:#e8f2ef;border:1px solid #2f7d68;">
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
                <p class="mt-5 text-xs text-body" data-i18n="cta.note">Bạn có thể xem danh mục dịch vụ và thông tin chi tiết ngay sau khi đăng nhập.</p>
            </div>
        </div>
    </section>

    </main>

    <!-- FOOTER -->
    <footer class="above border-t py-12 px-6 text-sm text-slate-500" style="border-color:var(--c-border);">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                            <div class="w-7 h-7 rounded-lg flex items-center justify-center"
                            style="background:#2f7d68;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none">
                                <path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z" fill="white" />
                            </svg>
                        </div>
                        <span class="font-bold text-heading">{{ $config->title ?? 'NexaSMM' }}</span>
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
                <div class="flex gap-4 text-xs text-muted"><a href="/services" class="hover:text-white transition"
                        data-i18n="footer.catalog">Danh mục dịch vụ</a><a href="/api" class="hover:text-white transition"
                        data-i18n="footer.apiLink">Tài liệu API</a></div>
            </div>
        </div>
    </footer>

    <script>
        // ── THREE.JS BACKGROUND ──────────────────────────────────────────────────────
        (function() {
            const canvas = document.getElementById('canvas-bg');
            if (!canvas || !window.THREE) return;
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

        const taglineWords = document.querySelectorAll('.tagline-word');
        taglineWords.forEach((word, index) => {
            word.style.transitionDelay = `${index * 55}ms`;
        });
        const taglineObs = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                taglineObs.unobserve(entry.target);
            });
        }, {
            rootMargin: '0px 0px -35% 0px',
            threshold: 0.15
        });
        taglineWords.forEach(word => taglineObs.observe(word));

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
                'hero.badge': 'Quản lý dịch vụ mạng xã hội',
                'hero.title1': 'Vận hành tăng trưởng',
                'hero.title2': 'từ một bảng điều khiển',
                'hero.desc': 'Tạo đơn, theo dõi tiến độ và quản lý số dư trên cùng một nền tảng. Chọn dịch vụ phù hợp mà không cần tích hợp kỹ thuật.',
                'hero.point1': 'Xem điều kiện, giới hạn và giá trước khi tạo đơn.',
                'hero.point2': 'Chỉ cần liên kết công khai, không yêu cầu mật khẩu mạng xã hội.',
                'hero.point3': 'Theo dõi lịch sử và trạng thái đơn trong một màn hình.',
                'hero.cta1': 'Tạo tài khoản miễn phí',
                'hero.cta2': 'Đã có tài khoản? Đăng nhập',
                'hero.stat1': 'Đơn đã ghi nhận',
                'hero.stat2': 'Dịch vụ hiện có',
                'hero.stat3': 'Dịch vụ hiện có',
                'preview.status': '● Hệ thống sẵn sàng',
                'preview.heading': 'Tổng quan đơn hàng',
                'preview.service': 'Dịch vụ',
                'preview.quantity': 'Số lượng',
                'preview.order': 'Mã đơn',
                'preview.progress': 'Tiến độ',
                'preview.processing': '● Đang xử lý',
                'preview.active': 'Đơn đang chạy',
                'preview.action': 'Tạo đơn mới',
                'tagline.one': 'Tập',
                'tagline.two': 'trung',
                'tagline.three': 'tạo',
                'tagline.four': 'nội',
                'tagline.five': 'dung.',
                'tagline.six': 'Theo',
                'tagline.seven': 'dõi',
                'tagline.eight': 'tăng',
                'tagline.nine': 'trưởng',
                'tagline.ten': 'tại',
                'tagline.eleven': 'một',
                'tagline.twelve': 'nơi.',
                'proof.item1': 'Theo dõi trạng thái đơn',
                'proof.item2': 'Danh mục nhiều nền tảng',
                'proof.item3': 'API cho nhà phân phối',
                'proof.item4': 'Thông tin dịch vụ trước khi đặt',
                'steps.label': 'Bắt đầu đơn giản',
                'steps.title': 'Từ lựa chọn dịch vụ đến theo dõi đơn',
                'steps.intro': 'Quy trình rõ ràng giúp bạn kiểm tra thông tin trước khi gửi đơn và chủ động theo dõi từng bước sau đó.',
                'steps.one.title': 'Chọn nền tảng và dịch vụ',
                'steps.one.body': 'Tìm dịch vụ theo mạng xã hội, xem giá và thông tin trước khi đặt.',
                'steps.two.title': 'Thêm liên kết và số lượng',
                'steps.two.body': 'Nhập thông tin công khai cần thiết. Không chia sẻ mật khẩu tài khoản.',
                'steps.three.title': 'Theo dõi tiến độ',
                'steps.three.body': 'Xem trạng thái đơn và quản lý các đơn đã tạo tại một nơi.',
                'platforms.label': 'Hỗ trợ đa nền tảng',
                'platforms.title1': 'Tất cả mạng xã hội',
                'platforms.title2': 'trong một nơi',
                'platforms.intro': 'Bắt đầu từ mạng xã hội phù hợp với mục tiêu của bạn, sau đó xem các nhóm dịch vụ và điều kiện đang được cung cấp.',
                'platforms.more': 'Khám phá thêm dịch vụ cho các nền tảng khác trong danh mục.',
                'platforms.cta': 'Khám phá dịch vụ',
                'platforms.summary1': '6 nền tảng phổ biến',
                'platforms.summary2': 'Nhiều mục tiêu đặt đơn',
                'platforms.summaryCta': 'Xem toàn bộ danh mục ↗',
                'platforms.instagram': 'Followers, likes và views',
                'platforms.facebook': 'Page likes và views',
                'platforms.tiktok': 'Followers, likes và views',
                'platforms.youtube': 'Views và subscribers',
                'platforms.x': 'Followers và engagement',
                'platforms.telegram': 'Members và views',
                'platforms.instagram.intro': 'Khám phá dịch vụ cho profile, bài đăng và video ngắn để xây dựng sự hiện diện nội dung nhất quán.',
                'platforms.facebook.intro': 'Tìm các nhóm dịch vụ cho fanpage, bài đăng và video để hỗ trợ hoạt động truyền thông của thương hiệu.',
                'platforms.tiktok.intro': 'Chọn dịch vụ phù hợp cho video ngắn, lượt xem và tương tác khi bạn muốn mở rộng độ phủ nội dung.',
                'platforms.youtube.intro': 'Duyệt dịch vụ cho kênh, video dài và Shorts, với thông tin cần xem trước khi đặt đơn.',
                'platforms.x.intro': 'Xem các lựa chọn cho tài khoản và bài đăng, giúp bạn tìm nhóm dịch vụ phù hợp với hoạt động trên X.',
                'platforms.telegram.intro': 'Khám phá dịch vụ cho nhóm, kênh và bài đăng khi bạn cần quản lý hoạt động cộng đồng trên Telegram.',
                'services.label': 'Dịch vụ nổi bật',
                'services.title1': 'Dịch vụ cho các',
                'services.title2': 'mục tiêu khác nhau',
                'services.intro': 'Từ xây dựng cộng đồng đến phân phối nội dung, mỗi nhóm dịch vụ đều có thông tin cần thiết để bạn chọn đúng nhu cầu.',
                'svc.followers.title': 'Followers & Subscribers',
                'svc.followers.desc': 'Chọn gói theo nền tảng, số lượng và thông tin khởi chạy phù hợp với mục tiêu của bạn.',
                'svc.followers.price': 'Xem giá trong danh mục dịch vụ',
                'svc.followers.meta': 'Tăng nhận diện profile',
                'svc.likes.title': 'Likes & Reactions',
                'svc.likes.desc': 'Tìm gói tương tác cho bài đăng, video ngắn và nội dung trên các nền tảng được hỗ trợ.',
                'svc.likes.price': 'Xem giá trong danh mục dịch vụ',
                'svc.likes.meta': 'Tương tác nội dung',
                'svc.views.title': 'Views & Impressions',
                'svc.views.desc': 'Chọn dịch vụ xem video theo nền tảng và kiểm tra giới hạn số lượng trước khi tạo đơn.',
                'svc.views.price': 'Xem giá trong danh mục dịch vụ',
                'svc.views.meta': 'Độ phủ nội dung',
                'svc.comments.title': 'Comments',
                'svc.comments.desc': 'Xem yêu cầu nội dung và tùy chọn của từng dịch vụ bình luận trước khi đặt.',
                'svc.comments.price': 'Xem giá trong danh mục dịch vụ',
                'svc.comments.meta': 'Tạo thảo luận',
                'svc.api.title': 'API Reseller',
                'svc.api.desc': 'Kết nối nền tảng qua API và quản lý thao tác đặt đơn bằng tích hợp riêng.',
                'svc.api.price': 'Tích hợp API cho nhà phân phối',
                'svc.api.meta': 'Quy trình tích hợp',
                'svc.refill.title': 'Refill Guarantee',
                'svc.refill.desc': 'Một số dịch vụ có tùy chọn nạp bù. Kiểm tra điều kiện áp dụng trong chi tiết gói.',
                'svc.refill.price': 'Điều kiện tùy theo dịch vụ',
                'svc.refill.meta': 'Kiểm tra điều kiện',
                'svc.speed': 'Tốc độ giao hàng',
                'svc.drop': 'Tỷ lệ rớt',
                'svc.startspeed': 'Tốc độ bắt đầu',
                'svc.quality': 'Chất lượng',
                'svc.maxvol': 'Volume tối đa',
                'svc.retention': 'Giữ chân',
                'svc.meta.goal': 'Mục tiêu phù hợp',
                'capabilities.label': 'Mọi thứ trong một panel',
                'capabilities.title': 'Từ danh mục đến lịch sử đơn, mọi thông tin ở đúng nơi cần dùng.',
                'capabilities.intro': 'Giao diện được tổ chức cho các thao tác lặp lại: tìm dịch vụ, kiểm tra điều kiện, đặt đơn và xem lại tiến độ.',
                'capabilities.cta': 'Khám phá bảng điều khiển',
                'capabilities.catalog.title': 'Danh mục rõ ràng',
                'capabilities.catalog.body': 'Duyệt dịch vụ theo nền tảng và xem thông tin phù hợp trước khi tạo đơn.',
                'capabilities.orders.title': 'Theo dõi đơn hàng',
                'capabilities.orders.body': 'Xem mã đơn, trạng thái và lịch sử trong cùng một khu vực quản lý.',
                'capabilities.balance.title': 'Quản lý số dư',
                'capabilities.balance.body': 'Kiểm tra phương thức nạp tiền và hoạt động tài khoản từ khu vực cá nhân.',
                'capabilities.api.title': 'Workflow cho reseller',
                'capabilities.api.body': 'Kết nối API khi quy trình của bạn cần tích hợp đặt đơn và theo dõi riêng.',
                'stats.orders': 'Đơn hàng đã ghi nhận',
                'stats.users': 'Khách hàng đang dùng',
                'stats.services': 'Dịch vụ hiện có',
                'stats.uptime': '% Uptime / năm',
                'stats.label': 'Tổng quan hệ thống',
                'stats.intro': 'Các con số dưới đây phản ánh dữ liệu hiện có trong panel và thay đổi theo danh mục dịch vụ đang hoạt động.',
                'pricing.label': 'Chi phí rõ ràng',
                'pricing.title1': 'Xem giá trước khi tạo đơn',
                'pricing.title2': 'minh bạch',
                'pricing.intro': 'Chọn dịch vụ dựa trên thông tin hiển thị, không dựa trên phỏng đoán.',
                'pricing.sub': 'Mỗi dịch vụ hiển thị mức giá và thông tin cần thiết trước khi bạn xác nhận.',
                'pricing.point1': 'Giá và đơn vị được hiển thị trong danh mục dịch vụ.',
                'pricing.point2': 'Kiểm tra giới hạn và điều kiện trước khi tạo đơn.',
                'pricing.point3': 'Lịch sử nạp tiền và đơn hàng được quản lý trong tài khoản.',
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
                'pricing.topup': 'Xem dịch vụ và giá',
                'pricing.topup_pro': 'Nạp ngay ↗',
                'pricing.contact': 'Liên hệ ngay',
                'audience.label': 'Làm việc theo cách của bạn',
                'audience.title': 'Một quy trình gọn cho từng cách vận hành.',
                'audience.intro': 'Dù bạn tự quản lý kênh, phối hợp cùng đội ngũ hay vận hành cho khách hàng, panel vẫn tập trung vào thao tác và thông tin cần thiết.',
                'audience.individual.label': 'Cá nhân',
                'audience.individual.title': 'Quản lý từng mục tiêu rõ ràng',
                'audience.individual.body': 'Chọn dịch vụ theo nền tảng, kiểm tra thông tin và theo dõi các đơn đã tạo từ một tài khoản.',
                'audience.team.label': 'Đội ngũ',
                'audience.team.title': 'Giữ tiến độ dễ theo dõi',
                'audience.team.body': 'Tập trung thông tin đơn hàng, số dư và lịch sử để việc trao đổi nội bộ rõ ràng hơn.',
                'audience.reseller.label': 'Reseller',
                'audience.reseller.title': 'Mở rộng bằng workflow riêng',
                'audience.reseller.body': 'Dùng API và danh mục hiện có để kết nối panel với quy trình quản lý của bạn.',
                'faq.title1': 'Câu hỏi',
                'faq.title2': 'thường gặp',
                'faq.intro': 'Tìm hiểu cách xem dịch vụ, tạo đơn và quản lý tài khoản trước khi bắt đầu.',
                'faq.q1': 'SMM Panel là gì và hoạt động như thế nào?',
                'faq.a1': 'SMM Panel là nền tảng cung cấp dịch vụ tăng tương tác mạng xã hội tự động. Bạn đặt đơn, cung cấp link, hệ thống tự xử lý và giao dịch vụ mà không cần can thiệp thủ công.',
                'faq.q2': 'Làm thế nào để chọn dịch vụ phù hợp?',
                'faq.a2': 'So sánh thông tin, giới hạn và mức giá trên trang dịch vụ. Chỉ tạo đơn khi các điều kiện phù hợp với nhu cầu của bạn.',
                'faq.q3': 'Tôi có thể tích hợp API vào hệ thống của mình không?',
                'faq.a3': 'Có! API RESTful đầy đủ với tài liệu chi tiết. Hỗ trợ đặt đơn, kiểm tra trạng thái, lấy danh sách dịch vụ và quản lý số dư — tương thích mọi ngôn ngữ lập trình.',
                'faq.q4': 'Xem phương thức nạp tiền ở đâu?',
                'faq.a4': 'Sau khi đăng nhập, mở trang Nạp tiền để xem các phương thức đang khả dụng cho tài khoản của bạn.',
                'faq.q5': 'Tôi cần trợ giúp với một đơn hàng?',
                'faq.a5': 'Mở mục đơn hàng để kiểm tra trạng thái và mã đơn, sau đó gửi thông tin đó cho bộ phận hỗ trợ.',
                'faq.q6': 'Đơn hàng bắt đầu khi nào?',
                'faq.a6': 'Thời gian bắt đầu tùy theo dịch vụ. Hãy xem thông tin khởi chạy trong chi tiết dịch vụ trước khi tạo đơn.',
                'cta.title1': 'Sẵn sàng tăng tốc',
                'cta.title2': 'social media?',
                'cta.sub': 'Tạo tài khoản để xem danh mục dịch vụ, thông tin khởi chạy và mức giá hiện tại.',
                'cta.btn1': 'Tạo tài khoản miễn phí →',
                'cta.btn2': 'Đăng nhập',
                'cta.note': 'Bạn có thể xem danh mục dịch vụ và thông tin chi tiết ngay sau khi đăng nhập.',
                'footer.desc': 'Nền tảng SMM Panel hàng đầu Việt Nam. Giao hàng nhanh, giá tốt, hỗ trợ 24/7.',
                'footer.services': 'Dịch vụ',
                'footer.support': 'Hỗ trợ',
                'footer.contact_title': 'Liên hệ',
                'footer.api': 'Tài liệu API',
                'footer.guide': 'Hướng dẫn đặt đơn',
                'footer.refund': 'Chính sách hoàn tiền',
                'footer.contact': 'Liên hệ',
                'footer.support_time': '⏰ Hỗ trợ: 24/7',
                'footer.terms': 'Danh mục dịch vụ',
                'footer.privacy': 'Tài liệu API',
                'footer.catalog': 'Danh mục dịch vụ',
                'footer.apiLink': 'Tài liệu API',
            },
            en: {
                'nav.services': 'Services',
                'nav.platforms': 'Platforms',
                'nav.pricing': 'Pricing',
                'nav.stats': 'Stats',
                'nav.login': 'Sign In',
                'nav.start': 'Get Started',
                'hero.badge': 'Social media service management',
                'hero.title1': 'Manage social growth',
                'hero.title2': 'from one dashboard',
                'hero.desc': 'Create orders, follow progress, and manage your balance in one place. Choose a service without setting up an integration.',
                'hero.point1': 'Review service terms, limits, and prices before placing an order.',
                'hero.point2': 'Use public links only; your social account password is never required.',
                'hero.point3': 'Track order status and history from one dashboard.',
                'hero.cta1': 'Create a free account',
                'hero.cta2': 'Already have an account? Sign in',
                'hero.stat1': 'Orders recorded',
                'hero.stat2': 'Services available',
                'hero.stat3': 'Services available',
                'preview.status': '● System ready',
                'preview.heading': 'Order overview',
                'preview.service': 'Service',
                'preview.quantity': 'Quantity',
                'preview.order': 'Order ID',
                'preview.progress': 'Progress',
                'preview.processing': '● Processing',
                'preview.active': 'Active orders',
                'preview.action': 'Create an order',
                'tagline.one': 'Focus',
                'tagline.two': 'on',
                'tagline.three': 'your',
                'tagline.four': 'content',
                'tagline.five': 'first.',
                'tagline.six': 'Track',
                'tagline.seven': 'growth',
                'tagline.eight': 'and',
                'tagline.nine': 'orders',
                'tagline.ten': 'from',
                'tagline.eleven': 'one',
                'tagline.twelve': 'dashboard.',
                'proof.item1': 'Track order status',
                'proof.item2': 'Services across platforms',
                'proof.item3': 'API for resellers',
                'proof.item4': 'Service details before ordering',
                'steps.label': 'Getting started',
                'steps.title': 'Choose a service, then track each order',
                'steps.intro': 'A clear flow lets you check the details before placing an order and follow each step afterward.',
                'steps.one.title': 'Choose a platform and service',
                'steps.one.body': 'Browse by social network and review the price and service details.',
                'steps.two.title': 'Add a link and quantity',
                'steps.two.body': 'Enter the required public information. Never share your account password.',
                'steps.three.title': 'Follow order progress',
                'steps.three.body': 'Check each order status and manage your orders in one place.',
                'platforms.label': 'Multi-platform Support',
                'platforms.title1': 'All social networks',
                'platforms.title2': 'in one place',
                'platforms.intro': 'Start with the social network that fits your goal, then review the available service categories and their terms.',
                'platforms.more': 'Browse more services for other platforms in the catalog.',
                'platforms.cta': 'Explore services',
                'platforms.summary1': '6 popular platforms',
                'platforms.summary2': 'Multiple ordering goals',
                'platforms.summaryCta': 'View the full catalog ↗',
                'platforms.instagram': 'Followers, likes and views',
                'platforms.facebook': 'Page likes and views',
                'platforms.tiktok': 'Followers, likes and views',
                'platforms.youtube': 'Views and subscribers',
                'platforms.x': 'Followers and engagement',
                'platforms.telegram': 'Members and views',
                'platforms.instagram.intro': 'Explore services for profiles, posts, and short-form video to build a consistent content presence.',
                'platforms.facebook.intro': 'Find service categories for pages, posts, and video to support brand communication activity.',
                'platforms.tiktok.intro': 'Choose services for short-form video, views, and engagement when you want to extend content reach.',
                'platforms.youtube.intro': 'Browse service categories for channels, long-form videos, and Shorts with details to review before ordering.',
                'platforms.x.intro': 'Review options for accounts and posts to find service categories that match your activity on X.',
                'platforms.telegram.intro': 'Explore services for groups, channels, and posts when managing community activity on Telegram.',
                'services.label': 'Featured Services',
                'services.title1': 'Services for',
                'services.title2': 'different goals',
                'services.intro': 'From community building to content distribution, every category includes the details needed to make an informed choice.',
                'svc.followers.title': 'Followers & Subscribers',
                'svc.followers.desc': 'Choose a package by platform and quantity, then review its launch details.',
                'svc.followers.price': 'See current price in the service list',
                'svc.followers.meta': 'Profile awareness',
                'svc.likes.title': 'Likes & Reactions',
                'svc.likes.desc': 'Browse engagement options for posts, short videos, and supported social platforms.',
                'svc.likes.price': 'See current price in the service list',
                'svc.likes.meta': 'Content engagement',
                'svc.views.title': 'Views & Impressions',
                'svc.views.desc': 'Choose a video view service by platform and review its order limits before checkout.',
                'svc.views.price': 'See current price in the service list',
                'svc.views.meta': 'Content reach',
                'svc.comments.title': 'Comments',
                'svc.comments.desc': 'Review the content requirements and available options for each comments service.',
                'svc.comments.price': 'See current price in the service list',
                'svc.comments.meta': 'Conversation building',
                'svc.api.title': 'API Reseller',
                'svc.api.desc': 'Connect through the API and manage order placement through your own integration.',
                'svc.api.price': 'API integration for resellers',
                'svc.api.meta': 'Integrated workflow',
                'svc.refill.title': 'Refill Guarantee',
                'svc.refill.desc': 'Some services include refill options. Review the conditions on the service details page.',
                'svc.refill.price': 'Terms vary by service',
                'svc.refill.meta': 'Review service terms',
                'svc.speed': 'Delivery Speed',
                'svc.drop': 'Drop Rate',
                'svc.startspeed': 'Start Speed',
                'svc.quality': 'Quality',
                'svc.maxvol': 'Max Volume',
                'svc.retention': 'Retention',
                'svc.meta.goal': 'Best suited for',
                'capabilities.label': 'Everything in one panel',
                'capabilities.title': 'From the catalog to order history, the details are where you need them.',
                'capabilities.intro': 'The experience is organized around repeatable work: find a service, check its terms, place an order, and review progress.',
                'capabilities.cta': 'Explore the dashboard',
                'capabilities.catalog.title': 'A clear catalog',
                'capabilities.catalog.body': 'Browse services by platform and review relevant details before placing an order.',
                'capabilities.orders.title': 'Order visibility',
                'capabilities.orders.body': 'Review order IDs, statuses, and history from one management area.',
                'capabilities.balance.title': 'Balance management',
                'capabilities.balance.body': 'Check funding methods and account activity from your personal area.',
                'capabilities.api.title': 'A reseller workflow',
                'capabilities.api.body': 'Connect through the API when your workflow needs separate order placement and tracking.',
                'stats.orders': 'Orders recorded',
                'stats.users': 'Active Customers',
                'stats.services': 'Services available',
                'stats.uptime': '% Uptime / year',
                'stats.label': 'Panel overview',
                'stats.intro': 'These figures reflect the current panel data and change with the active service catalog.',
                'pricing.label': 'Clear costs',
                'pricing.title1': 'See the price before ordering',
                'pricing.title2': 'clear pricing',
                'pricing.intro': 'Choose services based on the information shown, not assumptions.',
                'pricing.sub': 'Each service shows its price and the details you need before placing an order.',
                'pricing.point1': 'Prices and units are visible in the service catalog.',
                'pricing.point2': 'Review service limits and terms before placing an order.',
                'pricing.point3': 'Funding and order history remain available in your account.',
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
                'pricing.topup': 'Browse services and prices',
                'pricing.topup_pro': 'Deposit Now ↗',
                'pricing.contact': 'Contact Us',
                'audience.label': 'Work your way',
                'audience.title': 'A clear workflow for every operating style.',
                'audience.intro': 'Whether you manage your own channels, coordinate with a team, or operate for customers, the panel keeps the required actions and information together.',
                'audience.individual.label': 'Individual',
                'audience.individual.title': 'Keep each goal clear',
                'audience.individual.body': 'Choose services by platform, check the details, and follow orders from one account.',
                'audience.team.label': 'Team',
                'audience.team.title': 'Keep progress visible',
                'audience.team.body': 'Keep order information, balance, and history together to make internal coordination clearer.',
                'audience.reseller.label': 'Reseller',
                'audience.reseller.title': 'Extend your workflow',
                'audience.reseller.body': 'Use the API and current catalog to connect the panel with your own management process.',
                'faq.title1': 'Frequently',
                'faq.title2': 'Asked Questions',
                'faq.intro': 'Learn how to browse services, place orders, and manage your account before you begin.',
                'faq.q1': 'What is an SMM Panel and how does it work?',
                'faq.a1': 'An SMM Panel is a platform that provides automated social media engagement services. You place an order, provide a link, and the system processes and delivers the service without manual intervention.',
                'faq.q2': 'How do I choose a service?',
                'faq.a2': 'Compare the service details, limits, and price on the catalog page. Place an order only when the terms match your needs.',
                'faq.q3': 'Can I integrate the API into my system?',
                'faq.a3': 'Yes! Full RESTful API with detailed documentation. Supports order placement, status checking, service listing and balance management — compatible with any programming language.',
                'faq.q4': 'Where can I see available payment methods?',
                'faq.a4': 'After signing in, open Add funds to see the payment methods currently available for your account.',
                'faq.q5': 'How can I get help with an order?',
                'faq.a5': 'Open the orders page to check its status and ID, then share those details with support.',
                'faq.q6': 'When does an order start?',
                'faq.a6': 'Start times vary by service. Review the launch details on the service page before placing an order.',
                'cta.title1': 'Ready to accelerate your',
                'cta.title2': 'social media?',
                'cta.sub': 'Create an account to browse services, review launch details, and see current prices.',
                'cta.btn1': 'Create Free Account →',
                'cta.btn2': 'Sign In',
                'cta.note': 'The service catalog and detailed information are available right after you sign in.',
                'footer.desc': 'The leading SMM Panel platform. Fast delivery, great prices, 24/7 support.',
                'footer.services': 'Services',
                'footer.support': 'Support',
                'footer.contact_title': 'Contact',
                'footer.api': 'API Documentation',
                'footer.guide': 'Order Guide',
                'footer.refund': 'Refund Policy',
                'footer.contact': 'Contact Us',
                'footer.support_time': '⏰ Support: 24/7',
                'footer.terms': 'Service catalog',
                'footer.privacy': 'API docs',
                'footer.catalog': 'Service catalog',
                'footer.apiLink': 'API docs',
            }
        };

        var currentLang = localStorage.getItem('landing_lang') === 'en' ? 'en' : 'vi';

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
