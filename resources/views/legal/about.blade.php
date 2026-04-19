<x-layouts.main>

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-linear-to-br from-indigo-950/60 via-zinc-950 to-zinc-950 py-20 md:py-28">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_80%_60%_at_50%_-10%,rgb(99_102_241_/_0.12),transparent)]" aria-hidden="true"></div>

        <x-sur.container :narrow="true">
            <x-sur.reveal>
                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-400">About</p>
                <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                    Built for game night.<br class="hidden sm:block"> Free forever.
                </h1>
                <p class="mt-5 max-w-xl text-base leading-relaxed text-zinc-400 sm:text-lg">
                    Smash Up Randomizer is a fan-made web app that takes the hassle out of picking factions.
                    No login, no ads, no nonsense — just shuffle and play.
                </p>
            </x-sur.reveal>
        </x-sur.container>
    </section>

    {{-- Stats bar --}}
    <div class="border-y border-white/8 bg-zinc-950/80">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-center gap-x-8 gap-y-3 px-4 py-4 sm:px-6 lg:px-8">
            <span class="flex items-center gap-2 text-sm text-zinc-300">
                <i class="fa-solid fa-layer-group text-indigo-400" aria-hidden="true"></i>
                <strong class="text-white">{{ $factionCount }}</strong>&nbsp;factions supported
            </span>
            <span class="hidden h-3 w-px bg-white/15 sm:block" aria-hidden="true"></span>
            <span class="flex items-center gap-2 text-sm text-zinc-300">
                <i class="fa-solid fa-circle-check text-indigo-400" aria-hidden="true"></i>
                100% free
            </span>
            <span class="hidden h-3 w-px bg-white/15 sm:block" aria-hidden="true"></span>
            <span class="flex items-center gap-2 text-sm text-zinc-300">
                <i class="fa-solid fa-user-slash text-indigo-400" aria-hidden="true"></i>
                No account needed
            </span>
            <span class="hidden h-3 w-px bg-white/15 sm:block" aria-hidden="true"></span>
            <span class="flex items-center gap-2 text-sm text-zinc-300">
                <i class="fa-solid fa-boxes-stacked text-indigo-400" aria-hidden="true"></i>
                All expansions
            </span>
        </div>
    </div>

    {{-- The project --}}
    <x-sur.section class="border-b border-white/6 bg-zinc-900/30">
        <x-sur.reveal>
            <div class="grid gap-10 md:grid-cols-2 md:gap-16">
                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-widest text-indigo-400">The Project</p>
                    <h2 class="mb-4 text-2xl font-bold text-white">
                        The problem with picking factions by hand
                    </h2>
                    <div class="space-y-4 leading-relaxed text-zinc-400">
                        <p>
                            Every Smash Up session starts the same way: someone grabs the faction tokens, tries to
                            shuffle them "fairly," and inevitably someone ends up unhappy with the deal. Disputes,
                            re-draws, house rules that nobody agreed on first.
                        </p>
                        <p>
                            Smash Up Randomizer was built to solve exactly that. Pick your player count,
                            tell the app which expansions you own, and hit shuffle. The server assigns every
                            player two factions — truly random, visually clear, no arguments.
                        </p>
                        <p>
                            It started as a small personal tool and grew into something worth sharing. It's still
                            maintained by a single developer, updated whenever new expansions drop, and will
                            stay free indefinitely.
                        </p>
                    </div>
                </div>

                <div>
                    <p class="mb-2 text-xs font-bold uppercase tracking-widest text-violet-400">Under the hood</p>
                    <h2 class="mb-4 text-2xl font-bold text-white">Built in the open</h2>
                    <ul class="space-y-3 text-sm text-zinc-400">
                        @foreach([
                            ['icon' => 'fa-brands fa-laravel text-red-400',   'name' => 'Laravel',      'note' => 'PHP framework — backend logic, routing, data'],
                            ['icon' => 'fa-brands fa-js text-yellow-400',      'name' => 'Alpine.js',    'note' => 'Lightweight JS for interactive UI elements'],
                            ['icon' => 'fa-solid fa-wind text-sky-400',        'name' => 'Tailwind CSS', 'note' => 'Utility-first styles, dark theme throughout'],
                            ['icon' => 'fa-solid fa-bolt text-amber-400',      'name' => 'Vite',         'note' => 'Frontend build pipeline & hot reload in dev'],
                            ['icon' => 'fa-solid fa-chart-bar text-indigo-400','name' => 'Matomo',       'note' => 'Self-hosted analytics — opt-in only, no third parties'],
                        ] as $tech)
                        <li class="flex items-start gap-3">
                            <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-md border border-white/10 bg-zinc-800/60">
                                <i class="{{ $tech['icon'] }} text-xs" aria-hidden="true"></i>
                            </span>
                            <span>
                                <strong class="font-semibold text-zinc-200">{{ $tech['name'] }}</strong>
                                <span class="ml-1 text-zinc-500">— {{ $tech['note'] }}</span>
                            </span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </x-sur.reveal>
    </x-sur.section>

    {{-- Three values --}}
    <x-sur.section>
        <x-sur.reveal>
            <div class="mb-10 text-center">
                <p class="mb-2 text-xs font-bold uppercase tracking-widest text-indigo-400">Principles</p>
                <h2 class="text-2xl font-bold text-white sm:text-3xl">What we care about</h2>
            </div>
        </x-sur.reveal>

        <div class="grid gap-6 sm:grid-cols-3">
            @php
            $values = [
                [
                    'delay'   => 0,
                    'icon'    => 'fa-solid fa-shield-halved',
                    'color'   => 'text-emerald-400',
                    'border'  => 'border-top: 2px solid rgb(52 211 153 / 0.55);',
                    'title'   => 'Privacy first',
                    'body'    => 'Analytics run on our own Matomo instance — opt-in only. Zero third-party trackers, zero ad networks. Your session data stays yours.',
                ],
                [
                    'delay'   => 60,
                    'icon'    => 'fa-solid fa-dice',
                    'color'   => 'text-indigo-400',
                    'border'  => 'border-top: 2px solid rgb(99 102 241 / 0.55);',
                    'title'   => 'True randomness',
                    'body'    => 'Faction assignments are generated server-side using PHP\'s cryptographically seeded shuffle. No patterns, no favorites — every draw is genuinely fair.',
                ],
                [
                    'delay'   => 120,
                    'icon'    => 'fa-solid fa-bolt-lightning',
                    'color'   => 'text-amber-400',
                    'border'  => 'border-top: 2px solid rgb(251 191 36 / 0.55);',
                    'title'   => 'Radical simplicity',
                    'body'    => 'Three steps: pick players, pick expansions, shuffle. No account, no tutorial, no dark patterns. You\'re done before the snacks are out.',
                ],
            ];
            @endphp

            @foreach($values as $value)
            <x-sur.reveal :delay="$value['delay']">
                <div class="sur-card h-full border-white/8" style="{{ $value['border'] }}">
                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl border border-white/10 bg-zinc-800/60">
                        <i class="{{ $value['icon'] }} {{ $value['color'] }} text-xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="mb-2 text-base font-semibold text-white">{{ $value['title'] }}</h3>
                    <p class="text-sm leading-relaxed text-zinc-400">{{ $value['body'] }}</p>
                </div>
            </x-sur.reveal>
            @endforeach
        </div>
    </x-sur.section>

    {{-- CTA --}}
    <x-sur.section class="border-t border-white/6 bg-indigo-950/20" :padded="true">
        <x-sur.reveal>
            <div class="mx-auto max-w-xl text-center">
                <h2 class="mb-3 text-2xl font-bold text-white sm:text-3xl">
                    Stop arguing.<br class="hidden sm:block"> Start playing.
                </h2>
                <p class="mb-8 text-zinc-400">
                    The table is set, the snacks are ready. All you need is a fair deal on factions.
                </p>
                <a href="{{ route('home') }}" class="sur-btn-primary inline-flex min-h-12 items-center gap-2">
                    <i class="fa-solid fa-shuffle" aria-hidden="true"></i>
                    Shuffle Now
                </a>
            </div>
        </x-sur.reveal>
    </x-sur.section>

</x-layouts.main>
