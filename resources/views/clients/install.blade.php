<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <title>{{ __('install.title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="theme-color" content="#060818" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet" />
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --blue: #3b82f6;
            --indigo: #6366f1;
            --violet: #8b5cf6;
            --cyan: #06b6d4;
            --green: #10b981;
            --red: #ef4444;
            --card-bg: rgba(255, 255, 255, 0.04);
            --border: rgba(255, 255, 255, 0.10);
            --text: #fff;
            --muted: rgba(255, 255, 255, 0.45);
            --dim: rgba(255, 255, 255, 0.25);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #060818;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ═══════════════════════════════════════
       BACKGROUND SCENE
    ═══════════════════════════════════════ */
        .bg-scene {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .bg-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(125deg,
                    #060d2e 0%, #0a1540 18%, #0d1f5c 36%,
                    #0a1840 54%, #07102e 72%, #040a1c 100%);
            background-size: 400% 400%;
            animation: bgShift 14s ease infinite;
        }

        @keyframes bgShift {
            0% {
                background-position: 0% 50%;
            }

            25% {
                background-position: 100% 0%;
            }

            50% {
                background-position: 100% 100%;
            }

            75% {
                background-position: 0% 100%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .bg-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.022) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.022) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.3;
            animation: orbDrift 10s ease-in-out infinite;
            will-change: transform;
        }

        .orb-1 {
            width: 55vw;
            height: 55vw;
            max-width: 700px;
            max-height: 700px;
            background: radial-gradient(circle, var(--blue), transparent 70%);
            top: -20%;
            left: -15%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 45vw;
            height: 45vw;
            max-width: 600px;
            max-height: 600px;
            background: radial-gradient(circle, var(--violet), transparent 70%);
            bottom: -15%;
            right: -10%;
            animation-delay: 4s;
        }

        .orb-3 {
            width: 30vw;
            height: 30vw;
            max-width: 400px;
            max-height: 400px;
            background: radial-gradient(circle, var(--cyan), transparent 70%);
            top: 45%;
            left: 45%;
            transform: translate(-50%, -50%);
            animation-delay: 8s;
        }

        @keyframes orbDrift {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(25px, -35px) scale(1.06);
            }

            66% {
                transform: translate(-18px, 28px) scale(0.94);
            }
        }

        #particleCanvas {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
        }

        /* ═══════════════════════════════════════
       LAYOUT — 2 COLUMNS DESKTOP / 1 MOBILE
    ═══════════════════════════════════════ */
        .page-shell {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ── LEFT PANEL ── */
        .left-panel {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(2rem, 5vw, 4rem);
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(160deg,
                    rgba(59, 130, 246, 0.08) 0%,
                    rgba(99, 102, 241, 0.05) 50%,
                    transparent 100%);
            pointer-events: none;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 1px;
            height: 100%;
            background: linear-gradient(to bottom,
                    transparent, rgba(255, 255, 255, 0.08) 30%,
                    rgba(255, 255, 255, 0.08) 70%, transparent);
        }

        /* Brand top */
        .lp-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .lp-logo {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            flex-shrink: 0;
            background: linear-gradient(135deg, var(--blue), var(--violet));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 900;
            color: #fff;
            box-shadow: 0 6px 24px rgba(59, 130, 246, 0.35);
        }

        .lp-brand-name {
            font-size: 18px;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.3px;
        }

        .lp-brand-sub {
            font-size: 12px;
            color: var(--muted);
            margin-top: 1px;
        }

        /* Center content */
        .lp-center {
            position: relative;
            z-index: 1;
        }

        .lp-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 20px;
            padding: 5px 14px;
            font-size: 11px;
            font-weight: 600;
            color: #93c5fd;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 1.5rem;
        }

        .lp-badge i {
            font-size: 12px;
        }

        .lp-headline {
            font-size: clamp(24px, 3vw, 36px);
            font-weight: 900;
            color: #fff;
            line-height: 1.25;
            letter-spacing: -0.5px;
            margin-bottom: 1rem;
        }

        .lp-headline span {
            background: linear-gradient(135deg, var(--blue), var(--cyan));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .lp-desc {
            font-size: 14px;
            color: var(--muted);
            line-height: 1.7;
            max-width: 380px;
            margin-bottom: 2.5rem;
        }

        /* Feature list */
        .feat-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .feat-item {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .feat-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .feat-icon.blue {
            background: rgba(59, 130, 246, 0.15);
            color: #93c5fd;
        }

        .feat-icon.violet {
            background: rgba(139, 92, 246, 0.15);
            color: #c4b5fd;
        }

        .feat-icon.cyan {
            background: rgba(6, 182, 212, 0.15);
            color: #67e8f9;
        }

        .feat-icon.green {
            background: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
        }

        .feat-text strong {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #fff;
        }

        .feat-text span {
            font-size: 12px;
            color: var(--muted);
        }

        /* Bottom social proof */
        .lp-bottom {
            position: relative;
            z-index: 1;
        }

        .social-proof {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            backdrop-filter: blur(10px);
        }

        .avatars {
            display: flex;
        }

        .avatar-dot {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.15);
            background: linear-gradient(135deg, var(--blue), var(--violet));
            margin-left: -8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            color: #fff;
        }

        .avatar-dot:first-child {
            margin-left: 0;
        }

        .social-text strong {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
        }

        .social-text span {
            font-size: 11px;
            color: var(--muted);
        }

        .stars {
            color: #fbbf24;
            font-size: 11px;
            letter-spacing: 1px;
        }

        /* ═══════════════════════════════════════
       RIGHT PANEL — FORM
    ═══════════════════════════════════════ */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(1.5rem, 4vw, 3rem) clamp(1.25rem, 4vw, 3rem);
            overflow-y: auto;
        }

        .form-shell {
            width: 100%;
            max-width: clamp(260px, 90vw, 420px);
        }

        /* Card */
        .glass-card {
            background: rgba(255, 255, 255, 0.035);
            backdrop-filter: blur(32px);
            -webkit-backdrop-filter: blur(32px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: clamp(14px, 2.5vw, 20px);
            padding: clamp(0.9rem, 2vw, 1.5rem);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.05) inset,
                0 8px 32px rgba(0, 0, 0, 0.3),
                0 0 60px rgba(59, 130, 246, 0.08),
                0 0 120px rgba(139, 92, 246, 0.04);
            animation: cardFadeIn 0.8s ease-out forwards;
            opacity: 0;
            position: relative;
            overflow: hidden;
        }

        /* Fade in animation - no transform */
        @keyframes cardFadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        /* Gradient border effect */
        .glass-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: clamp(18px, 4vw, 24px);
            padding: 1px;
            background: linear-gradient(135deg,
                    rgba(59, 130, 246, 0.15) 0%,
                    rgba(139, 92, 246, 0.08) 50%,
                    rgba(6, 182, 212, 0.05) 100%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
            opacity: 0;
            animation: borderGlow 0.8s ease-out 0.3s forwards;
        }

        /* Smooth entrance animation */
        @keyframes cardFadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        /* Border glow animation */
        @keyframes borderGlow {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        /* Subtle hover effect */
        @media (hover: hover) {
            .glass-card:hover {
                background: rgba(255, 255, 255, 0.045);
                border-color: rgba(255, 255, 255, 0.15);
                box-shadow:
                    0 0 0 1px rgba(255, 255, 255, 0.06) inset,
                    0 12px 40px rgba(0, 0, 0, 0.35),
                    0 0 80px rgba(59, 130, 246, 0.12),
                    0 0 140px rgba(139, 92, 246, 0.06);
                transform: translateY(-2px);
                transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            }
        }

        /* Header */
        .form-header {
            text-align: center;
            margin-bottom: clamp(0.8rem, 2vw, 1rem);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-icon {
            width: clamp(40px, 9vw, 48px);
            height: clamp(40px, 9vw, 48px);
            border-radius: clamp(10px, 2vw, 14px);
            margin: 0 auto clamp(0.4rem, 1.2vw, 0.6rem);
            background: linear-gradient(135deg, var(--blue), var(--violet));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(16px, 3.5vw, 20px);
            font-weight: 900;
            color: #fff;
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
            position: relative;
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.8);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .form-icon-img {
            background: transparent;
            box-shadow: none;
        }

        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: clamp(12px, 2.5vw, 16px);
        }

        @keyframes logoZoom {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .form-icon::after {
            content: '';
            position: absolute;
            inset: -6px;
            border-radius: clamp(14px, 2.5vw, 18px);
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(139, 92, 246, 0.15));
            z-index: -1;
            animation: iconRingPulse 2.5s ease-in-out 0.3s infinite;
        }

        @keyframes iconBounce {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes iconRingPulse {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(1);
            }

            50% {
                opacity: 0.6;
                transform: scale(1.1);
            }
        }

        .form-header h2 {
            font-size: clamp(15px, 2.2vw, 18px);
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.3px;
            margin-bottom: clamp(1px, 0.6vw, 3px);
        }

        .form-header p {
            font-size: clamp(10px, 1.5vw, 11px);
            color: var(--muted);
        }

        @keyframes textSlideIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Step bar */
        .step-bar {
            display: flex;
            gap: clamp(2px, 0.8vw, 4px);
            margin-bottom: clamp(0.7rem, 1.8vw, 1rem);
        }

        @keyframes stepBarSlideIn {
            from {
                opacity: 0;
                transform: translateY(-6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-bar .s {
            flex: 1;
            height: clamp(2px, 0.5vw, 3px);
            border-radius: 3px;
            background: rgba(255, 255, 255, 0.08);
            position: relative;
            overflow: hidden;
            transition: background 0.3s ease;
        }

        .step-bar .s.active::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, var(--blue), var(--violet));
            animation: fillBar 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .step-bar .s.done::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, var(--green), #34d399);
            animation: fillBar 0.5s ease forwards;
        }

        @keyframes fillBar {
            from {
                width: 0;
            }

            to {
                width: 100%;
            }
        }

        /* Alerts */
        .alert-box {
            border-radius: 12px;
            padding: clamp(10px, 2vw, 12px) clamp(12px, 2vw, 14px);
            margin-bottom: clamp(0.9rem, 2vw, 1.25rem);
            font-size: clamp(12px, 2vw, 13px);
            display: flex;
            align-items: flex-start;
            gap: clamp(8px, 1.5vw, 10px);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        @keyframes alertSlideIn {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-box.err {
            background: rgba(239, 68, 68, 0.12);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #fca5a5;
        }

        .alert-box.ok {
            background: rgba(16, 185, 129, 0.12);
            border: 1px solid rgba(16, 185, 129, 0.25);
            color: #6ee7b7;
        }

        .alert-box>i {
            font-size: clamp(13px, 2vw, 15px);
            margin-top: 1px;
            flex-shrink: 0;
        }

        .alert-box ul {
            padding-left: clamp(12px, 2vw, 15px);
            margin: clamp(2px, 1vw, 4px) 0 0;
        }

        .alert-box li {
            margin-bottom: clamp(1px, 0.5vw, 2px);
        }

        /* ═══════════════════════════════════════
       FORM FIELDS
    ═══════════════════════════════════════ */
        .field {
            margin-bottom: clamp(0.6rem, 1.6vw, 0.8rem);
        }

        .field label {
            display: block;
            font-size: clamp(8px, 1.2vw, 9px);
            font-weight: 600;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: clamp(2px, 0.6vw, 4px);
        }

        .input-wrap {
            position: relative;
            border-radius: 12px;
        }

        .input-wrap::before {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: 13px;
            z-index: 0;
            pointer-events: none;
            background: transparent;
            transition: background 0.3s;
        }

        .input-wrap:focus-within::before {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.55), rgba(139, 92, 246, 0.55));
        }

        .input-wrap .ico {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dim);
            font-size: 15px;
            z-index: 2;
            pointer-events: none;
            transition: color 0.3s;
        }

        .input-wrap:focus-within .ico {
            color: #93c5fd;
        }

        .input-wrap input {
            position: relative;
            z-index: 1;
            width: 100%;
            padding: clamp(8px, 1.6vw, 10px) clamp(10px, 1.6vw, 12px) clamp(8px, 1.6vw, 10px) clamp(32px, 2.6vw, 36px);
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.09);
            border-radius: 12px;
            color: #fff;
            font-size: clamp(11px, 1.6vw, 12px);
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: all 0.3s;
            -webkit-appearance: none;
        }

        .input-wrap input:focus {
            background: rgba(255, 255, 255, 0.06);
            border-color: transparent;
        }

        .input-wrap input::placeholder {
            color: rgba(255, 255, 255, 0.18);
            font-size: 13px;
        }

        .input-wrap input.err-field {
            border-color: rgba(239, 68, 68, 0.45) !important;
        }

        .input-wrap .eye {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dim);
            font-size: 15px;
            cursor: pointer;
            z-index: 2;
            transition: color 0.3s;
            padding: 4px;
            line-height: 1;
            -webkit-tap-highlight-color: transparent;
        }

        .input-wrap .eye:hover {
            color: #93c5fd;
        }

        .field-hint {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.28);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .field-err {
            font-size: 11px;
            color: #fca5a5;
            margin-top: 5px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: clamp(0.6rem, 1.6vw, 0.8rem) 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.07);
        }

        .divider span {
            font-size: clamp(10px, 1.5vw, 11px);
            color: rgba(255, 255, 255, 0.22);
            white-space: nowrap;
        }

        /* Submit */
        .btn-launch {
            width: 100%;
            padding: clamp(10px, 1.8vw, 12px);
            border: none;
            border-radius: 12px;
            font-size: clamp(11px, 1.6vw, 12px);
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            color: #fff;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--blue) 0%, var(--indigo) 50%, var(--violet) 100%);
            background-size: 200% 200%;
            box-shadow: 0 4px 22px rgba(99, 102, 241, 0.4);
            transition: transform 0.25s, box-shadow 0.25s;
            margin-top: clamp(0.2rem, 0.6vw, 0.3rem);
            -webkit-tap-highlight-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: clamp(4px, 1vw, 6px);
        }

        @keyframes btnShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .btn-launch::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.14), transparent);
            transition: left 0.55s;
        }

        .btn-launch:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(99, 102, 241, 0.55);
        }

        .btn-launch:hover::after {
            left: 100%;
        }

        .btn-launch:active {
            transform: translateY(0);
        }

        .btn-launch:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .spin-ring {
            display: none;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            animation: spin 0.7s linear infinite;
            flex-shrink: 0;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .btn-launch.loading .spin-ring {
            display: block;
        }

        /* Footer */
        .form-footer {
            text-align: center;
            font-size: clamp(9px, 1.3vw, 10px);
            color: rgba(255, 255, 255, 0.22);
            margin-top: clamp(0.6rem, 1.6vw, 0.8rem);
            line-height: 1.4;
        }

        .form-footer a {
            color: rgba(99, 102, 241, 0.75);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .form-footer a:hover {
            color: #818cf8;
        }

        /* Stagger */
        .stagger {
            opacity: 1;
        }

        .stagger.in {
            opacity: 1;
        }

        /* ═══════════════════════════════════════
       RESPONSIVE
    ═══════════════════════════════════════ */

        /* Tablet landscape & small desktop */
        @media (max-width: 1024px) {
            .lp-headline {
                font-size: 26px;
            }

            .feat-list {
                gap: 12px;
            }
        }

        /* Tablet portrait — stack vertically, hide left panel */
        @media (max-width: 768px) {
            .page-shell {
                grid-template-columns: 1fr;
            }

            .left-panel {
                display: none;
            }

            .right-panel {
                min-height: 100vh;
                padding: 1.5rem 1rem;
                align-items: flex-start;
                padding-top: max(2rem, env(safe-area-inset-top));
                padding-bottom: max(2rem, env(safe-area-inset-bottom));
            }

            .form-shell {
                max-width: 100%;
            }

            .glass-card {
                border-radius: 20px;
                padding: 1.75rem 1.25rem;
            }
        }

        /* Mobile — tighter spacing */
        @media (max-width: 420px) {
            .glass-card {
                border-radius: 18px;
                padding: 1.5rem 1rem;
            }

            .form-header h2 {
                font-size: 18px;
            }

            .form-icon {
                width: 52px;
                height: 52px;
                font-size: 20px;
            }

            .input-wrap input {
                font-size: 16px;
            }

            /* prevent iOS zoom */
        }

        /* Very small screens */
        @media (max-width: 360px) {
            .glass-card {
                padding: 1.25rem 0.875rem;
            }
        }

        /* Large screens — wider left panel */
        @media (min-width: 1280px) {
            .page-shell {
                grid-template-columns: 1.1fr 0.9fr;
            }
        }

        @media (min-width: 1600px) {
            .page-shell {
                grid-template-columns: 1.2fr 0.8fr;
            }
        }

        /* Landscape mobile — compact */
        @media (max-height: 600px) and (orientation: landscape) {
            .right-panel {
                padding: 1rem;
                align-items: flex-start;
            }

            .form-header {
                margin-bottom: 1rem;
            }

            .form-icon {
                width: 44px;
                height: 44px;
                font-size: 18px;
                margin-bottom: 0.5rem;
            }

            .field {
                margin-bottom: 0.75rem;
            }

            .step-bar {
                margin-bottom: 1rem;
            }
        }

        /* Reduce motion */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
            }
        }

        /* ═══════════════════════════════════════
       MODAL
    ═══════════════════════════════════════ */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
            z-index: 9999;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.035);
            backdrop-filter: blur(32px);
            -webkit-backdrop-filter: blur(32px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: clamp(14px, 2.5vw, 20px);
            padding: clamp(1.2rem, 2.5vw, 1.6rem);
            max-width: clamp(260px, 85vw, 380px);
            box-shadow:
                0 0 0 1px rgba(255, 255, 255, 0.05) inset,
                0 8px 32px rgba(0, 0, 0, 0.3),
                0 0 60px rgba(59, 130, 246, 0.08);
            position: relative;
        }

        .modal-header {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: clamp(0.9rem, 2vw, 1.2rem);
        }

        .modal-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .modal-icon.error {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
        }

        .modal-icon.success {
            background: rgba(16, 185, 129, 0.15);
            color: #6ee7b7;
        }

        .modal-title {
            font-size: clamp(15px, 2.2vw, 17px);
            font-weight: 800;
            color: #fff;
            margin: 0;
            line-height: 1.3;
        }

        .modal-message {
            font-size: clamp(12px, 1.8vw, 13px);
            color: var(--muted);
            margin-bottom: clamp(0.8rem, 2vw, 1rem);
            line-height: 1.5;
        }

        .modal-errors {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 8px;
            padding: clamp(0.8rem, 1.8vw, 1rem);
            margin-bottom: clamp(0.8rem, 2vw, 1rem);
        }

        .modal-errors ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .modal-errors li {
            font-size: clamp(11px, 1.6vw, 12px);
            color: #fca5a5;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .modal-errors li:last-child {
            margin-bottom: 0;
        }

        .modal-errors li::before {
            content: '•';
            font-weight: bold;
            flex-shrink: 0;
        }

        .modal-footer {
            display: flex;
            gap: 8px;
        }

        .modal-btn {
            flex: 1;
            padding: clamp(9px, 1.8vw, 11px);
            border: none;
            border-radius: 10px;
            font-size: clamp(11px, 1.6vw, 12px);
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s;
            -webkit-tap-highlight-color: transparent;
        }

        .modal-btn-primary {
            background: linear-gradient(135deg, var(--blue) 0%, var(--indigo) 50%, var(--violet) 100%);
            color: #fff;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
        }

        .modal-btn-primary:hover {
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
            transform: translateY(-1px);
        }

        .modal-btn-secondary {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }

        .modal-btn-secondary:hover {
            background: rgba(255, 255, 255, 0.12);
        }
    </style>
</head>

<body>

    <!-- ═══ BACKGROUND ═══ -->
    <div class="bg-scene">
        <div class="bg-gradient"></div>
        <div class="bg-grid"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <canvas id="particleCanvas"></canvas>
    </div>

    <!-- ═══ MAIN SHELL ═══ -->
    <div class="page-shell">

        <!-- ══ LEFT PANEL ══ -->
        <div class="left-panel">

            <!-- Brand -->
            <div class="lp-brand stagger">
                <div class="lp-logo">{{ strtoupper(getDomain())[0] }}</div>
                <div>
                    <div class="lp-brand-name">{{ strtoupper(getDomain()) }}</div>
                    <div class="lp-brand-sub">SMM Panel Platform</div>
                </div>
            </div>

            <!-- Center -->
            <div class="lp-center">
                <div class="lp-badge stagger">
                    <i class="bi bi-stars"></i> Thiết lập hệ thống
                </div>
                <h2 class="lp-headline stagger">
                    Khởi động<br><span>nền tảng của bạn</span><br>chỉ trong vài phút
                </h2>
                <p class="lp-desc stagger">
                    Tạo tài khoản quản trị viên để bắt đầu quản lý dịch vụ, đơn hàng và người dùng trên hệ thống của
                    bạn.
                </p>
                <ul class="feat-list">
                    <li class="feat-item stagger">
                        <div class="feat-icon blue"><i class="bi bi-lightning-charge-fill"></i></div>
                        <div class="feat-text">
                            <strong>Tốc độ xử lý cao</strong>
                            <span>Hệ thống phản hồi nhanh chóng</span>
                        </div>
                    </li>
                    <li class="feat-item stagger">
                        <div class="feat-icon violet"><i class="bi bi-shield-check"></i></div>
                        <div class="feat-text">
                            <strong>Bảo mật tuyệt đối</strong>
                            <span>Mã hóa dữ liệu đầu cuối</span>
                        </div>
                    </li>
                    <li class="feat-item stagger">
                        <div class="feat-icon cyan"><i class="bi bi-graph-up-arrow"></i></div>
                        <div class="feat-text">
                            <strong>Quản lý thông minh</strong>
                            <span>Dashboard trực quan, dễ dùng</span>
                        </div>
                    </li>
                    <li class="feat-item stagger">
                        <div class="feat-icon green"><i class="bi bi-headset"></i></div>
                        <div class="feat-text">
                            <strong>Hỗ trợ 24/7</strong>
                            <span>Đội ngũ sẵn sàng hỗ trợ bạn</span>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Social proof -->
            <div class="lp-bottom stagger">
                <div class="social-proof">
                    <div class="avatars">
                        <div class="avatar-dot">A</div>
                        <div class="avatar-dot">B</div>
                        <div class="avatar-dot">C</div>
                        <div class="avatar-dot">+</div>
                    </div>
                    <div class="social-text">
                        <strong>1,000+ người dùng tin tưởng</strong>
                        <span><span class="stars">★★★★★</span> Đánh giá 5 sao</span>
                    </div>
                </div>
            </div>

        </div><!-- /left-panel -->

        <!-- ══ RIGHT PANEL ══ -->
        <div class="right-panel">
            <div class="form-shell">
                <div class="glass-card">

                    <!-- Header -->
                    <div class="form-header stagger">
                        @if (config('app.logo'))
                            <div class="form-icon form-icon-img">
                                <img src="{{ config('app.logo') }}" alt="Logo" class="logo-img">
                            </div>
                        @else
                            <div class="form-icon">{{ strtoupper(getDomain())[0] }}</div>
                        @endif
                        <h2>{{ __('install.title') }}</h2>
                        <p>{{ __('install.subtitle') }}</p>
                    </div>

                    <!-- Step bar -->
                    <div class="step-bar stagger" id="stepBar">
                        <div class="s active"></div>
                        <div class="s"></div>
                        <div class="s"></div>
                        <div class="s"></div>
                        <div class="s"></div>
                    </div>

                    <!-- Alerts - Show as Modal -->
                    @if ($errors->any())
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const errors = {!! json_encode($errors->all()) !!};
                                showInstallModal('error', '{{ __('install.error_title') }}', 'Please fix the following errors:',
                                    errors);
                            });
                        </script>
                    @endif
                    @if (session('success'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showInstallModal('success', 'Success', '{{ session('success') }}');
                                setTimeout(() => {
                                    window.location.href = '/admin/dashboard';
                                }, 2000);
                            });
                        </script>
                    @endif
                    @if (session('error'))
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                showInstallModal('error', 'Error', '{{ session('error') }}');
                            });
                        </script>
                    @endif

                    <!-- Form -->
                    <form id="installForm" method="POST" action="{{ route('install.store') }}" novalidate>
                        @csrf

                        <!-- Name -->
                        <div class="field stagger">
                            <label>{{ __('install.full_name') }}</label>
                            <div class="input-wrap">
                                <i class="bi bi-person-fill ico"></i>
                                <input type="text" name="name" class="@error('name') err-field @enderror"
                                    placeholder="{{ __('install.full_name_placeholder') }}"
                                    value="{{ old('name') }}" autocomplete="name" required>
                            </div>
                            @error('name')
                                <div class="field-err"><i class="bi bi-x-circle-fill"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Username -->
                        <div class="field stagger">
                            <label>{{ __('install.username') }}</label>
                            <div class="input-wrap">
                                <i class="bi bi-at ico"></i>
                                <input type="text" name="username" class="@error('username') err-field @enderror"
                                    placeholder="{{ __('install.username_placeholder') }}"
                                    value="{{ old('username') }}" autocomplete="username" required>
                            </div>
                            <div class="field-hint"><i class="bi bi-info-circle"></i>{{ __('install.username_hint') }}
                            </div>
                            @error('username')
                                <div class="field-err"><i class="bi bi-x-circle-fill"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="field stagger">
                            <label>{{ __('install.email') }}</label>
                            <div class="input-wrap">
                                <i class="bi bi-envelope-fill ico"></i>
                                <input type="email" name="email" class="@error('email') err-field @enderror"
                                    placeholder="{{ __('install.email_placeholder') }}" value="{{ old('email') }}"
                                    autocomplete="email" required>
                            </div>
                            @error('email')
                                <div class="field-err"><i class="bi bi-x-circle-fill"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="divider stagger"><span>Bảo mật tài khoản</span></div>

                        <!-- Password -->
                        <div class="field stagger">
                            <label>{{ __('install.password') }}</label>
                            <div class="input-wrap">
                                <i class="bi bi-lock-fill ico"></i>
                                <input type="password" name="password" id="password"
                                    class="@error('password') err-field @enderror"
                                    placeholder="{{ __('install.password_placeholder') }}"
                                    autocomplete="new-password" required>
                                <i class="bi bi-eye eye" id="togglePwd"></i>
                            </div>
                            <div class="field-hint"><i
                                    class="bi bi-shield-check"></i>{{ __('install.password_hint') }}</div>
                            @error('password')
                                <div class="field-err"><i class="bi bi-x-circle-fill"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="field stagger">
                            <label>{{ __('install.confirm_password') }}</label>
                            <div class="input-wrap">
                                <i class="bi bi-lock-fill ico"></i>
                                <input type="password" name="password_confirmation" id="passwordConfirm"
                                    placeholder="{{ __('install.confirm_password_placeholder') }}"
                                    autocomplete="new-password" required>
                                <i class="bi bi-eye eye" id="togglePwdConfirm"></i>
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="stagger">
                            <button type="submit" class="btn-launch" id="submitBtn">
                                <span class="spin-ring"></span>
                                <i class="bi bi-rocket-takeoff"></i>
                                <span>{{ __('install.submit') }}</span>
                            </button>
                        </div>
                    </form>

                    <p class="form-footer stagger">
                        {{ __('install.terms_text') }}
                        <a href="#">{{ __('install.terms_link') }}</a>
                        {{ __('install.and') }}
                        <a href="#">{{ __('install.privacy_link') }}</a>.
                    </p>

                </div><!-- /glass-card -->
            </div><!-- /form-shell -->
        </div><!-- /right-panel -->

    </div><!-- /page-shell -->

    <script>
        /* ═══ PARTICLE SYSTEM ═══ */
        (function() {
            const cv = document.getElementById('particleCanvas');
            const cx = cv.getContext('2d');
            let W, H, pts = [];
            const COLS = ['#3b82f6', '#6366f1', '#8b5cf6', '#06b6d4', '#a78bfa', '#38bdf8'];
            const COUNT = window.innerWidth < 768 ? 50 : 90;

            function resize() {
                W = cv.width = window.innerWidth;
                H = cv.height = window.innerHeight;
            }
            resize();

            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    resize();
                    init();
                }, 200);
            });

            function rnd(a, b) {
                return Math.random() * (b - a) + a;
            }

            class P {
                constructor(init) {
                    this.x = rnd(0, W);
                    this.y = init ? rnd(0, H) : H + 5;
                    this.r = rnd(0.8, 3);
                    this.vx = rnd(-0.25, 0.25);
                    this.vy = rnd(-0.55, -0.18);
                    this.col = COLS[Math.floor(Math.random() * COLS.length)];
                    this.life = 0;
                    this.max = rnd(100, 280);
                }
                tick() {
                    this.x += this.vx;
                    this.y += this.vy;
                    this.life++;
                    const t = this.life / this.max;
                    this.a = t < 0.12 ? t / 0.12 * 0.75 : t > 0.78 ? (1 - t) / 0.22 * 0.75 : 0.75;
                    if (this.life >= this.max || this.y < -8) {
                        Object.assign(this, new P(false));
                    }
                }
                draw() {
                    cx.save();
                    cx.globalAlpha = this.a;
                    cx.fillStyle = this.col;
                    cx.shadowBlur = 7;
                    cx.shadowColor = this.col;
                    cx.beginPath();
                    cx.arc(this.x, this.y, this.r, 0, Math.PI * 2);
                    cx.fill();
                    cx.restore();
                }
            }

            function init() {
                pts = Array.from({
                    length: COUNT
                }, (_, i) => new P(true));
            }

            function loop() {
                cx.clearRect(0, 0, W, H);
                pts.forEach(p => {
                    p.tick();
                    p.draw();
                });
                requestAnimationFrame(loop);
            }

            init();
            loop();
        })();

        /* ═══ PASSWORD TOGGLE ═══ */
        function pwdToggle(btnId, inputId) {
            const btn = document.getElementById(btnId);
            const inp = document.getElementById(inputId);
            if (!btn || !inp) return;
            btn.addEventListener('click', () => {
                const show = inp.type === 'password';
                inp.type = show ? 'text' : 'password';
                btn.classList.toggle('bi-eye', !show);
                btn.classList.toggle('bi-eye-slash', show);
            });
        }
        pwdToggle('togglePwd', 'password');
        pwdToggle('togglePwdConfirm', 'passwordConfirm');

        /* ═══ PROGRESS BAR ═══ */
        (function() {
            const form = document.getElementById('installForm');
            const inputs = [...form.querySelectorAll('input')];
            const steps = [...document.querySelectorAll('#stepBar .s')];

            function update() {
                const filled = inputs.filter(i => i.value.trim()).length;
                const ratio = filled / inputs.length;
                steps.forEach((s, idx) => {
                    const lo = idx / steps.length;
                    const hi = (idx + 1) / steps.length;
                    s.classList.remove('active', 'done');
                    if (ratio >= hi) s.classList.add('done');
                    else if (ratio > lo) s.classList.add('active');
                });
            }

            inputs.forEach(i => i.addEventListener('input', update));
            update();
        })();

        /* ═══ SUBMIT LOADING ═══ */
        document.getElementById('installForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });
    </script>

    <!-- Modal -->
    <div class="modal-overlay" id="installModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon error" id="modalIcon">
                    <i class="bi bi-exclamation-circle-fill"></i>
                </div>
                <h3 class="modal-title" id="modalTitle">Installation Error</h3>
            </div>
            <p class="modal-message" id="modalMessage"></p>
            <div class="modal-errors" id="modalErrors" style="display: none;">
                <ul id="errorList"></ul>
            </div>
            <div class="modal-footer">
                <button class="modal-btn modal-btn-primary" onclick="closeInstallModal()">
                    <i class="bi bi-check-lg"></i> OK
                </button>
            </div>
        </div>
    </div>

    <script>
        function showInstallModal(type, title, message, errors = []) {
            const modal = document.getElementById('installModal');
            const icon = document.getElementById('modalIcon');
            const titleEl = document.getElementById('modalTitle');
            const messageEl = document.getElementById('modalMessage');
            const errorsDiv = document.getElementById('modalErrors');
            const errorList = document.getElementById('errorList');

            // Set icon and title
            titleEl.textContent = title;
            messageEl.textContent = message;

            if (type === 'error') {
                icon.className = 'modal-icon error';
                icon.innerHTML = '<i class="bi bi-exclamation-circle-fill"></i>';
            } else {
                icon.className = 'modal-icon success';
                icon.innerHTML = '<i class="bi bi-check-circle-fill"></i>';
            }

            // Show errors if any
            if (errors.length > 0) {
                errorList.innerHTML = '';
                errors.forEach(error => {
                    const li = document.createElement('li');
                    li.textContent = error;
                    errorList.appendChild(li);
                });
                errorsDiv.style.display = 'block';
            } else {
                errorsDiv.style.display = 'none';
            }

            modal.classList.add('show');
        }

        function closeInstallModal() {
            const modal = document.getElementById('installModal');
            modal.classList.remove('show');
        }

        // Close modal when clicking overlay
        document.getElementById('installModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeInstallModal();
            }
        });
    </script>

</body>

</html>
