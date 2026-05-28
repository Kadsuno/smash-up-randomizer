<x-layouts.main>

    @php
        $hasAnyContent = !empty($deck->description)
            || !empty($deck->cardsTeaser)
            || !empty($deck->actions)
            || !empty($deck->characters)
            || !empty($deck->synergy)
            || !empty($deck->tips)
            || !empty($deck->mechanics);

        $palettes = [
            'from-indigo-900 to-violet-900',
            'from-emerald-900 to-teal-900',
            'from-rose-900 to-pink-900',
            'from-amber-900 to-orange-900',
            'from-sky-900 to-blue-900',
            'from-violet-900 to-purple-900',
            'from-teal-900 to-cyan-900',
            'from-red-900 to-rose-900',
        ];
        $palette = $palettes[abs(crc32($deck->name)) % count($palettes)];
        $letter  = strtoupper(substr($deck->name, 0, 1));
    @endphp

    {{-- Hero --}}
    <section class="relative overflow-hidden border-b border-white/6">
        @if($deck->image)
            <div class="absolute inset-0">
                <img src="{{ asset($deck->image) }}" alt="" class="h-full w-full object-cover" aria-hidden="true">
                <div class="absolute inset-0 bg-linear-to-b from-black/30 via-black/50 to-zinc-950"></div>
            </div>
            <div class="relative py-28 md:py-36">
        @else
            <div class="absolute inset-0 bg-linear-to-br {{ $palette }} opacity-40"></div>
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_70%_60%_at_50%_0%,rgb(99_102_241_/_0.12),transparent)]" aria-hidden="true"></div>
            <div class="relative py-20 md:py-28">
        @endif
            <x-sur.container>
                <x-sur.reveal>
                    <a href="{{ route('factionList') }}" class="mb-6 inline-flex items-center gap-1.5 text-xs font-semibold text-zinc-500 transition hover:text-zinc-300">
                        <i class="fa-solid fa-arrow-left text-[0.6rem]" aria-hidden="true"></i>
                        All factions
                    </a>

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            @if($deck->expansion)
                                <span class="mb-3 inline-block rounded-full border border-white/10 bg-black/30 px-3 py-1 text-xs font-semibold text-zinc-300 backdrop-blur-sm">
                                    {{ $deck->expansion }}
                                </span>
                            @endif
                            <h1 class="text-4xl font-black tracking-tight text-white drop-shadow-lg sm:text-5xl md:text-6xl">
                                {{ $deck->name }}
                            </h1>
                        </div>

                        @if($deck->playstyle)
                            @php
                                preg_match_all('/<li>(.*?)<\/li>/is', $deck->playstyle, $m);
                                $playstyleTags = !empty($m[1])
                                    ? array_filter(array_map('trim', $m[1]))
                                    : array_filter(array_map('trim', explode(',', strip_tags($deck->playstyle))));
                            @endphp
                            <div class="flex flex-wrap gap-1.5 sm:justify-end">
                                @foreach($playstyleTags as $tag)
                                    <span class="rounded-full border border-indigo-500/30 bg-indigo-900/30 px-3 py-1 text-xs font-semibold text-indigo-300">
                                        {{ strip_tags($tag) }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    @if($deck->teaser)
                        <p class="mt-5 max-w-2xl text-base leading-relaxed text-zinc-300 drop-shadow">
                            {!! strip_tags($deck->teaser) !!}
                        </p>
                    @endif
                </x-sur.reveal>
            </x-sur.container>
        </div>
    </section>

    {{-- Content --}}
    <x-sur.section>
        <x-sur.container>

            @if($hasAnyContent)

                <div class="flex flex-col gap-8">

                    {{-- Description --}}
                    @if(!empty($deck->description))
                    <x-sur.reveal>
                        <div class="sur-card border-white/8 p-6 sm:p-8">
                            <h2 class="mb-4 flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-indigo-400">
                                <i class="fa-solid fa-circle-info" aria-hidden="true"></i>Description
                            </h2>
                            <div class="deck-html text-sm leading-relaxed text-zinc-300">
                                {!! $deck->description !!}
                            </div>
                        </div>
                    </x-sur.reveal>
                    @endif

                    {{-- Cards overview --}}
                    @if(!empty($deck->cardsTeaser) || !empty($deck->actionTeaser) || !empty($deck->actionList))
                    <x-sur.reveal :delay="40">
                        <div class="sur-card border-white/8 p-6 sm:p-8">
                            <h2 class="mb-4 flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-violet-400">
                                <i class="fa-solid fa-layer-group" aria-hidden="true"></i>Cards Overview
                            </h2>
                            @if(!empty($deck->cardsTeaser))
                                <div class="deck-html mb-4 text-sm leading-relaxed text-zinc-300">{!! $deck->cardsTeaser !!}</div>
                            @endif
                            @if(!empty($deck->actionTeaser))
                                <div class="deck-html mb-2 text-sm leading-relaxed text-zinc-300">{!! $deck->actionTeaser !!}</div>
                            @endif
                            @if(!empty($deck->actionList))
                                <div class="deck-html text-sm leading-relaxed text-zinc-400">{!! $deck->actionList !!}</div>
                            @endif
                        </div>
                    </x-sur.reveal>
                    @endif

                    {{-- Actions + Characters --}}
                    @if(!empty($deck->actions) || !empty($deck->characters))
                    <x-sur.reveal :delay="60">
                        <div class="grid gap-6 md:grid-cols-2">
                            @if(!empty($deck->actions))
                            <div class="sur-card border-white/8 p-6">
                                <h2 class="mb-4 flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-amber-400">
                                    <i class="fa-solid fa-bolt" aria-hidden="true"></i>Actions
                                </h2>
                                <div class="deck-html text-sm leading-relaxed text-zinc-300">{!! $deck->actions !!}</div>
                            </div>
                            @endif
                            @if(!empty($deck->characters))
                            <div class="sur-card border-white/8 p-6">
                                <h2 class="mb-4 flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-emerald-400">
                                    <i class="fa-solid fa-user" aria-hidden="true"></i>Characters
                                </h2>
                                <div class="deck-html text-sm leading-relaxed text-zinc-300">{!! $deck->characters !!}</div>
                            </div>
                            @endif
                        </div>
                    </x-sur.reveal>
                    @endif

                    {{-- Strategy --}}
                    @if(!empty($deck->suggestionTeaser) || !empty($deck->synergy) || !empty($deck->tips))
                    <x-sur.reveal :delay="80">
                        <div class="sur-card border-white/8 p-6 sm:p-8">
                            <h2 class="mb-4 flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-rose-400">
                                <i class="fa-solid fa-chess" aria-hidden="true"></i>Strategy
                            </h2>
                            @if(!empty($deck->suggestionTeaser))
                                <div class="deck-html mb-6 text-sm leading-relaxed text-zinc-300">{!! $deck->suggestionTeaser !!}</div>
                            @endif
                            <div class="grid gap-6 md:grid-cols-2">
                                @if(!empty($deck->synergy))
                                <div>
                                    <h3 class="mb-3 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-zinc-500">
                                        <i class="fa-solid fa-link" aria-hidden="true"></i>Synergies
                                    </h3>
                                    <div class="deck-html text-sm leading-relaxed text-zinc-300">{!! $deck->synergy !!}</div>
                                </div>
                                @endif
                                @if(!empty($deck->tips))
                                <div>
                                    <h3 class="mb-3 flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-zinc-500">
                                        <i class="fa-solid fa-lightbulb" aria-hidden="true"></i>Tips
                                    </h3>
                                    <div class="deck-html text-sm leading-relaxed text-zinc-300">{!! $deck->tips !!}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </x-sur.reveal>
                    @endif

                    {{-- Mechanics --}}
                    @if(!empty($deck->mechanics))
                    <x-sur.reveal :delay="100">
                        <div class="sur-card border-white/8 p-6 sm:p-8">
                            <h2 class="mb-4 flex items-center gap-2 text-sm font-bold uppercase tracking-widest text-sky-400">
                                <i class="fa-solid fa-gears" aria-hidden="true"></i>Mechanics
                            </h2>
                            <div class="deck-html text-sm leading-relaxed text-zinc-300">{!! $deck->mechanics !!}</div>
                        </div>
                    </x-sur.reveal>
                    @endif

                </div>

            @else

                {{-- Empty state --}}
                <x-sur.reveal>
                    <div class="flex flex-col items-center gap-4 rounded-2xl border border-white/6 bg-zinc-900/40 py-20 text-center">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-linear-to-br {{ $palette }}">
                            <span class="text-3xl font-black text-white/20 select-none">{{ $letter }}</span>
                        </div>
                        <div>
                            <p class="text-base font-semibold text-zinc-300">No details yet for {{ $deck->name }}</p>
                            <p class="mt-1 text-sm text-zinc-600">This faction hasn't been documented yet.</p>
                        </div>
                        <a href="{{ route('contact') }}" class="sur-btn-secondary mt-2 inline-flex items-center gap-2 text-indigo-300 hover:border-indigo-500/35 hover:bg-indigo-500/10 hover:text-indigo-200">
                            <i class="fa-regular fa-envelope text-xs" aria-hidden="true"></i>
                            Know this faction? Get in touch
                        </a>
                    </div>
                </x-sur.reveal>

            @endif

            {{-- Bottom nav --}}
            <x-sur.reveal :delay="120">
                <div class="mt-10 flex items-center justify-between border-t border-white/6 pt-6">
                    <a href="{{ route('factionList') }}" class="inline-flex items-center gap-2 text-sm text-zinc-500 transition hover:text-zinc-200">
                        <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                        All factions
                    </a>
                    <a href="{{ route('home') }}#wizard" class="sur-btn-primary inline-flex items-center gap-2">
                        <i class="fa-solid fa-shuffle text-xs" aria-hidden="true"></i>
                        Shuffle now
                    </a>
                </div>
            </x-sur.reveal>

        </x-sur.container>
    </x-sur.section>

</x-layouts.main>

<style>
    .deck-html {
        line-height: 1.65;
        font-size: 0.9375rem;
    }
    .deck-html p {
        margin-bottom: 1rem;
    }
    .deck-html p:last-child {
        margin-bottom: 0;
    }
    .deck-html h3,
    .deck-html h4 {
        margin-top: 1.25rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: rgb(228 228 231);
    }
    .deck-html h3:first-child,
    .deck-html h4:first-child {
        margin-top: 0;
    }
    .deck-html ul,
    .deck-html ol {
        list-style: disc;
        padding-left: 1.25rem;
        margin-bottom: 1rem;
    }
    .deck-html ol {
        list-style: decimal;
    }
    .deck-html li {
        margin-bottom: 0.4rem;
    }
    .deck-html li:last-child {
        margin-bottom: 0;
    }
    .deck-html a {
        color: #818cf8;
        text-decoration: underline;
        text-underline-offset: 2px;
    }
</style>
