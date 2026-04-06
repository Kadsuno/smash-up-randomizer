<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="title" content="SmashUp Randomizer">
    <meta name="description" content="With the help of the Smash Up Randomizer, factions of the card game Smash Up can be shuffled and assigned to players.">
    <meta name="keywords" content="SmashUp, Card game, Card, Game, Randomizer">
    <meta property="og:title" content="Assigning randomized factions" />
    <meta property="og:image" content="{{ asset('images/favicons/favicon.ico') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="SmashUp Randomizer" />
    <meta property="og:description" content="With the help of the Smash Up Randomizer, factions of the card game Smash Up can be shuffled and assigned to players." />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="Assigning randomized factions" />
    <meta name="twitter:description" content="With the help of the Smash Up Randomizer, factions of the card game Smash Up can be shuffled and assigned to players." />
    <meta name="twitter:image" content="{{ asset('images/favicons/favicon.ico') }}" />
    <meta name="robots" content="index,follow" />
    <meta name="googlebot" content="index,follow" />
    <title>Smash Up Randomizer</title>
    @vite(['resources/css/app.css'])
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons/site.webmanifest') }}">
    <link rel="canonical" href="https://www.smash-up-randomizer.com">

</head>

<body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">
    <nav
        x-data="{ open: false }"
        @keydown.window.escape="open = false"
        class="fixed top-0 z-50 w-full border-b border-white/10 bg-zinc-950/80 backdrop-blur-xl transition-colors duration-300"
    >
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-3 sm:px-6">
            <a class="flex min-h-11 items-center gap-2 rounded-lg pr-2 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60" href="{{ route('home') }}">
                <img src="{{ asset('images/favicons/favicon.ico') }}" class="h-8 w-8" alt="Logo" width="32" height="32">
                <span class="font-bold tracking-tight text-white">Smash Up Randomizer</span>
            </a>
            <button
                type="button"
                class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-zinc-100 transition hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60 lg:hidden"
                @click="open = !open"
                :aria-expanded="open.toString()"
                aria-controls="primary-nav-panel"
                aria-label="Toggle navigation"
            >
                <span class="sr-only">Toggle navigation</span>
                <svg x-show="!open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-cloak x-show="open" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
            <div class="hidden items-center gap-1 lg:flex" id="desktop-nav">
                <a class="sur-link-nav" href="{{ route('factionList') }}">Factions</a>
                <a class="sur-link-nav" href="{{ route('about') }}">About</a>
                <a class="sur-link-nav" href="{{ route('contact') }}">Contact</a>
            </div>
        </div>
        <div
            x-cloak
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1"
            id="primary-nav-panel"
            class="border-t border-white/10 bg-zinc-950/95 px-4 py-4 lg:hidden"
            style="display: none;"
        >
            <div class="flex flex-col gap-1">
                <a class="sur-link-nav" href="{{ route('factionList') }}">Factions</a>
                <a class="sur-link-nav" href="{{ route('about') }}">About</a>
                <a class="sur-link-nav" href="{{ route('contact') }}">Contact</a>
            </div>
        </div>
    </nav>
