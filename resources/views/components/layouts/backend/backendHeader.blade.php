<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Smash Up Randomizer · Admin</title>
    @vite(['resources/css/app.css'])
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/brand/logo-mark.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favicons/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicons/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicons/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favicons/site.webmanifest') }}">
</head>

<body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">
    <header
        x-data="{ userOpen: false }"
        @keydown.escape.window="userOpen = false"
        class="fixed top-0 z-50 w-full border-b border-white/6 bg-zinc-950/95 backdrop-blur-sm"
    >
        <div class="flex h-14 items-center justify-between gap-4 px-4 sm:px-6">

            {{-- Logo --}}
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60 rounded-lg">
                <img src="{{ asset('images/brand/logo-mark.svg') }}" class="h-7 w-7 shrink-0" alt="" width="28" height="28" decoding="async">
                <span class="font-bold text-white text-sm">Smash Up Randomizer</span>
                <span class="rounded-md border border-indigo-500/30 bg-indigo-500/10 px-1.5 py-0.5 text-[0.6rem] font-bold uppercase tracking-wider text-indigo-400">Admin</span>
            </a>

            {{-- User menu --}}
            <div class="relative" @click.outside="userOpen = false">
                <button
                    type="button"
                    @click="userOpen = !userOpen"
                    :aria-expanded="userOpen.toString()"
                    aria-haspopup="true"
                    class="flex items-center gap-2 rounded-lg px-2.5 py-1.5 text-sm text-zinc-300 transition hover:bg-white/5 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60"
                >
                    <span class="flex h-7 w-7 items-center justify-center rounded-full bg-indigo-600/30 text-xs font-bold text-indigo-300">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </span>
                    <span class="hidden max-w-[8rem] truncate sm:block">{{ Auth::user()->name }}</span>
                    <i class="fa-solid fa-chevron-down text-[0.6rem] text-zinc-600" :class="userOpen ? 'rotate-180' : ''" style="transition: transform 0.15s;" aria-hidden="true"></i>
                </button>

                <div
                    x-cloak
                    x-show="userOpen"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 z-50 mt-1 w-48 origin-top-right overflow-hidden rounded-xl border border-white/8 bg-zinc-900 shadow-xl shadow-black/50"
                    style="display: none;"
                >
                    <div class="border-b border-white/6 px-3 py-2.5">
                        <p class="text-xs font-semibold text-zinc-200">{{ Auth::user()->name }}</p>
                        <p class="truncate text-xs text-zinc-600">{{ Auth::user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 px-3 py-2.5 text-left text-sm text-zinc-400 transition hover:bg-white/5 hover:text-red-400">
                            <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center text-xs" aria-hidden="true"></i>
                            {{ __('backend.logout') }}
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </header>
