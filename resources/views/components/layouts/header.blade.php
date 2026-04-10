<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ __('frontend.meta_description') }}">
    <meta name="keywords" content="Smash Up, card game, randomizer, faction picker, board game tool">
    <meta property="og:title" content="{{ __('frontend.meta_og_title') }}" />
    <meta property="og:image" content="{{ asset('images/result.png') }}" />
    <meta property="og:image:width" content="1792" />
    <meta property="og:image:height" content="1024" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="Smash Up Randomizer" />
    <meta property="og:description" content="{{ __('frontend.meta_description') }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ __('frontend.meta_og_title') }}" />
    <meta name="twitter:description" content="{{ __('frontend.meta_description') }}" />
    <meta name="twitter:image" content="{{ asset('images/result.png') }}" />
    <meta name="robots" content="index,follow" />
    <meta name="googlebot" content="index,follow" />
    <title>Smash Up Randomizer</title>
    @vite(['resources/css/app.css'])
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/brand/logo-mark.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons/site.webmanifest') }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @stack('head')
    @env('production')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebApplication",
        "name": "Smash Up Randomizer",
        "url": "{{ config('app.url') }}",
        "description": "{{ __('frontend.meta_description') }}",
        "applicationCategory": "GameApplication",
        "operatingSystem": "Any",
        "offers": {
            "@@type": "Offer",
            "price": "0",
            "priceCurrency": "EUR"
        },
        "inLanguage": ["en", "de"]
    }
    </script>
    @endenv

</head>

<body class="flex min-h-screen flex-col bg-zinc-950 text-zinc-100 antialiased">
    <a href="#main-content" class="sur-skip-link">{{ __('frontend.skip_to_content') }}</a>
    <nav
        x-data="{ open: false, scrolled: false }"
        @keydown.window.escape="open = false"
        @scroll.window="scrolled = (window.pageYOffset || document.documentElement.scrollTop) > 12"
        :class="{ 'sur-site-header--scrolled': scrolled }"
        class="sur-site-header"
        aria-label="Primary"
    >
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8 lg:h-[4.25rem]">
            <a class="group flex min-h-11 min-w-0 flex-1 items-center gap-3 rounded-xl py-1 pr-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60 lg:flex-none" href="{{ route('home') }}" aria-label="{{ __('frontend.logo_alt') }}">
                <span class="relative flex h-9 w-9 shrink-0 items-center justify-center rounded-xl ring-1 ring-white/[0.08] transition duration-300 group-hover:ring-indigo-400/30">
                    <img src="{{ asset('images/brand/logo-mark.svg') }}" class="h-7 w-7" alt="" width="28" height="28" decoding="async" aria-hidden="true">
                </span>
                <span class="min-w-0 truncate text-left text-sm font-bold tracking-tight text-white sm:text-base">{{ __('frontend.logo_alt') }}</span>
            </a>

            <div class="hidden items-center gap-3 lg:flex">
                <div class="flex items-center rounded-full border border-white/10 bg-white/[0.04] p-1 shadow-inner shadow-black/20 backdrop-blur-md">
                    <x-site-nav-link routeName="factionList" :routes="['factionList', 'factionDetail']" :label="__('frontend.nav_factions')" />
                    <x-site-nav-link routeName="about" :label="__('frontend.nav_about')" />
                    <x-site-nav-link routeName="contact" :label="__('frontend.nav_contact')" />
                </div>
                <a
                    href="{{ route('home') }}#wizard"
                    class="{{ request()->routeIs('home') ? 'ring-2 ring-indigo-400/40 ring-offset-2 ring-offset-zinc-950' : '' }} sur-btn-primary min-h-10 rounded-full px-5 text-sm shadow-indigo-500/20"
                >
                    <i class="fa-solid fa-shuffle me-2 opacity-90" aria-hidden="true"></i>{{ __('frontend.nav_shuffle') }}
                </a>
            </div>

            <button
                type="button"
                class="inline-flex min-h-11 min-w-11 shrink-0 items-center justify-center rounded-full border border-white/10 bg-white/[0.06] text-zinc-100 transition hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60 lg:hidden"
                @click="open = !open"
                :aria-expanded="open.toString()"
                aria-controls="primary-nav-panel"
                aria-label="{{ __('frontend.nav_toggle') }}"
            >
                <span class="sr-only">{{ __('frontend.nav_toggle') }}</span>
                <svg x-show="!open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-cloak x-show="open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div
            x-cloak
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            id="primary-nav-panel"
            class="absolute inset-x-0 top-full z-40 border-b border-white/10 bg-zinc-950/95 shadow-2xl shadow-black/50 backdrop-blur-xl lg:hidden"
            style="display: none;"
        >
            <div class="mx-auto max-w-7xl space-y-1 px-4 py-4">
                <x-site-nav-link routeName="factionList" :routes="['factionList', 'factionDetail']" :label="__('frontend.nav_factions')" :mobile="true" />
                <x-site-nav-link routeName="about" :label="__('frontend.nav_about')" :mobile="true" />
                <x-site-nav-link routeName="contact" :label="__('frontend.nav_contact')" :mobile="true" />
                <a href="{{ route('home') }}#wizard" class="sur-btn-primary mt-3 flex w-full min-h-12 justify-center gap-2 rounded-xl">
                    <i class="fa-solid fa-shuffle" aria-hidden="true"></i>{{ __('frontend.nav_shuffle') }}
                </a>
            </div>
        </div>
    </nav>
