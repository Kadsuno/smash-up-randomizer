<x-layouts.main>

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
    @endphp

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-white/6 bg-linear-to-br from-indigo-950/50 via-zinc-950 to-zinc-950 py-16 md:py-20">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_50%_at_50%_-5%,rgb(99_102_241_/_0.10),transparent)]" aria-hidden="true"></div>
        <x-sur.container>
            <x-sur.reveal>
                <a href="{{ route('expansions') }}" class="mb-5 inline-flex items-center gap-1.5 text-xs font-semibold text-zinc-500 transition hover:text-zinc-300">
                    <i class="fa-solid fa-arrow-left text-[0.6rem]" aria-hidden="true"></i>
                    {{ __('frontend.expansion_back_link') }}
                </a>
                <p class="mb-3 text-xs font-bold uppercase tracking-widest text-indigo-400">{{ __('frontend.expansions_hero_eyebrow') }}</p>
                <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    {{ $expansionName }}
                </h1>
                <p class="mt-3 text-sm text-zinc-500">
                    {{ __('frontend.expansions_factions_label', ['count' => $decks->count()]) }} &middot; {{ __('frontend.expansion_detail_sub') }}
                </p>
            </x-sur.reveal>
        </x-sur.container>
    </section>

    {{-- Faction grid --}}
    <x-sur.section>
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($decks as $deck)
            @php
                $palette = $palettes[$loop->index % count($palettes)];
                $letter  = strtoupper(substr($deck->name, 0, 1));
            @endphp
            <x-sur.reveal :delay="($loop->index % 8) * 20">
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
                                <span class="select-none text-5xl font-black text-white/10">{{ $letter }}</span>
                            </div>
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
            </x-sur.reveal>
            @endforeach
        </div>

        {{-- Bottom nav --}}
        <x-sur.reveal>
            <div class="mt-10 flex items-center justify-between border-t border-white/6 pt-6">
                <a href="{{ route('expansions') }}" class="inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-200">
                    <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                    {{ __('frontend.expansion_back_link') }}
                </a>
                <a href="{{ route('home') }}#wizard" class="sur-btn-primary inline-flex items-center gap-2">
                    <i class="fa-solid fa-shuffle text-xs" aria-hidden="true"></i>
                    {{ __('frontend.nav_shuffle') }}
                </a>
            </div>
        </x-sur.reveal>
    </x-sur.section>

</x-layouts.main>
