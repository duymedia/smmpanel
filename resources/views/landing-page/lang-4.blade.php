@php($config = $config ?? null)
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f3f3eb">
    <title>{{ getDomain() }} | {{ $config->title ?? 'Social media services, made easier to manage' }}</title>
    <meta name="description" content="{{ $config->description ?? 'Browse social media services, manage orders, and connect your workflow with a straightforward dashboard and API.' }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ getDomain() }} | Social media services">
    <meta property="og:description" content="{{ $config->description ?? 'A practical workspace for social media services, orders, and reseller workflows.' }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=DM+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['DM Sans', 'sans-serif'],
                        display: ['Space Grotesk', 'sans-serif'],
                        mono: ['DM Mono', 'monospace'],
                    },
                    colors: {
                        paper: '#f3f3eb',
                        paper2: '#e9eade',
                        ink: '#17231e',
                        forest: '#173b32',
                        leaf: '#c9f36b',
                        orange: '#e87545',
                        line: '#d8dbce',
                        muted: '#68736c',
                    },
                },
            },
        };
    </script>
    <style>
        :root {
            --paper: #f3f3eb;
            --ink: #17231e;
            --forest: #173b32;
            --leaf: #c9f36b;
            --line: #d8dbce;
            --muted: #68736c;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 88px;
            background: var(--paper);
        }

        body {
            margin: 0;
            overflow-x: hidden;
            color: var(--ink);
            background:
                linear-gradient(90deg, transparent 0, transparent calc(50% - .5px), rgba(23, 59, 50, .035) 50%, transparent calc(50% + .5px)),
                var(--paper);
            font-family: 'DM Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        h1, h2, h3, .font-display { font-family: 'Space Grotesk', sans-serif; }
        a { text-underline-offset: 4px; }
        a:focus-visible, button:focus-visible, summary:focus-visible {
            outline: 3px solid #e87545;
            outline-offset: 3px;
        }

        .site-header { transition: background-color .2s ease, border-color .2s ease; }
        .site-header.is-scrolled { background: rgba(243, 243, 235, .94); border-color: var(--line); }
        .eyebrow { font: 500 11px/1.4 'DM Mono', monospace; letter-spacing: .08em; text-transform: uppercase; }
        .hero-grid { background-image: linear-gradient(rgba(23,59,50,.055) 1px, transparent 1px), linear-gradient(90deg, rgba(23,59,50,.055) 1px, transparent 1px); background-size: 34px 34px; }
        .outline-word { color: transparent; -webkit-text-stroke: 1.5px var(--forest); }
        .workflow-line { background: repeating-linear-gradient(90deg, rgba(201,243,107,.8) 0 5px, transparent 5px 10px); }
        .section-rule { border-top: 1px solid var(--line); }
        .service-mark { width: 38px; height: 38px; display: grid; place-items: center; border-radius: 50%; color: white; font: 700 13px 'Space Grotesk', sans-serif; }
        .reveal { opacity: 0; transform: translateY(14px); transition: opacity .55s ease, transform .55s cubic-bezier(.2,.75,.25,1); }
        .reveal.is-visible { opacity: 1; transform: none; }
        .skip-link { position: absolute; z-index: 100; top: 8px; left: 8px; transform: translateY(-150%); background: var(--leaf); color: var(--ink); padding: 10px 14px; }
        .skip-link:focus { transform: translateY(0); }
        [x-cloak] { display: none !important; }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; animation-duration: .01ms !important; transition-duration: .01ms !important; }
            .reveal { opacity: 1; transform: none; }
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
    <a href="#main" class="skip-link">Skip to content</a>

    <header class="site-header fixed inset-x-0 top-0 z-50 border-b border-transparent" x-data="{ open: false }" @scroll.window="$el.classList.toggle('is-scrolled', window.scrollY > 12)">
        <div class="mx-auto flex h-[72px] max-w-7xl items-center justify-between gap-5 px-5 sm:px-8">
            <a href="{{ route('landing') }}" class="flex min-w-0 items-center gap-3" aria-label="{{ getDomain() }} home">
                @if (!empty($config?->logo))
                    <img src="{{ $config->logo }}" alt="" class="h-9 w-9 rounded-full object-contain">
                @else
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-forest text-sm font-bold text-leaf">{{ strtoupper(substr(getDomain(), 0, 1)) }}</span>
                @endif
                <span class="truncate font-display text-[16px] font-bold">{{ getDomain() }}</span>
            </a>

            <nav class="hidden items-center gap-7 text-sm font-medium text-muted lg:flex" aria-label="Main navigation">
                <a class="transition-colors hover:text-ink" href="#services">Services</a>
                <a class="transition-colors hover:text-ink" href="#workflow">Workflow</a>
                <a class="transition-colors hover:text-ink" href="#resellers">For resellers</a>
                <a class="transition-colors hover:text-ink" href="#faq">FAQ</a>
            </nav>

            <div class="hidden items-center gap-2 md:flex">
                <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-ink transition-colors hover:text-forest">Sign in</a>
                <a href="{{ route('signup') }}" class="inline-flex min-h-11 items-center gap-2 rounded-full bg-forest px-5 text-sm font-semibold text-white transition hover:bg-[#245448]">
                    Create account <span aria-hidden="true">↗</span>
                </a>
            </div>

            <button type="button" class="grid h-11 w-11 place-items-center rounded-full border border-line text-ink md:hidden" @click="open = !open" :aria-expanded="open.toString()" aria-label="Toggle navigation">
                <svg x-show="!open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg x-show="open" x-cloak width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>

        <nav x-show="open" x-collapse x-cloak class="border-t border-line bg-paper px-5 py-4 md:hidden" aria-label="Mobile navigation">
            <div class="mx-auto flex max-w-7xl flex-col gap-1">
                <a @click="open=false" class="rounded-lg px-3 py-3 text-sm font-medium hover:bg-paper2" href="#services">Services</a>
                <a @click="open=false" class="rounded-lg px-3 py-3 text-sm font-medium hover:bg-paper2" href="#workflow">Workflow</a>
                <a @click="open=false" class="rounded-lg px-3 py-3 text-sm font-medium hover:bg-paper2" href="#resellers">For resellers</a>
                <a @click="open=false" class="rounded-lg px-3 py-3 text-sm font-medium hover:bg-paper2" href="#faq">FAQ</a>
                <div class="mt-2 flex gap-2 border-t border-line pt-4">
                    <a href="{{ route('login') }}" class="flex min-h-11 flex-1 items-center justify-center rounded-full border border-line font-semibold">Sign in</a>
                    <a href="{{ route('signup') }}" class="flex min-h-11 flex-1 items-center justify-center rounded-full bg-forest font-semibold text-white">Create account</a>
                </div>
            </div>
        </nav>
    </header>

    <main id="main">
        <section class="relative overflow-hidden pb-16 pt-32 sm:pb-24 sm:pt-40 lg:pb-28">
            <div class="hero-grid absolute inset-0 opacity-50" aria-hidden="true"></div>
            <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-5 sm:px-8 lg:grid-cols-[1.08fr_.92fr] lg:gap-16">
                <div class="reveal relative z-10 min-w-0">
                    <p class="eyebrow mb-6 inline-flex items-center gap-3 text-forest">
                        <span class="h-2.5 w-2.5 rounded-full bg-orange"></span>
                        Social media services workspace
                    </p>
                    <h1 class="max-w-3xl break-words font-display text-4xl font-semibold leading-[.95] sm:text-7xl lg:text-8xl">
                        Social growth.<br>
                        <span class="outline-word block">Less guesswork.</span>
                    </h1>
                    <p class="mt-7 max-w-xl text-base leading-7 text-muted sm:text-lg sm:leading-8">
                        Find services, organize orders, and manage your workflow from one straightforward panel built for creators, teams, and resellers.
                    </p>
                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a href="{{ route('signup') }}" class="inline-flex min-h-14 items-center gap-3 rounded-full bg-forest px-7 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-[#245448]">
                            Get started <span class="grid h-7 w-7 place-items-center rounded-full bg-leaf text-ink" aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('clients.services.index') }}" class="inline-flex min-h-14 items-center rounded-full border border-line bg-paper/80 px-7 text-sm font-bold text-ink transition hover:border-forest">
                            Explore services
                        </a>
                    </div>
                    <div class="mt-8 grid gap-2 text-xs font-medium text-muted sm:flex sm:flex-wrap sm:gap-x-6 sm:gap-y-2">
                        <span class="inline-flex items-center gap-2"><span class="text-orange">01</span> Browse the catalog</span>
                        <span class="inline-flex items-center gap-2"><span class="text-orange">02</span> Review service details</span>
                        <span class="inline-flex items-center gap-2"><span class="text-orange">03</span> Track your orders</span>
                    </div>
                </div>

                <div class="reveal relative min-w-0">
                    <div class="absolute -right-6 -top-8 hidden h-28 w-28 rounded-full border border-forest/20 lg:block" aria-hidden="true"></div>
                    <div class="relative w-full min-w-0 overflow-hidden rounded-lg border border-forest/20 bg-forest p-5 text-white shadow-[0_28px_80px_-36px_rgba(23,59,50,.55)] sm:p-7">
                        <div class="flex items-center justify-between border-b border-white/15 pb-5">
                            <div class="flex items-center gap-3">
                                <span class="grid h-10 w-10 place-items-center rounded-full bg-leaf text-forest">
                                    <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 19V5m0 14h16M8 15l3-4 3 2 5-7"/></svg>
                                </span>
                                <div>
                                    <p class="font-display text-lg font-semibold">Order workspace</p>
                                    <p class="text-xs text-white/55">A simple path from selection to tracking</p>
                                </div>
                            </div>
                            <span class="eyebrow text-leaf">Preview</span>
                        </div>

                        <div class="mt-6 grid min-w-0 grid-cols-[38px_minmax(0,1fr)] gap-x-4">
                            <div class="flex flex-col items-center">
                                <span class="grid h-9 w-9 place-items-center rounded-full bg-leaf text-sm font-bold text-forest">1</span>
                                <span class="workflow-line my-2 min-h-10 w-px"></span>
                                <span class="grid h-9 w-9 place-items-center rounded-full border border-white/25 text-sm font-semibold">2</span>
                                <span class="workflow-line my-2 min-h-10 w-px opacity-50"></span>
                                <span class="grid h-9 w-9 place-items-center rounded-full border border-white/25 text-sm font-semibold">3</span>
                            </div>
                            <div class="min-w-0 space-y-5 pb-2">
                                <div class="rounded-2xl border border-white/10 bg-white/[.07] p-4">
                                    <p class="eyebrow text-white/45">Choose a platform</p>
                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <span class="rounded-full bg-leaf px-3 py-1.5 text-xs font-semibold text-forest">Instagram</span>
                                        <span class="rounded-full border border-white/15 px-3 py-1.5 text-xs text-white/75">TikTok</span>
                                        <span class="rounded-full border border-white/15 px-3 py-1.5 text-xs text-white/75">YouTube</span>
                                        <span class="rounded-full border border-white/15 px-3 py-1.5 text-xs text-white/75">More</span>
                                    </div>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-white/[.07] p-4">
                                    <p class="eyebrow text-white/45">Review service details</p>
                                    <div class="mt-3 flex items-center justify-between gap-3 text-sm">
                                        <span class="font-medium">Description, rate, limits</span>
                                        <span class="text-leaf" aria-hidden="true">↗</span>
                                    </div>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-white/[.07] p-4">
                                    <p class="eyebrow text-white/45">Follow progress</p>
                                    <div class="mt-3 flex items-center justify-between gap-3 text-sm">
                                        <span class="font-medium">Order history and status</span>
                                        <span class="rounded-full bg-leaf/15 px-2.5 py-1 text-[11px] font-medium text-leaf">In your dashboard</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 flex items-center justify-between gap-4 border-t border-white/15 pt-4 text-xs text-white/55">
                            <span>Service availability and terms vary by listing.</span>
                            <a href="{{ route('clients.services.index') }}" class="shrink-0 font-semibold text-leaf hover:underline">View catalog <span aria-hidden="true">→</span></a>
                        </div>
                    </div>
                    <p class="mt-3 text-right font-mono text-[10px] uppercase tracking-wider text-muted">A clear workflow, from one place</p>
                </div>
            </div>
        </section>

        <section id="services" class="section-rule py-16 sm:py-20">
            <div class="mx-auto max-w-7xl px-5 sm:px-8">
                <div class="reveal grid gap-5 md:grid-cols-[.78fr_1.22fr] md:items-end">
                    <div>
                        <p class="eyebrow text-orange">The catalog</p>
                        <h2 class="mt-3 max-w-lg font-display text-4xl font-semibold leading-tight sm:text-5xl">One place to find the right service.</h2>
                    </div>
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <p class="max-w-lg text-sm leading-6 text-muted">Browse available listings by platform. Each service page shows its description, rate, order limits, and other details before you continue.</p>
                        <a href="{{ route('clients.services.index') }}" class="inline-flex shrink-0 items-center gap-2 text-sm font-bold text-forest hover:underline">Browse service list <span aria-hidden="true">↗</span></a>
                    </div>
                </div>

                @php($platforms = [
                    ['name' => 'Instagram', 'tag' => 'IG', 'color' => '#bd4772', 'items' => 'Followers · Likes · Views'],
                    ['name' => 'TikTok', 'tag' => 'TK', 'color' => '#17231e', 'items' => 'Views · Likes · Followers'],
                    ['name' => 'YouTube', 'tag' => 'YT', 'color' => '#e24d43', 'items' => 'Views · Subscribers · Watch time'],
                    ['name' => 'Facebook', 'tag' => 'FB', 'color' => '#3977c8', 'items' => 'Page · Reactions · Video'],
                    ['name' => 'Telegram', 'tag' => 'TG', 'color' => '#2989a9', 'items' => 'Members · Views · Reactions'],
                    ['name' => 'Other platforms', 'tag' => '+', 'color' => '#59705e', 'items' => 'See the current service catalog'],
                ])
                <div class="mt-9 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($platforms as $platform)
                        <a href="{{ route('clients.services.index') }}" class="reveal group flex min-h-[132px] items-start gap-4 border border-line bg-white/45 p-5 transition hover:-translate-y-1 hover:border-forest/40 hover:bg-white">
                            <span class="service-mark shrink-0" style="background: {{ $platform['color'] }}">{{ $platform['tag'] }}</span>
                            <span class="min-w-0">
                                <span class="flex items-center gap-2 font-display text-lg font-semibold">{{ $platform['name'] }} <span class="text-orange opacity-0 transition group-hover:opacity-100" aria-hidden="true">↗</span></span>
                                <span class="mt-2 block text-xs leading-5 text-muted">{{ $platform['items'] }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="workflow" class="bg-forest py-16 text-white sm:py-24">
            <div class="mx-auto grid max-w-7xl gap-12 px-5 sm:px-8 lg:grid-cols-[.8fr_1.2fr] lg:gap-20">
                <div class="reveal">
                    <p class="eyebrow text-leaf">A practical workflow</p>
                    <h2 class="mt-4 font-display text-4xl font-semibold leading-tight sm:text-5xl">Less searching.<br><span class="text-leaf">More clarity.</span></h2>
                    <p class="mt-5 max-w-md text-sm leading-7 text-white/65">Use the catalog to compare service details, then keep an eye on submitted work from your account. The information shown on each listing is the source of truth.</p>
                    <a href="{{ route('signup') }}" class="mt-8 inline-flex min-h-12 items-center gap-3 rounded-full bg-leaf px-6 text-sm font-bold text-forest transition hover:bg-white">Create your account <span aria-hidden="true">↗</span></a>
                </div>
                <div class="grid gap-0 sm:grid-cols-3">
                    @php($steps = [
                        ['n' => '01', 'title' => 'Find', 'text' => 'Browse the catalog and filter by platform or service.'],
                        ['n' => '02', 'title' => 'Review', 'text' => 'Check the rate, limits, description, and requirements.'],
                        ['n' => '03', 'title' => 'Manage', 'text' => 'Submit orders and follow their status in your account.'],
                    ])
                    @foreach ($steps as $step)
                        <article class="reveal border-t border-white/20 py-6 sm:border-l sm:border-t-0 sm:px-5 sm:first:border-l-0 sm:first:pl-0">
                            <span class="font-mono text-xs text-leaf">{{ $step['n'] }} / PROCESS</span>
                            <h3 class="mt-8 font-display text-2xl font-semibold">{{ $step['title'] }}</h3>
                            <p class="mt-3 text-sm leading-6 text-white/60">{{ $step['text'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="resellers" class="py-16 sm:py-24">
            <div class="mx-auto max-w-7xl px-5 sm:px-8">
                <div class="reveal grid overflow-hidden border border-line bg-paper2 md:grid-cols-2">
                    <div class="flex flex-col justify-center p-7 sm:p-12 lg:p-16">
                        <p class="eyebrow text-orange">For teams and resellers</p>
                        <h2 class="mt-4 max-w-xl font-display text-4xl font-semibold leading-tight sm:text-5xl">A service layer for the work you already do.</h2>
                        <p class="mt-5 max-w-lg text-sm leading-7 text-muted">Organize service selection and order management in a single account. Resellers can also use the API to connect supported workflows to their own tools.</p>
                        <div class="mt-7 flex flex-wrap gap-3">
                            <a href="{{ route('clients.api.index') }}" class="inline-flex min-h-12 items-center gap-2 rounded-full bg-forest px-5 text-sm font-bold text-white hover:bg-[#245448]">Explore the API <span aria-hidden="true">↗</span></a>
                            <a href="{{ route('clients.services.index') }}" class="inline-flex min-h-12 items-center rounded-full border border-line px-5 text-sm font-bold text-ink hover:border-forest">View services</a>
                        </div>
                    </div>
                    <div class="relative min-h-[320px] overflow-hidden bg-[#dfe5d0] p-6 sm:min-h-[420px] sm:p-10">
                        <div class="absolute right-8 top-8 h-40 w-40 rounded-full border border-forest/20 sm:right-14 sm:top-12 sm:h-64 sm:w-64" aria-hidden="true"></div>
                        <div class="absolute right-16 top-16 h-24 w-24 rounded-full border border-forest/25 sm:right-28 sm:top-28 sm:h-36 sm:w-36" aria-hidden="true"></div>
                        <div class="absolute bottom-8 left-6 right-6 border border-forest/15 bg-paper p-5 shadow-[0_18px_45px_-30px_rgba(23,59,50,.45)] sm:bottom-12 sm:left-12 sm:right-12 sm:p-7">
                            <div class="flex items-center justify-between border-b border-line pb-4">
                                <span class="eyebrow text-muted">Connected workflow</span>
                                <span class="flex items-center gap-2 text-xs font-semibold text-forest"><span class="h-2 w-2 rounded-full bg-[#6a9b3f]"></span> API access</span>
                            </div>
                            <div class="mt-5 flex items-center gap-3">
                                <span class="grid h-11 w-11 place-items-center rounded-full bg-forest font-mono text-xs text-leaf">{ }</span>
                                <div class="min-w-0 flex-1">
                                    <p class="font-display font-semibold">Your application</p>
                                    <p class="truncate font-mono text-xs text-muted">Request → service → status</p>
                                </div>
                                <span class="font-mono text-xs text-orange">REST</span>
                            </div>
                            <div class="mt-5 h-1.5 overflow-hidden bg-paper2"><div class="h-full w-2/3 bg-forest"></div></div>
                            <p class="mt-3 text-xs text-muted">Review the API documentation for available actions and requirements.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="section-rule py-16 sm:py-24">
            <div class="mx-auto grid max-w-7xl gap-10 px-5 sm:px-8 lg:grid-cols-[.7fr_1.3fr] lg:gap-20">
                <div class="reveal">
                    <p class="eyebrow text-orange">FAQ</p>
                    <h2 class="mt-4 font-display text-4xl font-semibold sm:text-5xl">Good to know.</h2>
                    <p class="mt-4 max-w-sm text-sm leading-6 text-muted">A few details to help you get oriented before you start.</p>
                </div>
                <div class="reveal divide-y divide-line border-y border-line" x-data="{ active: 0 }">
                    <div>
                        <button type="button" class="flex min-h-[72px] w-full items-center justify-between gap-5 text-left" @click="active = active === 1 ? 0 : 1" :aria-expanded="active === 1">
                            <span class="font-display text-base font-semibold sm:text-lg">What is a social media services panel?</span>
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full border border-line text-lg" x-text="active === 1 ? '−' : '+'"></span>
                        </button>
                        <div x-show="active === 1" x-collapse x-cloak><p class="max-w-2xl pb-6 pr-10 text-sm leading-6 text-muted">It is a dashboard for browsing listed social media services, submitting orders, and reviewing order information in one account.</p></div>
                    </div>
                    <div>
                        <button type="button" class="flex min-h-[72px] w-full items-center justify-between gap-5 text-left" @click="active = active === 2 ? 0 : 2" :aria-expanded="active === 2">
                            <span class="font-display text-base font-semibold sm:text-lg">How do I compare services?</span>
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full border border-line text-lg" x-text="active === 2 ? '−' : '+'"></span>
                        </button>
                        <div x-show="active === 2" x-collapse x-cloak><p class="max-w-2xl pb-6 pr-10 text-sm leading-6 text-muted">Open the service list and review each listing's description, rate, limits, and any stated requirements. Details can differ between services.</p></div>
                    </div>
                    <div>
                        <button type="button" class="flex min-h-[72px] w-full items-center justify-between gap-5 text-left" @click="active = active === 3 ? 0 : 3" :aria-expanded="active === 3">
                            <span class="font-display text-base font-semibold sm:text-lg">Can I connect my own application?</span>
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full border border-line text-lg" x-text="active === 3 ? '−' : '+'"></span>
                        </button>
                        <div x-show="active === 3" x-collapse x-cloak><p class="max-w-2xl pb-6 pr-10 text-sm leading-6 text-muted">API access is available for supported workflows. See the API documentation for the current endpoints, parameters, and authentication requirements.</p></div>
                    </div>
                    <div>
                        <button type="button" class="flex min-h-[72px] w-full items-center justify-between gap-5 text-left" @click="active = active === 4 ? 0 : 4" :aria-expanded="active === 4">
                            <span class="font-display text-base font-semibold sm:text-lg">Where can I see order progress?</span>
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full border border-line text-lg" x-text="active === 4 ? '−' : '+'"></span>
                        </button>
                        <div x-show="active === 4" x-collapse x-cloak><p class="max-w-2xl pb-6 pr-10 text-sm leading-6 text-muted">After signing in, use the orders area in your account to review order status and available actions.</p></div>
                    </div>
                    <div>
                        <button type="button" class="flex min-h-[72px] w-full items-center justify-between gap-5 text-left" @click="active = active === 5 ? 0 : 5" :aria-expanded="active === 5">
                            <span class="font-display text-base font-semibold sm:text-lg">How do payments and service terms work?</span>
                            <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full border border-line text-lg" x-text="active === 5 ? '−' : '+'"></span>
                        </button>
                        <div x-show="active === 5" x-collapse x-cloak><p class="max-w-2xl pb-6 pr-10 text-sm leading-6 text-muted">Available payment options, pricing, delivery details, and any refill or refund conditions are shown in the relevant account or service screens. Please check those details before placing an order.</p></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="px-5 pb-16 sm:px-8 sm:pb-24">
            <div class="reveal relative mx-auto max-w-7xl overflow-hidden bg-forest px-6 py-14 text-white sm:px-12 sm:py-20">
                <div class="absolute -right-16 -top-24 h-72 w-72 rounded-full border border-white/10 sm:right-8 sm:top-1/2 sm:-translate-y-1/2" aria-hidden="true"></div>
                <div class="absolute -right-5 -top-12 h-48 w-48 rounded-full border border-leaf/25 sm:right-20 sm:top-1/2 sm:-translate-y-1/2" aria-hidden="true"></div>
                <div class="relative max-w-3xl">
                    <p class="eyebrow text-leaf">Start with the catalog</p>
                    <h2 class="mt-4 font-display text-4xl font-semibold leading-tight sm:text-6xl">Make your next order with a clearer view.</h2>
                    <p class="mt-5 max-w-xl text-sm leading-7 text-white/65">Create an account to browse available services and manage your orders from one place.</p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('signup') }}" class="inline-flex min-h-14 items-center gap-3 rounded-full bg-leaf px-7 text-sm font-bold text-forest transition hover:bg-white">Create an account <span aria-hidden="true">↗</span></a>
                        <a href="{{ route('clients.services.index') }}" class="inline-flex min-h-14 items-center rounded-full border border-white/30 px-7 text-sm font-bold text-white transition hover:bg-white/10">Browse services</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-line">
        <div class="mx-auto grid max-w-7xl gap-10 px-5 py-12 sm:px-8 md:grid-cols-[1.3fr_.7fr_.7fr]">
            <div>
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 font-display text-base font-bold">
                    @if (!empty($config?->logo))
                        <img src="{{ $config->logo }}" alt="" class="h-9 w-9 rounded-full object-contain">
                    @else
                        <span class="grid h-9 w-9 place-items-center rounded-full bg-forest text-sm text-leaf">{{ strtoupper(substr(getDomain(), 0, 1)) }}</span>
                    @endif
                    {{ getDomain() }}
                </a>
                <p class="mt-4 max-w-sm text-sm leading-6 text-muted">A practical workspace for discovering social media services and managing orders.</p>
            </div>
            <div>
                <p class="eyebrow mb-4 text-muted">Explore</p>
                <ul class="space-y-3 text-sm font-medium">
                    <li><a class="hover:text-forest hover:underline" href="{{ route('clients.services.index') }}">Service list</a></li>
                    <li><a class="hover:text-forest hover:underline" href="{{ route('clients.api.index') }}">API documentation</a></li>
                    <li><a class="hover:text-forest hover:underline" href="#faq">FAQ</a></li>
                </ul>
            </div>
            <div>
                <p class="eyebrow mb-4 text-muted">Account</p>
                <ul class="space-y-3 text-sm font-medium">
                    <li><a class="hover:text-forest hover:underline" href="{{ route('signup') }}">Create account</a></li>
                    <li><a class="hover:text-forest hover:underline" href="{{ route('login') }}">Sign in</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-line">
            <div class="mx-auto flex max-w-7xl flex-col gap-2 px-5 py-5 text-xs text-muted sm:flex-row sm:items-center sm:justify-between sm:px-8">
                <span>(c) {{ date('Y') }} {{ getDomain() }}</span>
                <span>Service availability and terms may vary by listing.</span>
            </div>
        </div>
    </footer>

    <script>
        window.addEventListener('DOMContentLoaded', function () {
            const items = document.querySelectorAll('.reveal');
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !('IntersectionObserver' in window)) {
                items.forEach((item) => item.classList.add('is-visible'));
                return;
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            items.forEach((item) => observer.observe(item));
        });
    </script>
</body>

</html>
