<x-layouts.main>
    @if (session('error'))
        <div
            class="border-b border-amber-500/35 bg-amber-950/50 px-4 py-3 text-center text-sm leading-snug text-amber-100"
            role="alert"
        >
            {{ session('error') }}
        </div>
    @endif

    {{-- Marketing hero --}}
    <section id="wizard" class="relative overflow-hidden border-b border-white/10">
        <div class="pointer-events-none absolute inset-0 bg-linear-to-b from-indigo-950/50 via-zinc-950 to-zinc-950"></div>
        <div class="relative mx-auto max-w-7xl px-4 py-12 sm:px-6 sm:py-16 lg:px-8 lg:py-20">
            <p class="mb-4 text-center text-xs font-semibold uppercase tracking-[0.22em] text-indigo-300/95 lg:text-left">
                {{ __('frontend.landing_eyebrow') }}
            </p>
            <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-10">
                <div class="order-2 lg:order-1 lg:col-span-5">
                    <h1 class="text-balance text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-[2.65rem] lg:leading-[1.1]">
                        {{ __('frontend.landing_hero_title') }}
                    </h1>
                    <p class="mt-5 text-pretty text-lg leading-relaxed text-zinc-400 sm:text-xl">
                        {{ __('frontend.landing_hero_sub') }}
                    </p>
                    <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                        <button type="button" class="js-open-shuffle sur-btn-primary min-h-12 px-8 text-base shadow-indigo-500/30 transition-transform hover:scale-[1.02] active:scale-[0.98]">
                            <i class="fa-solid fa-shuffle me-2" aria-hidden="true"></i>{{ __('frontend.landing_cta_shuffle') }}
                        </button>
                        <a href="{{ route('factionList') }}" class="sur-btn-secondary min-h-12 px-8 text-base">{{ __('frontend.landing_cta_factions') }}</a>
                        <a href="{{ route('contact') }}" class="sur-btn-ghost min-h-12 border-white/15 px-8 text-base">{{ __('frontend.landing_cta_contact') }}</a>
                    </div>
                    <a href="{{ route('random') }}" class="mt-3 inline-flex items-center gap-1.5 text-sm text-zinc-500 transition hover:text-indigo-400">
                        <i class="fa-solid fa-bolt text-xs" aria-hidden="true"></i>
                        {{ __('frontend.landing_cta_random') }}
                    </a>
                    <p class="mt-4 max-w-xl text-sm leading-relaxed text-zinc-500">
                        {{ __('frontend.landing_hero_note') }}
                    </p>
                </div>

                <div
                    class="order-1 lg:order-2 lg:col-span-7"
                    x-data="landingHero(3)"
                    @mouseenter="stop()"
                    @mouseleave="start()"
                    role="region"
                    aria-roledescription="carousel"
                    aria-label="{{ __('frontend.landing_demo_carousel_region_label') }}"
                >
                    <div class="sur-landing-carousel relative aspect-[4/3] w-full overflow-hidden rounded-3xl border border-white/10 shadow-2xl shadow-black/50 sm:aspect-[16/10] lg:min-h-[22rem]">

                        <div
                            class="pointer-events-none absolute inset-x-0 top-11 z-20 flex justify-center px-2 sm:px-4"
                            aria-hidden="true"
                        >
                            <p
                                class="max-w-full rounded-full border border-white/12 bg-black/55 px-3 py-1.5 text-center text-[0.62rem] leading-snug text-zinc-300 shadow-sm backdrop-blur-sm sm:text-xs sm:leading-normal"
                            >
                                <span class="font-semibold text-indigo-300">{{ __('frontend.landing_demo_carousel_badge') }}</span>
                                <span class="text-zinc-400"> — {{ __('frontend.landing_demo_carousel_hint') }}</span>
                            </p>
                        </div>

                        {{-- Slide 1: Choose your players --}}
                        <div
                            x-show="i === 0"
                            x-transition.opacity.duration.500ms
                            class="absolute inset-0 flex flex-col bg-linear-to-br from-indigo-950/70 via-zinc-900 to-zinc-900"
                            x-cloak
                            role="group"
                            aria-roledescription="slide"
                            aria-label="{{ __('frontend.landing_slide_1_title') }}"
                        >
                            <div class="flex min-h-0 flex-1 flex-col">
                                <div class="h-11 shrink-0" aria-hidden="true"></div>
                                <div class="flex min-h-0 flex-1 items-stretch gap-1 px-2 pb-2 sm:gap-2 sm:px-3">
                                    <button
                                        type="button"
                                        class="sur-landing-carousel-btn shrink-0 self-center"
                                        @click="prev()"
                                        aria-label="{{ __('frontend.landing_carousel_prev') }}"
                                    >
                                        <i class="fa-solid fa-chevron-left fa-fw text-xs sm:text-sm" aria-hidden="true"></i>
                                    </button>
                                    <div class="flex min-h-0 min-w-0 flex-1 flex-col items-center justify-center gap-4">
                                        <p class="text-center text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">Step 1</p>
                                        <div class="mx-auto grid w-full max-w-[15.5rem] grid-cols-3 gap-2 sm:max-w-sm sm:gap-3">
                                            @foreach([2, 3, 4] as $n)
                                                <div class="pointer-events-none select-none flex min-h-[5.25rem] min-w-0 flex-col items-center justify-center rounded-2xl border px-1 py-3 text-center sm:min-h-[6rem] sm:px-2 sm:py-4
                                                    {{ $n === 2 ? 'border-indigo-500 bg-indigo-500/15 shadow-lg shadow-indigo-500/20' : 'border-white/15 bg-zinc-900/60' }}">
                                                    <span class="text-3xl font-extrabold tabular-nums {{ $n === 2 ? 'text-white' : 'text-zinc-400' }} sm:text-4xl">{{ $n }}</span>
                                                    <span class="mt-1 text-[0.65rem] font-medium uppercase tracking-wider {{ $n === 2 ? 'text-indigo-200' : 'text-zinc-600' }}">{{ __('frontend.shuffle_wizard_players_unit') }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <button
                                        type="button"
                                        class="sur-landing-carousel-btn shrink-0 self-center"
                                        @click="next()"
                                        aria-label="{{ __('frontend.landing_carousel_next') }}"
                                    >
                                        <i class="fa-solid fa-chevron-right fa-fw text-xs sm:text-sm" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="shrink-0 border-t border-white/8 bg-black/40 px-5 py-4 sm:px-7">
                                <h2 class="text-base font-bold text-white sm:text-xl">{{ __('frontend.landing_slide_1_title') }}</h2>
                                <p class="mt-1 text-xs leading-relaxed text-zinc-300 sm:text-sm">{{ __('frontend.landing_slide_1_tagline') }}</p>
                            </div>
                        </div>

                        {{-- Slide 2: Filter your sets --}}
                        <div
                            x-show="i === 1"
                            x-transition.opacity.duration.500ms
                            class="absolute inset-0 flex flex-col bg-linear-to-br from-violet-950/60 via-zinc-900 to-zinc-900"
                            x-cloak
                            role="group"
                            aria-roledescription="slide"
                            aria-label="{{ __('frontend.landing_slide_2_title') }}"
                        >
                            <div class="flex min-h-0 flex-1 flex-col">
                                <div class="h-11 shrink-0" aria-hidden="true"></div>
                                <div class="flex min-h-0 flex-1 items-stretch gap-1 px-2 pb-2 sm:gap-2 sm:px-3">
                                    <button
                                        type="button"
                                        class="sur-landing-carousel-btn shrink-0 self-center"
                                        @click="prev()"
                                        aria-label="{{ __('frontend.landing_carousel_prev') }}"
                                    >
                                        <i class="fa-solid fa-chevron-left fa-fw text-xs sm:text-sm" aria-hidden="true"></i>
                                    </button>
                                    {{-- Top-align + scroll: justify-center here clips overflow on mobile (centered flex + overflow-y). --}}
                                    <div class="flex min-h-0 min-w-0 flex-1 flex-col items-center justify-start gap-2 overflow-y-auto overscroll-y-contain py-1 touch-pan-y sm:gap-3">
                                        <p class="shrink-0 text-center text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">Step 2</p>
                                        @if($factions->isNotEmpty())
                                            <div class="mx-auto w-full max-w-xl shrink-0 grid grid-cols-2 gap-1.5 sm:grid-cols-5 sm:gap-2">
                                                @foreach($factions->take(10) as $idx => $faction)
                                                    <span class="pointer-events-none select-none flex min-h-[2.55rem] items-center justify-center rounded-lg border px-1.5 py-1.5 text-center text-[0.625rem] font-medium leading-snug sm:min-h-[3rem] sm:px-2 sm:py-2 sm:text-xs
                                                        {{ $idx < 6 ? 'border-indigo-500/40 bg-indigo-500/12 text-indigo-200' : 'border-white/10 bg-zinc-800/60 text-zinc-500 line-through' }}">
                                                        <span class="line-clamp-2 break-words">{{ $faction->name }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-center text-sm text-zinc-500">{{ __('frontend.landing_slide_2_tagline') }}</p>
                                        @endif
                                    </div>
                                    <button
                                        type="button"
                                        class="sur-landing-carousel-btn shrink-0 self-center"
                                        @click="next()"
                                        aria-label="{{ __('frontend.landing_carousel_next') }}"
                                    >
                                        <i class="fa-solid fa-chevron-right fa-fw text-xs sm:text-sm" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="shrink-0 border-t border-white/8 bg-black/40 px-5 py-4 sm:px-7">
                                <h2 class="text-base font-bold text-white sm:text-xl">{{ __('frontend.landing_slide_2_title') }}</h2>
                                <p class="mt-1 text-xs leading-relaxed text-zinc-300 sm:text-sm">{{ __('frontend.landing_slide_2_tagline') }}</p>
                            </div>
                        </div>

                        {{-- Slide 3: Your combos --}}
                        <div
                            x-show="i === 2"
                            x-transition.opacity.duration.500ms
                            class="absolute inset-0 flex flex-col bg-linear-to-br from-indigo-950/50 via-violet-950/30 to-zinc-900"
                            x-cloak
                            role="group"
                            aria-roledescription="slide"
                            aria-label="{{ __('frontend.landing_slide_3_title') }}"
                        >
                            @php $demoFactions = $factions->take(4); @endphp
                            <div class="flex min-h-0 flex-1 flex-col">
                                <div class="h-11 shrink-0" aria-hidden="true"></div>
                                <div class="flex min-h-0 flex-1 items-stretch gap-1 px-2 pb-2 sm:gap-2 sm:px-3">
                                    <button
                                        type="button"
                                        class="sur-landing-carousel-btn shrink-0 self-center"
                                        @click="prev()"
                                        aria-label="{{ __('frontend.landing_carousel_prev') }}"
                                    >
                                        <i class="fa-solid fa-chevron-left fa-fw text-xs sm:text-sm" aria-hidden="true"></i>
                                    </button>
                                    {{-- Same as slide 2: avoid justify-center + overflow clipping on short viewports. --}}
                                    <div class="flex min-h-0 min-w-0 flex-1 flex-col items-center justify-start gap-2 overflow-y-auto overscroll-y-contain py-1 touch-pan-y sm:gap-3">
                                        <p class="shrink-0 text-center text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">Step 3</p>
                                        @if($demoFactions->count() >= 4)
                                            <div class="mx-auto flex w-full max-w-md shrink-0 flex-col gap-2 sm:gap-3">
                                                @foreach([[0,1],[2,3]] as $pi => $pair)
                                                    @php
                                                        $nameA = $demoFactions[$pair[0]]->name;
                                                        $nameB = $demoFactions[$pair[1]]->name;
                                                    @endphp
                                                    <div class="pointer-events-none select-none flex min-h-[5.25rem] flex-col justify-center rounded-2xl border border-white/10 bg-zinc-800/50 px-3 py-2 sm:min-h-[6rem] sm:px-4 sm:py-3">
                                                        <p class="mb-1.5 text-center text-[0.65rem] font-semibold uppercase tracking-wider text-zinc-500 sm:mb-2">
                                                            {{ str_replace(':n', $pi + 1, __('frontend.landing_slide_player_label')) }}
                                                        </p>
                                                        <div class="grid grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)] items-center gap-x-1.5 gap-y-1 sm:gap-x-2">
                                                            <span class="flex min-h-[2.45rem] min-w-0 items-center justify-center rounded-xl border border-indigo-500/35 bg-indigo-500/12 px-1.5 py-1 text-center text-[0.7rem] font-semibold leading-tight text-indigo-200 sm:min-h-[2.5rem] sm:px-2 sm:py-1.5 sm:text-xs" title="{{ $nameA }}">
                                                                <span class="line-clamp-2 break-words">{{ $nameA }}</span>
                                                            </span>
                                                            <span class="shrink-0 text-sm font-bold text-zinc-500">+</span>
                                                            <span class="flex min-h-[2.45rem] min-w-0 items-center justify-center rounded-xl border border-violet-500/35 bg-violet-500/12 px-1.5 py-1 text-center text-[0.7rem] font-semibold leading-tight text-violet-200 sm:min-h-[2.5rem] sm:px-2 sm:py-1.5 sm:text-xs" title="{{ $nameB }}">
                                                                <span class="line-clamp-2 break-words">{{ $nameB }}</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-center text-sm text-zinc-500">{{ __('frontend.landing_slide_3_tagline') }}</p>
                                        @endif
                                    </div>
                                    <button
                                        type="button"
                                        class="sur-landing-carousel-btn shrink-0 self-center"
                                        @click="next()"
                                        aria-label="{{ __('frontend.landing_carousel_next') }}"
                                    >
                                        <i class="fa-solid fa-chevron-right fa-fw text-xs sm:text-sm" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="shrink-0 border-t border-white/8 bg-black/40 px-5 py-4 sm:px-7">
                                <h2 class="text-base font-bold text-white sm:text-xl">{{ __('frontend.landing_slide_3_title') }}</h2>
                                <p class="mt-1 text-xs leading-relaxed text-zinc-300 sm:text-sm">{{ __('frontend.landing_slide_3_tagline') }}</p>
                            </div>
                        </div>

                        {{-- Dots only (top). Prev/next are in each slide row (items-stretch + self-center on buttons). --}}
                        <div class="pointer-events-none absolute inset-x-0 top-0 z-30 flex h-11 items-center justify-center gap-1.5">
                            @foreach([0, 1, 2] as $idx)
                                <button
                                    type="button"
                                    class="pointer-events-auto h-2.5 w-2.5 shrink-0 rounded-full transition sm:h-2 sm:w-2"
                                    :class="i === {{ $idx }} ? 'bg-white shadow-lg shadow-indigo-500/40 ring-2 ring-indigo-400/50' : 'bg-white/35 hover:bg-white/60'"
                                    @click="go({{ $idx }})"
                                    :aria-current="i === {{ $idx }} ? 'true' : 'false'"
                                    aria-label="Slide {{ $idx + 1 }}"
                                ></button>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats bar --}}
    <div class="border-b border-white/8 bg-zinc-950/80">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-center gap-x-8 gap-y-3 px-4 py-4 sm:px-6 lg:px-8">
            <span class="flex items-center gap-2 text-sm text-zinc-300">
                <i class="fa-solid fa-layer-group text-indigo-400" aria-hidden="true"></i>
                <strong class="text-white">{{ count($factions) }}</strong>&nbsp;{{ __('frontend.landing_stats_factions') }}
            </span>
            <span class="hidden h-3 w-px bg-white/15 sm:block" aria-hidden="true"></span>
            <span class="flex items-center gap-2 text-sm text-zinc-300">
                <i class="fa-solid fa-circle-check text-indigo-400" aria-hidden="true"></i>
                {{ __('frontend.landing_stats_free') }}
            </span>
            <span class="hidden h-3 w-px bg-white/15 sm:block" aria-hidden="true"></span>
            <span class="flex items-center gap-2 text-sm text-zinc-300">
                <i class="fa-solid fa-user-slash text-indigo-400" aria-hidden="true"></i>
                {{ __('frontend.landing_stats_no_account') }}
            </span>
            <span class="hidden h-3 w-px bg-white/15 sm:block" aria-hidden="true"></span>
            <span class="flex items-center gap-2 text-sm text-zinc-300">
                <i class="fa-solid fa-boxes-stacked text-indigo-400" aria-hidden="true"></i>
                {{ __('frontend.landing_stats_expansions') }}
            </span>
        </div>
    </div>

    {{-- Feature grid --}}
    <x-sur.section class="border-y border-white/6 bg-zinc-900/30">
        <div class="text-center">
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">{{ __('frontend.landing_features_eyebrow') }}</p>
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('frontend.landing_features_title') }}</h2>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            <x-sur.reveal :delay="0">
                <div class="sur-card group h-full overflow-hidden border-white/10 p-6 transition duration-300 hover:border-indigo-500/40 sm:p-8" style="border-top: 2px solid rgb(99 102 241 / 0.55);">
                    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-500/15 text-indigo-300 ring-1 ring-indigo-500/30 transition duration-300 group-hover:bg-indigo-500/25">
                        <i class="fa-solid fa-scale-balanced text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="mb-3 text-lg font-semibold text-white">{{ __('frontend.landing_feature_1_title') }}</h3>
                    <p class="text-sm leading-relaxed text-zinc-400">{{ __('frontend.landing_feature_1_body') }}</p>
                </div>
            </x-sur.reveal>
            <x-sur.reveal :delay="70">
                <div class="sur-card group h-full overflow-hidden border-white/10 p-6 transition duration-300 hover:border-violet-500/40 sm:p-8" style="border-top: 2px solid rgb(139 92 246 / 0.55);">
                    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/30 transition duration-300 group-hover:bg-violet-500/25">
                        <i class="fa-solid fa-layer-group text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="mb-3 text-lg font-semibold text-white">{{ __('frontend.landing_feature_2_title') }}</h3>
                    <p class="text-sm leading-relaxed text-zinc-400">{{ __('frontend.landing_feature_2_body') }}</p>
                </div>
            </x-sur.reveal>
            <x-sur.reveal :delay="140">
                <div class="sur-card group h-full overflow-hidden border-white/10 p-6 transition duration-300 hover:border-indigo-500/40 sm:p-8" style="border-top: 2px solid rgb(99 102 241 / 0.55);">
                    <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-indigo-500/15 text-indigo-300 ring-1 ring-indigo-500/30 transition duration-300 group-hover:bg-indigo-500/25">
                        <i class="fa-solid fa-bolt text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="mb-3 text-lg font-semibold text-white">{{ __('frontend.landing_feature_3_title') }}</h3>
                    <p class="text-sm leading-relaxed text-zinc-400">{{ __('frontend.landing_feature_3_body') }}</p>
                </div>
            </x-sur.reveal>
        </div>
    </x-sur.section>

    {{-- How it works --}}
    <x-sur.section>
        <div class="text-center">
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">{{ __('frontend.landing_howto_eyebrow') }}</p>
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('frontend.landing_howto_title') }}</h2>
        </div>
        <div class="mt-14 flex flex-col gap-8 md:flex-row md:items-start md:gap-0">
            @foreach([
                ['icon' => 'fa-users', 'color' => 'indigo', 'step' => 1],
                ['icon' => 'fa-filter', 'color' => 'violet', 'step' => 2],
                ['icon' => 'fa-shuffle', 'color' => 'indigo', 'step' => 3],
            ] as $i => $item)
                {{-- Step --}}
                @php
                    $isViolet = $item['color'] === 'violet';
                    $iconBg    = $isViolet ? 'bg-violet-500/15 ring-violet-500/35 hover:bg-violet-500/25' : 'bg-indigo-500/15 ring-indigo-500/35 hover:bg-indigo-500/25';
                    $iconText  = $isViolet ? 'text-violet-300' : 'text-indigo-300';
                    $badgeCls  = $isViolet ? 'bg-violet-500 shadow-violet-500/50' : 'bg-indigo-500 shadow-indigo-500/50';
                @endphp
                <x-sur.reveal :delay="$i * 80" class="flex flex-1 flex-col items-center text-center">
                    <div class="relative">
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl ring-2 transition duration-300 {{ $iconBg }}">
                            <i class="fa-solid {{ $item['icon'] }} text-2xl {{ $iconText }}" aria-hidden="true"></i>
                        </div>
                        <span class="absolute -right-2 -top-2 flex h-7 w-7 items-center justify-center rounded-full text-sm font-extrabold text-white shadow-lg ring-2 ring-zinc-950 {{ $badgeCls }}">{{ $item['step'] }}</span>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold text-white">{{ __('frontend.landing_howto_step'.$item['step'].'_title') }}</h3>
                    <p class="mt-2 max-w-[16rem] text-sm leading-relaxed text-zinc-400">{{ __('frontend.landing_howto_step'.$item['step'].'_body') }}</p>
                </x-sur.reveal>

                {{-- Connector arrow (between steps, desktop only) --}}
                @if($i < 2)
                    <div class="hidden shrink-0 items-center justify-center px-4 pt-7 md:flex">
                        <i class="fa-solid fa-arrow-right text-xl text-zinc-600" aria-hidden="true"></i>
                    </div>
                @endif
            @endforeach
        </div>
    </x-sur.section>

    {{-- Quotes carousel --}}
    <section class="relative overflow-hidden border-y border-white/10 bg-linear-to-b from-zinc-950 via-zinc-900/40 to-zinc-950 py-16 sm:py-20">
        <img
            src="{{ asset('images/landing/game-night-social.jpg') }}"
            alt=""
            aria-hidden="true"
            class="absolute inset-0 h-full w-full object-cover opacity-[0.07] mix-blend-luminosity"
            loading="lazy"
            width="1400"
            height="1051"
        >
        <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">{{ __('frontend.landing_showcase_eyebrow') }}</p>
            <h2 class="mt-2 text-3xl font-bold text-white sm:text-4xl">{{ __('frontend.landing_showcase_title') }}</h2>
            <p class="mt-3 text-sm text-zinc-400 sm:text-base">{{ __('frontend.landing_showcase_sub') }}</p>
        </div>
        <div
            class="relative mx-auto mt-10 max-w-3xl px-4 sm:px-6 lg:px-8"
            x-data="landingQuotes()"
            @mouseenter="stop()"
            @mouseleave="start()"
            role="region"
            aria-roledescription="carousel"
            aria-label="{{ __('frontend.landing_showcase_title') }}"
        >
            <div class="relative min-h-[10rem] overflow-hidden rounded-3xl border border-white/10 bg-zinc-900/60 p-8 shadow-xl backdrop-blur-sm sm:min-h-[9rem] sm:p-10">
                @foreach([1, 2, 3] as $qi)
                    <div x-show="q === {{ $qi - 1 }}" x-transition.opacity.duration.400ms class="absolute inset-0 flex flex-col justify-center p-8 sm:p-10" x-cloak>
                        <blockquote class="text-center text-lg leading-relaxed text-zinc-100 sm:text-xl">
                            {{ __('frontend.landing_quote_'.$qi) }}
                        </blockquote>
                        <cite class="mt-6 block text-center text-sm font-medium not-italic text-indigo-300/90">{{ __('frontend.landing_quote_'.$qi.'_by') }}</cite>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 flex items-center justify-center gap-3">
                <button type="button" class="sur-landing-carousel-btn !static !translate-y-0" @click="prev()" aria-label="{{ __('frontend.landing_quotes_prev') }}">
                    <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                </button>
                <div class="flex gap-2">
                    @foreach([0, 1, 2] as $j)
                        <button
                            type="button"
                            class="h-2 w-2 rounded-full transition"
                            :class="q === {{ $j }} ? 'bg-indigo-400 shadow-md shadow-indigo-500/40' : 'bg-white/25 hover:bg-white/45'"
                            @click="goQuote({{ $j }})"
                            aria-label="Quote {{ $j + 1 }}"
                        ></button>
                    @endforeach
                </div>
                <button type="button" class="sur-landing-carousel-btn !static !translate-y-0" @click="next()" aria-label="{{ __('frontend.landing_quotes_next') }}">
                    <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                </button>
            </div>
        </div>
    </section>

    {{-- CTA band --}}
    <section class="relative overflow-hidden py-16 sm:py-20">
        <img
            src="{{ asset('images/landing/cards-dark-surface.jpg') }}"
            alt=""
            aria-hidden="true"
            class="absolute inset-0 h-full w-full object-cover opacity-20 mix-blend-luminosity"
            loading="lazy"
            width="1600"
            height="1043"
        >
        <div class="pointer-events-none absolute inset-0 bg-linear-to-r from-indigo-600/25 via-violet-600/20 to-indigo-700/25"></div>
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_top,_rgba(99,102,241,0.2),_transparent_55%)]"></div>
        <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-white sm:text-4xl">{{ __('frontend.landing_band_title') }}</h2>
            <p class="mt-4 text-lg text-zinc-300">{{ __('frontend.landing_band_sub') }}</p>
            <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <button type="button" class="js-open-shuffle sur-btn-primary min-h-12 px-10 text-base shadow-lg shadow-indigo-500/35">
                    <i class="fa-solid fa-shuffle me-2" aria-hidden="true"></i>{{ __('frontend.landing_band_cta_shuffle') }}
                </button>
                <a href="{{ route('factionList') }}" class="sur-btn-secondary min-h-12 px-10 text-base">{{ __('frontend.landing_band_cta_factions') }}</a>
            </div>
        </div>
    </section>

    {{-- Faction combo examples --}}
    <x-sur.section class="border-y border-white/6 bg-zinc-900/25">
        <div class="text-center">
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">{{ __('frontend.landing_combos_eyebrow') }}</p>
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('frontend.landing_combos_title') }}</h2>
            <p class="mx-auto mt-3 max-w-2xl text-sm leading-relaxed text-zinc-400 sm:text-base">{{ __('frontend.landing_combos_sub') }}</p>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            @foreach([1, 2, 3] as $i => $ci)
                <x-sur.reveal :delay="$i * 70">
                    <div class="sur-card group h-full border-white/10 p-6 text-center transition duration-300 hover:border-indigo-500/30 sm:p-8">
                        <div class="mb-5 flex flex-wrap items-center justify-center gap-2">
                            <span class="rounded-xl border border-indigo-500/40 bg-indigo-500/12 px-4 py-2 text-sm font-bold text-indigo-200 shadow-sm shadow-indigo-500/10">{{ __('frontend.landing_combo_'.$ci.'_a') }}</span>
                            <span class="text-lg font-bold text-zinc-500">+</span>
                            <span class="rounded-xl border border-violet-500/40 bg-violet-500/12 px-4 py-2 text-sm font-bold text-violet-200 shadow-sm shadow-violet-500/10">{{ __('frontend.landing_combo_'.$ci.'_b') }}</span>
                        </div>
                        <div class="mb-3 flex items-center justify-center gap-2">
                            <span class="h-px flex-1 bg-white/8"></span>
                            <span class="text-xs font-bold uppercase tracking-widest text-zinc-500">=</span>
                            <span class="h-px flex-1 bg-white/8"></span>
                        </div>
                        <h3 class="mb-2 text-lg font-bold text-white">{{ __('frontend.landing_combo_'.$ci.'_name') }}</h3>
                        <p class="text-sm leading-relaxed text-zinc-400">{{ __('frontend.landing_combo_'.$ci.'_tagline') }}</p>
                    </div>
                </x-sur.reveal>
            @endforeach
        </div>
    </x-sur.section>

    {{-- What is Smash Up? explainer --}}
    <x-sur.section>
        <x-sur.reveal>
            <div class="sur-card border-white/10 p-6 sm:p-10">
                <div class="grid gap-8 md:grid-cols-2 md:gap-12">
                    <div>
                        <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">{{ __('frontend.landing_whatis_eyebrow') }}</p>
                        <h2 class="mb-4 text-2xl font-bold tracking-tight text-white sm:text-3xl">{{ __('frontend.landing_whatis_title') }}</h2>
                        <p class="text-sm leading-relaxed text-zinc-400 sm:text-base">{{ __('frontend.landing_whatis_body') }}</p>
                    </div>
                    <div class="flex flex-col justify-center">
                        <p class="mb-4 text-xs font-semibold uppercase tracking-[0.2em] text-zinc-500">{{ __('frontend.landing_whatis_facts_label') }}</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(['players', 'duration', 'age', 'author', 'year'] as $fact)
                                <span class="rounded-xl border border-white/10 bg-zinc-800/60 px-3 py-2 text-sm font-medium text-zinc-200">
                                    {{ __('frontend.landing_whatis_fact_'.$fact) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </x-sur.reveal>
    </x-sur.section>

    {{-- Faction teaser strip --}}
    @if($factions->isNotEmpty())
        <x-sur.section :padded="true">
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="mb-1 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">{{ __('frontend.landing_factions_eyebrow') }}</p>
                    <h2 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">{{ __('frontend.landing_factions_title') }}</h2>
                </div>
                <a href="{{ route('factionList') }}" class="sur-btn-secondary shrink-0 self-start sm:self-auto">
                    {{ __('frontend.landing_factions_view_all') }} <i class="fa-solid fa-arrow-right ms-1.5 text-xs" aria-hidden="true"></i>
                </a>
            </div>
            <div class="sur-faction-strip mt-6 flex gap-2 overflow-x-auto pb-2">
                @foreach($factions as $faction)
                    <span class="faction-chip flex shrink-0 cursor-default items-center justify-center rounded-xl border border-white/12 bg-zinc-900/70 px-3 py-2 text-xs font-medium text-zinc-200 shadow-sm">
                        {{ $faction->name }}
                    </span>
                @endforeach
            </div>
        </x-sur.section>
    @endif

    {{-- Result preview --}}
    <x-sur.section class="border-y border-white/6 bg-indigo-950/20">
        <div class="flex flex-col items-center gap-12 lg:flex-row lg:gap-16">
            <x-sur.reveal class="flex-1 text-center lg:text-left">
                <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">{{ __('frontend.landing_result_eyebrow') }}</p>
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('frontend.landing_result_title') }}</h2>
                <p class="mt-4 text-sm leading-relaxed text-zinc-400 sm:text-base">{{ __('frontend.landing_result_sub') }}</p>
                <div class="mt-8">
                    <button type="button" class="js-open-shuffle sur-btn-primary min-h-12 px-8 text-base shadow-lg shadow-indigo-500/25">
                        <i class="fa-solid fa-shuffle me-2" aria-hidden="true"></i>{{ __('frontend.landing_result_cta') }}
                    </button>
                </div>
            </x-sur.reveal>
            <x-sur.reveal :delay="80" class="w-full flex-1 lg:max-w-lg">
                <div class="relative rounded-2xl border border-white/10 bg-zinc-900/50 p-1 shadow-2xl shadow-black/60 ring-1 ring-white/5">
                    <img
                        src="{{ asset('images/landing/result-preview.png') }}"
                        alt="{{ __('frontend.landing_result_img_alt') }}"
                        class="w-full rounded-xl"
                        loading="lazy"
                        width="1920"
                        height="1650"
                    >
                </div>
            </x-sur.reveal>
        </div>
    </x-sur.section>

    {{-- FAQ --}}
    <x-sur.section>
        <div class="mx-auto max-w-3xl">
            <div class="mb-10 text-center">
                <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">{{ __('frontend.landing_faq_eyebrow') }}</p>
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('frontend.landing_faq_title') }}</h2>
            </div>
            <div
                x-data="{ open: null }"
                class="divide-y divide-white/8 rounded-2xl border border-white/10 bg-zinc-900/40"
            >
                @foreach(range(1, 4) as $n)
                    <div>
                        <button
                            type="button"
                            class="flex w-full items-start justify-between gap-4 px-6 py-5 text-left focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60 focus-visible:ring-inset"
                            @click="open = open === {{ $n }} ? null : {{ $n }}"
                            :aria-expanded="open === {{ $n }} ? 'true' : 'false'"
                        >
                            <span class="text-sm font-semibold text-white sm:text-base">{{ __('frontend.landing_faq_q' . $n) }}</span>
                            <svg
                                class="mt-0.5 h-5 w-5 shrink-0 text-indigo-400 transition-transform duration-300"
                                :class="{ 'rotate-180': open === {{ $n }} }"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                            >
                                <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div
                            x-show="open === {{ $n }}"
                            x-collapse
                            class="px-6 pb-5"
                            x-cloak
                        >
                            <p class="text-sm leading-relaxed text-zinc-400">{{ __('frontend.landing_faq_a' . $n) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </x-sur.section>

    <dialog
        id="shuffle-modal"
        class="shuffle-modal-dialog shadow-2xl"
        closedby="any"
        aria-labelledby="shuffleModalTitle"
        aria-describedby="shuffleModalSubtitle"
        data-step-badge-template="{{ e(__('frontend.shuffle_wizard_step_badge_template')) }}"
    >
        <div class="shuffle-modal-card isolate flex min-h-0 flex-col overflow-hidden rounded-2xl border border-white/10 bg-zinc-950 shadow-[0_24px_80px_-12px_rgba(0,0,0,0.65)] ring-1 ring-white/10">
            <div class="relative border-b border-white/10 bg-linear-to-br from-zinc-900/90 via-zinc-950 to-indigo-950/40 px-5 py-5 sm:px-8 sm:py-6">
                <div class="flex items-start justify-between gap-4">
                    <div class="min-w-0">
                        <h2 class="text-xl font-bold tracking-tight text-white sm:text-2xl" id="shuffleModalTitle">{{ __('frontend.shuffle') }}</h2>
                        <p class="mt-1 max-w-prose text-sm leading-relaxed text-zinc-400" id="shuffleModalSubtitle">{{ __('frontend.shuffle_modal_subtitle') }}</p>
                    </div>
                    <button
                        type="button"
                        class="flex h-11 min-w-11 shrink-0 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-zinc-400 transition hover:border-white/20 hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60"
                        data-close-shuffle-modal
                        aria-label="{{ __('frontend.shuffle_modal_close') }}"
                    >
                        <i class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <form
                id="shuffle-wizard-form"
                class="shuffle-wizard-form flex min-h-0 flex-1 flex-col"
                method="POST"
                action="{{ route('shuffle-result') }}"
                novalidate
                data-msg-conflict="{{ e(__('frontend.shuffle_error_include_exclude_conflict')) }}"
                data-msg-pool-empty="{{ e(__('frontend.shuffle_error_pool_empty')) }}"
                data-msg-insufficient="{{ e(__('frontend.shuffle_error_not_enough_factions')) }}"
            >
                @csrf
                <div class="shuffle-modal-chrome shrink-0 border-b border-white/10 px-5 pb-4 pt-1 sm:px-8">
                    <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                        <p id="shuffle-wizard-badge" class="text-sm font-medium text-zinc-300" aria-live="polite"></p>
                    </div>
                    <nav class="shuffle-wizard-stepper" aria-label="{{ __('frontend.shuffle_wizard_nav_aria') }}">
                        <ol class="flex items-start gap-2 sm:gap-4" role="list">
                            <li class="shuffle-wizard-step is-current flex min-w-0 flex-1 flex-col items-center gap-2 text-center" data-shuffle-step="1">
                                <span class="shuffle-wizard-step__index">1</span>
                                <span class="shuffle-wizard-step__label">{{ __('frontend.shuffle_wizard_step_players') }}</span>
                            </li>
                            <li class="shuffle-wizard-connector hidden sm:block" aria-hidden="true"></li>
                            <li class="shuffle-wizard-step flex min-w-0 flex-1 flex-col items-center gap-2 text-center" data-shuffle-step="2">
                                <span class="shuffle-wizard-step__index">2</span>
                                <span class="shuffle-wizard-step__label">{{ __('frontend.shuffle_wizard_step_include') }}</span>
                            </li>
                            <li class="shuffle-wizard-connector hidden sm:block" aria-hidden="true"></li>
                            <li class="shuffle-wizard-step flex min-w-0 flex-1 flex-col items-center gap-2 text-center" data-shuffle-step="3">
                                <span class="shuffle-wizard-step__index">3</span>
                                <span class="shuffle-wizard-step__label">{{ __('frontend.shuffle_wizard_step_exclude') }}</span>
                            </li>
                        </ol>
                    </nav>
                </div>

                <div class="shuffle-modal-scroll sur-scrollbar min-h-0 flex-1 overflow-y-auto overflow-x-hidden px-5 py-5 sm:px-8 sm:py-6">
                    <div
                        id="shuffle-wizard-toast"
                        class="mb-4 hidden rounded-xl border border-amber-500/35 bg-amber-950/45 px-4 py-3 text-sm font-medium leading-snug text-amber-100 shadow-lg shadow-black/20"
                        role="alert"
                        aria-live="assertive"
                    ></div>
                    <div class="shuffle-step-content" id="step1-content">
                        <h3 class="mb-1 text-lg font-semibold text-white sm:text-xl">{{ __('frontend.shuffle_wizard_heading_players') }}</h3>
                        <p class="mb-5 text-sm text-zinc-500">{{ __('frontend.shuffle_wizard_players_hint') }}</p>
                        <fieldset id="shuffle-player-fieldset" class="rounded-2xl border border-white/10 bg-zinc-900/40 p-4 transition-[box-shadow] sm:p-5">
                            <legend class="sr-only">{{ __('frontend.shuffle_wizard_players_legend') }}</legend>
                            <div class="grid grid-cols-3 gap-3" role="radiogroup" aria-required="true">
                                @foreach ([2, 3, 4] as $i => $n)
                                    <label class="relative flex cursor-pointer flex-col items-center justify-center rounded-2xl border border-white/15 bg-zinc-900/60 px-3 py-5 text-center transition hover:border-indigo-500/45 hover:bg-indigo-500/10 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-500/15 has-[:checked]:shadow-lg has-[:checked]:shadow-indigo-500/20 has-[:focus-visible]:ring-2 has-[:focus-visible]:ring-indigo-400/50">
                                        <input class="peer sr-only" type="radio" name="numberOfPlayers" value="{{ $n }}" @if ($i === 0) required @endif>
                                        <span class="text-3xl font-extrabold tabular-nums text-white sm:text-4xl">{{ $n }}</span>
                                        <span class="mt-2 text-[0.65rem] font-medium uppercase tracking-wider text-zinc-500 peer-checked:text-indigo-200">{{ __('frontend.shuffle_wizard_players_unit') }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>

                    <div class="shuffle-step-content hidden" id="step2-content">
                        <h3 class="mb-2 text-lg font-semibold text-white sm:text-xl">{{ __('frontend.shuffle_wizard_heading_include') }}</h3>
                        <p class="mb-4 text-sm leading-relaxed text-zinc-500">{{ __('frontend.shuffle_wizard_include_hint') }}</p>
                        <div class="mb-4">
                            <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                                <span class="text-sm font-medium text-zinc-300">{{ __('frontend.shuffle_wizard_include_label') }}</span>
                                <button type="button" class="sur-btn-ghost min-h-9 rounded-lg px-3 py-1.5 text-xs font-medium" id="selectAllInclude">{{ __('frontend.shuffle_wizard_select_all') }}</button>
                            </div>
                            <div class="faction-grid">
                                @foreach($factions as $faction)
                                    <div class="faction-item">
                                        <input class="sr-only include-faction" type="checkbox" name="includeFactions[]" value="{{ $faction->name }}" id="include{{ $faction->id }}">
                                        <label class="faction-chip flex w-full min-h-11 cursor-pointer items-center justify-center rounded-xl border border-white/12 bg-zinc-900/70 px-2 py-2.5 text-center text-xs font-medium text-zinc-200 shadow-sm transition hover:border-indigo-500/40 hover:bg-zinc-800/90 sm:text-sm" for="include{{ $faction->id }}">
                                            {{ $faction->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="shuffle-step-content hidden" id="step3-content">
                        <h3 class="mb-2 text-lg font-semibold text-white sm:text-xl">{{ __('frontend.shuffle_wizard_heading_exclude') }}</h3>
                        <p class="mb-4 text-sm leading-relaxed text-zinc-500">{{ __('frontend.shuffle_wizard_exclude_hint') }}</p>
                        <div class="mb-4">
                            <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                                <span class="text-sm font-medium text-zinc-300">{{ __('frontend.shuffle_wizard_exclude_label') }}</span>
                                <button type="button" class="sur-btn-ghost min-h-9 rounded-lg px-3 py-1.5 text-xs font-medium" id="selectAllExclude">{{ __('frontend.shuffle_wizard_select_all') }}</button>
                            </div>
                            <div class="faction-grid">
                                @foreach($factions as $faction)
                                    <div class="faction-item">
                                        <input class="sr-only exclude-faction" type="checkbox" name="excludeFactions[]" value="{{ $faction->name }}" id="exclude{{ $faction->id }}">
                                        <label class="faction-chip flex w-full min-h-11 cursor-pointer items-center justify-center rounded-xl border border-white/12 bg-zinc-900/70 px-2 py-2.5 text-center text-xs font-medium text-zinc-200 shadow-sm transition hover:border-indigo-500/40 hover:bg-zinc-800/90 sm:text-sm" for="exclude{{ $faction->id }}">
                                            {{ $faction->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex shrink-0 flex-col gap-3 border-t border-white/10 bg-zinc-950 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-8">
                    <button type="button" id="shuffle-prev" class="sur-btn-secondary order-2 min-h-12 w-full sm:order-1 sm:w-auto" hidden>
                        {{ __('frontend.shuffle_wizard_back') }}
                    </button>
                    <div class="order-1 flex w-full flex-col gap-2 sm:order-2 sm:ms-auto sm:w-auto sm:flex-row sm:justify-end">
                        <button type="button" id="shuffle-next" class="sur-btn-primary min-h-12 w-full min-w-[10rem] sm:w-auto">
                            {{ __('frontend.shuffle_wizard_next') }}
                        </button>
                        <button type="submit" id="shuffle-submit" class="sur-btn-primary inline-flex min-h-12 w-full items-center justify-center gap-2 min-w-[10rem] sm:w-auto" hidden disabled>
                            <i class="fa-solid fa-shuffle" aria-hidden="true"></i>{{ __('frontend.shuffle_wizard_run') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </dialog>
</x-layouts.main>

<script>
    window.__SUR_SHUFFLE_PRESET__ = @json($shufflePresetPayload ?? null);
    window.__SUR_OPEN_SHUFFLE_WITH_PRESET__ = @json($openShuffleWithPreset ?? false);
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const shuffleDialog = document.getElementById('shuffle-modal');
        /**
         * Keep the modal under document.body so it is not affected by scroll/layout in <main>
         * (native dialog top layer + sr-only focus can still interact badly when the node sits deep in the page).
         */
        if (shuffleDialog && shuffleDialog.parentElement !== document.body) {
            document.body.appendChild(shuffleDialog);
        }

        const contents = document.querySelectorAll('.shuffle-step-content');
        const stepEls = document.querySelectorAll('[data-shuffle-step]');
        const badgeEl = document.getElementById('shuffle-wizard-badge');
        const prevBtn = document.getElementById('shuffle-prev');
        const nextBtn = document.getElementById('shuffle-next');
        const submitBtn = document.getElementById('shuffle-submit');
        const playerFieldset = document.getElementById('shuffle-player-fieldset');
        const stepTemplate = shuffleDialog?.dataset.stepBadgeTemplate || 'Step :current of :total';

        const totalSteps = contents.length;
        const modalBodyScroll = shuffleDialog?.querySelector('.shuffle-modal-scroll');

        /**
         * Scroll only the step body region (badge + stepper stay fixed above).
         */
        function scrollModalBodyToTop() {
            if (modalBodyScroll) {
                modalBodyScroll.scrollTop = 0;
            }
        }

        function formatBadge(current, total) {
            return stepTemplate.replace(':current', String(current)).replace(':total', String(total));
        }

        function updateChrome(step) {
            if (badgeEl) {
                badgeEl.textContent = formatBadge(step, totalSteps);
            }
            stepEls.forEach((el) => {
                const n = parseInt(el.dataset.shuffleStep, 10);
                el.classList.remove('is-current', 'is-complete');
                if (n < step) {
                    el.classList.add('is-complete');
                }
                if (n === step) {
                    el.classList.add('is-current');
                }
            });
            if (prevBtn) {
                prevBtn.hidden = step <= 1;
            }
            if (nextBtn) {
                nextBtn.hidden = step >= totalSteps;
            }
            if (submitBtn) {
                const showSubmit = step === totalSteps;
                submitBtn.hidden = !showSubmit;
                submitBtn.disabled = !showSubmit;
            }
        }

        function getVisibleStepIndex() {
            const visible = document.querySelector('.shuffle-step-content:not(.hidden)');
            return visible ? Array.from(contents).indexOf(visible) : 0;
        }

        function animateContentChange(currentEl, nextEl, done) {
            scrollModalBodyToTop();
            currentEl.classList.add('slide-out');
            window.setTimeout(() => {
                currentEl.classList.add('hidden');
                currentEl.classList.remove('slide-out');
                nextEl.classList.remove('hidden');
                nextEl.classList.add('slide-in');
                window.setTimeout(() => {
                    nextEl.classList.remove('slide-in');
                    done?.();
                }, 300);
            }, 300);
        }

        function resetShuffleWizard() {
            document.querySelectorAll('input[name="numberOfPlayers"]').forEach((r) => {
                r.checked = false;
            });
            contents.forEach((el, i) => {
                el.classList.toggle('hidden', i !== 0);
                el.classList.remove('slide-out', 'slide-in');
            });
            playerFieldset?.classList.remove('shuffle-wizard--error');
            document.getElementById('shuffle-wizard-toast')?.classList.add('hidden');
            updateChrome(1);
            scrollModalBodyToTop();
        }

        document.querySelectorAll('.js-open-shuffle').forEach((btn) => {
            btn.addEventListener('click', () => {
                if (shuffleDialog && typeof shuffleDialog.showModal === 'function') {
                    resetShuffleWizard();
                    shuffleDialog.showModal();
                }
            });
        });

        document.querySelectorAll('[data-close-shuffle-modal]').forEach((btn) => {
            btn.addEventListener('click', () => {
                shuffleDialog?.close();
            });
        });

        // Backdrop / light dismiss: `closedby="any"` enables this in supporting browsers; older engines need the target check.
        shuffleDialog?.addEventListener('click', (e) => {
            if (e.target === shuffleDialog) {
                shuffleDialog.close();
            }
        });

        /**
         * Ensure sr-only faction inputs never trigger an unwanted scrollIntoView.
         * (position:relative on .faction-item anchors each input to its own item, so
         * Chromium's implicit scrollIntoView lands on the clicked item — already visible.)
         */
        shuffleDialog?.addEventListener(
            'focusin',
            (e) => {
                const t = e.target;
                if (
                    t &&
                    t.matches &&
                    t.matches('input.include-faction, input.exclude-faction, input[name="numberOfPlayers"]')
                ) {
                    t.focus({ preventScroll: true });
                }
            },
            true,
        );

        nextBtn?.addEventListener('click', () => {
            const currentIndex = getVisibleStepIndex();
            const step = currentIndex + 1;

            if (step === 1) {
                const checked = document.querySelector('input[name="numberOfPlayers"]:checked');
                if (!checked) {
                    playerFieldset?.classList.add('shuffle-wizard--error');
                    return;
                }
                playerFieldset?.classList.remove('shuffle-wizard--error');
            }

            if (currentIndex < totalSteps - 1) {
                updateChrome(currentIndex + 2);
                animateContentChange(contents[currentIndex], contents[currentIndex + 1]);
            }
        });

        prevBtn?.addEventListener('click', () => {
            const currentIndex = getVisibleStepIndex();
            if (currentIndex > 0) {
                updateChrome(currentIndex);
                animateContentChange(contents[currentIndex], contents[currentIndex - 1]);
            }
        });

        document.querySelectorAll('input[name="numberOfPlayers"]').forEach((radio) => {
            radio.addEventListener('change', () => playerFieldset?.classList.remove('shuffle-wizard--error'));
        });

        const shuffleForm = document.getElementById('shuffle-wizard-form');
        const shuffleToastEl = document.getElementById('shuffle-wizard-toast');

        function computeEligibleFactionNames() {
            const allNames = Array.from(document.querySelectorAll('.include-faction')).map((cb) => cb.value);
            const included = Array.from(document.querySelectorAll('.include-faction:checked')).map((cb) => cb.value);
            const excluded = new Set(
                Array.from(document.querySelectorAll('.exclude-faction:checked')).map((cb) => cb.value),
            );
            const pool = included.length === 0 ? allNames : included;
            return pool.filter((name) => !excluded.has(name));
        }

        function isIncludeFullyExcluded() {
            const included = Array.from(document.querySelectorAll('.include-faction:checked')).map((cb) => cb.value);
            if (included.length === 0) {
                return false;
            }
            const excluded = new Set(
                Array.from(document.querySelectorAll('.exclude-faction:checked')).map((cb) => cb.value),
            );
            return included.every((name) => excluded.has(name));
        }

        function showShuffleToast(message) {
            if (!shuffleToastEl || !message) {
                return;
            }
            shuffleToastEl.textContent = message;
            shuffleToastEl.classList.remove('hidden');
            window.clearTimeout(showShuffleToast._timer);
            showShuffleToast._timer = window.setTimeout(() => {
                shuffleToastEl.classList.add('hidden');
            }, 7000);
        }

        function maybeWarnEmptyPool() {
            const eligible = computeEligibleFactionNames();
            if (eligible.length === 0 && shuffleForm) {
                const d = shuffleForm.dataset;
                const msg = isIncludeFullyExcluded() ? d.msgConflict : d.msgPoolEmpty;
                showShuffleToast(msg);
            }
        }

        document.getElementById('selectAllInclude')?.addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('.include-faction');
            const allChecked = Array.from(checkboxes).every((cb) => cb.checked);
            checkboxes.forEach((cb) => {
                cb.checked = !allChecked;
            });
            maybeWarnEmptyPool();
        });

        document.getElementById('selectAllExclude')?.addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('.exclude-faction');
            const allChecked = Array.from(checkboxes).every((cb) => cb.checked);
            checkboxes.forEach((cb) => {
                cb.checked = !allChecked;
            });
            maybeWarnEmptyPool();
        });

        shuffleForm?.addEventListener('keydown', (e) => {
            if (e.key !== 'Enter') {
                return;
            }
            const t = e.target;
            if (t && t.matches && t.matches('input[type="checkbox"]')) {
                e.preventDefault();
            }
        });
        shuffleForm?.addEventListener('submit', (e) => {
            if (submitBtn && submitBtn.disabled) {
                e.preventDefault();
                return;
            }
            const players = parseInt(document.querySelector('input[name="numberOfPlayers"]:checked')?.value ?? '0', 10);
            const needed = Number.isFinite(players) ? players * 2 : 0;
            const eligible = computeEligibleFactionNames();
            const d = shuffleForm.dataset;
            if (eligible.length === 0) {
                e.preventDefault();
                showShuffleToast(isIncludeFullyExcluded() ? d.msgConflict : d.msgPoolEmpty);
                return;
            }
            if (needed > 0 && eligible.length < needed) {
                e.preventDefault();
                showShuffleToast(d.msgInsufficient);
            }
        });

        /**
         * Chromium (Chrome, Brave, Edge) can leave the viewport in a bad compositor state after
         * native <dialog> close() — dim or “blur” appears stuck though the dialog is gone.
         * Double rAF + forced layout + scroll nudge triggers a full repaint (Firefox is unaffected).
         */
        function nudgeViewportAfterShuffleDialogClose() {
            window.requestAnimationFrame(() => {
                window.requestAnimationFrame(() => {
                    document.documentElement.getBoundingClientRect();
                    document.body.getBoundingClientRect();
                    const y = window.scrollY;
                    window.scrollTo(0, y);
                });
            });
        }

        shuffleDialog?.addEventListener('close', nudgeViewportAfterShuffleDialogClose);

        /** Apply saved preset (player count + include/exclude checkboxes). */
        function applyShufflePreset(preset) {
            if (!preset || typeof preset !== 'object') {
                return;
            }
            const pc = preset.player_count;
            if (pc) {
                const radio = document.querySelector(`input[name="numberOfPlayers"][value="${pc}"]`);
                if (radio) {
                    radio.checked = true;
                }
            }
            const inc = Array.isArray(preset.include) ? preset.include : [];
            const exc = Array.isArray(preset.exclude) ? preset.exclude : [];
            document.querySelectorAll('.include-faction').forEach((cb) => {
                cb.checked = inc.includes(cb.value);
            });
            document.querySelectorAll('.exclude-faction').forEach((cb) => {
                cb.checked = exc.includes(cb.value);
            });
        }

        resetShuffleWizard();
        const presetPayload = window.__SUR_SHUFFLE_PRESET__;
        if (presetPayload) {
            applyShufflePreset(presetPayload);
        }
        if (window.__SUR_OPEN_SHUFFLE_WITH_PRESET__ && shuffleDialog && typeof shuffleDialog.showModal === 'function') {
            shuffleDialog.showModal();
        }
    });
</script>
