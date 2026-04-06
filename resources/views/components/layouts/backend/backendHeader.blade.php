<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Smash Up Randomizer Backend</title>

    @vite(['resources/css/app.css'])
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/brand/logo-mark.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons/site.webmanifest') }}">
</head>

<body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">
    <nav x-data="{ menuOpen: false, userOpen: false }" @keydown.escape.window="menuOpen = false; userOpen = false" class="fixed top-0 z-50 w-full border-b border-indigo-500/20 bg-linear-to-r from-zinc-900 via-zinc-950 to-zinc-900 shadow-lg shadow-black/40">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-3 px-4 py-3 sm:px-6">
            <a class="flex min-h-11 items-center gap-2 rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/brand/logo-mark.svg') }}" class="h-8 w-8 shrink-0" alt="{{ __('frontend.logo_alt') }}" width="32" height="32" decoding="async">
                <span class="font-bold text-white">Smash Up Randomizer</span>
            </a>
            <div class="flex items-center gap-2">
                <div class="relative" @click.outside="userOpen = false">
                    <button type="button"
                        class="inline-flex min-h-11 items-center gap-2 rounded-xl border border-white/10 bg-white/5 px-3 py-2 text-sm font-medium text-zinc-100 transition hover:bg-white/10 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60"
                        @click="userOpen = !userOpen"
                        :aria-expanded="userOpen.toString()"
                        aria-haspopup="true"
                    >
                        <i class="fa-regular fa-user text-indigo-400" aria-hidden="true"></i>
                        <span class="max-w-[10rem] truncate">{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-xs text-zinc-500" aria-hidden="true"></i>
                    </button>
                    <div x-cloak x-show="userOpen" x-transition
                        class="absolute right-0 z-50 mt-2 w-56 origin-top-right rounded-xl border border-white/10 bg-zinc-900 py-1 shadow-xl shadow-black/50"
                        style="display: none;"
                    >
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 px-4 py-3 text-left text-sm text-zinc-200 transition hover:bg-white/5 hover:text-indigo-300">
                                <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                                <span>{{ __('backend.logout') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>
