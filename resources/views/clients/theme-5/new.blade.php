<!DOCTYPE html>
<html lang="vi" data-theme="dark" data-lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexaBoost — SMM Panel</title>
    <!-- ① Anti-flash: apply theme/lang BEFORE first paint (Next.js _document pattern) -->
    <script>
        (function () {
            var html = document.documentElement;
            // Theme
            var theme = localStorage.getItem('nexaTheme');
            html.setAttribute('data-theme', (theme === 'light' || theme === 'dark') ? theme : 'dark');
            // Lang
            var lang = localStorage.getItem('nexaLang');
            if (lang === 'vi' || lang === 'en') {
                html.setAttribute('data-lang', lang);
                html.setAttribute('lang', lang);
            }
            // Sidebar collapsed state
            var sc = localStorage.getItem('sidebarCollapsed');
            if (sc === 'true') html.setAttribute('data-sidebar', 'collapsed');
            // Prevent FOUC: hide body until CSS is ready
            html.style.visibility = 'hidden';
            // Safety fallback: always reveal after 500ms max
            setTimeout(function() { html.style.visibility = ''; html.classList.add('ready'); }, 500);
        })();
    </script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <!-- Tippy.js tooltip -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css">
    <!-- NProgress -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css">
    <!-- ② Reveal body after CSS loads — eliminates FOUC -->
    <style>
        html.ready { visibility: visible !important }
    </style>
    <!-- Fallback: reveal if JS disabled or slow -->
    <noscript><style>html { visibility: visible !important }</style></noscript>
    <style>
        /* ═══════════════════════════════════════════════
           DESIGN TOKENS — Semantic Color System
           Based on: ui-ux-pro-max skill guidelines
           Style: Glassmorphism Dark + Light adaptive
           Product: SaaS Dashboard / SMM Panel
        ═══════════════════════════════════════════════ */
        :root {
            /* Brand */
            --brand-primary: #7c3aed;
            --brand-secondary: #06b6d4;
            --brand-accent: #f59e0b;
            --brand-neon: #a855f7;

            /* Semantic surface */
            --surface-bg: #0a0a12;
            --surface-card: rgba(255, 255, 255, .04);
            --surface-card-hover: rgba(255, 255, 255, .07);
            --surface-sidebar: rgba(8, 8, 16, .92);
            --surface-topbar: rgba(8, 8, 16, .80);
            --surface-input: rgba(255, 255, 255, .05);
            --surface-select: #1a1a2e;

            /* Semantic border */
            --border-subtle: rgba(255, 255, 255, .08);
            --border-default: rgba(255, 255, 255, .12);
            --border-strong: rgba(255, 255, 255, .18);

            /* Semantic text — contrast ≥4.5:1 on dark bg */
            --text-primary: #f1f5f9;    /* 15.8:1 on #0a0a12 */
            --text-secondary: #cbd5e1;  /* 9.2:1 */
            --text-muted: #94a3b8;      /* 5.1:1 — raised from 64748b */
            --text-disabled: #475569;   /* 3.1:1 */

            /* Semantic status */
            --status-success: #10b981;
            --status-error: #ef4444;
            --status-warning: #f59e0b;
            --status-info: #06b6d4;

            /* Elevation / shadow scale */
            --shadow-sm: 0 1px 3px rgba(0,0,0,.3);
            --shadow-md: 0 4px 16px rgba(0,0,0,.4);
            --shadow-lg: 0 8px 32px rgba(0,0,0,.5);
            --shadow-xl: 0 16px 48px rgba(0,0,0,.6);

            /* Animation tokens — 150-300ms per skill */
            --dur-fast: 150ms;
            --dur-base: 200ms;
            --dur-slow: 300ms;
            --ease-out: cubic-bezier(0, 0, 0.2, 1);
            --ease-in: cubic-bezier(0.4, 0, 1, 1);
            --ease-spring: cubic-bezier(0.34, 1.56, 0.64, 1);

            /* Spacing — 4/8dp system */
            --sp-1: 4px;
            --sp-2: 8px;
            --sp-3: 12px;
            --sp-4: 16px;
            --sp-5: 20px;
            --sp-6: 24px;
            --sp-8: 32px;
            --sp-10: 40px;
            --sp-12: 48px;

            /* Typography scale */
            --text-xs: 11px;
            --text-sm: 12px;
            --text-base: 14px;
            --text-md: 16px;
            --text-lg: 18px;
            --text-xl: 20px;
            --text-2xl: 24px;
            --text-3xl: 28px;

            /* Border radius */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --radius-xl: 18px;
            --radius-full: 9999px;

            /* Z-index scale */
            --z-base: 0;
            --z-raised: 10;
            --z-dropdown: 100;
            --z-sticky: 110;
            --z-overlay: 149;
            --z-drawer: 150;
            --z-modal: 200;
            --z-toast: 300;

            /* Legacy aliases — keep backward compat */
            --c1: var(--surface-bg);
            --accent: var(--brand-primary);
            --accent2: var(--brand-secondary);
            --accent3: var(--brand-accent);
            --neon: var(--brand-neon);
            --green: var(--status-success);
            --red: var(--status-error);
            --glass: var(--surface-card);
            --glass2: var(--surface-card-hover);
            --border: var(--border-subtle);
            --border2: var(--border-default);
            --text: var(--text-primary);
            --text2: var(--text-secondary);
            --muted: var(--text-muted);
            --fn: var(--fb);
            --fh: 'Inter', Helvetica, sans-serif;
            --fb: 'Inter', Helvetica, sans-serif;
            --sw: 252px;
            --sidebar-bg: var(--surface-sidebar);
            --topbar-bg: var(--surface-topbar);
            --input-bg: var(--surface-input);
            --select-bg: var(--surface-select);
        }

        /* ── LIGHT MODE TOKENS ── */
        [data-theme="light"] {
            --surface-bg: #f1f5fb;
            --surface-card: rgba(255, 255, 255, .80);
            --surface-card-hover: rgba(255, 255, 255, .95);
            --surface-sidebar: rgba(255, 255, 255, .96);
            --surface-topbar: rgba(241, 245, 251, .92);
            --surface-input: rgba(0, 0, 0, .04);
            --surface-select: #ffffff;

            --border-subtle: rgba(0, 0, 0, .08);
            --border-default: rgba(0, 0, 0, .13);
            --border-strong: rgba(0, 0, 0, .20);

            --text-primary: #0f172a;    /* 18.1:1 on white */
            --text-secondary: #334155;  /* 10.7:1 */
            --text-muted: #64748b;      /* 4.6:1 */
            --text-disabled: #94a3b8;

            --shadow-sm: 0 1px 3px rgba(0,0,0,.08);
            --shadow-md: 0 4px 16px rgba(0,0,0,.10);
            --shadow-lg: 0 8px 32px rgba(0,0,0,.12);
            --shadow-xl: 0 16px 48px rgba(0,0,0,.15);

            --c1: var(--surface-bg);
            --glass: var(--surface-card);
            --glass2: var(--surface-card-hover);
            --border: var(--border-subtle);
            --border2: var(--border-default);
            --text: var(--text-primary);
            --text2: var(--text-secondary);
            --muted: var(--text-muted);
            --sidebar-bg: var(--surface-sidebar);
            --topbar-bg: var(--surface-topbar);
            --input-bg: var(--surface-input);
            --select-bg: #ffffff;
        }

        [data-theme="light"] .orb-1 { background: #7c3aed; opacity: var(--orb-op) }
        [data-theme="light"] .orb-2 { background: #06b6d4; opacity: var(--orb-op) }
        [data-theme="light"] .orb-3 { background: #f59e0b; opacity: .06 }

        [data-theme="light"] .sidebar {
            background: var(--sidebar-bg);
            border-right-color: var(--border);
            box-shadow: 2px 0 20px rgba(0,0,0,.06)
        }

        [data-theme="light"] .topbar {
            background: var(--topbar-bg);
            border-bottom-color: var(--border);
            box-shadow: 0 2px 12px rgba(0,0,0,.06)
        }

        [data-theme="light"] .panel {
            background: rgba(255,255,255,.82);
            border-color: var(--border);
            box-shadow: 0 2px 16px rgba(0,0,0,.06)
        }

        [data-theme="light"] .sc {
            background: rgba(255,255,255,.9);
            border-color: var(--border);
            box-shadow: 0 2px 12px rgba(0,0,0,.05)
        }

        [data-theme="light"] .sc::before {
            opacity: .18
        }

        [data-theme="light"] .sc.p {
            background: linear-gradient(135deg, rgba(124,58,237,.08) 0%, rgba(255,255,255,.95) 60%);
            border-color: rgba(124,58,237,.2);
            box-shadow: 0 2px 16px rgba(124,58,237,.1)
        }

        [data-theme="light"] .sc.c {
            background: linear-gradient(135deg, rgba(6,182,212,.1) 0%, rgba(255,255,255,.95) 60%);
            border-color: rgba(6,182,212,.22);
            box-shadow: 0 2px 16px rgba(6,182,212,.1)
        }

        [data-theme="light"] .sc.a {
            background: linear-gradient(135deg, rgba(245,158,11,.1) 0%, rgba(255,255,255,.95) 60%);
            border-color: rgba(245,158,11,.22);
            box-shadow: 0 2px 16px rgba(245,158,11,.1)
        }

        [data-theme="light"] .sc.g {
            background: linear-gradient(135deg, rgba(16,185,129,.1) 0%, rgba(255,255,255,.95) 60%);
            border-color: rgba(16,185,129,.22);
            box-shadow: 0 2px 16px rgba(16,185,129,.1)
        }

        [data-theme="light"] .sc:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 24px rgba(0,0,0,.1)
        }

        [data-theme="light"] .si.p { background: rgba(124,58,237,.15) }
        [data-theme="light"] .si.c { background: rgba(6,182,212,.15) }
        [data-theme="light"] .si.a { background: rgba(245,158,11,.15) }
        [data-theme="light"] .si.g { background: rgba(16,185,129,.15) }

        [data-theme="light"] .sv { color: #0f172a }
        [data-theme="light"] .sn { color: #64748b }

        [data-theme="light"] .osum {
            background: rgba(255,255,255,.9);
            border-color: var(--border);
            box-shadow: 0 2px 16px rgba(0,0,0,.06)
        }

        [data-theme="light"] .bal {
            background: linear-gradient(135deg, rgba(124,58,237,.1), rgba(6,182,212,.06));
            border-color: rgba(124,58,237,.18)
        }

        [data-theme="light"] .fi,
        [data-theme="light"] .fse,
        [data-theme="light"] .fta {
            background: var(--input-bg);
            border-color: var(--border);
            color: var(--text)
        }

        [data-theme="light"] .fse {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E")
        }

        [data-theme="light"] .fse option { background: #ffffff }

        [data-theme="light"] .tsrch {
            background: rgba(0,0,0,.04);
            border-color: var(--border)
        }

        [data-theme="light"] .nb,
        [data-theme="light"] .lang-dd-btn {
            background: rgba(0,0,0,.04);
            border-color: var(--border)
        }

        [data-theme="light"] .chart-stats {
            border-bottom-color: var(--border)
        }

        [data-theme="light"] .nb:hover { background: rgba(0,0,0,.07) }

        [data-theme="light"] .np { border-color: var(--c1) }

        [data-theme="light"] .pb2,
        [data-theme="light"] .sr,
        [data-theme="light"] .spb {
            background: rgba(255,255,255,.8);
            border-color: var(--border)
        }

        [data-theme="light"] .pb2:hover,
        [data-theme="light"] .sr:hover,
        [data-theme="light"] .spb:hover {
            background: rgba(255,255,255,.95)
        }

        [data-theme="light"] .tab {
            background: rgba(0,0,0,.04);
            border-color: var(--border);
            color: var(--muted)
        }

        [data-theme="light"] .pgb { color: var(--muted) }
        [data-theme="light"] .pgb:hover { background: rgba(0,0,0,.05); color: var(--text) }

        [data-theme="light"] ::-webkit-scrollbar-thumb { background: rgba(0,0,0,.12) }
        [data-theme="light"] ::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,.2) }

        [data-theme="light"] .ot th { background: rgba(0,0,0,.02) }
        [data-theme="light"] .ot tbody tr:hover td { background: rgba(0,0,0,.025) }
        [data-theme="light"] .ot td { border-bottom-color: rgba(0,0,0,.05) }
        [data-theme="light"] .ai:hover { background: rgba(0,0,0,.02) }
        [data-theme="light"] .ai { border-bottom-color: rgba(0,0,0,.05) }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            font-family: var(--fb);
            background: var(--surface-bg);
            color: var(--text-primary);
            min-height: 100dvh;
            overflow-x: hidden;
            transition: background var(--dur-slow), color var(--dur-slow);
            /* Prevent 300ms tap delay */
            touch-action: manipulation;
            /* Base 16px for mobile readability */
            font-size: 16px;
            line-height: 1.5
        }

        /* ── FOCUS STATES — Priority 1: Accessibility ── */
        :focus-visible {
            outline: 2px solid var(--brand-primary);
            outline-offset: 2px;
            border-radius: var(--radius-sm)
        }

        /* ── REDUCED MOTION — Priority 1 ── */
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                animation-duration: .01ms !important;
                transition-duration: .01ms !important
            }
        }

        /* BG */
        #bg-canvas {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none
        }

        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            opacity: .16;
            pointer-events: none;
            z-index: 0;
            animation: od 20s ease-in-out infinite alternate
        }

        .orb-1 {
            width: 620px;
            height: 620px;
            background: #7c3aed;
            top: -220px;
            left: -220px;
            animation-duration: 22s
        }

        .orb-2 {
            width: 520px;
            height: 520px;
            background: #06b6d4;
            bottom: -180px;
            right: -180px;
            animation-duration: 28s;
            animation-delay: -9s
        }

        .orb-3 {
            width: 380px;
            height: 380px;
            background: #f59e0b;
            top: 42%;
            left: 52%;
            animation-duration: 34s;
            animation-delay: -16s;
            opacity: .08
        }

        @keyframes od {
            0% {
                transform: translate(0, 0) scale(1)
            }

            33% {
                transform: translate(50px, -35px) scale(1.06)
            }

            66% {
                transform: translate(-25px, 45px) scale(.96)
            }

            100% {
                transform: translate(35px, 25px) scale(1.04)
            }
        }

        /* LAYOUT */
        .shell {
            position: relative;
            z-index: 1;
            display: flex;
            min-height: 100dvh
        }

        /* ══════════════════════════════════════
           SIDEBAR — GPU-accelerated, no layout shift
           Pattern: data-sidebar attribute on <html>
           (Next.js layout pattern: state on root element)
        ══════════════════════════════════════ */
        .sidebar {
            width: var(--sw);
            flex-shrink: 0;
            background: var(--surface-sidebar);
            border-right: 1px solid var(--border-subtle);
            display: flex;
            flex-direction: column;
            padding: 26px 0;
            position: sticky;
            top: 0;
            height: 100dvh;
            overflow-y: auto;
            overflow-x: hidden;
            /* GPU layer — no layout recalc on transition */
            will-change: width;
            transition: width var(--dur-slow) var(--ease-out),
                        background var(--dur-slow),
                        border-color var(--dur-slow)
        }

        /* Sidebar inner content — fade on collapse */
        .sidebar-inner {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: 0;
            /* Prevent text wrapping during width transition */
            white-space: nowrap;
            overflow: hidden
        }

        /* Mobile: solid bg, no blur, GPU drawer */
        @media (max-width: 768px) {
            .sidebar {
                background: var(--surface-bg) !important;
                backdrop-filter: none !important;
                -webkit-backdrop-filter: none !important;
                box-shadow: none;
                will-change: transform
            }
            [data-theme="light"] .sidebar {
                background: #ffffff !important
            }
        }

        .logo {
            padding: 0 22px 24px;
            border-bottom: 1px solid var(--border);
            margin-bottom: 18px
        }

        .logo-mark {
            font-family: var(--fh);
            font-weight: 800;
            font-size: 21px;
            background: linear-gradient(135deg, var(--neon), var(--accent2));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            display: flex;
            align-items: center;
            gap: 9px
        }

        .logo-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--accent2);
            box-shadow: 0 0 12px var(--accent2);
            animation: pd 2s ease-in-out infinite;
            flex-shrink: 0;
            margin-top: 2px
        }

        @keyframes pd {

            0%,
            100% {
                transform: scale(1);
                opacity: 1
            }

            50% {
                transform: scale(1.6);
                opacity: .55
            }
        }

        .nl {
            font-size: 10px;
            font-weight: 700;
            color: var(--muted);
            letter-spacing: 1.8px;
            text-transform: uppercase;
            padding: 0 22px 7px;
            margin-top: 6px
        }

        .ni {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 22px;
            cursor: pointer;
            color: var(--text-muted);
            font-size: var(--text-base);
            font-weight: 500;
            transition: all var(--dur-base) var(--ease-out);
            border-left: 2px solid transparent;
            /* Touch target ≥44px — Priority 2 */
            min-height: 44px;
            text-decoration: none;
            user-select: none
        }

        .ni:hover {
            color: var(--text-secondary);
            background: var(--surface-card-hover);
            border-left-color: var(--border-default)
        }

        .ni.active {
            color: var(--brand-neon);
            background: rgba(124, 58, 237, .12);
            border-left-color: var(--brand-neon)
        }

        .ni.active svg {
            filter: drop-shadow(0 0 5px var(--brand-neon))
        }

        .ni svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            transition: filter var(--dur-base)
        }

        .sf {
            margin-top: auto;
            padding: 18px 22px 0;
            border-top: 1px solid var(--border)
        }

        .bal {
            background: linear-gradient(135deg, rgba(124, 58, 237, .18), rgba(6, 182, 212, .08));
            border: 1px solid rgba(124, 58, 237, .22);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 14px
        }

        .bal-l {
            font-size: 10px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: 600
        }

        .bal-a {
            font-family: var(--fh);
            font-size: 23px;
            font-weight: 700;
            color: var(--text);
            margin: 5px 0 3px;
            letter-spacing: -.3px
        }

        .bal-s {
            font-size: 12px;
            color: var(--accent2)
        }

        .btn-tp {
            width: 100%;
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
            border: none;
            border-radius: var(--radius-md);
            color: #fff;
            font-family: var(--fb);
            font-size: var(--text-base);
            font-weight: 600;
            padding: 12px var(--sp-4);
            cursor: pointer;
            transition: opacity var(--dur-base) var(--ease-out),
                        transform var(--dur-fast) var(--ease-out);
            /* Touch target ≥44px */
            min-height: 44px
        }

        .btn-tp:hover {
            opacity: .88;
            transform: translateY(-1px)
        }

        .btn-tp:active {
            transform: scale(.97);
            opacity: .95
        }

        /* MAIN */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            /* Prevent layout shift when sidebar collapses */
            transition: margin-left var(--dur-slow) var(--ease-out)
        }

        .topbar {
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 var(--sp-6);
            /* Separate layer for backdrop-filter — no repaint on scroll */
            position: sticky;
            top: 0;
            z-index: var(--z-sticky);
            /* Use pseudo-element for bg to avoid stacking context issues */
            isolation: isolate
        }

        /* Topbar background as pseudo — GPU composited */
        .topbar::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--surface-topbar);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-subtle);
            z-index: -1;
            transition: background var(--dur-slow), border-color var(--dur-slow)
        }

        [data-theme="light"] .topbar::before {
            background: rgba(241, 245, 251, .94);
            box-shadow: 0 1px 0 var(--border-subtle), 0 4px 16px rgba(0,0,0,.04)
        }

        .tbl {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 0
        }

        .pt {
            font-family: var(--fh);
            font-size: 17px;
            font-weight: 700;
            white-space: nowrap
        }

        /* Search in left */
        .tsrch {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 6px 14px;
            color: var(--muted);
            font-size: 13px;
            width: 200px;
            transition: border-color .25s, width .3s, box-shadow .25s
        }

        .tsrch:focus-within {
            border-color: rgba(124, 58, 237, .5);
            width: 260px;
            box-shadow: 0 0 0 3px rgba(124,58,237,.08)
        }

        .tsrch svg {
            width: 13px;
            height: 13px;
            flex-shrink: 0;
            opacity: .6
        }

        .tsrch input {
            background: none;
            border: none;
            outline: none;
            color: var(--text);
            font-size: 13px;
            font-family: var(--fb);
            width: 100%;
            min-width: 0
        }

        .tsrch input::placeholder { color: var(--muted) }

        .blv {
            font-size: 10px;
            font-weight: 700;
            background: rgba(16, 185, 129, .14);
            color: var(--green);
            border: 1px solid rgba(16, 185, 129, .24);
            padding: 2px 9px;
            border-radius: 20px;
            letter-spacing: .8px;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 5px
        }

        .blv::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--green);
            box-shadow: 0 0 6px var(--green);
            animation: pd 1.8s ease infinite
        }

        .tbr {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0
        }

        .nb {
            width: 40px;
            height: 40px;
            background: var(--surface-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            transition: background var(--dur-base) var(--ease-out);
            /* Touch target ≥44px via padding */
            flex-shrink: 0
        }

        .nb:hover { background: var(--surface-card-hover) }

        .np {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 7px;
            height: 7px;
            background: var(--status-error);
            border-radius: 50%;
            border: 1.5px solid var(--surface-bg);
            box-shadow: 0 0 6px var(--status-error)
        }

        .av {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-md);
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--fh);
            font-weight: 700;
            font-size: var(--text-base);
            cursor: pointer;
            position: relative;
            user-select: none;
            flex-shrink: 0;
            transition: transform var(--dur-fast) var(--ease-out),
                        box-shadow var(--dur-base)
        }

        .av:hover {
            transform: scale(1.04);
            box-shadow: 0 0 0 3px rgba(124,58,237,.3)
        }

        .av:active { transform: scale(.96) }

        /* ── DROPDOWN BASE ── */
        .dd-wrap {
            position: relative;
            flex-shrink: 0
        }

        .dd-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: var(--c1);
            border: 1px solid var(--border2);
            border-radius: 12px;
            padding: 6px;
            min-width: 160px;
            box-shadow: 0 12px 40px rgba(0,0,0,.35);
            backdrop-filter: blur(20px);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-6px);
            transition: opacity .18s, transform .18s, visibility .18s;
            z-index: 200
        }

        [data-theme="light"] .dd-menu {
            background: #fff;
            box-shadow: 0 8px 32px rgba(0,0,0,.12)
        }

        .dd-wrap.open .dd-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0)
        }

        .dd-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            color: var(--text2);
            cursor: pointer;
            transition: background .14s, color .14s
        }

        .dd-item:hover {
            background: var(--glass2);
            color: var(--text)
        }

        .dd-item i {
            width: 16px;
            text-align: center;
            color: var(--muted);
            font-size: 13px
        }

        .dd-item:hover i { color: var(--neon) }

        .dd-sep {
            height: 1px;
            background: var(--border);
            margin: 5px 6px
        }

        .dd-header {
            padding: 10px 12px 6px;
            font-size: 11px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1px
        }

        /* ── LANG DROPDOWN ── */
        .lang-dd-btn {
            display: flex;
            align-items: center;
            gap: 7px;
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 22px;
            padding: 6px 13px 6px 10px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text);
            cursor: pointer;
            transition: background .18s, border-color .18s;
            user-select: none
        }

        .lang-dd-btn:hover {
            background: var(--glass2);
            border-color: var(--border2)
        }

        .lang-flag {
            font-size: 18px;
            line-height: 1;
            flex-shrink: 0
        }

        .lang-code {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: .5px
        }

        .lang-dd-btn .fa-chevron-up,
        .lang-dd-btn .fa-chevron-down {
            font-size: 9px;
            color: var(--muted);
            transition: opacity .15s
        }

        .lang-dd-menu {
            min-width: 220px;
            max-height: 320px;
            overflow-y: auto;
            padding: 8px 6px
        }

        .lang-dd-menu::-webkit-scrollbar { width: 3px }
        .lang-dd-menu::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 3px }

        .lang-dd-header {
            padding: 6px 10px 10px;
            font-size: 10.5px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1.4px
        }

        .lang-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 9px 12px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--text2);
            cursor: pointer;
            transition: background .14s, color .14s;
            position: relative
        }

        .lang-item:hover {
            background: var(--glass2);
            color: var(--text)
        }

        .lang-item.active {
            background: rgba(124,58,237,.12);
            color: var(--accent);
            font-weight: 600
        }

        [data-theme="light"] .lang-item.active {
            background: rgba(99,102,241,.1);
            color: #4f46e5
        }

        .lang-item .li-flag {
            font-size: 22px;
            line-height: 1;
            flex-shrink: 0;
            width: 28px;
            text-align: center
        }

        .lang-item .li-check {
            margin-left: auto;
            font-size: 11px;
            color: var(--accent);
            opacity: 0
        }

        .lang-item.active .li-check { opacity: 1 }

        /* PAGES */
        .page {
            display: none;
            flex: 1;
            flex-direction: column;
            min-width: 0
        }

        .page.active {
            display: flex
        }

        .content {
            flex: 1;
            padding: 26px 30px;
            overflow-y: auto
        }

        /* PANEL */
        .panel {
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 16px;
            backdrop-filter: blur(12px);
            overflow: hidden
        }

        .ph {
            padding: 18px 22px 15px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between
        }

        .pt2 {
            font-family: var(--fh);
            font-size: 14.5px;
            font-weight: 700
        }

        .pa {
            font-size: 12px;
            color: var(--neon);
            cursor: pointer;
            font-weight: 600;
            transition: opacity .15s
        }

        .pa:hover {
            opacity: .72
        }

        /* ── DASHBOARD STATS ── */
        .sg {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 22px
        }

        .sc {
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 20px;
            backdrop-filter: blur(12px);
            position: relative;
            overflow: hidden;
            transition: transform .2s, border-color .2s;
            cursor: default
        }

        .sc::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at top left, var(--cg, transparent) 0%, transparent 65%);
            opacity: .35;
            pointer-events: none
        }

        .sc:hover {
            transform: translateY(-3px);
            border-color: var(--border2)
        }

        .sc.p {
            --cg: #7c3aed
        }

        .sc.c {
            --cg: #06b6d4
        }

        .sc.a {
            --cg: #f59e0b
        }

        .sc.g {
            --cg: #10b981
        }

        .st {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 15px
        }

        .si {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px
        }

        .si.p {
            background: rgba(124, 58, 237, .2)
        }

        .si.c {
            background: rgba(6, 182, 212, .2)
        }

        .si.a {
            background: rgba(245, 158, 11, .2)
        }

        .si.g {
            background: rgba(16, 185, 129, .2)
        }

        .str {
            font-size: 11.5px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            letter-spacing: 0
        }

        .str.up {
            background: rgba(16, 185, 129, .14);
            color: var(--green)
        }

        .str.dn {
            background: rgba(239, 68, 68, .14);
            color: var(--red)
        }

        .sv {
            font-family: var(--fh);
            font-size: 24px;
            font-weight: 600;
            line-height: 1;
            margin-bottom: 5px;
            letter-spacing: -.2px
        }

        .sn {
            font-size: 12.5px;
            color: var(--muted)
        }

        /* CHART */
        .cw {
            padding: 6px 22px 18px
        }

        .chart-stats {
            display: flex;
            gap: 24px;
            padding: 16px 22px 0;
            border-bottom: 1px solid var(--border)
        }

        .chart-stat {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding-bottom: 14px
        }

        .chart-stat-v {
            font-size: 20px;
            font-weight: 700;
            font-family: var(--fh);
            letter-spacing: -.3px
        }

        .chart-stat-l {
            font-size: 11px;
            color: var(--muted)
        }

        .chart-stat-d {
            font-size: 11px;
            font-weight: 600;
            padding: 1px 7px;
            border-radius: 20px
        }

        .chart-stat-d.up {
            background: rgba(16,185,129,.12);
            color: var(--green)
        }

        .chart-stat-d.dn {
            background: rgba(239,68,68,.12);
            color: var(--red)
        }

        .cs {
            width: 100%;
            height: 170px
        }

        .cl {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: var(--muted);
            margin-top: 10px;
            padding: 0 2px
        }

        .mb18 {
            margin-bottom: 18px
        }

        .mb22 {
            margin-bottom: 22px
        }

        /* TWO COL */
        .tc {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
            margin-bottom: 18px
        }

        /* ORDER TABLE (shared) */
        .ot {
            width: 100%;
            border-collapse: collapse
        }

        .ot th {
            padding: 10px 20px;
            text-align: left;
            font-size: 10.5px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: 700;
            background: rgba(255, 255, 255, .02);
            border-bottom: 1px solid var(--border);
            white-space: nowrap
        }

        .ot td {
            padding: 13px 20px;
            font-size: 13px;
            border-bottom: 1px solid rgba(255, 255, 255, .035);
            vertical-align: middle
        }

        .ot tr:last-child td {
            border-bottom: none
        }

        .ot tbody tr:hover td {
            background: rgba(255, 255, 255, .025);
            transition: background .14s
        }

        .ot .num {
            font-size: 12.5px;
            font-weight: 500
        }

        .ot .oid {
            font-size: 12px;
            color: var(--muted);
            font-weight: 500
        }

        .sb {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 6px;
            white-space: nowrap
        }

        .sb.ig {
            background: rgba(225, 48, 108, .14);
            color: #e1306c
        }

        .sb.yt {
            background: rgba(255, 0, 0, .13);
            color: #ff4040
        }

        .sb.tt {
            background: rgba(255, 255, 255, .07);
            color: #f0f0f0;
            border: 1px solid rgba(255, 255, 255, .09)
        }

        .sb.fb {
            background: rgba(24, 119, 242, .14);
            color: #4f8ef7
        }

        .sb.tw {
            background: rgba(29, 161, 242, .11);
            color: #1da1f2
        }

        .sb.li {
            background: rgba(0, 119, 181, .14);
            color: #4db0e0
        }

        .sp {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-weight: 600;
            padding: 3px 10px;
            border-radius: 20px;
            white-space: nowrap
        }

        .sp::before {
            content: '';
            width: 5px;
            height: 5px;
            border-radius: 50%;
            flex-shrink: 0
        }

        .sp.ok {
            background: rgba(16, 185, 129, .13);
            color: var(--green)
        }

        .sp.ok::before {
            background: var(--green)
        }

        .sp.wt {
            background: rgba(245, 158, 11, .13);
            color: var(--accent3)
        }

        .sp.wt::before {
            background: var(--accent3)
        }

        .sp.ac {
            background: rgba(6, 182, 212, .13);
            color: var(--accent2)
        }

        .sp.ac::before {
            background: var(--accent2);
            animation: pd 1.5s infinite
        }

        .sp.er {
            background: rgba(239, 68, 68, .13);
            color: var(--red)
        }

        .sp.er::before {
            background: var(--red)
        }

        .sp.rf {
            background: rgba(168, 85, 247, .13);
            color: var(--neon)
        }

        .sp.rf::before {
            background: var(--neon)
        }

        .pb {
            height: 4px;
            background: rgba(255, 255, 255, .07);
            border-radius: 2px;
            width: 80px;
            overflow: hidden;
            min-width: 60px
        }

        .pb-i {
            height: 100%;
            border-radius: 2px;
            background: linear-gradient(90deg, var(--accent), var(--accent2))
        }

        /* ACTIVITY */
        .al {
            padding: 0 0 6px
        }

        .ai {
            display: flex;
            align-items: flex-start;
            gap: 13px;
            padding: 14px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .04);
            transition: background .15s
        }

        .ai:last-child {
            border-bottom: none
        }

        .ai:hover {
            background: rgba(255, 255, 255, .02)
        }

        .ad {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            margin-top: 2px
        }

        .ad.or {
            background: rgba(124, 58, 237, .2)
        }

        .ad.py {
            background: rgba(16, 185, 129, .2)
        }

        .ad.dn {
            background: rgba(6, 182, 212, .2)
        }

        .ad.wn {
            background: rgba(245, 158, 11, .2)
        }

        .at {
            font-size: 13px;
            line-height: 1.55
        }

        .at strong {
            color: var(--text);
            font-weight: 600;
            font-size: 12.5px
        }

        .atm {
            font-size: 11px;
            color: var(--muted);
            margin-top: 3px
        }

        /* ── ORDER PAGE ── */
        .opg {
            display: grid;
            grid-template-columns: 1fr 370px;
            gap: 20px;
            align-items: start
        }

        .platg {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-bottom: 22px
        }

        .pb2 {
            background: var(--glass);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all .2s;
            text-align: center
        }

        .pb2:hover {
            background: var(--glass2);
            border-color: rgba(255, 255, 255, .14);
            transform: translateY(-2px)
        }

        .pb2.sel {
            border-color: var(--accent);
            background: rgba(124, 58, 237, .1);
            box-shadow: 0 0 0 1px var(--accent)
        }

        .pi {
            font-size: 26px;
            line-height: 1
        }

        .pn {
            font-size: 12px;
            font-weight: 600;
            color: var(--text2)
        }

        .pb2.sel .pn {
            color: var(--neon)
        }

        .svl {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 22px
        }

        .sr {
            background: var(--glass);
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
            transition: all .18s
        }

        .sr:hover {
            background: var(--glass2);
            border-color: rgba(255, 255, 255, .13)
        }

        .sr.sel {
            border-color: var(--accent);
            background: rgba(124, 58, 237, .09)
        }

        .srd {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid var(--border);
            flex-shrink: 0;
            transition: all .18s;
            display: flex;
            align-items: center;
            justify-content: center
        }

        .sr.sel .srd {
            border-color: var(--accent);
            background: var(--accent)
        }

        .sr.sel .srd::after {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #fff
        }

        .srin {
            flex: 1;
            min-width: 0
        }

        .srin-n {
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text)
        }

        .srin-d {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px
        }

        .srp {
            font-size: 13.5px;
            font-weight: 700;
            color: var(--neon);
            white-space: nowrap;
            text-align: right
        }

        .srq {
            font-size: 11px;
            color: var(--muted);
            text-align: right;
            margin-top: 2px
        }

        .fst {
            font-family: var(--fh);
            font-size: 13px;
            font-weight: 700;
            color: var(--text2);
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px
        }

        .fst::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border)
        }

        .fr {
            margin-bottom: 16px
        }

        .fl {
            display: block;
            font-size: 11.5px;
            color: var(--muted);
            font-weight: 700;
            letter-spacing: .6px;
            text-transform: uppercase;
            margin-bottom: 7px
        }

        .fi,
        .fse,
        .fta {
            width: 100%;
            background: var(--input-bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            color: var(--text);
            font-family: var(--fb);
            font-size: 13.5px;
            padding: 11px 14px;
            outline: none;
            transition: border-color .2s, box-shadow .2s
        }

        .fi:focus,
        .fse:focus,
        .fta:focus {
            border-color: rgba(124, 58, 237, .5);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, .1)
        }

        .fi.mn {
            letter-spacing: 0
        }

        .fse {
            appearance: none;
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2.5'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            padding-right: 40px
        }

        .fse option {
            background: var(--select-bg)
        }

        .fta {
            resize: vertical;
            min-height: 78px
        }

        .fr2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px
        }

        .fh2 {
            font-size: 11.5px;
            color: var(--muted);
            margin-top: 6px;
            line-height: 1.5
        }

        .qs {
            width: 100%;
            accent-color: var(--accent);
            margin: 8px 0
        }

        .qmm {
            display: flex;
            justify-content: space-between;
            font-size: 11px;
            color: var(--muted)
        }

        .spg {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px
        }

        .spb {
            background: var(--glass);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 12px;
            cursor: pointer;
            text-align: center;
            transition: all .18s
        }

        .spb:hover {
            background: var(--glass2)
        }

        .spb.sel {
            border-color: var(--accent);
            background: rgba(124, 58, 237, .09)
        }

        .spbi {
            font-size: 18px;
            margin-bottom: 4px
        }

        .spbl {
            font-size: 12px;
            font-weight: 600;
            color: var(--text2);
            display: block
        }

        .spbs {
            font-size: 11px;
            color: var(--muted)
        }

        /* SUMMARY */
        .osum {
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 16px;
            backdrop-filter: blur(12px);
            padding: 22px;
            position: sticky;
            top: 82px
        }

        .os-t {
            font-family: var(--fh);
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 18px
        }

        .os-plat {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, .04);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 16px
        }

        .os-pi {
            font-size: 22px
        }

        .os-pn {
            font-size: 13px;
            font-weight: 600
        }

        .os-ps {
            font-size: 12px;
            color: var(--muted)
        }

        .os-rows {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 18px
        }

        .os-r {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px
        }

        .os-rl {
            color: var(--muted)
        }

        .os-rv {
            font-weight: 600;
            color: var(--text2)
        }

        .os-div {
            height: 1px;
            background: var(--border);
            margin: 14px 0
        }

        .os-tr {
            display: flex;
            justify-content: space-between;
            align-items: baseline
        }

        .os-tl {
            font-size: 13px;
            font-weight: 600;
            color: var(--text)
        }

        .os-tp {
            font-family: var(--fh);
            font-size: 26px;
            font-weight: 600;
            color: var(--neon);
            letter-spacing: -.2px
        }

        .os-bc {
            font-size: 12px;
            color: var(--green);
            margin-top: 6px;
            text-align: right
        }

        .btn-ord {
            width: 100%;
            margin-top: 18px;
            background: linear-gradient(135deg, var(--accent) 0%, #9333ea 50%, var(--accent2) 100%);
            background-size: 200% 200%;
            animation: gs 4s ease infinite;
            border: none;
            border-radius: 12px;
            color: #fff;
            font-family: var(--fh);
            font-size: 15px;
            font-weight: 700;
            padding: 14px;
            cursor: pointer;
            transition: opacity .2s, transform .12s;
            box-shadow: 0 0 28px rgba(124, 58, 237, .32)
        }

        .btn-ord:hover {
            opacity: .9;
            transform: translateY(-2px);
            box-shadow: 0 0 36px rgba(124, 58, 237, .48)
        }

        .btn-ord:disabled {
            opacity: .4;
            cursor: not-allowed;
            transform: none
        }

        @keyframes gs {
            0% {
                background-position: 0% 50%
            }

            50% {
                background-position: 100% 50%
            }

            100% {
                background-position: 0% 50%
            }
        }

        /* ── ORDERS PAGE ── */
        .osts {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 20px
        }

        .ost {
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 16px;
            text-align: center
        }

        .ost-n {
            font-family: var(--fh);
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 4px;
            letter-spacing: -.1px
        }

        .ost-l {
            font-size: 11.5px;
            color: var(--muted)
        }

        .ost.al .ost-n {
            color: var(--text)
        }

        .ost.ac .ost-n {
            color: var(--accent2)
        }

        .ost.ok .ost-n {
            color: var(--green)
        }

        .ost.wt .ost-n {
            color: var(--accent3)
        }

        .ost.er .ost-n {
            color: var(--red)
        }

        .otb {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            flex-wrap: wrap
        }

        .sbox {
            flex: 1;
            min-width: 200px;
            display: flex;
            align-items: center;
            gap: 9px;
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 9px 14px;
            color: var(--muted);
            font-size: 13px;
            transition: border-color .2s
        }

        .sbox:focus-within {
            border-color: rgba(124, 58, 237, .4)
        }

        .sbox input {
            background: none;
            border: none;
            outline: none;
            color: var(--text);
            font-size: 13px;
            font-family: var(--fb);
            flex: 1;
            min-width: 0
        }

        .sbox input::placeholder {
            color: var(--muted)
        }

        .sbox svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0
        }

        .ftabs {
            display: flex;
            gap: 6px;
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 4px
        }

        .ft {
            padding: 6px 14px;
            border-radius: 7px;
            font-size: 12.5px;
            font-weight: 600;
            cursor: pointer;
            color: var(--muted);
            transition: all .18s;
            white-space: nowrap
        }

        .ft.sel {
            background: rgba(124, 58, 237, .2);
            color: var(--neon)
        }

        .ft:hover:not(.sel) {
            color: var(--text2)
        }

        .bico {
            width: 36px;
            height: 36px;
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--muted);
            flex-shrink: 0;
            transition: all .18s
        }

        .bico:hover {
            background: var(--glass2);
            color: var(--text)
        }

        .oft {
            width: 100%;
            border-collapse: collapse
        }

        .oft th {
            padding: 11px 20px;
            text-align: left;
            font-size: 10.5px;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            font-weight: 700;
            background: rgba(255, 255, 255, .02);
            border-bottom: 1px solid var(--border);
            white-space: nowrap
        }

        .oft td {
            padding: 14px 20px;
            font-size: 13px;
            border-bottom: 1px solid rgba(255, 255, 255, .035);
            vertical-align: middle
        }

        .oft tr:last-child td {
            border-bottom: none
        }

        .oft tbody tr {
            transition: background .14s;
            cursor: pointer
        }

        .oft tbody tr:hover td {
            background: rgba(255, 255, 255, .025)
        }

        .oft .num {
            font-size: 12.5px
        }

        .osc {
            display: flex;
            flex-direction: column;
            gap: 3px
        }

        .osn {
            font-size: 13px;
            font-weight: 600;
            color: var(--text)
        }

        .osl {
            font-size: 11.5px;
            color: var(--muted);
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            max-width: 200px
        }

        .tab {
            background: var(--glass);
            border: 1px solid var(--border);
            border-radius: 7px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            cursor: pointer;
            transition: all .15s;
            white-space: nowrap
        }

        .tab:hover {
            background: rgba(124, 58, 237, .12);
            color: var(--neon);
            border-color: rgba(124, 58, 237, .3)
        }

        .tab.dng:hover {
            background: rgba(239, 68, 68, .1);
            color: var(--red);
            border-color: rgba(239, 68, 68, .25)
        }

        .pgn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 22px;
            border-top: 1px solid var(--border)
        }

        .pgi {
            font-size: 12.5px;
            color: var(--muted)
        }

        .pgbs {
            display: flex;
            gap: 4px
        }

        .pgb {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            border: 1px solid transparent;
            color: var(--muted);
            transition: all .15s
        }

        .pgb:hover {
            background: var(--glass2);
            color: var(--text)
        }

        .pgb.sel {
            background: rgba(124, 58, 237, .2);
            border-color: rgba(124, 58, 237, .35);
            color: var(--neon)
        }

        /* SCROLLBAR */
        ::-webkit-scrollbar {
            width: 4px
        }

        ::-webkit-scrollbar-track {
            background: transparent
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, .1);
            border-radius: 4px
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, .18)
        }

        /* ── THEME TOGGLE ── */
        .theme-toggle {
            width: 40px;
            height: 40px;
            background: var(--surface-card);
            border: 1px solid var(--border-subtle);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background var(--dur-base) var(--ease-out),
                        border-color var(--dur-base),
                        transform var(--dur-slow) var(--ease-spring);
            font-size: 15px;
            color: var(--text-secondary);
            flex-shrink: 0
        }

        .theme-toggle:hover {
            background: var(--surface-card-hover);
            border-color: var(--border-default);
            transform: rotate(22deg)
        }

        .theme-toggle:active { transform: rotate(22deg) scale(.92) }

        [data-theme="light"] .theme-toggle {
            color: #d97706;
            border-color: rgba(217,119,6,.25);
            background: rgba(245,158,11,.08)
        }

        [data-theme="dark"] .theme-toggle {
            color: #a5b4fc;
            border-color: rgba(165,180,252,.18);
            background: rgba(165,180,252,.06)
        }

        /* ── I18N ── */
        [data-lang="vi"] [data-en],
        [data-lang="en"] [data-vi] {
            display: none !important
        }

        /* ══════════════════════════════════════
           RESPONSIVE LAYOUT
        ══════════════════════════════════════ */

        /* ── SIDEBAR TOGGLE BTN — always visible ── */
        .sb-toggle {
            display: flex;
            width: 36px;
            height: 36px;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 10px;
            cursor: pointer;
            color: var(--text2);
            font-size: 15px;
            flex-shrink: 0;
            transition: background .18s, color .18s
        }

        .sb-toggle:hover {
            background: var(--glass2);
            color: var(--text)
        }

        /* ── SIDEBAR OVERLAY — mobile only ── */
        .sb-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .5);
            z-index: 149;
            opacity: 0;
            visibility: hidden;
            transition: opacity .28s, visibility .28s
        }

        .sb-overlay.show {
            opacity: 1;
            visibility: visible
        }

        /* ── NPROGRESS ── */
        #nprogress .bar {
            background: linear-gradient(90deg, var(--accent), var(--accent2)) !important;
            height: 3px !important
        }

        #nprogress .peg {
            box-shadow: 0 0 10px var(--neon), 0 0 5px var(--neon) !important
        }

        /* ── TIPPY ── */
        .tippy-box[data-theme~='nexa'] {
            background: rgba(15, 15, 25, .96);
            border: 1px solid var(--border2);
            border-radius: 8px;
            font-size: 12px;
            font-family: var(--fb);
            backdrop-filter: blur(12px)
        }

        .tippy-box[data-theme~='nexa'][data-placement^='top'] > .tippy-arrow::before {
            border-top-color: rgba(15, 15, 25, .96)
        }

        .tippy-box[data-theme~='nexa'][data-placement^='right'] > .tippy-arrow::before {
            border-right-color: rgba(15, 15, 25, .96)
        }

        [data-theme="light"] .tippy-box[data-theme~='nexa'] {
            background: #fff;
            border-color: var(--border);
            color: var(--text)
        }

                /* ══════════════════════════════════════
           DESKTOP ≥ 1025px
           Collapsed via [data-sidebar="collapsed"] on <html>
        ══════════════════════════════════════ */
        @media (min-width: 1025px) {
            [data-sidebar="collapsed"] .sidebar { width: 72px }

            [data-sidebar="collapsed"] .sidebar .nl,
            [data-sidebar="collapsed"] .sidebar .ni span,
            [data-sidebar="collapsed"] .sidebar .sf { opacity: 0; pointer-events: none }

            [data-sidebar="collapsed"] .sidebar .logo {
                justify-content: center; padding-left: 0; padding-right: 0
            }
            [data-sidebar="collapsed"] .sidebar .logo-mark { font-size: 0; gap: 0; justify-content: center }
            [data-sidebar="collapsed"] .sidebar .logo-dot { width: 10px; height: 10px; margin: 0 }

            [data-sidebar="collapsed"] .sidebar .ni {
                padding: 11px 0; justify-content: center;
                margin: 2px 8px; border-left: none; border-radius: var(--radius-md)
            }
            [data-sidebar="collapsed"] .sidebar .ni svg { width: 20px; height: 20px }
            [data-sidebar="collapsed"] .sidebar .ni.active { border-left: none; background: rgba(124,58,237,.15) }
        }

        /* ══════════════════════════════════════
           TABLET 769–1024px — icon sidebar
        ══════════════════════════════════════ */
        @media (min-width: 769px) and (max-width: 1024px) {
            :root { --sw: 72px }
            .sidebar { width: 72px; overflow: visible; padding: 20px 0 }
            .logo { width: 100%; padding: 0 0 18px; display: flex; justify-content: center; border-bottom: 1px solid var(--border-subtle); margin-bottom: 14px }
            .logo-mark { font-size: 0; gap: 0; justify-content: center }
            .logo-dot { width: 10px; height: 10px; margin: 0 }
            .nl { display: none }
            .ni { width: calc(100% - 16px); padding: 10px 0; justify-content: center; border-left: none; border-radius: var(--radius-md); margin: 2px 8px }
            .ni span { display: none }
            .ni svg { width: 20px; height: 20px }
            .ni:hover { background: var(--surface-card-hover); border-left: none }
            .ni.active { background: rgba(124,58,237,.15); border-left: none }
            .sf { display: none }
            .content { padding: var(--sp-5) }
            .sg { grid-template-columns: repeat(2, 1fr) }
            .tc { grid-template-columns: 1fr }
            .opg { grid-template-columns: 1fr }
            .osum { position: static }
        }

        /* ══════════════════════════════════════
           MOBILE ≤ 768px — GPU drawer
        ══════════════════════════════════════ */
        @media (max-width: 768px) {
            :root { --sw: 280px }
            .sidebar {
                position: fixed; left: 0; top: 0; height: 100dvh; width: 280px !important;
                z-index: var(--z-drawer);
                transform: translate3d(-100%, 0, 0);
                transition: transform var(--dur-slow) var(--ease-out);
                overflow-y: auto; overflow-x: hidden; padding: 26px 0;
                will-change: transform
            }
            .sidebar.open { transform: translate3d(0, 0, 0) }
            .sidebar .logo { padding: 0 22px 24px; display: block; text-align: left; width: auto }
            .sidebar .logo-mark { font-size: 21px; gap: 9px; justify-content: flex-start }
            .sidebar .logo-dot { width: 8px; height: 8px; margin-top: 2px }
            .sidebar .nl { display: block }
            .sidebar .ni { width: auto; padding: 10px 22px; justify-content: flex-start; margin: 0; border-radius: 0; border-left: 2px solid transparent }
            .sidebar .ni:hover { border-left-color: var(--border-default) }
            .sidebar .ni.active { border-left-color: var(--brand-neon) }
            .sidebar .ni span { display: inline }
            .sidebar .ni svg { width: 17px; height: 17px }
            .sidebar .sf { display: block }
            .topbar { padding: 0 var(--sp-4) }
            .tsrch { display: none }
            .content { padding: var(--sp-4) }
            .sg { grid-template-columns: repeat(2, 1fr) }
            .tc { grid-template-columns: 1fr }
            .opg { grid-template-columns: 1fr }
            .osum { position: static }
            .osts { grid-template-columns: repeat(3, 1fr) }
            .chart-stats { gap: var(--sp-4) }
        }

        /* ══════════════════════════════════════
           SMALL MOBILE ≤ 480px
        ══════════════════════════════════════ */
        @media (max-width: 480px) {
            .sg { grid-template-columns: repeat(2, 1fr) }
            .osts { grid-template-columns: repeat(2, 1fr) }
            .tbr { gap: var(--sp-2) }
            .nb, .theme-toggle { width: 36px; height: 36px }
            .av { width: 36px; height: 36px; font-size: 13px }
            .lang-dd-btn { padding: 5px 8px }
            .lang-code { display: none }
            .blv { display: none }
            .chart-stats { flex-wrap: wrap; gap: var(--sp-2) }
        }
    </style>
</head>

<body>

    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>
    <canvas id="bg-canvas"></canvas>

    <!-- Sidebar overlay for mobile -->
    <div class="sb-overlay" id="sb-overlay"></div>

    <div class="shell">
        <!-- SIDEBAR -->
        <aside class="sidebar" id="sidebar" role="navigation" aria-label="Main navigation">
            <div class="logo" aria-label="NexaBoost">
                <div class="logo-mark">
                    <div class="logo-dot" aria-hidden="true"></div>NexaBoost
                </div>
            </div>

            <div class="nl" aria-hidden="true"><span data-vi>Menu chính</span><span data-en>Main Menu</span></div>
            <div class="ni active" data-page="dashboard" role="button" tabindex="0" aria-current="page">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="3" y="3" width="7" height="7" rx="1" />
                    <rect x="14" y="3" width="7" height="7" rx="1" />
                    <rect x="3" y="14" width="7" height="7" rx="1" />
                    <rect x="14" y="14" width="7" height="7" rx="1" />
                </svg><span data-vi>Dashboard</span><span data-en>Dashboard</span>
            </div>
            <div class="ni" data-page="order" role="button" tabindex="0">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="9" cy="21" r="1" />
                    <circle cx="20" cy="21" r="1" />
                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                </svg><span data-vi>Đặt dịch vụ</span><span data-en>New Order</span>
            </div>
            <div class="ni" data-page="orders" role="button" tabindex="0">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                </svg><span data-vi>Đơn hàng</span><span data-en>Orders</span>
            </div>
            <div class="ni" data-page="dashboard" role="button" tabindex="0">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="2" y="3" width="20" height="14" rx="2" />
                    <line x1="8" y1="21" x2="16" y2="21" />
                    <line x1="12" y1="17" x2="12" y2="21" />
                </svg><span>API</span>
            </div>
            <div class="ni" data-page="dashboard" role="button" tabindex="0">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M12 2L2 7l10 5 10-5-10-5z" />
                    <path d="M2 17l10 5 10-5" />
                    <path d="M2 12l10 5 10-5" />
                </svg><span data-vi>Dịch vụ</span><span data-en>Services</span>
            </div>
            <div class="ni" data-page="dashboard" role="button" tabindex="0">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <line x1="12" y1="1" x2="12" y2="23" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg><span data-vi>Nạp tiền</span><span data-en>Add Funds</span>
            </div>

            <div class="nl" style="margin-top:14px" aria-hidden="true"><span data-vi>Tài khoản</span><span data-en>Account</span></div>
            <div class="ni" data-page="dashboard" role="button" tabindex="0">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg><span data-vi>Hồ sơ</span><span data-en>Profile</span>
            </div>
            <div class="ni" data-page="dashboard" role="button" tabindex="0">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="3" />
                    <path d="M19.07 4.93A10 10 0 0 1 21 12a10 10 0 0 1-1.93 7.07" />
                    <path d="M4.93 4.93A10 10 0 0 0 3 12a10 10 0 0 0 1.93 7.07" />
                </svg><span data-vi>Cài đặt</span><span data-en>Settings</span>
            </div>

            <div class="sf">
                <div class="bal">
                    <div class="bal-l"><span data-vi>Số dư tài khoản</span><span data-en>Account Balance</span></div>
                    <div class="bal-a">$248.50</div>
                    <div class="bal-s"><span data-vi>↑ +$50.00 hôm nay</span><span data-en>↑ +$50.00 today</span></div>
                </div>
                <button class="btn-tp"><span data-vi>+ Nạp tiền ngay</span><span data-en>+ Add Funds</span></button>
            </div>
        </aside>

        <!-- MAIN -->
        <div class="main">
            <header class="topbar">
                <div class="tbl">
                    <!-- Sidebar toggle button -->
                    <div class="sb-toggle" id="sb-toggle"
                        role="button" tabindex="0"
                        aria-label="Toggle sidebar navigation"
                        aria-expanded="false">
                        <i class="fa-solid fa-bars" aria-hidden="true"></i>
                    </div>
                    <div class="pt" id="topbar-title"><span data-vi>Dashboard</span><span data-en>Dashboard</span></div>
                    <span class="blv">Live</span>
                    <!-- Search LEFT -->
                    <div class="tsrch">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.35-4.35" />
                        </svg>
                        <input type="text" id="topbar-search"
                            data-placeholder-vi="Tìm kiếm..."
                            data-placeholder-en="Search..."
                            placeholder="Tìm kiếm...">
                    </div>
                </div>
                <div class="tbr">
                    <!-- Language Dropdown -->
                    <div class="dd-wrap" id="lang-dd-wrap">
                        <div class="lang-dd-btn" id="lang-dd-btn">
                            <span class="lang-flag" id="lang-flag">🇻🇳</span>
                            <span class="lang-code" id="lang-label">VI</span>
                            <i class="fa-solid fa-chevron-down" id="lang-chevron"></i>
                        </div>
                        <div class="dd-menu lang-dd-menu" id="lang-dd-menu">
                            <div class="lang-dd-header">Language</div>
                            <div class="lang-item active" data-lang-select="vi" data-flag="🇻🇳" data-code="VI">
                                <span class="li-flag">🇻🇳</span>
                                <span>Tiếng Việt</span>
                                <i class="fa-solid fa-check li-check"></i>
                            </div>
                            <div class="lang-item" data-lang-select="en" data-flag="🇺🇸" data-code="EN">
                                <span class="li-flag">🇺🇸</span>
                                <span>English</span>
                                <i class="fa-solid fa-check li-check"></i>
                            </div>
                            <div class="lang-item" data-lang-select="th" data-flag="🇹🇭" data-code="TH">
                                <span class="li-flag">🇹🇭</span>
                                <span>ภาษาไทย</span>
                                <i class="fa-solid fa-check li-check"></i>
                            </div>
                            <div class="lang-item" data-lang-select="zh" data-flag="🇨🇳" data-code="ZH">
                                <span class="li-flag">🇨🇳</span>
                                <span>中文</span>
                                <i class="fa-solid fa-check li-check"></i>
                            </div>
                            <div class="lang-item" data-lang-select="ja" data-flag="🇯🇵" data-code="JA">
                                <span class="li-flag">🇯🇵</span>
                                <span>日本語</span>
                                <i class="fa-solid fa-check li-check"></i>
                            </div>
                            <div class="lang-item" data-lang-select="ko" data-flag="🇰🇷" data-code="KO">
                                <span class="li-flag">🇰🇷</span>
                                <span>한국어</span>
                                <i class="fa-solid fa-check li-check"></i>
                            </div>
                            <div class="lang-item" data-lang-select="es" data-flag="🇪🇸" data-code="ES">
                                <span class="li-flag">🇪🇸</span>
                                <span>Español</span>
                                <i class="fa-solid fa-check li-check"></i>
                            </div>
                            <div class="lang-item" data-lang-select="ar" data-flag="🇸🇦" data-code="AR">
                                <span class="li-flag">🇸🇦</span>
                                <span>العربية</span>
                                <i class="fa-solid fa-check li-check"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Theme Toggle: circle, FA icon -->
                    <div class="theme-toggle" id="theme-toggle"
                        role="button" tabindex="0"
                        aria-label="Toggle light/dark theme">
                        <i class="fa-solid fa-moon" id="theme-icon" aria-hidden="true"></i>
                    </div>
                    <!-- Notification -->
                    <div class="nb" role="button" tabindex="0" aria-label="Notifications">
                        <i class="fa-regular fa-bell" style="font-size:14px" aria-hidden="true"></i>
                        <div class="np" aria-hidden="true"></div>
                    </div>
                    <!-- Avatar Dropdown -->
                    <div class="dd-wrap" id="av-dd-wrap">
                        <div class="av" id="av-btn">T</div>
                        <div class="dd-menu" id="av-dd-menu" style="min-width:180px">
                            <div class="dd-header">user@nexaboost.com</div>
                            <div class="dd-sep"></div>
                            <div class="dd-item" data-page="dashboard">
                                <i class="fa-regular fa-user"></i>
                                <span data-vi>Hồ sơ</span><span data-en>Profile</span>
                            </div>
                            <div class="dd-item" data-page="dashboard">
                                <i class="fa-solid fa-wallet"></i>
                                <span data-vi>Số dư: </span><span data-en>Balance: </span>
                                <strong style="color:var(--neon)">$248.50</strong>
                            </div>
                            <div class="dd-item" data-page="dashboard">
                                <i class="fa-solid fa-gear"></i>
                                <span data-vi>Cài đặt</span><span data-en>Settings</span>
                            </div>
                            <div class="dd-sep"></div>
                            <div class="dd-item" style="color:var(--red)">
                                <i class="fa-solid fa-right-from-bracket" style="color:var(--red)"></i>
                                <span data-vi>Đăng xuất</span><span data-en>Sign out</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- <!-- DASHBOARD -->
            <div class="page active" id="page-dashboard">
                <div class="content">

                    <div class="sg mb22">
                        <div class="sc p">
                            <div class="st">
                                <div class="si p">📦</div><span class="str up">↑ 12%</span>
                            </div>
                            <div class="sv">1,284</div>
                            <div class="sn"><span data-vi>Tổng đơn hàng</span><span data-en>Total Orders</span></div>
                        </div>
                        <div class="sc c">
                            <div class="st">
                                <div class="si c">⚡</div><span class="str up">↑ 8%</span>
                            </div>
                            <div class="sv">47</div>
                            <div class="sn"><span data-vi>Đang xử lý</span><span data-en>Processing</span></div>
                        </div>
                        <div class="sc a">
                            <div class="st">
                                <div class="si a">💰</div><span class="str up">↑ 23%</span>
                            </div>
                            <div class="sv">$3,741</div>
                            <div class="sn"><span data-vi>Doanh thu tháng</span><span data-en>Monthly Revenue</span></div>
                        </div>
                        <div class="sc g">
                            <div class="st">
                                <div class="si g">✅</div><span class="str dn">↓ 2%</span>
                            </div>
                            <div class="sv">98.4%</div>
                            <div class="sn"><span data-vi>Tỷ lệ thành công</span><span data-en>Success Rate</span></div>
                        </div>
                    </div>

                    <div class="panel mb18">
                        <div class="ph">
                            <div class="pt2"><span data-vi>Đơn hàng 7 ngày qua</span><span data-en>Orders Last 7 Days</span></div><span class="pa" data-page="orders"><span data-vi>Xem tất cả →</span><span data-en>View all →</span></span>
                        </div>
                        <!-- Mini stats row -->
                        <div class="chart-stats">
                            <div class="chart-stat">
                                <div style="display:flex;align-items:center;gap:8px">
                                    <div class="chart-stat-v" style="color:var(--neon)">1,284</div>
                                    <span class="chart-stat-d up">↑ 12%</span>
                                </div>
                                <div class="chart-stat-l"><span data-vi>Tổng đơn</span><span data-en>Total orders</span></div>
                            </div>
                            <div class="chart-stat">
                                <div style="display:flex;align-items:center;gap:8px">
                                    <div class="chart-stat-v" style="color:var(--accent2)">$3,741</div>
                                    <span class="chart-stat-d up">↑ 23%</span>
                                </div>
                                <div class="chart-stat-l"><span data-vi>Doanh thu</span><span data-en>Revenue</span></div>
                            </div>
                            <div class="chart-stat">
                                <div style="display:flex;align-items:center;gap:8px">
                                    <div class="chart-stat-v" style="color:var(--green)">98.4%</div>
                                    <span class="chart-stat-d dn">↓ 2%</span>
                                </div>
                                <div class="chart-stat-l"><span data-vi>Thành công</span><span data-en>Success rate</span></div>
                            </div>
                        </div>
                        <div class="cw">
                            <svg class="cs" viewBox="0 0 700 170" xmlns="http://www.w3.org/2000/svg"
                                preserveAspectRatio="none">
                                <defs>
                                    <linearGradient id="cg" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#7c3aed" stop-opacity=".45" />
                                        <stop offset="100%" stop-color="#7c3aed" stop-opacity="0" />
                                    </linearGradient>
                                    <linearGradient id="cg2" x1="0" y1="0" x2="1" y2="0">
                                        <stop offset="0%" stop-color="#7c3aed" />
                                        <stop offset="60%" stop-color="#a855f7" />
                                        <stop offset="100%" stop-color="#06b6d4" />
                                    </linearGradient>
                                    <filter id="glow">
                                        <feGaussianBlur stdDeviation="3" result="blur"/>
                                        <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
                                    </filter>
                                </defs>
                                <!-- Grid lines -->
                                <line x1="0" y1="34" x2="700" y2="34" stroke="rgba(255,255,255,.05)" stroke-width="1" stroke-dasharray="4,4"/>
                                <line x1="0" y1="68" x2="700" y2="68" stroke="rgba(255,255,255,.05)" stroke-width="1" stroke-dasharray="4,4"/>
                                <line x1="0" y1="102" x2="700" y2="102" stroke="rgba(255,255,255,.05)" stroke-width="1" stroke-dasharray="4,4"/>
                                <line x1="0" y1="136" x2="700" y2="136" stroke="rgba(255,255,255,.05)" stroke-width="1" stroke-dasharray="4,4"/>
                                <!-- Area fill -->
                                <path d="M0,130 C50,120 80,100 150,80 C220,60 260,55 300,42 C340,30 370,50 420,58 C470,66 510,20 570,30 C620,38 660,22 700,14 L700,170 L0,170 Z"
                                    fill="url(#cg)" />
                                <!-- Line -->
                                <path d="M0,130 C50,120 80,100 150,80 C220,60 260,55 300,42 C340,30 370,50 420,58 C470,66 510,20 570,30 C620,38 660,22 700,14"
                                    fill="none" stroke="url(#cg2)" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <!-- Dots -->
                                <circle cx="150" cy="80" r="3.5" fill="#7c3aed" opacity=".9"/>
                                <circle cx="300" cy="42" r="3.5" fill="#a855f7" opacity=".9"/>
                                <circle cx="420" cy="58" r="3.5" fill="#a855f7" opacity=".9"/>
                                <circle cx="570" cy="30" r="5" fill="#06b6d4" filter="url(#glow)"/>
                                <circle cx="700" cy="14" r="3.5" fill="#06b6d4" opacity=".9"/>
                            </svg>
                            <div class="cl">
                                <span data-vi>T2</span><span data-en>Mon</span>
                                <span data-vi>T3</span><span data-en>Tue</span>
                                <span data-vi>T4</span><span data-en>Wed</span>
                                <span data-vi>T5</span><span data-en>Thu</span>
                                <span data-vi>T6</span><span data-en>Fri</span>
                                <span data-vi>T7</span><span data-en>Sat</span>
                                <span data-vi>CN</span><span data-en>Sun</span>
                                <span data-vi>Hôm nay</span><span data-en>Today</span>
                            </div>
                        </div>
                    </div>

                    <div class="tc">
                        <div class="panel">
                            <div class="ph">
                                <div class="pt2"><span data-vi>Đơn hàng gần đây</span><span data-en>Recent Orders</span></div><span class="pa" data-page="orders"><span data-vi>Tất cả →</span><span data-en>All →</span></span>
                            </div>
                            <table class="ot">
                                <thead>
                                    <tr>
                                        <th><span data-vi>Dịch vụ</span><span data-en>Service</span></th>
                                        <th><span data-vi>SL</span><span data-en>Qty</span></th>
                                        <th><span data-vi>Tiến độ</span><span data-en>Progress</span></th>
                                        <th><span data-vi>TT</span><span data-en>Status</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="sb ig">📸 IG Likes</span></td>
                                        <td class="num">5,000</td>
                                        <td>
                                            <div class="pb">
                                                <div class="pb-i" style="width:92%"></div>
                                            </div>
                                        </td>
                                        <td><span class="sp ac">Active</span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="sb yt">▶ YT Views</span></td>
                                        <td class="num">20,000</td>
                                        <td>
                                            <div class="pb">
                                                <div class="pb-i" style="width:100%"></div>
                                            </div>
                                        </td>
                                        <td><span class="sp ok"><span data-vi>Xong</span><span data-en>Done</span></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="sb tt">♪ TikTok Flw</span></td>
                                        <td class="num">1,500</td>
                                        <td>
                                            <div class="pb">
                                                <div class="pb-i" style="width:45%"></div>
                                            </div>
                                        </td>
                                        <td><span class="sp wt"><span data-vi>Chờ</span><span data-en>Pending</span></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="sb fb">f FB Boost</span></td>
                                        <td class="num">3,000</td>
                                        <td>
                                            <div class="pb">
                                                <div class="pb-i" style="width:100%"></div>
                                            </div>
                                        </td>
                                        <td><span class="sp ok"><span data-vi>Xong</span><span data-en>Done</span></span></td>
                                    </tr>
                                    <tr>
                                        <td><span class="sb tw">✦ X Retweets</span></td>
                                        <td class="num">800</td>
                                        <td>
                                            <div class="pb">
                                                <div class="pb-i" style="width:10%"></div>
                                            </div>
                                        </td>
                                        <td><span class="sp er"><span data-vi>Lỗi</span><span data-en>Error</span></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="panel">
                            <div class="ph">
                                <div class="pt2"><span data-vi>Hoạt động gần đây</span><span data-en>Recent Activity</span></div><span class="pa"><span data-vi>Tất cả →</span><span data-en>All →</span></span>
                            </div>
                            <div class="al">
                                <div class="ai">
                                    <div class="ad or">📦</div>
                                    <div>
                                        <div class="at"><span data-vi>Đơn <strong>#2841</strong> — IG Followers 5,000 đã tạo</span><span data-en>Order <strong>#2841</strong> — IG Followers 5,000 created</span></div>
                                        <div class="atm"><span data-vi>2 phút trước</span><span data-en>2 minutes ago</span></div>
                                    </div>
                                </div>
                                <div class="ai">
                                    <div class="ad py">💰</div>
                                    <div>
                                        <div class="at"><span data-vi>Nạp <strong>$50.00</strong> qua USDT thành công</span><span data-en>Deposited <strong>$50.00</strong> via USDT successfully</span></div>
                                        <div class="atm"><span data-vi>18 phút trước</span><span data-en>18 minutes ago</span></div>
                                    </div>
                                </div>
                                <div class="ai">
                                    <div class="ad dn">✅</div>
                                    <div>
                                        <div class="at"><span data-vi>Đơn <strong>#2836</strong> — YT Views 20,000 hoàn tất</span><span data-en>Order <strong>#2836</strong> — YT Views 20,000 completed</span></div>
                                        <div class="atm"><span data-vi>1 giờ trước</span><span data-en>1 hour ago</span></div>
                                    </div>
                                </div>
                                <div class="ai">
                                    <div class="ad wn">⚠️</div>
                                    <div>
                                        <div class="at"><span data-vi>Đơn <strong>#2830</strong> — X Retweets lỗi, đang hoàn tiền</span><span data-en>Order <strong>#2830</strong> — X Retweets error, refunding</span></div>
                                        <div class="atm"><span data-vi>3 giờ trước</span><span data-en>3 hours ago</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- <!-- ĐẶT DỊCH VỤH VỤ -->
            <div class="page" id="page-order">
                <div class="content">
                    <div class="opg">

                        <!-- LEFT -->
                        <div>
                            <!-- Nền tảng -->
                            <div class="panel mb18">
                                <div class="ph">
                                    <div class="pt2"><span data-vi>① Chọn nền tảng</span><span data-en>① Select Platform</span></div>
                                </div>
                                <div style="padding:20px">
                                    <div class="platg">
                                        <div class="pb2 sel" data-plat="ig">
                                            <div class="pi">📸</div>
                                            <div class="pn">Instagram</div>
                                        </div>
                                        <div class="pb2" data-plat="yt">
                                            <div class="pi">▶️</div>
                                            <div class="pn">YouTube</div>
                                        </div>
                                        <div class="pb2" data-plat="tt">
                                            <div class="pi">🎵</div>
                                            <div class="pn">TikTok</div>
                                        </div>
                                        <div class="pb2" data-plat="fb">
                                            <div class="pi">📘</div>
                                            <div class="pn">Facebook</div>
                                        </div>
                                        <div class="pb2" data-plat="tw">
                                            <div class="pi">✦</div>
                                            <div class="pn">X (Twitter)</div>
                                        </div>
                                        <div class="pb2" data-plat="li">
                                            <div class="pi">💼</div>
                                            <div class="pn">LinkedIn</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dịch vụ -->
                            <div class="panel mb18">
                                <div class="ph">
                                    <div class="pt2"><span data-vi>② Chọn loại dịch vụ</span><span data-en>② Select Service</span></div>
                                </div>
                                <div style="padding:20px">
                                    <div class="svl">
                                        <div class="sr sel" data-rate="0.80"
                                            data-svc-vi="Followers à Real &amp; Active"
                                            data-svc-en="Followers à Real &amp; Active">
                                            <div class="srd"></div>
                                            <div class="srin">
                                                <div class="srin-n">👥 Followers à Real &amp; Active</div>
                                                <div class="srin-d"><span data-vi>Người theo dài thật, tốc độ tự nhiên, khàng drop</span><span data-en>Real followers, natural speed, no drop</span></div>
                                            </div>
                                            <div>
                                                <div class="srp">$0.80</div>
                                                <div class="srq">/ 1,000</div>
                                            </div>
                                        </div>
                                        <div class="sr" data-rate="0.40"
                                            data-svc-vi="Likes à High Quality"
                                            data-svc-en="Likes à High Quality">
                                            <div class="srd"></div>
                                            <div class="srin">
                                                <div class="srin-n">❤️ Likes à High Quality</div>
                                                <div class="srin-d"><span data-vi>Lượt thàch chất lượng cao, giao nhanh trong 1à6h</span><span data-en>High quality likes, delivered in 1à6h</span></div>
                                            </div>
                                            <div>
                                                <div class="srp">$0.40</div>
                                                <div class="srq">/ 1,000</div>
                                            </div>
                                        </div>
                                        <div class="sr" data-rate="0.20"
                                            data-svc-vi="Views à Mix Traffic"
                                            data-svc-en="Views à Mix Traffic">
                                            <div class="srd"></div>
                                            <div class="srin">
                                                <div class="srin-n">à Views à Mix Traffic</div>
                                                <div class="srin-d"><span data-vi>Lượt xem pha trộn, phà hợp Reels &amp; Video</span><span data-en>Mixed traffic views, suitable for Reels &amp; Video</span></div>
                                            </div>
                                            <div>
                                                <div class="srp">$0.20</div>
                                                <div class="srq">/ 1,000</div>
                                            </div>
                                        </div>
                                        <div class="sr" data-rate="2.50"
                                            data-svc-vi="Comments à Custom"
                                            data-svc-en="Comments à Custom">
                                            <div class="srd"></div>
                                            <div class="srin">
                                                <div class="srin-n">💬 Comments à Custom</div>
                                                <div class="srin-d"><span data-vi>Bành luận tuỳ chỉnh nội dung theo yàu cầu</span><span data-en>Custom comments per your request</span></div>
                                            </div>
                                            <div>
                                                <div class="srp">$2.50</div>
                                                <div class="srq">/ 100</div>
                                            </div>
                                        </div>
                                        <div class="sr" data-rate="1.20"
                                            data-svc-vi="Shares à Viral Boost"
                                            data-svc-en="Shares à Viral Boost">
                                            <div class="srd"></div>
                                            <div class="srin">
                                                <div class="srin-n">🔄 Shares à Viral Boost</div>
                                                <div class="srin-d"><span data-vi>Chia sẻ chào nền tảng, tăng viral tự nhiên</span><span data-en>Cross-platform shares, natural viral growth</span></div>
                                            </div>
                                            <div>
                                                <div class="srp">$1.20</div>
                                                <div class="srq">/ 1,000</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Chi tiết -->
                            <div class="panel mb18">
                                <div class="ph">
                                    <div class="pt2"><span data-vi>③ Thàng tin chi tiết</span><span data-en>③ Order Details</span></div>
                                </div>
                                <div style="padding:20px">
                                    <div class="fr">
                                        <label class="fl"><span data-vi>Link bài đăng / trang</span><span data-en>Post / Page Link</span></label>
                                        <input class="fi mn" type="url"
                                            placeholder="https://instagram.com/p/...">
                                        <div class="fh2"><span data-vi>Dàn link công khai của bài đăng hoặc trang bạn muốn tăng tương tàc.</span><span data-en>Paste the public link of the post or page you want to boost.</span></div>
                                    </div>

                                    <div class="fst"><span data-vi>Số lượng &amp; tốc độ</span><span data-en>Quantity &amp; Speed</span></div>
                                    <div class="fr">
                                        <label class="fl"><span data-vi>Số lượng</span><span data-en>Quantity</span></label>
                                        <input class="fi mn" id="qty-input" type="number" value="5000"
                                            min="100" max="100000" step="100">
                                        <input class="qs" id="qty-slider" type="range" min="100"
                                            max="50000" value="5000" step="100">
                                        <div class="qmm"><span>100</span><span
                                                id="qty-display">5,000</span><span>50,000</span></div>
                                    </div>
                                    <div class="fr">
                                        <label class="fl"><span data-vi>Tốc độ giao hàng</span><span data-en>Delivery Speed</span></label>
                                        <div class="spg">
                                            <div class="spb sel" data-speed="fast">
                                                <div class="spbi">⚡</div>
                                                <span class="spbl"><span data-vi>Nhanh</span><span data-en>Fast</span></span>
                                                <div class="spbs"><span data-vi>1à6 giờ</span><span data-en>1à6 hours</span></div>
                                            </div>
                                            <div class="spb" data-speed="slow">
                                                <div class="spbi">🌱</div>
                                                <span class="spbl"><span data-vi>Tự nhiên</span><span data-en>Natural</span></span>
                                                <div class="spbs"><span data-vi>1à7 ngày</span><span data-en>1à7 days</span></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="fst"><span data-vi>Ghi chà (tuỳ chọn)</span><span data-en>Notes (optional)</span></div>
                                    <div class="fr">
                                        <textarea class="fta" data-placeholder-vi="Và dụ: giao tự nhiên, khàng giao từ 12hà14h, ưu tiàn tài khoản VN..." data-placeholder-en="E.g.: natural delivery, avoid 12pmà2pm, prioritize VN accounts..." placeholder="Và dụ: giao tự nhiên, khàng giao từ 12hà14h, ưu tiàn tài khoản VN..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- RIGHT: SUMMARY -->
                        <div class="osum">
                            <div class="os-t"><span data-vi>Tìm tắt đơn hàng</span><span data-en>Order Summary</span></div>
                            <div class="os-plat">
                                <div class="os-pi" id="sum-icon">📸</div>
                                <div>
                                    <div class="os-pn" id="sum-plat">Instagram</div>
                                    <div class="os-ps" id="sum-svc">Followers à Real &amp; Active</div>
                                </div>
                            </div>
                            <div class="os-rows">
                                <div class="os-r"><span class="os-rl"><span data-vi>Số lượng</span><span data-en>Quantity</span></span><span class="os-rv" id="sum-qty">5,000</span></div>
                                <div class="os-r"><span class="os-rl"><span data-vi>Đơn già</span><span data-en>Unit Price</span></span><span class="os-rv" id="sum-rate">$0.80 / 1,000</span></div>
                                <div class="os-r"><span class="os-rl"><span data-vi>Tốc độ</span><span data-en>Speed</span></span><span class="os-rv" id="sum-speed">⚡ <span data-vi>Nhanh (1à6h)</span><span data-en>Fast (1à6h)</span></span></div>
                                <div class="os-r"><span class="os-rl"><span data-vi>Bảo hành</span><span data-en>Warranty</span></span><span class="os-rv" style="color:var(--green)">✅ <span data-vi>30 ngày</span><span data-en>30 days</span></span></div>
                            </div>
                            <div class="os-div"></div>
                            <div class="os-tr">
                                <span class="os-tl"><span data-vi>Tổng thanh toàn</span><span data-en>Total</span></span>
                                <span class="os-tp" id="sum-price">$4.00</span>
                            </div>
                            <div class="os-bc">✓ <span data-vi>Số dư đủ ($248.50)</span><span data-en>Balance sufficient ($248.50)</span></div>
                            <button class="btn-ord" id="btn-place-order">🚀 <span data-vi>Xác nhận đặt hàng</span><span data-en>Place Order</span></button>
                            <div
                                style="margin-top:18px;padding-top:16px;border-top:1px solid var(--border);font-size:11.5px;color:var(--muted);line-height:1.7;text-align:center">
                                <span data-vi>🔒 Bảo mật thanh toàn à Hoàn tiền nếu khàng giao<br>Hỗ trợ 24/7 qua Telegram &amp; Live Chat</span>
                                <span data-en>🔒 Secure payment à Refund if not delivered<br>24/7 support via Telegram &amp; Live Chat</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- <!-- ĐƠN HÀNG -->
            <div class="page" id="page-orders">
                <div class="content">

                    <div class="osts">
                        <div class="ost al">
                            <div class="ost-n">1,284</div>
                            <div class="ost-l"><span data-vi>Tất cả</span><span data-en>All</span></div>
                        </div>
                        <div class="ost ac">
                            <div class="ost-n">47</div>
                            <div class="ost-l"><span data-vi>Đang chạy</span><span data-en>Active</span></div>
                        </div>
                        <div class="ost ok">
                            <div class="ost-n">1,196</div>
                            <div class="ost-l"><span data-vi>Hoàn tất</span><span data-en>Completed</span></div>
                        </div>
                        <div class="ost wt">
                            <div class="ost-n">28</div>
                            <div class="ost-l"><span data-vi>Chờ xử lý</span><span data-en>Pending</span></div>
                        </div>
                        <div class="ost er">
                            <div class="ost-n">13</div>
                            <div class="ost-l"><span data-vi>Lỗi / Hoàn</span><span data-en>Error / Refund</span></div>
                        </div>
                    </div>

                    <div class="otb">
                        <div class="sbox">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.35-4.35" />
                            </svg>
                            <input type="text" data-placeholder-vi="Tìm theo mà đơn, link, dịch vụ..." data-placeholder-en="Search by order ID, link, service..." placeholder="Tìm theo mà đơn, link, dịch vụ...">
                        </div>
                        <div class="ftabs">
                            <div class="ft sel"><span data-vi>Tất cả</span><span data-en>All</span></div>
                            <div class="ft">Active</div>
                            <div class="ft"><span data-vi>Hoàn tất</span><span data-en>Completed</span></div>
                            <div class="ft"><span data-vi>Chờ xử lý</span><span data-en>Pending</span></div>
                            <div class="ft"><span data-vi>Lỗi</span><span data-en>Error</span></div>
                        </div>
                        <div class="bico" title="Lọc / Filter"><svg width="15" height="15" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <line x1="4" y1="6" x2="20" y2="6" />
                                <line x1="8" y1="12" x2="16" y2="12" />
                                <line x1="11" y1="18" x2="13" y2="18" />
                            </svg></div>
                        <div class="bico" title="Export CSV"><svg width="15" height="15" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" y1="15" x2="12" y2="3" />
                            </svg></div>
                    </div>

                    <div class="panel">
                        <table class="oft">
                            <thead>
                                <tr>
                                    <th><span data-vi>Mà đơn</span><span data-en>Order ID</span></th>
                                    <th><span data-vi>Ngày tạo</span><span data-en>Date</span></th>
                                    <th><span data-vi>Dịch vụ &amp; Link</span><span data-en>Service &amp; Link</span></th>
                                    <th><span data-vi>Số lượng</span><span data-en>Qty</span></th>
                                    <th><span data-vi>Đã giao</span><span data-en>Delivered</span></th>
                                    <th><span data-vi>Tiến độ</span><span data-en>Progress</span></th>
                                    <th><span data-vi>Chi phà</span><span data-en>Cost</span></th>
                                    <th><span data-vi>Trạng thài</span><span data-en>Status</span></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="oid">#2841</td>
                                    <td class="num" style="color:var(--muted);font-size:12px">09/05 14:32</td>
                                    <td>
                                        <div class="osc">
                                            <div class="osn"><span class="sb ig" style="margin-right:5px">📸
                                                    IG</span>Followers</div>
                                            <div class="osl">instagram.com/p/nexaboost_demo</div>
                                        </div>
                                    </td>
                                    <td class="num">5,000</td>
                                    <td class="num">4,600</td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="pb" style="min-width:70px">
                                                <div class="pb-i" style="width:92%"></div>
                                            </div><span class="num"
                                                style="font-size:11.5px;color:var(--muted)">92%</span>
                                        </div>
                                    </td>
                                    <td class="num" style="color:var(--text2)">$4.00</td>
                                    <td><span class="sp ac">Active</span></td>
                                    <td><button class="tab"><span data-vi>Xem</span><span data-en>View</span></button></td>
                                </tr>
                                <tr>
                                    <td class="oid">#2840</td>
                                    <td class="num" style="color:var(--muted);font-size:12px">09/05 11:18</td>
                                    <td>
                                        <div class="osc">
                                            <div class="osn"><span class="sb yt" style="margin-right:5px">▶
                                                    YT</span>Views</div>
                                            <div class="osl">youtube.com/watch?v=dQw4w9WgXcQ</div>
                                        </div>
                                    </td>
                                    <td class="num">20,000</td>
                                    <td class="num">20,000</td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="pb" style="min-width:70px">
                                                <div class="pb-i" style="width:100%"></div>
                                            </div><span class="num"
                                                style="font-size:11.5px;color:var(--green)">100%</span>
                                        </div>
                                    </td>
                                    <td class="num" style="color:var(--text2)">$4.00</td>
                                    <td><span class="sp ok"><span data-vi>Hoàn tất</span><span data-en>Completed</span></span></td>
                                    <td><button class="tab"><span data-vi>Xem</span><span data-en>View</span></button></td>
                                </tr>
                                <tr>
                                    <td class="oid">#2839</td>
                                    <td class="num" style="color:var(--muted);font-size:12px">09/05 09:44</td>
                                    <td>
                                        <div class="osc">
                                            <div class="osn"><span class="sb tt" style="margin-right:5px">♪
                                                    TT</span>Followers</div>
                                            <div class="osl">tiktok.com/@nexaboost</div>
                                        </div>
                                    </td>
                                    <td class="num">1,500</td>
                                    <td class="num">675</td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="pb" style="min-width:70px">
                                                <div class="pb-i" style="width:45%"></div>
                                            </div><span class="num"
                                                style="font-size:11.5px;color:var(--muted)">45%</span>
                                        </div>
                                    </td>
                                    <td class="num" style="color:var(--text2)">$1.20</td>
                                    <td><span class="sp wt"><span data-vi>Chờ xử lý</span><span data-en>Pending</span></span></td>
                                    <td><button class="tab dng"><span data-vi>Huỷ</span><span data-en>Cancel</span></button></td>
                                </tr>
                                <tr>
                                    <td class="oid">#2838</td>
                                    <td class="num" style="color:var(--muted);font-size:12px">08/05 22:10</td>
                                    <td>
                                        <div class="osc">
                                            <div class="osn"><span class="sb fb" style="margin-right:5px">f
                                                    FB</span>Likes</div>
                                            <div class="osl">facebook.com/posts/987654321</div>
                                        </div>
                                    </td>
                                    <td class="num">3,000</td>
                                    <td class="num">3,000</td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="pb" style="min-width:70px">
                                                <div class="pb-i" style="width:100%"></div>
                                            </div><span class="num"
                                                style="font-size:11.5px;color:var(--green)">100%</span>
                                        </div>
                                    </td>
                                    <td class="num" style="color:var(--text2)">$1.20</td>
                                    <td><span class="sp ok"><span data-vi>Hoàn tất</span><span data-en>Completed</span></span></td>
                                    <td><button class="tab"><span data-vi>Xem</span><span data-en>View</span></button></td>
                                </tr>
                                <tr>
                                    <td class="oid">#2837</td>
                                    <td class="num" style="color:var(--muted);font-size:12px">08/05 18:55</td>
                                    <td>
                                        <div class="osc">
                                            <div class="osn"><span class="sb tw" style="margin-right:5px">✦
                                                    X</span>Retweets</div>
                                            <div class="osl">x.com/nexaboost/status/12345</div>
                                        </div>
                                    </td>
                                    <td class="num">800</td>
                                    <td class="num">80</td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="pb" style="min-width:70px">
                                                <div class="pb-i"
                                                    style="width:10%;background:linear-gradient(90deg,var(--red),#ff6b6b)">
                                                </div>
                                            </div><span class="num"
                                                style="font-size:11.5px;color:var(--red)">10%</span>
                                        </div>
                                    </td>
                                    <td class="num" style="color:var(--text2)">$0.96</td>
                                    <td><span class="sp er"><span data-vi>Lỗi</span><span data-en>Error</span></span></td>
                                    <td><button class="tab"><span data-vi>Hoàn tiền</span><span data-en>Refund</span></button></td>
                                </tr>
                                <tr>
                                    <td class="oid">#2836</td>
                                    <td class="num" style="color:var(--muted);font-size:12px">08/05 10:20</td>
                                    <td>
                                        <div class="osc">
                                            <div class="osn"><span class="sb ig" style="margin-right:5px">📸
                                                    IG</span>Views à Reels</div>
                                            <div class="osl">instagram.com/reel/ABCDEF123</div>
                                        </div>
                                    </td>
                                    <td class="num">50,000</td>
                                    <td class="num">50,000</td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="pb" style="min-width:70px">
                                                <div class="pb-i" style="width:100%"></div>
                                            </div><span class="num"
                                                style="font-size:11.5px;color:var(--green)">100%</span>
                                        </div>
                                    </td>
                                    <td class="num" style="color:var(--text2)">$10.00</td>
                                    <td><span class="sp ok"><span data-vi>Hoàn tất</span><span data-en>Completed</span></span></td>
                                    <td><button class="tab"><span data-vi>Đặt lại</span><span data-en>Reorder</span></button></td>
                                </tr>
                                <tr>
                                    <td class="oid">#2835</td>
                                    <td class="num" style="color:var(--muted);font-size:12px">07/05 16:08</td>
                                    <td>
                                        <div class="osc">
                                            <div class="osn"><span class="sb li" style="margin-right:5px">💼
                                                    LI</span>Followers</div>
                                            <div class="osl">linkedin.com/in/nexaboost</div>
                                        </div>
                                    </td>
                                    <td class="num">2,000</td>
                                    <td class="num">2,000</td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="pb" style="min-width:70px">
                                                <div class="pb-i" style="width:100%"></div>
                                            </div><span class="num"
                                                style="font-size:11.5px;color:var(--green)">100%</span>
                                        </div>
                                    </td>
                                    <td class="num" style="color:var(--text2)">$1.60</td>
                                    <td><span class="sp ok"><span data-vi>Hoàn tất</span><span data-en>Completed</span></span></td>
                                    <td><button class="tab"><span data-vi>Xem</span><span data-en>View</span></button></td>
                                </tr>
                                <tr>
                                    <td class="oid">#2834</td>
                                    <td class="num" style="color:var(--muted);font-size:12px">07/05 09:30</td>
                                    <td>
                                        <div class="osc">
                                            <div class="osn"><span class="sb tt" style="margin-right:5px">♪
                                                    TT</span>Likes</div>
                                            <div class="osl">tiktok.com/@demo/video/78901</div>
                                        </div>
                                    </td>
                                    <td class="num">10,000</td>
                                    <td class="num">10,000</td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:8px">
                                            <div class="pb" style="min-width:70px">
                                                <div class="pb-i" style="width:100%"></div>
                                            </div><span class="num"
                                                style="font-size:11.5px;color:var(--green)">100%</span>
                                        </div>
                                    </td>
                                    <td class="num" style="color:var(--text2)">$4.00</td>
                                    <td><span class="sp rf"><span data-vi>Đã hoàn</span><span data-en>Refunded</span></span></td>
                                    <td><button class="tab"><span data-vi>Xem</span><span data-en>View</span></button></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pgn">
                            <div class="pgi"><span data-vi>Hiển thị 1à8 / 1,284 đơn hàng</span><span data-en>Showing 1à8 of 1,284 orders</span></div>
                            <div class="pgbs">
                                <div class="pgb">à</div>
                                <div class="pgb sel">1</div>
                                <div class="pgb">2</div>
                                <div class="pgb">3</div>
                                <div class="pgb" style="letter-spacing:1px;color:var(--muted)"></div>
                                <div class="pgb">161</div>
                                <div class="pgb">à</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div><!-- /main -->
    </div><!-- /shell -->


    <script>
        /* ── PARTICLES ── */
        const cv = document.getElementById('bg-canvas'),
            cx = cv.getContext('2d');

        function rsz() { cv.width = innerWidth; cv.height = innerHeight }
        rsz();
        addEventListener('resize', rsz);
        const C = ['rgba(124,58,237,', 'rgba(6,182,212,', 'rgba(168,85,247,', 'rgba(245,158,11,'];
        const pts = Array.from({ length: 75 }, () => ({
            x: Math.random() * innerWidth, y: Math.random() * innerHeight,
            r: Math.random() * 1.7 + .3, vx: (Math.random() - .5) * .28,
            vy: (Math.random() - .5) * .28 - .08, a: Math.random() * .48 + .1,
            c: C[Math.random() * 4 | 0], p: Math.random() * Math.PI * 2,
            ps: Math.random() * .022 + .008
        }));
        const gls = Array.from({ length: 10 }, () => ({
            x: Math.random() * innerWidth, y: Math.random() * innerHeight,
            r: Math.random() * 3 + 1.5, vx: (Math.random() - .5) * .14,
            vy: (Math.random() - .5) * .14, a: Math.random() * .22 + .04,
            c: C[Math.random() * 4 | 0], p: Math.random() * Math.PI * 2,
            ps: Math.random() * .012 + .004
        }));

        function drw() {
            cx.clearRect(0, 0, cv.width, cv.height);
            const W = cv.width, H = cv.height;
            for (let i = 0; i < pts.length; i++)
                for (let j = i + 1; j < pts.length; j++) {
                    const dx = pts[i].x - pts[j].x, dy = pts[i].y - pts[j].y,
                        d = Math.sqrt(dx * dx + dy * dy);
                    if (d < 95) {
                        cx.beginPath();
                        cx.strokeStyle = `rgba(124,58,237,${.055 * (1 - d / 95)})`;
                        cx.lineWidth = .5;
                        cx.moveTo(pts[i].x, pts[i].y);
                        cx.lineTo(pts[j].x, pts[j].y);
                        cx.stroke()
                    }
                }
            for (const p of gls) {
                p.p += p.ps;
                const a = p.a + Math.sin(p.p) * .055, r = p.r + Math.sin(p.p * 1.3) * .7;
                const g = cx.createRadialGradient(p.x, p.y, 0, p.x, p.y, r * 6);
                g.addColorStop(0, p.c + Math.min(a * 2, 1) + ')');
                g.addColorStop(1, p.c + '0)');
                cx.beginPath(); cx.fillStyle = g;
                cx.arc(p.x, p.y, r * 6, 0, Math.PI * 2); cx.fill();
                p.x += p.vx; p.y += p.vy;
                if (p.x < -20) p.x = W + 20; if (p.x > W + 20) p.x = -20;
                if (p.y < -20) p.y = H + 20; if (p.y > H + 20) p.y = -20;
            }
            for (const p of pts) {
                p.p += p.ps;
                const a = p.a + Math.sin(p.p) * .08;
                cx.beginPath(); cx.fillStyle = p.c + a + ')';
                cx.arc(p.x, p.y, p.r, 0, Math.PI * 2); cx.fill();
                p.x += p.vx; p.y += p.vy;
                if (p.x < -5) p.x = W + 5; if (p.x > W + 5) p.x = -5;
                if (p.y < -5) p.y = H + 5; if (p.y > H + 5) p.y = -5;
            }
            requestAnimationFrame(drw);
        }
        drw();

        /* ── LANG ── */
        function getLang() {
            return document.documentElement.getAttribute('data-lang') || 'vi';
        }

        function applyLang(lang) {
            document.documentElement.setAttribute('data-lang', lang);
            document.documentElement.setAttribute('lang', lang);
            // Update button: flag + code
            const sel = document.querySelector('[data-lang-select="' + lang + '"]');
            if (sel) {
                const flag = sel.dataset.flag || '';
                const code = sel.dataset.code || lang.toUpperCase();
                const flagEl = document.getElementById('lang-flag');
                const labelEl = document.getElementById('lang-label');
                if (flagEl) flagEl.textContent = flag;
                if (labelEl) labelEl.textContent = code;
            }
            // Update active state
            document.querySelectorAll('.lang-item').forEach(el => {
                el.classList.toggle('active', el.dataset.langSelect === lang);
            });
            // Update placeholders
            document.querySelectorAll('[data-placeholder-vi],[data-placeholder-en]').forEach(el => {
                const ph = el.dataset['placeholder' + (lang === 'vi' ? 'Vi' : 'En')];
                if (ph) el.placeholder = ph;
            });
            localStorage.setItem('nexaLang', lang);
        }

        // Lang dropdown toggle
        const langWrap = document.getElementById('lang-dd-wrap');
        const langBtn = document.getElementById('lang-dd-btn');
        /* ── AVATAR DROPDOWN ── */
        const avWrap = document.getElementById('av-dd-wrap');
        const avBtn = document.getElementById('av-btn');

        if (langBtn) {
            langBtn.addEventListener('click', e => {
                e.stopPropagation();
                const isOpen = langWrap.classList.toggle('open');
                const chevron = document.getElementById('lang-chevron');
                if (chevron) chevron.className = isOpen ? 'fa-solid fa-chevron-up' : 'fa-solid fa-chevron-down';
                if (avWrap) avWrap.classList.remove('open');
            });
        }
        document.querySelectorAll('.lang-item').forEach(el => {
            el.addEventListener('click', () => {
                applyLang(el.dataset.langSelect);
                langWrap.classList.remove('open');
                const chevron = document.getElementById('lang-chevron');
                if (chevron) chevron.className = 'fa-solid fa-chevron-down';
            });
        });

        /* ── THEME ── */
        const themeBtn = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');

        function applyTheme(theme) {
            document.documentElement.setAttribute('data-theme', theme);
            if (themeIcon) {
                themeIcon.className = theme === 'dark' ? 'fa-solid fa-moon' : 'fa-solid fa-sun';
            }
            localStorage.setItem('nexaTheme', theme);
        }

        themeBtn.addEventListener('click', () => {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            applyTheme(isDark ? 'light' : 'dark');
        });

        if (avBtn) {
            avBtn.addEventListener('click', e => {
                e.stopPropagation();
                avWrap.classList.toggle('open');
                if (langWrap) langWrap.classList.remove('open');
            });
        }

        // Close all dropdowns on outside click
        document.addEventListener('click', () => {
            if (avWrap) avWrap.classList.remove('open');
            if (langWrap) {
                langWrap.classList.remove('open');
                const chevron = document.getElementById('lang-chevron');
                if (chevron) chevron.className = 'fa-solid fa-chevron-down';
            }
        });

        /* ── NAV ── */
        const PG = {
            dashboard: { vi: 'Dashboard', en: 'Dashboard' },
            order: { vi: 'Dat dich vu', en: 'New Order' },
            orders: { vi: 'Don hang', en: 'Orders' }
        };

        function goTo(id) {
            document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.ni').forEach(n => n.classList.remove('active'));
            const pg = document.getElementById('page-' + id);
            if (pg) pg.classList.add('active');
            document.querySelectorAll('.ni[data-page="' + id + '"]').forEach(n => n.classList.add('active'));
            // Close dropdowns on nav
            if (avWrap) avWrap.classList.remove('open');
            if (langWrap) langWrap.classList.remove('open');
        }
        document.querySelectorAll('[data-page]').forEach(el => el.addEventListener('click', () => goTo(el.dataset.page)));

        /* ── PLATFORM ── */
        const PI = { ig: '\uD83D\uDCF8', yt: '\u25B6\uFE0F', tt: '\uD83C\uDFB5', fb: '\uD83D\uDCD8', tw: '\u2726', li: '\uD83D\uDCBC' };
        const PN = { ig: 'Instagram', yt: 'YouTube', tt: 'TikTok', fb: 'Facebook', tw: 'X (Twitter)', li: 'LinkedIn' };
        document.querySelectorAll('.pb2').forEach(b => b.addEventListener('click', () => {
            document.querySelectorAll('.pb2').forEach(x => x.classList.remove('sel'));
            b.classList.add('sel');
            document.getElementById('sum-icon').textContent = PI[b.dataset.plat];
            document.getElementById('sum-plat').textContent = PN[b.dataset.plat];
        }));

        /* ── SERVICE ── */
        let curRate = 0.80;
        document.querySelectorAll('.sr').forEach(r => r.addEventListener('click', () => {
            document.querySelectorAll('.sr').forEach(x => x.classList.remove('sel'));
            r.classList.add('sel');
            curRate = parseFloat(r.dataset.rate);
            const lang = getLang();
            const svcKey = 'svc' + lang.charAt(0).toUpperCase() + lang.slice(1);
            document.getElementById('sum-svc').textContent = r.dataset[svcKey] || r.dataset.svcVi;
            document.getElementById('sum-rate').textContent = '$' + curRate.toFixed(2) + ' / 1,000';
            calcPrice();
        }));

        /* ── SPEED ── */
        document.querySelectorAll('.spb').forEach(b => b.addEventListener('click', () => {
            document.querySelectorAll('.spb').forEach(x => x.classList.remove('sel'));
            b.classList.add('sel');
            const lang = getLang();
            if (b.dataset.speed === 'fast') {
                document.getElementById('sum-speed').textContent = lang === 'vi' ? '\u26A1 Nhanh (1\u20136h)' : '\u26A1 Fast (1\u20136h)';
            } else {
                document.getElementById('sum-speed').textContent = lang === 'vi' ? '\uD83C\uDF31 Tu nhien (1\u20137 ngay)' : '\uD83C\uDF31 Natural (1\u20137 days)';
            }
        }));

        /* ── QTY ── */
        const qi = document.getElementById('qty-input'),
            qs2 = document.getElementById('qty-slider'),
            qd = document.getElementById('qty-display');

        function calcPrice() {
            const qty = parseInt(qi.value) || 0;
            qd.textContent = qty.toLocaleString();
            document.getElementById('sum-qty').textContent = qty.toLocaleString();
            document.getElementById('sum-price').textContent = '$' + (qty / 1000 * curRate).toFixed(2);
        }
        qi.addEventListener('input', () => { qs2.value = qi.value; calcPrice(); });
        qs2.addEventListener('input', () => { qi.value = qs2.value; calcPrice(); });

        /* ── ORDER BTN ── */
        const ob = document.getElementById('btn-place-order');
        ob.addEventListener('click', () => {
            const lang = getLang();
            ob.textContent = lang === 'vi' ? '\u23F3 Dang xu ly...' : '\u23F3 Processing...';
            ob.disabled = true;
            setTimeout(() => {
                ob.textContent = lang === 'vi' ? '\u2705 Dat hang thanh cong!' : '\u2705 Order placed!';
                setTimeout(() => {
                    ob.textContent = '\uD83D\uDE80 ' + (lang === 'vi' ? 'Xac nhan dat hang' : 'Place Order');
                    ob.disabled = false;
                    goTo('orders');
                }, 1400);
            }, 1200);
        });

        /* ── FILTER TABS ── */
        document.querySelectorAll('.ft').forEach(t => t.addEventListener('click', () => {
            document.querySelectorAll('.ft').forEach(x => x.classList.remove('sel'));
            t.classList.add('sel');
        }));

        /* ── PAGE BTNS ── */
        document.querySelectorAll('.pgb').forEach(b => b.addEventListener('click', () => {
            const txt = b.textContent.trim();
            if (txt !== '\u2039' && txt !== '\u203A' && txt !== '\u00B7\u00B7\u00B7') {
                document.querySelectorAll('.pgb').forEach(x => x.classList.remove('sel'));
                b.classList.add('sel');
            }
        }));

        /* ── RESTORE SETTINGS ── */
        const savedTheme = localStorage.getItem('nexaTheme');
        applyTheme(savedTheme === 'light' ? 'light' : 'dark');
        const savedLang = localStorage.getItem('nexaLang');
        if (savedLang === 'vi' || savedLang === 'en') applyLang(savedLang);

        /* ③ Reveal page — eliminates FOUC (Next.js pattern) */
        document.documentElement.classList.add('ready');
        document.documentElement.style.visibility = '';

        /* ── SIDEBAR TOGGLE ── */
        const sidebar = document.querySelector('.sidebar');
        const sbToggle = document.getElementById('sb-toggle');
        const sbOverlay = document.getElementById('sb-overlay');

        function isMobile() { return window.innerWidth <= 768; }
        function isDesktop() { return window.innerWidth >= 1025; }

        function openSidebar() {
            sidebar.classList.add('open');
            if (sbOverlay) sbOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';
            if (sbToggle) sbToggle.setAttribute('aria-expanded', 'true');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            if (sbOverlay) sbOverlay.classList.remove('show');
            document.body.style.overflow = '';
            if (sbToggle) sbToggle.setAttribute('aria-expanded', 'false');
        }

        function toggleDesktopSidebar() {
            const isCollapsed = document.documentElement.getAttribute('data-sidebar') === 'collapsed';
            if (isCollapsed) {
                document.documentElement.removeAttribute('data-sidebar');
                localStorage.setItem('sidebarCollapsed', 'false');
            } else {
                document.documentElement.setAttribute('data-sidebar', 'collapsed');
                localStorage.setItem('sidebarCollapsed', 'true');
            }
            // Update icon
            const icon = sbToggle ? sbToggle.querySelector('i') : null;
            if (icon) {
                icon.className = !isCollapsed ? 'fa-solid fa-indent' : 'fa-solid fa-outdent';
            }
        }

        if (sbToggle) {
            sbToggle.addEventListener('click', e => {
                e.stopPropagation();
                if (isMobile()) {
                    sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
                } else {
                    toggleDesktopSidebar();
                }
            });
            sbToggle.addEventListener('keydown', e => {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); sbToggle.click(); }
            });
        }

        if (sbOverlay) sbOverlay.addEventListener('click', closeSidebar);

        // Close on nav click (mobile)
        document.querySelectorAll('.ni').forEach(n => {
            n.addEventListener('click', () => { if (isMobile()) closeSidebar(); });
            n.addEventListener('keydown', e => {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); n.click(); }
            });
        });

        // Keyboard support for theme toggle
        if (themeBtn) {
            themeBtn.addEventListener('keydown', e => {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); themeBtn.click(); }
            });
        }

        // Resize handler
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (!isMobile()) { closeSidebar(); document.body.style.overflow = ''; }
            }, 100);
        });

        // Sync toggle icon with current state
        (function syncToggleIcon() {
            if (!sbToggle || isMobile()) return;
            const icon = sbToggle.querySelector('i');
            if (!icon) return;
            const isCollapsed = document.documentElement.getAttribute('data-sidebar') === 'collapsed';
            icon.className = isCollapsed ? 'fa-solid fa-indent' : 'fa-solid fa-outdent';
        })();
    </script>

    <!-- Popper + Tippy -->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.min.js"></script>
    <!-- NProgress -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <!-- CountUp.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/countup.js/2.8.0/countUp.umd.min.js"></script>

    <script>
        /* ── INIT LIBRARIES ── */

        // NProgress config
        NProgress.configure({ showSpinner: false, speed: 400 });

        // Tippy tooltips on nav items (tablet collapsed mode)
        if (typeof tippy !== 'undefined') {
            tippy('.ni', {
                content(ref) { return ref.querySelector('span') ? ref.querySelector('span').textContent.trim() : ''; },
                placement: 'right',
                theme: 'nexa',
                delay: [300, 0],
                arrow: true,
                onShow(instance) {
                    // Only show on collapsed sidebar
                    const sb = document.querySelector('.sidebar');
                    return sb && (sb.classList.contains('collapsed') || window.innerWidth <= 1024 && window.innerWidth > 768);
                }
            });

            // Tooltips for topbar icon buttons
            tippy('#theme-toggle', { content: 'Toggle theme', theme: 'nexa', placement: 'bottom' });
            tippy('.nb', { content: 'Notifications', theme: 'nexa', placement: 'bottom' });
        }

        // CountUp animations for stat cards
        if (typeof CountUp !== 'undefined') {
            const countups = [
                { el: document.querySelector('.sc.p .sv'), val: 1284, opts: { separator: ',' } },
                { el: document.querySelector('.sc.c .sv'), val: 47, opts: {} },
                { el: document.querySelector('.sc.a .sv'), val: 3741, opts: { prefix: '$', separator: ',' } },
                { el: document.querySelector('.sc.g .sv'), val: 98.4, opts: { suffix: '%', decimalPlaces: 1 } },
            ];
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const found = countups.find(c => c.el === entry.target);
                        if (found && found.el) {
                            const cu = new CountUp.CountUp(found.el, found.val, { duration: 1.8, ...found.opts });
                            if (!cu.error) cu.start();
                            observer.unobserve(entry.target);
                        }
                    }
                });
            }, { threshold: 0.3 });
            countups.forEach(c => { if (c.el) observer.observe(c.el); });
        }

        // NProgress on page nav
        const origGoTo = goTo;
        window.goTo = function(id) {
            NProgress.start();
            setTimeout(() => { origGoTo(id); NProgress.done(); }, 180);
        };
        document.querySelectorAll('[data-page]').forEach(el => {
            el.addEventListener('click', () => window.goTo(el.dataset.page));
        });
    </script>
</body>

</html>
