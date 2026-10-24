<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title data-lang="maintenance::Page title">Under Maintenance</title>
    <link rel="shortcut icon" href="/assets/media/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #060818;
            overflow: hidden;
        }

        /* Grid background */
        .grid-bg {
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(99,102,241,0.06) 1px, transparent 1px),
                linear-gradient(90deg, rgba(99,102,241,0.06) 1px, transparent 1px);
            background-size: 48px 48px;
            z-index: 0;
        }

        .glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            z-index: 0;
            pointer-events: none;
        }
        .glow-1 { width: 500px; height: 500px; background: rgba(99,102,241,0.18); top: -100px; left: -100px; }
        .glow-2 { width: 400px; height: 400px; background: rgba(168,85,247,0.12); bottom: -80px; right: -80px; }

        /* Wrapper */
        .wrap {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0;
            max-width: 560px;
            width: 92%;
        }

        /* Top label */
        .label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(99,102,241,0.1);
            border: 1px solid rgba(99,102,241,0.25);
            color: #a5b4fc;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 6px 16px;
            border-radius: 999px;
            margin-bottom: 32px;
        }

        .dot {
            width: 7px; height: 7px;
            background: #6366f1;
            border-radius: 50%;
            animation: blink 1.4s ease-in-out infinite;
        }

        @keyframes blink {
            0%,100% { opacity:1; transform:scale(1); }
            50%      { opacity:0.3; transform:scale(0.7); }
        }

        /* Gear illustration */
        .gears {
            position: relative;
            width: 120px;
            height: 120px;
            margin-bottom: 36px;
        }

        .gear {
            position: absolute;
            border-radius: 50%;
            border: 3px solid transparent;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gear-outer {
            width: 120px; height: 120px;
            top: 0; left: 0;
            background: conic-gradient(from 0deg, #6366f1, #a855f7, #6366f1);
            -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 12px), #000 calc(100% - 12px));
            mask: radial-gradient(farthest-side, transparent calc(100% - 12px), #000 calc(100% - 12px));
            animation: spin-cw 6s linear infinite;
        }

        .gear-inner {
            width: 64px; height: 64px;
            top: 28px; left: 28px;
            background: conic-gradient(from 0deg, #a855f7, #6366f1, #a855f7);
            -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 8px), #000 calc(100% - 8px));
            mask: radial-gradient(farthest-side, transparent calc(100% - 8px), #000 calc(100% - 8px));
            animation: spin-ccw 4s linear infinite;
        }

        .gear-center {
            width: 28px; height: 28px;
            top: 46px; left: 46px;
            background: rgba(99,102,241,0.15);
            border: 1px solid rgba(99,102,241,0.4);
        }

        @keyframes spin-cw  { to { transform: rotate(360deg); } }
        @keyframes spin-ccw { to { transform: rotate(-360deg); } }

        /* Text */
        h1 {
            font-size: 30px;
            font-weight: 700;
            color: #f1f5f9;
            text-align: center;
            margin-bottom: 14px;
            line-height: 1.3;
        }

        .sub {
            font-size: 15px;
            color: #64748b;
            text-align: center;
            line-height: 1.75;
            margin-bottom: 40px;
        }

        /* Steps */
        .steps {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 0;
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 32px;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            font-size: 13.5px;
        }

        .step:last-child { border-bottom: none; }

        .step-num {
            width: 28px; height: 28px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .step.done   .step-num { background: rgba(34,197,94,0.15); color: #4ade80; }
        .step.active .step-num { background: rgba(99,102,241,0.2); color: #818cf8; animation: blink 1.4s infinite; }
        .step.wait   .step-num { background: rgba(255,255,255,0.05); color: #475569; }

        .step.done   .step-text { color: #94a3b8; }
        .step.active .step-text { color: #e2e8f0; font-weight: 500; }
        .step.wait   .step-text { color: #475569; }

        .step-badge {
            margin-left: auto;
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 999px;
            font-weight: 500;
        }

        .step.done   .step-badge { background: rgba(34,197,94,0.1); color: #4ade80; }
        .step.active .step-badge { background: rgba(99,102,241,0.15); color: #818cf8; }
        .step.wait   .step-badge { background: rgba(255,255,255,0.04); color: #475569; }

        /* Footer */
        .footer {
            font-size: 12.5px;
            color: #334155;
            text-align: center;
        }

        .footer a { color: #6366f1; text-decoration: none; }
        .footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="grid-bg"></div>
    <div class="glow glow-1"></div>
    <div class="glow glow-2"></div>

    <div class="wrap">
        <div class="label">
            <span class="dot"></span>
            <span data-lang="maintenance::Scheduled Maintenance">Scheduled Maintenance</span>
        </div>

        <div class="gears">
            <div class="gear gear-outer"></div>
            <div class="gear gear-inner"></div>
            <div class="gear gear-center"></div>
        </div>

        <h1 data-lang="maintenance::We're upgrading the system">We're upgrading the system</h1>
        <p class="sub" data-lang="maintenance::Maintenance description">
            We are performing scheduled maintenance to improve performance and deliver new features. We will be back online shortly.
        </p>

        <div class="steps">
            <div class="step done">
                <div class="step-num">✓</div>
                <span class="step-text" data-lang="maintenance::Database backup completed">Database backup completed</span>
                <span class="step-badge" data-lang="maintenance::Done">Done</span>
            </div>
            <div class="step done">
                <div class="step-num">✓</div>
                <span class="step-text" data-lang="maintenance::Core system update applied">Core system update applied</span>
                <span class="step-badge" data-lang="maintenance::Done">Done</span>
            </div>
            <div class="step active">
                <div class="step-num">⟳</div>
                <span class="step-text" data-lang="maintenance::Applying optimizations and new features">Applying optimizations and new features</span>
                <span class="step-badge" data-lang="maintenance::In progress">In progress</span>
            </div>
            <div class="step wait">
                <div class="step-num">4</div>
                <span class="step-text" data-lang="maintenance::Final checks and restart">Final checks and restart</span>
                <span class="step-badge" data-lang="maintenance::Pending">Pending</span>
            </div>
        </div>

        <p class="footer">
            <span data-lang="maintenance::Need help?">Need help?</span>
            <a href="mailto:support@{{ isset($config) ? $config->domain : request()->getHost() }}" data-lang="maintenance::Contact support">Contact support</a>
        </p>
    </div>

    <script>
        @php
            // Đọc lang từ cookie hoặc fallback en
            $mLang = request()->cookie('lang') ?? 'en';
            if (!in_array($mLang, ['en','vi','af','al'])) $mLang = 'en';
            $mFile = resource_path("lang/{$mLang}.json");
            if (!file_exists($mFile)) $mFile = resource_path('lang/en.json');
            $mData = json_decode(file_get_contents($mFile), true) ?? [];
        @endphp

        var LANGUAGE = @json($mData);

        function resolveLang(raw) {
            if (LANGUAGE[raw] !== undefined) return LANGUAGE[raw];
            if (raw.includes('::')) {
                var parts = raw.split('::');
                var snake = parts[0] + '.' + parts[1].toLowerCase().replace(/\s+/g, '_').replace(/[^a-z0-9_.]/g, '');
                if (LANGUAGE[snake] !== undefined) return LANGUAGE[snake];
            }
            return raw;
        }

        document.querySelectorAll('[data-lang]').forEach(function(el) {
            var val = resolveLang(el.getAttribute('data-lang'));
            if (el.tagName !== 'INPUT' && el.tagName !== 'TEXTAREA') el.innerHTML = val;
        });
    </script>
</body>
</html>
