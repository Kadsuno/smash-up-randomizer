<x-layouts.main :metaRobots="$metaRobots ?? 'index, follow'">

    @php
        $playerCount = count($selectedDecks);
        $shareUrl = isset($sharePublicId) ? route('shuffle.share', ['publicId' => $sharePublicId]) : null;

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

            @if($shareUrl !== null)
                <x-sur.reveal :delay="$playerCount * 80 + 20">
                    <div
                        class="mt-10 rounded-2xl border border-indigo-500/20 bg-indigo-950/25 px-6 py-5 sm:px-8 sm:py-6"
                        x-data="{
                            shareUrl: {{ \Illuminate\Support\Js::from($shareUrl) }},
                            shareText: {{ \Illuminate\Support\Js::from($sharePlainText ?? '') }},
                            copied: null,
                            timer: null,
                            flash(kind) {
                                this.copied = kind;
                                clearTimeout(this.timer);
                                this.timer = setTimeout(() => { this.copied = null }, 2000);
                            },
                            async copyUrl() {
                                try {
                                    await navigator.clipboard.writeText(this.shareUrl);
                                    this.flash('link');
                                } catch (e) {}
                            },
                            async copyPlain() {
                                try {
                                    await navigator.clipboard.writeText(this.shareText);
                                    this.flash('text');
                                } catch (e) {}
                            }
                        }"
                    >
                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between lg:gap-10">
                            <div class="min-w-0 space-y-2 lg:max-w-2xl">
                                <h2 class="text-sm font-bold uppercase tracking-widest text-indigo-300">
                                    {{ __('frontend.shuffle_share_heading') }}
                                </h2>
                                <p class="text-sm leading-relaxed text-zinc-400">{{ __('frontend.shuffle_share_hint') }}</p>
                            </div>
                            <div class="flex flex-shrink-0 flex-wrap items-center justify-start gap-3 lg:justify-end">
                                <button
                                    type="button"
                                    class="sur-btn-primary inline-flex items-center gap-2"
                                    @click="copyUrl()"
                                >
                                    <i class="fa-solid fa-link text-xs" aria-hidden="true"></i>
                                    {{ __('frontend.shuffle_share_copy_link') }}
                                </button>
                                <button
                                    type="button"
                                    class="sur-share-copy-text-btn"
                                    @click="copyPlain()"
                                >
                                    <i class="fa-solid fa-clipboard text-xs" aria-hidden="true"></i>
                                    {{ __('frontend.shuffle_share_copy_text') }}
                                </button>
                            </div>
                        </div>
                        <div class="mt-3" aria-live="polite">
                            <p
                                class="text-xs font-medium leading-tight text-emerald-400"
                                x-show="copied !== null"
                                x-cloak
                                x-text="copied === 'link' ? {{ \Illuminate\Support\Js::from(__('frontend.shuffle_share_copied_link')) }} : (copied === 'text' ? {{ \Illuminate\Support\Js::from(__('frontend.shuffle_share_copied_text')) }} : '')"
                            ></p>
                        </div>
                    </div>
                </x-sur.reveal>
            @endif

            {{-- Actions --}}
            <x-sur.reveal :delay="$playerCount * 80 + 40">
                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    <a
                        href="{{ route('home') }}#wizard"
                        class="sur-btn-primary inline-flex items-center gap-2"
                    >
                        <i class="fa-solid fa-shuffle text-xs" aria-hidden="true"></i>
                        {{ __('frontend.shuffle_again') }}
                    </a>
                    <a
                        href="{{ route('factionList') }}"
                        class="sur-btn-secondary inline-flex items-center gap-2"
                    >
                        <i class="fa-solid fa-list text-xs" aria-hidden="true"></i>
                        {{ __('frontend.browse_all_factions') }}
                    </a>
                </div>
            </x-sur.reveal>

        </x-sur.container>
    </x-sur.section>

</x-layouts.main>
