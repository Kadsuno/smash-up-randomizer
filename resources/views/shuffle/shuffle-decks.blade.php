<x-layouts.main>

    @php
        $playerCount = count($selectedDecks);

        $playerAccents = [
            1 => ['border' => 'border-indigo-500/40',  'bg' => 'bg-indigo-500/10',  'text' => 'text-indigo-400',  'ring' => 'ring-indigo-500/30'],
            2 => ['border' => 'border-violet-500/40',  'bg' => 'bg-violet-500/10',  'text' => 'text-violet-400',  'ring' => 'ring-violet-500/30'],
            3 => ['border' => 'border-emerald-500/40', 'bg' => 'bg-emerald-500/10', 'text' => 'text-emerald-400', 'ring' => 'ring-emerald-500/30'],
            4 => ['border' => 'border-rose-500/40',    'bg' => 'bg-rose-500/10',    'text' => 'text-rose-400',    'ring' => 'ring-rose-500/30'],
        ];

        $factionPalettes = [
            'from-indigo-900/70 to-violet-900/70',
            'from-emerald-900/70 to-teal-900/70',
            'from-rose-900/70 to-pink-900/70',
            'from-amber-900/70 to-orange-900/70',
            'from-sky-900/70 to-blue-900/70',
            'from-violet-900/70 to-purple-900/70',
            'from-teal-900/70 to-cyan-900/70',
            'from-red-900/70 to-rose-900/70',
        ];

        $gridClass = match($playerCount) {
            2       => 'grid-cols-1 sm:grid-cols-2',
            3       => 'grid-cols-1 sm:grid-cols-3',
            default => 'grid-cols-1 sm:grid-cols-2 xl:grid-cols-4',
        };
    @endphp

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-white/6 bg-linear-to-br from-indigo-950/60 via-zinc-950 to-zinc-950 py-14 md:py-20">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_60%_50%_at_50%_-10%,rgb(99_102_241_/_0.15),transparent)]" aria-hidden="true"></div>
        <x-sur.container>
            <x-sur.reveal>
                <div class="text-center">
                    <p class="mb-3 inline-flex items-center gap-2 rounded-full border border-indigo-500/20 bg-indigo-900/20 px-3 py-1 text-xs font-bold uppercase tracking-widest text-indigo-400">
                        <i class="fa-solid fa-shuffle text-[0.6rem]" aria-hidden="true"></i>
                        {{ __('frontend.shuffle_results') }}
                    </p>
                    <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                        Your factions are ready!
                    </h1>
                    <p class="mt-3 text-sm text-zinc-500">
                        {{ $playerCount }} {{ $playerCount === 1 ? 'player' : 'players' }} · {{ $playerCount * 2 }} factions assigned · good luck at the table
                    </p>
                </div>
            </x-sur.reveal>
        </x-sur.container>
    </section>

    {{-- Results grid --}}
    <x-sur.section>
        <x-sur.container>

            <div class="grid {{ $gridClass }} gap-5">
                @foreach($selectedDecks as $playerDecks)
                @php
                    $n      = $loop->iteration;
                    $accent = $playerAccents[$n] ?? $playerAccents[1];
                @endphp
                <x-sur.reveal :delay="$loop->index * 80">
                    <div class="flex h-full flex-col overflow-hidden rounded-2xl border {{ $accent['border'] }} bg-zinc-900/60">

                        {{-- Player header --}}
                        <div class="{{ $accent['bg'] }} border-b {{ $accent['border'] }} px-5 py-3 text-center">
                            <span class="text-xs font-bold uppercase tracking-widest {{ $accent['text'] }}">
                                {{ __('frontend.player') }} {{ $n }}
                            </span>
                        </div>

                        {{-- Faction pair --}}
                        <div class="flex flex-1 flex-col gap-3 p-4">
                            @foreach($playerDecks as $i => $deck)
                            @php
                                $palette = $factionPalettes[abs(crc32($deck['name'])) % count($factionPalettes)];
                                $letter  = strtoupper(substr($deck['name'], 0, 1));
                            @endphp

                            <a
                                href="{{ route('factionDetail', ['name' => $deck['name']]) }}"
                                class="group relative flex items-center gap-3 overflow-hidden rounded-xl border border-white/6 bg-linear-to-br {{ $palette }} p-4 transition duration-200 hover:border-white/15 hover:brightness-110"
                            >
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-black/20 text-lg font-black text-white/20 select-none">
                                    {{ $letter }}
                                </span>
                                <span class="text-sm font-bold leading-tight text-white">
                                    {{ $deck['name'] }}
                                </span>
                                <i class="fa-solid fa-arrow-right ml-auto shrink-0 text-[0.6rem] text-white/30 transition group-hover:text-white/60" aria-hidden="true"></i>
                            </a>

                            @if(!$loop->last)
                                <div class="flex items-center gap-2">
                                    <div class="h-px flex-1 bg-white/6"></div>
                                    <span class="text-[0.65rem] font-bold uppercase tracking-widest text-zinc-700">+</span>
                                    <div class="h-px flex-1 bg-white/6"></div>
                                </div>
                            @endif

                            @endforeach
                        </div>

                    </div>
                </x-sur.reveal>
                @endforeach
            </div>

            {{-- Actions --}}
            <x-sur.reveal :delay="$playerCount * 80 + 40">
                <div class="mt-10 flex flex-wrap items-center justify-center gap-3">
                    <a
                        href="{{ route('home') }}#wizard"
                        class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-500 active:scale-[0.98]"
                    >
                        <i class="fa-solid fa-shuffle text-xs" aria-hidden="true"></i>
                        {{ __('frontend.shuffle_again') }}
                    </a>
                    <a
                        href="{{ route('factionList') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/10 bg-zinc-900/60 px-5 py-2.5 text-sm font-semibold text-zinc-300 transition hover:border-white/20 hover:text-white"
                    >
                        <i class="fa-solid fa-list text-xs" aria-hidden="true"></i>
                        Browse all factions
                    </a>
                </div>
            </x-sur.reveal>

        </x-sur.container>
    </x-sur.section>

</x-layouts.main>
