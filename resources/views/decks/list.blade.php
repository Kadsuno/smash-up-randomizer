<x-layouts.main>

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-white/6 bg-linear-to-br from-indigo-950/50 via-zinc-950 to-zinc-950 py-16 md:py-20">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_50%_at_50%_-5%,rgb(99_102_241_/_0.10),transparent)]" aria-hidden="true"></div>
        <x-sur.container>
            <x-sur.reveal>
                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-400">Browse</p>
                <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    Faction List
                </h1>
                <p class="mt-3 max-w-xl text-sm leading-relaxed text-zinc-500">
                    All <strong class="font-semibold text-zinc-300">{{ $total }}</strong> factions from the Smash Up universe — find yours, explore their playstyle, and build the perfect combo.
                </p>
            </x-sur.reveal>
        </x-sur.container>
    </section>

    {{-- Main content --}}
    <x-sur.section>
        <div
            x-data="{
                search: '',
                get filtered() {
                    if (!this.search) return true;
                    return (name) => name.toLowerCase().includes(this.search.toLowerCase());
                },
                visibleCount: {{ $total }},
                updateCount() {
                    this.$nextTick(() => {
                        this.visibleCount = this.$el.querySelectorAll('[data-faction-card]:not([style*=\'display: none\'])').length;
                    });
                }
            }"
            @input.debounce.150ms="updateCount()"
        >
            {{-- Search bar --}}
            <div class="mb-8 flex items-center gap-3">
                <div class="relative flex-1 max-w-sm">
                    <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-zinc-500" aria-hidden="true"></i>
                    <input
                        x-model="search"
                        @input="updateCount()"
                        type="search"
                        placeholder="Search factions…"
                        class="w-full rounded-xl border border-white/8 bg-zinc-900/80 py-2.5 pl-9 pr-4 text-sm text-white placeholder-zinc-600 transition focus:border-indigo-500/50 focus:outline-none focus:ring-1 focus:ring-indigo-500/30"
                    >
                </div>
                <p class="shrink-0 text-sm text-zinc-600">
                    <span x-text="visibleCount"></span> factions
                </p>
            </div>

            {{-- Grid --}}
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach($decks as $deck)
                @php
                    $palettes = [
                        'from-indigo-900/80 to-violet-900/80',
                        'from-emerald-900/80 to-teal-900/80',
                        'from-rose-900/80 to-pink-900/80',
                        'from-amber-900/80 to-orange-900/80',
                        'from-sky-900/80 to-blue-900/80',
                        'from-violet-900/80 to-purple-900/80',
                        'from-teal-900/80 to-cyan-900/80',
                        'from-red-900/80 to-rose-900/80',
                    ];
                    $palette = $palettes[$loop->index % count($palettes)];
                    $letter  = strtoupper(substr($deck->name, 0, 1));
                @endphp
                <div
                    data-faction-card
                    x-show="!search || '{{ addslashes(strtolower($deck->name)) }}'.includes(search.toLowerCase())"
                    x-transition:enter="transition duration-150"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                >
                    <a
                        href="{{ route('factionDetail', ['name' => $deck->name]) }}"
                        class="group flex h-full flex-col overflow-hidden rounded-2xl border border-white/8 bg-zinc-900/60 transition duration-200 hover:border-indigo-500/30 hover:bg-zinc-800/60 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60"
                    >
                        {{-- Thumbnail --}}
                        <div class="relative h-36 overflow-hidden">
                            @if($deck->image)
                                <img
                                    src="{{ asset($deck->image) }}"
                                    alt="{{ $deck->name }}"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.04]"
                                    loading="lazy"
                                >
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-linear-to-br {{ $palette }}">
                                    <span class="text-5xl font-black text-white/10 select-none">{{ $letter }}</span>
                                </div>
                            @endif
                            {{-- Expansion badge --}}
                            @if($deck->expansion)
                                <span class="absolute bottom-2 left-2 rounded-full bg-black/60 px-2 py-0.5 text-[0.65rem] font-semibold text-zinc-300 backdrop-blur-sm">
                                    {{ $deck->expansion }}
                                </span>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="flex flex-1 flex-col gap-1.5 p-4">
                            <h2 class="text-sm font-bold leading-tight text-white transition group-hover:text-indigo-300">
                                {{ $deck->name }}
                            </h2>
                            @if($deck->teaser)
                                <p class="line-clamp-2 text-xs leading-relaxed text-zinc-500">{!! strip_tags($deck->teaser) !!}</p>
                            @else
                                <p class="text-xs italic text-zinc-700">No description yet.</p>
                            @endif
                            <div class="mt-auto pt-2">
                                <span class="inline-flex items-center gap-1 text-[0.65rem] font-semibold text-indigo-500 transition group-hover:text-indigo-400">
                                    View faction <i class="fa-solid fa-arrow-right text-[0.55rem]" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Empty state --}}
            <div
                x-show="visibleCount === 0"
                x-transition
                class="mt-16 flex flex-col items-center gap-3 text-center"
            >
                <i class="fa-solid fa-circle-xmark text-3xl text-zinc-700" aria-hidden="true"></i>
                <p class="text-sm text-zinc-500">No factions found for "<span class="text-zinc-300" x-text="search"></span>".</p>
                <button @click="search = ''; updateCount()" class="text-xs text-indigo-500 underline hover:text-indigo-400">Clear search</button>
            </div>
        </div>
    </x-sur.section>

</x-layouts.main>
