@php($config = $config ?? null)
@php($platforms = $platforms ?? collect())
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f7f9fc">
    <title>{{ getDomain() }} | {{ $config->title ?? 'Social media services in one SMM panel' }}</title>
    <meta name="description" content="{{ $config->description ?? 'Browse social media services, review rates and requirements, and manage your orders from one SMM panel.' }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ getDomain() }} | Social media services">
    <meta property="og:description" content="{{ $config->description ?? 'A practical workspace for social media services, order tracking, and reseller workflows.' }}">

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
                        ink: '#17233a',
                        blue: '#2858d8',
                        blueDark: '#173b9b',
                        mint: '#d9f7e8',
                        lime: '#c8ed68',
                        coral: '#f17c61',
                        paper: '#f7f9fc',
                        muted: '#617087',
                        line: '#e1e7f0',
                    },
                },
            },
        };
    </script>
    <style>
        :root { --ink: #17233a; --blue: #2858d8; --blue-dark: #173b9b; --line: #e1e7f0; --muted: #617087; }
        html { scroll-behavior: smooth; scroll-padding-top: 84px; }
        body { margin: 0; background: #f7f9fc; color: var(--ink); font-family: 'DM Sans', sans-serif; -webkit-font-smoothing: antialiased; }
        h1, h2, h3, .font-display { font-family: 'Space Grotesk', sans-serif; }
        a:focus-visible, button:focus-visible, summary:focus-visible { outline: 3px solid #f17c61; outline-offset: 3px; }
        .eyebrow { font: 500 11px/1.4 'DM Mono', monospace; letter-spacing: 0; text-transform: uppercase; }
        .site-header { transition: background-color .2s ease, box-shadow .2s ease; }
        .site-header.is-scrolled { background: rgba(247,249,252,.96); box-shadow: 0 8px 26px rgba(23,35,58,.08); }
        .hero-wash { background: radial-gradient(ellipse at 76% 34%, rgba(200,237,104,.34), transparent 29%), radial-gradient(ellipse at 82% 68%, rgba(40,88,216,.10), transparent 35%); }
        .hero-grid { background-image: linear-gradient(rgba(23,35,58,.035) 1px, transparent 1px), linear-gradient(90deg, rgba(23,35,58,.035) 1px, transparent 1px); background-size: 36px 36px; mask-image: linear-gradient(to bottom, #000 0, transparent 82%); }
        .hero-art { transform: rotate(1.5deg); box-shadow: 0 32px 80px -42px rgba(23,35,58,.5); }
        .platform-row { transition: background .18s ease, border-color .18s ease, transform .18s ease; }
        .platform-row:hover { transform: translateY(-2px); border-color: #afc0e7; background: #fff; }
        .reveal { opacity: 0; transform: translateY(12px); transition: opacity .5s ease, transform .5s cubic-bezier(.2,.75,.25,1); }
        .reveal.is-visible { opacity: 1; transform: none; }
        .faq-item[open] .faq-plus { transform: rotate(45deg); }
        .skip-link { position: absolute; z-index: 100; top: 8px; left: 8px; transform: translateY(-150%); background: #c8ed68; color: var(--ink); padding: 10px 14px; }
        .skip-link:focus { transform: translateY(0); }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; animation-duration: .01ms !important; transition-duration: .01ms !important; }
            .reveal { opacity: 1; transform: none; }
        }
    </style>
</head>

<body>
    <a href="#main" class="skip-link">Skip to content</a>

    <header class="site-header fixed inset-x-0 top-0 z-50 border-b border-line/80 bg-paper/90 backdrop-blur-md" id="siteHeader">
        <div class="mx-auto flex h-[72px] max-w-7xl items-center justify-between gap-5 px-5 sm:px-8">
            <a href="{{ route('landing') }}" class="flex min-w-0 items-center gap-3" aria-label="{{ getDomain() }} home">
                @if (!empty($config?->logo))
                    <img src="{{ $config->logo }}" alt="" class="h-9 w-9 rounded-lg object-contain">
                @else
                    <span class="grid h-9 w-9 shrink-0 place-items-center rounded-lg bg-blue font-display text-base font-bold text-white">{{ strtoupper(substr(getDomain(), 0, 1)) }}</span>
                @endif
                <span class="truncate font-display text-lg font-bold text-ink">{{ getDomain() }}</span>
            </a>

            <nav class="hidden items-center gap-7 text-sm font-semibold text-muted lg:flex" aria-label="Main navigation">
                <a class="transition hover:text-blue" href="#services">Services</a>
                <a class="transition hover:text-blue" href="#benefits">Why {{ getDomain() }}</a>
                <a class="transition hover:text-blue" href="#how-it-works">How it works</a>
                <a class="transition hover:text-blue" href="{{ route('clients.api.index') }}">API</a>
                <a class="transition hover:text-blue" href="#faq">FAQ</a>
            </nav>

            <div class="hidden items-center gap-2 md:flex">
                <a href="{{ route('login') }}" class="rounded-full px-4 py-2.5 text-sm font-bold text-ink hover:text-blue">Sign in</a>
                <a href="{{ route('signup') }}" class="inline-flex min-h-11 items-center gap-2 rounded-full bg-blue px-5 text-sm font-bold text-white transition hover:bg-blueDark">Create account <span aria-hidden="true">↗</span></a>
            </div>

            <button type="button" id="menuToggle" class="grid h-11 w-11 place-items-center rounded-full border border-line text-ink md:hidden" aria-expanded="false" aria-controls="mobileMenu" aria-label="Open navigation">
                <svg class="menu-open" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                <svg class="menu-close hidden" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </div>
        <nav id="mobileMenu" class="hidden border-t border-line bg-paper px-5 py-4 md:hidden" aria-label="Mobile navigation">
            <div class="mx-auto flex max-w-7xl flex-col gap-1">
                <a class="rounded-lg px-3 py-3 text-sm font-semibold hover:bg-white" href="#services">Services</a>
                <a class="rounded-lg px-3 py-3 text-sm font-semibold hover:bg-white" href="#benefits">Why {{ getDomain() }}</a>
                <a class="rounded-lg px-3 py-3 text-sm font-semibold hover:bg-white" href="#how-it-works">How it works</a>
                <a class="rounded-lg px-3 py-3 text-sm font-semibold hover:bg-white" href="{{ route('clients.api.index') }}">API</a>
                <a class="rounded-lg px-3 py-3 text-sm font-semibold hover:bg-white" href="#faq">FAQ</a>
                <div class="mt-2 flex gap-2 border-t border-line pt-4">
                    <a href="{{ route('login') }}" class="flex min-h-11 flex-1 items-center justify-center rounded-full border border-line text-sm font-bold">Sign in</a>
                    <a href="{{ route('signup') }}" class="flex min-h-11 flex-1 items-center justify-center rounded-full bg-blue text-sm font-bold text-white">Create account</a>
                </div>
            </div>
        </nav>
    </header>

    <main id="main">
        <section class="relative overflow-hidden bg-paper pb-16 pt-32 sm:pb-20 sm:pt-36 lg:pb-24 lg:pt-40">
            <div class="hero-wash absolute inset-0" aria-hidden="true"></div>
            <div class="hero-grid absolute inset-0" aria-hidden="true"></div>
            <div class="relative mx-auto grid max-w-7xl items-center gap-12 px-5 sm:px-8 lg:grid-cols-[.92fr_1.08fr] lg:gap-16">
                <div class="reveal relative z-10 min-w-0">
                    <p class="eyebrow inline-flex items-center gap-2 rounded-full border border-blue/15 bg-white/80 px-3 py-2 text-blue">
                        <span class="h-2 w-2 rounded-full bg-blue"></span>Social media marketing panel
                    </p>
                    <h1 class="mt-6 max-w-2xl font-display text-5xl font-bold leading-[1.02] sm:text-6xl lg:text-7xl">
                        Social growth, <span class="text-blue">made easier to manage.</span>
                    </h1>
                    <p class="mt-6 max-w-xl text-base leading-7 text-muted sm:text-lg sm:leading-8">
                        Browse social media services, compare each listing's details, and manage order progress from one SMM panel.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('signup') }}" class="inline-flex min-h-14 items-center gap-3 rounded-full bg-blue px-7 text-sm font-bold text-white transition hover:-translate-y-0.5 hover:bg-blueDark">
                            Get started <span class="grid h-7 w-7 place-items-center rounded-full bg-white/15" aria-hidden="true">↗</span>
                        </a>
                        <a href="{{ route('clients.services.index') }}" class="inline-flex min-h-14 items-center rounded-full border border-line bg-white/70 px-7 text-sm font-bold text-ink transition hover:border-blue/40">
                            View services
                        </a>
                    </div>
                    <div class="mt-8 flex flex-wrap gap-x-6 gap-y-3 text-xs font-semibold text-muted">
                        <span class="inline-flex items-center gap-2"><span class="text-blue">✓</span> Service requirements in the listing</span>
                        <span class="inline-flex items-center gap-2"><span class="text-blue">✓</span> Order history in your account</span>
                    </div>
                </div>

                <div class="reveal relative min-w-0 px-2 sm:px-5 lg:px-0">
                    <div class="absolute -right-2 top-2 h-32 w-32 rounded-full bg-lime/70 sm:-right-5 sm:top-0 sm:h-48 sm:w-48" aria-hidden="true"></div>
                    <div class="absolute -bottom-5 left-0 h-28 w-28 rounded-full bg-mint sm:-bottom-8 sm:left-2 sm:h-40 sm:w-40" aria-hidden="true"></div>
                    <div class="hero-art relative mx-auto max-w-[590px] overflow-hidden rounded-lg border border-[#d8e0ed] bg-white">
                        <div class="flex items-center justify-between border-b border-line px-4 py-3 sm:px-6">
                            <div class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full bg-coral"></span><span class="h-2.5 w-2.5 rounded-full bg-[#f0c55d]"></span><span class="h-2.5 w-2.5 rounded-full bg-[#56b98d]"></span>
                                <span class="ml-2 font-display text-xs font-bold text-ink">{{ getDomain() }}</span>
                            </div>
                            <span class="eyebrow text-muted">New order</span>
                        </div>
                        <div class="grid sm:grid-cols-[1fr_170px]">
                            <div class="min-w-0 p-5 sm:p-7">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <p class="eyebrow text-blue">Order workspace</p>
                                        <h2 class="mt-2 font-display text-2xl font-bold">Select a service</h2>
                                    </div>
                                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-mint text-blue">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 19V5m0 14h16M8 15l3-4 3 2 5-7"/></svg>
                                    </span>
                                </div>
                                <div class="mt-6 space-y-3">
                                    <div class="rounded-md border border-line bg-paper px-4 py-3">
                                        <p class="text-[11px] font-semibold text-muted">PLATFORM</p>
                                        <div class="mt-2 flex items-center justify-between gap-3 text-sm font-semibold"><span>Choose from catalog</span><span class="text-blue">⌄</span></div>
                                    </div>
                                    <div class="rounded-md border border-line bg-paper px-4 py-3">
                                        <p class="text-[11px] font-semibold text-muted">SERVICE</p>
                                        <div class="mt-2 flex items-center justify-between gap-3 text-sm font-semibold"><span>Review description and rate</span><span class="text-blue">⌄</span></div>
                                    </div>
                                    <div class="rounded-md border border-line bg-paper px-4 py-3">
                                        <p class="text-[11px] font-semibold text-muted">ORDER INFORMATION</p>
                                        <div class="mt-2 h-2 w-4/5 rounded-full bg-[#dfe5ef]"></div>
                                    </div>
                                </div>
                                <div class="mt-5 flex items-center justify-between gap-3 border-t border-line pt-4">
                                    <span class="text-xs text-muted">Limits and requirements vary by service</span>
                                    <span class="rounded-full bg-blue px-4 py-2 text-xs font-bold text-white">Continue <span aria-hidden="true">→</span></span>
                                </div>
                            </div>
                            <div class="hidden border-l border-line bg-[#f7f9fc] p-5 sm:block">
                                <p class="eyebrow text-muted">Order flow</p>
                                <ol class="mt-6 space-y-5">
                                    <li class="flex items-center gap-3 text-sm font-semibold"><span class="grid h-7 w-7 place-items-center rounded-full bg-blue text-xs text-white">1</span> Select</li>
                                    <li class="flex items-center gap-3 text-sm font-semibold text-muted"><span class="grid h-7 w-7 place-items-center rounded-full border border-line bg-white text-xs">2</span> Review</li>
                                    <li class="flex items-center gap-3 text-sm font-semibold text-muted"><span class="grid h-7 w-7 place-items-center rounded-full border border-line bg-white text-xs">3</span> Track</li>
                                </ol>
                                <div class="mt-8 border-t border-line pt-4">
                                    <p class="text-xs leading-5 text-muted">Check the service page for current details before submitting.</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-t border-line px-5 py-3 text-[10px] text-muted sm:px-7">
                            <span>Illustrative workspace preview</span><span>Catalog · Orders · API</span>
                        </div>
                    </div>
                    <div class="absolute -right-1 top-1/2 hidden -translate-y-1/2 rounded-full border border-[#d8e0ed] bg-white px-4 py-3 text-xs font-bold text-ink shadow-lg sm:block">
                        <span class="mr-2 inline-block h-2 w-2 rounded-full bg-[#56b98d]"></span>Service details first
                    </div>
                </div>
            </div>
        </section>

        <section class="border-y border-line bg-white">
            <div class="mx-auto grid max-w-7xl gap-px px-5 sm:grid-cols-3 sm:px-8">
                <div class="reveal flex items-start gap-4 py-6 sm:pr-6">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-[#eaf0ff] text-blue">01</span>
                    <div><h2 class="font-display font-bold">Browse the catalog</h2><p class="mt-1 text-xs leading-5 text-muted">Find services by platform and category.</p></div>
                </div>
                <div class="reveal flex items-start gap-4 border-line py-6 sm:border-x sm:px-6">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-mint text-blue">02</span>
                    <div><h2 class="font-display font-bold">Review the details</h2><p class="mt-1 text-xs leading-5 text-muted">Check rates, limits, and requirements.</p></div>
                </div>
                <div class="reveal flex items-start gap-4 py-6 sm:pl-6">
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-[#fff0eb] text-coral">03</span>
                    <div><h2 class="font-display font-bold">Manage your orders</h2><p class="mt-1 text-xs leading-5 text-muted">Review progress in your account.</p></div>
                </div>
            </div>
        </section>

        <section id="services" class="py-16 sm:py-24">
            <div class="mx-auto max-w-7xl px-5 sm:px-8">
                <div class="reveal flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="eyebrow text-blue">Social media services</p>
                        <h2 class="mt-3 max-w-2xl font-display text-3xl font-bold leading-tight sm:text-5xl">Choose a platform. Find a service.</h2>
                        <p class="mt-3 max-w-2xl text-sm leading-6 text-muted">Browse popular social channels from one catalog. Service availability and types depend on the current listings.</p>
                    </div>
                    <a href="{{ route('clients.services.index') }}" class="inline-flex min-h-11 items-center gap-2 self-start rounded-full border border-line bg-white px-5 text-sm font-bold text-ink hover:border-blue/40 hover:text-blue">Browse all services <span aria-hidden="true">↗</span></a>
                </div>

                @php($activePlatformNames = collect($platforms)->map(fn ($platform) => strtolower(is_array($platform) ? ($platform['name'] ?? '') : ($platform->name ?? ''))))
                @php($socialPlatforms = [
                    ['name' => 'Facebook', 'image' => asset('images/social/facebook.gif'), 'description' => 'Pages, posts, and other listed services.'],
                    ['name' => 'TikTok', 'image' => asset('images/social/tiktok.gif'), 'description' => 'Short-form video services in the catalog.'],
                    ['name' => 'Instagram', 'image' => asset('images/social/instagram.gif'), 'description' => 'Profile and content service categories.'],
                    ['name' => 'YouTube', 'image' => asset('images/social/youtube.gif'), 'description' => 'Video and channel service categories.'],
                    ['name' => 'Telegram', 'image' => asset('images/social/telegram.gif'), 'description' => 'Community and post-related listings.'],
                    ['name' => 'X', 'image' => asset('images/social/x.gif'), 'description' => 'Explore currently listed X services.'],
                ])
                <div class="mt-8 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($socialPlatforms as $platform)
                        @php($isAvailable = $activePlatformNames->contains(strtolower($platform['name'])))
                        <a href="{{ route('clients.services.index') }}" class="platform-row reveal flex min-h-[132px] items-center gap-4 rounded-lg border border-line bg-white/70 p-5">
                            <img src="{{ $platform['image'] }}" alt="{{ $platform['name'] }}" class="h-12 w-12 shrink-0 rounded-lg border border-line bg-white object-contain" width="48" height="48" loading="lazy" decoding="async">
                            <span class="min-w-0 flex-1">
                                <span class="flex items-center justify-between gap-2 font-display text-lg font-bold">{{ $platform['name'] }} <span class="text-blue" aria-hidden="true">↗</span></span>
                                <span class="mt-1 block text-xs leading-5 text-muted">{{ $platform['description'] }}</span>
                                <span class="mt-2 inline-flex items-center gap-1 text-[11px] font-semibold {{ $isAvailable ? 'text-[#26784c]' : 'text-muted' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $isAvailable ? 'bg-[#3c9b62]' : 'bg-[#9aa5b5]' }}"></span>
                                    {{ $isAvailable ? 'Listed in catalog' : 'Check current catalog' }}
                                </span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        <section id="benefits" class="bg-[#edf2fb] py-16 sm:py-24">
            <div class="mx-auto max-w-7xl px-5 sm:px-8">
                <div class="reveal max-w-3xl">
                    <p class="eyebrow text-blue">One SMM workspace</p>
                    <h2 class="mt-3 font-display text-3xl font-bold leading-tight sm:text-5xl">The everyday tools for service ordering and account management.</h2>
                    <p class="mt-4 max-w-2xl text-sm leading-6 text-muted">A clear catalog and account history help keep the ordering workflow easy to follow. Always use the service-specific terms shown in the panel.</p>
                </div>
                <div class="mt-10 grid gap-x-8 md:grid-cols-2 lg:grid-cols-3">
                    <article class="reveal border-t border-[#d3dcec] py-6">
                        <span class="eyebrow text-blue">01 / Catalog</span>
                        <h3 class="mt-4 font-display text-xl font-bold">Find services by category</h3>
                        <p class="mt-2 text-sm leading-6 text-muted">Navigate platforms and categories to find the right listing for your task.</p>
                    </article>
                    <article class="reveal border-t border-[#d3dcec] py-6">
                        <span class="eyebrow text-coral">02 / Details</span>
                        <h3 class="mt-4 font-display text-xl font-bold">Review before ordering</h3>
                        <p class="mt-2 text-sm leading-6 text-muted">Check the service description, rate, order limits, and requirements first.</p>
                    </article>
                    <article class="reveal border-t border-[#d3dcec] py-6">
                        <span class="eyebrow text-blue">03 / Orders</span>
                        <h3 class="mt-4 font-display text-xl font-bold">Keep order history together</h3>
                        <p class="mt-2 text-sm leading-6 text-muted">Use your account to review order references, status, and available actions.</p>
                    </article>
                    <article class="reveal border-t border-[#d3dcec] py-6">
                        <span class="eyebrow text-coral">04 / Funding</span>
                        <h3 class="mt-4 font-display text-xl font-bold">View account funding options</h3>
                        <p class="mt-2 text-sm leading-6 text-muted">Available funding methods and their terms are shown in the account area.</p>
                    </article>
                    <article class="reveal border-t border-[#d3dcec] py-6">
                        <span class="eyebrow text-blue">05 / API</span>
                        <h3 class="mt-4 font-display text-xl font-bold">Connect supported workflows</h3>
                        <p class="mt-2 text-sm leading-6 text-muted">Use the API documentation to review supported actions and requirements.</p>
                    </article>
                    <article class="reveal border-t border-[#d3dcec] py-6">
                        <span class="eyebrow text-coral">06 / Support</span>
                        <h3 class="mt-4 font-display text-xl font-bold">Get help from your account</h3>
                        <p class="mt-2 text-sm leading-6 text-muted">Sign in to find support options available for your panel account.</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="how-it-works" class="bg-white py-16 sm:py-24">
            <div class="mx-auto max-w-7xl px-5 sm:px-8">
                <div class="reveal grid gap-5 md:grid-cols-[.8fr_1.2fr] md:items-end">
                    <div>
                        <p class="eyebrow text-blue">How it works</p>
                        <h2 class="mt-3 font-display text-3xl font-bold leading-tight sm:text-5xl">A simple path from browse to track.</h2>
                    </div>
                    <p class="max-w-xl text-sm leading-6 text-muted">The exact fields and steps can vary by service. Review the instructions shown in the order form before submitting.</p>
                </div>
                @php($steps = [
                    ['number' => '01', 'title' => 'Create an account', 'copy' => 'Sign up to access the panel and account tools.'],
                    ['number' => '02', 'title' => 'Choose a listing', 'copy' => 'Browse platforms and compare service details.'],
                    ['number' => '03', 'title' => 'Submit order details', 'copy' => 'Follow the listed requirements and confirm your order.'],
                    ['number' => '04', 'title' => 'Review progress', 'copy' => 'Check order history for status and available actions.'],
                ])
                <div class="mt-10 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($steps as $step)
                        <article class="reveal min-h-[210px] border-t-2 border-blue bg-paper p-5 sm:p-6">
                            <span class="font-mono text-sm font-medium text-blue">{{ $step['number'] }}</span>
                            <h3 class="mt-8 font-display text-xl font-bold">{{ $step['title'] }}</h3>
                            <p class="mt-3 text-sm leading-6 text-muted">{{ $step['copy'] }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="overflow-hidden bg-ink py-16 text-white sm:py-24">
            <div class="mx-auto grid max-w-7xl items-center gap-10 px-5 sm:px-8 lg:grid-cols-[.85fr_1.15fr] lg:gap-16">
                <div class="reveal">
                    <p class="eyebrow text-lime">For creators, teams, and resellers</p>
                    <h2 class="mt-4 font-display text-3xl font-bold leading-tight sm:text-5xl">Bring service discovery into your workflow.</h2>
                    <p class="mt-5 max-w-lg text-sm leading-7 text-white/65">Use the panel to review listings and manage orders. For integrations, consult the API documentation for current endpoints and requirements.</p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('clients.api.index') }}" class="inline-flex min-h-12 items-center gap-2 rounded-full bg-lime px-5 text-sm font-bold text-ink hover:bg-white">Explore the API <span aria-hidden="true">↗</span></a>
                        <a href="{{ route('clients.services.index') }}" class="inline-flex min-h-12 items-center rounded-full border border-white/25 px-5 text-sm font-bold text-white hover:border-lime/70">View catalog</a>
                    </div>
                </div>
                <div class="reveal relative">
                    <div class="absolute -inset-5 rotate-2 border border-white/10" aria-hidden="true"></div>
                    <div class="relative border border-white/15 bg-[#202c43] p-5 sm:p-8">
                        <div class="flex items-center justify-between gap-3 border-b border-white/10 pb-4">
                            <div>
                                <p class="eyebrow text-white/45">Integration flow</p>
                                <h3 class="mt-2 font-display text-lg font-bold">Connect your tools</h3>
                            </div>
                            <span class="rounded-full bg-white/10 px-3 py-1.5 font-mono text-[10px] text-lime">API</span>
                        </div>
                        <div class="mt-6 grid gap-3 sm:grid-cols-[1fr_auto_1fr_auto_1fr] sm:items-center">
                            <div class="border border-white/10 bg-white/[.04] p-4">
                                <p class="eyebrow text-white/40">Your app</p><p class="mt-3 text-sm font-semibold">Request</p>
                            </div>
                            <span class="text-center text-lime" aria-hidden="true">→</span>
                            <div class="border border-blue/50 bg-blue/15 p-4">
                                <p class="eyebrow text-white/40">Panel API</p><p class="mt-3 text-sm font-semibold">Supported action</p>
                            </div>
                            <span class="text-center text-lime" aria-hidden="true">→</span>
                            <div class="border border-white/10 bg-white/[.04] p-4">
                                <p class="eyebrow text-white/40">Account</p><p class="mt-3 text-sm font-semibold">Order status</p>
                            </div>
                        </div>
                        <p class="mt-5 text-xs leading-5 text-white/45">Check the API page for authentication details and supported parameters.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="bg-paper py-16 sm:py-24">
            <div class="mx-auto grid max-w-7xl gap-10 px-5 sm:px-8 lg:grid-cols-[.7fr_1.3fr] lg:gap-16">
                <div class="reveal">
                    <p class="eyebrow text-blue">FAQ</p>
                    <h2 class="mt-3 font-display text-4xl font-bold sm:text-5xl">Questions, answered.</h2>
                    <p class="mt-4 max-w-sm text-sm leading-6 text-muted">Service availability and conditions are specific to each listing.</p>
                </div>
                <div class="reveal divide-y divide-line border-y border-line">
                    <details class="faq-item py-1">
                        <summary class="flex min-h-[70px] cursor-pointer list-none items-center justify-between gap-5 font-display text-base font-bold sm:text-lg">What is an SMM panel?<span class="faq-plus grid h-8 w-8 shrink-0 place-items-center rounded-full border border-line text-xl font-normal transition-transform" aria-hidden="true">+</span></summary>
                        <p class="max-w-2xl pb-5 pr-10 text-sm leading-6 text-muted">It is a dashboard for browsing social media service listings, submitting orders, and reviewing order information in one account.</p>
                    </details>
                    <details class="faq-item py-1">
                        <summary class="flex min-h-[70px] cursor-pointer list-none items-center justify-between gap-5 font-display text-base font-bold sm:text-lg">How do I compare services?<span class="faq-plus grid h-8 w-8 shrink-0 place-items-center rounded-full border border-line text-xl font-normal transition-transform" aria-hidden="true">+</span></summary>
                        <p class="max-w-2xl pb-5 pr-10 text-sm leading-6 text-muted">Review each listing's description, rate, limits, and requirements. These details can vary between services.</p>
                    </details>
                    <details class="faq-item py-1">
                        <summary class="flex min-h-[70px] cursor-pointer list-none items-center justify-between gap-5 font-display text-base font-bold sm:text-lg">Where can I review order status?<span class="faq-plus grid h-8 w-8 shrink-0 place-items-center rounded-full border border-line text-xl font-normal transition-transform" aria-hidden="true">+</span></summary>
                        <p class="max-w-2xl pb-5 pr-10 text-sm leading-6 text-muted">Sign in and open the orders area in your account to review status and available actions.</p>
                    </details>
                    <details class="faq-item py-1">
                        <summary class="flex min-h-[70px] cursor-pointer list-none items-center justify-between gap-5 font-display text-base font-bold sm:text-lg">Does the panel offer API access?<span class="faq-plus grid h-8 w-8 shrink-0 place-items-center rounded-full border border-line text-xl font-normal transition-transform" aria-hidden="true">+</span></summary>
                        <p class="max-w-2xl pb-5 pr-10 text-sm leading-6 text-muted">API documentation is available from the API page. Check it for current endpoints, parameters, and authentication requirements.</p>
                    </details>
                    <details class="faq-item py-1">
                        <summary class="flex min-h-[70px] cursor-pointer list-none items-center justify-between gap-5 font-display text-base font-bold sm:text-lg">What payment methods can I use?<span class="faq-plus grid h-8 w-8 shrink-0 place-items-center rounded-full border border-line text-xl font-normal transition-transform" aria-hidden="true">+</span></summary>
                        <p class="max-w-2xl pb-5 pr-10 text-sm leading-6 text-muted">Available methods and terms are displayed in the funding section after signing in.</p>
                    </details>
                </div>
            </div>
        </section>

        <section class="px-5 pb-16 sm:px-8 sm:pb-24">
            <div class="reveal mx-auto grid max-w-7xl gap-7 rounded-lg bg-blue px-6 py-10 text-white sm:px-12 sm:py-14 md:grid-cols-[1fr_auto] md:items-center">
                <div>
                    <p class="eyebrow text-white/70">Start with the catalog</p>
                    <h2 class="mt-3 max-w-3xl font-display text-3xl font-bold leading-tight sm:text-5xl">Find the service details you need before you order.</h2>
                    <p class="mt-4 max-w-2xl text-sm leading-6 text-white/75">Create an account to browse available services and manage orders from your workspace.</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('signup') }}" class="inline-flex min-h-12 items-center gap-2 rounded-full bg-white px-5 text-sm font-bold text-blue hover:bg-lime">Create account <span aria-hidden="true">↗</span></a>
                    <a href="{{ route('clients.services.index') }}" class="inline-flex min-h-12 items-center rounded-full border border-white/50 px-5 text-sm font-bold text-white hover:bg-white/10">Browse services</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-line bg-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-5 py-12 sm:px-8 md:grid-cols-[1.3fr_.7fr_.7fr]">
            <div>
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-3 font-display text-lg font-bold">
                    @if (!empty($config?->logo))
                        <img src="{{ $config->logo }}" alt="" class="h-9 w-9 rounded-lg object-contain">
                    @else
                        <span class="grid h-9 w-9 place-items-center rounded-lg bg-blue text-white">{{ strtoupper(substr(getDomain(), 0, 1)) }}</span>
                    @endif
                    {{ getDomain() }}
                </a>
                <p class="mt-4 max-w-sm text-sm leading-6 text-muted">A practical workspace for browsing social media services, managing orders, and connecting supported workflows.</p>
            </div>
            <div>
                <p class="eyebrow mb-4 text-muted">Explore</p>
                <ul class="space-y-3 text-sm font-semibold text-ink">
                    <li><a class="hover:text-blue" href="{{ route('clients.services.index') }}">Service list</a></li>
                    <li><a class="hover:text-blue" href="{{ route('clients.api.index') }}">API documentation</a></li>
                    <li><a class="hover:text-blue" href="#faq">FAQ</a></li>
                </ul>
            </div>
            <div>
                <p class="eyebrow mb-4 text-muted">Account</p>
                <ul class="space-y-3 text-sm font-semibold text-ink">
                    <li><a class="hover:text-blue" href="{{ route('signup') }}">Create account</a></li>
                    <li><a class="hover:text-blue" href="{{ route('login') }}">Sign in</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-line">
            <div class="mx-auto flex max-w-7xl flex-col gap-2 px-5 py-5 text-xs text-muted sm:flex-row sm:items-center sm:justify-between sm:px-8">
                <span>(c) {{ date('Y') }} {{ getDomain() }}</span>
                <span>Review the terms shown with each service before ordering.</span>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const header = document.getElementById('siteHeader');
            const menuButton = document.getElementById('menuToggle');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuOpen = menuButton.querySelector('.menu-open');
            const menuClose = menuButton.querySelector('.menu-close');

            window.addEventListener('scroll', function () {
                header.classList.toggle('is-scrolled', window.scrollY > 12);
            }, { passive: true });

            menuButton.addEventListener('click', function () {
                const isOpen = menuButton.getAttribute('aria-expanded') === 'true';
                menuButton.setAttribute('aria-expanded', String(!isOpen));
                menuButton.setAttribute('aria-label', isOpen ? 'Open navigation' : 'Close navigation');
                mobileMenu.classList.toggle('hidden', isOpen);
                menuOpen.classList.toggle('hidden', !isOpen);
                menuClose.classList.toggle('hidden', isOpen);
            });

            mobileMenu.querySelectorAll('a[href^="#"]').forEach(function (link) {
                link.addEventListener('click', function () {
                    menuButton.setAttribute('aria-expanded', 'false');
                    menuButton.setAttribute('aria-label', 'Open navigation');
                    mobileMenu.classList.add('hidden');
                    menuOpen.classList.remove('hidden');
                    menuClose.classList.add('hidden');
                });
            });

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
