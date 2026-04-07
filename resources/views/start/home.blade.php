<x-layouts.main>
    {{-- Marketing hero --}}
    <section class="relative overflow-hidden border-b border-white/10">
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
                    <p class="mt-5 max-w-xl text-sm leading-relaxed text-zinc-500">
                        {{ __('frontend.landing_hero_note') }}
                    </p>
                </div>

                <div
                    class="order-1 lg:order-2 lg:col-span-7"
                    x-data="landingHero({{ count($landingSlides) }})"
                    @mouseenter="stop()"
                    @mouseleave="start()"
                    role="region"
                    aria-roledescription="carousel"
                    aria-label="{{ __('frontend.logo_alt') }}"
                >
                    <div class="sur-landing-carousel relative aspect-[4/3] w-full overflow-hidden rounded-3xl border border-white/10 shadow-2xl shadow-black/50 sm:aspect-[16/10] lg:min-h-[22rem]">
                        @foreach($landingSlides as $idx => $slide)
                            <div
                                x-show="i === {{ $idx }}"
                                x-transition.opacity.duration.500ms
                                class="absolute inset-0"
                                x-cloak
                                role="group"
                                aria-roledescription="slide"
                                aria-label="{{ __('frontend.landing_slide_'.$slide['id'].'_title') }}"
                            >
                                <img
                                    src="{{ $slide['src'] }}"
                                    alt="{{ __('frontend.landing_slide_'.$slide['id'].'_alt') }}"
                                    class="h-full w-full object-cover"
                                    loading="{{ $idx === 0 ? 'eager' : 'lazy' }}"
                                    width="1200"
                                    height="750"
                                >
                                <div class="absolute inset-0 bg-linear-to-t from-black/88 via-black/25 to-transparent"></div>
                                <div class="absolute inset-x-0 bottom-0 p-5 sm:p-7">
                                    <h2 class="text-lg font-bold text-white sm:text-2xl">{{ __('frontend.landing_slide_'.$slide['id'].'_title') }}</h2>
                                    <p class="mt-2 max-w-xl text-sm leading-relaxed text-zinc-200 sm:text-base">{{ __('frontend.landing_slide_'.$slide['id'].'_tagline') }}</p>
                                </div>
                            </div>
                        @endforeach

                        <div class="pointer-events-none absolute inset-x-0 top-4 flex justify-center gap-1.5 sm:justify-end sm:px-5">
                            @foreach($landingSlides as $idx => $_)
                                <button
                                    type="button"
                                    class="pointer-events-auto h-2.5 w-2.5 rounded-full transition sm:h-2 sm:w-2"
                                    :class="i === {{ $idx }} ? 'bg-white shadow-lg shadow-indigo-500/40 ring-2 ring-indigo-400/50' : 'bg-white/35 hover:bg-white/60'"
                                    @click="go({{ $idx }})"
                                    :aria-current="i === {{ $idx }} ? 'true' : 'false'"
                                    aria-label="Slide {{ $idx + 1 }}"
                                ></button>
                            @endforeach
                        </div>

                        <button
                            type="button"
                            class="sur-landing-carousel-btn absolute left-2 top-1/2 z-10 -translate-y-1/2 sm:left-3"
                            @click="prev()"
                            aria-label="{{ __('frontend.landing_carousel_prev') }}"
                        >
                            <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
                        </button>
                        <button
                            type="button"
                            class="sur-landing-carousel-btn absolute right-2 top-1/2 z-10 -translate-y-1/2 sm:right-3"
                            @click="next()"
                            aria-label="{{ __('frontend.landing_carousel_next') }}"
                        >
                            <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Feature grid --}}
    <x-sur.section>
        <div class="text-center">
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-indigo-400/90">{{ __('frontend.landing_features_eyebrow') }}</p>
            <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('frontend.landing_features_title') }}</h2>
        </div>
        <div class="mt-12 grid gap-6 md:grid-cols-3">
            <x-sur.reveal :delay="0">
                <div class="sur-card group h-full border-white/10 p-6 transition duration-300 hover:border-indigo-500/30 sm:p-8">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-500/15 text-indigo-300 ring-1 ring-indigo-500/25">
                        <i class="fa-solid fa-scale-balanced text-xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="mb-3 text-lg font-semibold text-white">{{ __('frontend.landing_feature_1_title') }}</h3>
                    <p class="text-sm leading-relaxed text-zinc-400">{{ __('frontend.landing_feature_1_body') }}</p>
                </div>
            </x-sur.reveal>
            <x-sur.reveal :delay="70">
                <div class="sur-card group h-full border-white/10 p-6 transition duration-300 hover:border-indigo-500/30 sm:p-8">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-violet-500/15 text-violet-300 ring-1 ring-violet-500/25">
                        <i class="fa-solid fa-layer-group text-xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="mb-3 text-lg font-semibold text-white">{{ __('frontend.landing_feature_2_title') }}</h3>
                    <p class="text-sm leading-relaxed text-zinc-400">{{ __('frontend.landing_feature_2_body') }}</p>
                </div>
            </x-sur.reveal>
            <x-sur.reveal :delay="140">
                <div class="sur-card group h-full border-white/10 p-6 transition duration-300 hover:border-indigo-500/30 sm:p-8">
                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-500/15 text-indigo-300 ring-1 ring-indigo-500/25">
                        <i class="fa-solid fa-bolt text-xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="mb-3 text-lg font-semibold text-white">{{ __('frontend.landing_feature_3_title') }}</h3>
                    <p class="text-sm leading-relaxed text-zinc-400">{{ __('frontend.landing_feature_3_body') }}</p>
                </div>
            </x-sur.reveal>
        </div>
    </x-sur.section>

    {{-- Quotes carousel --}}
    <section class="border-y border-white/10 bg-linear-to-b from-zinc-950 via-zinc-900/40 to-zinc-950 py-16 sm:py-20">
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

    {{-- Legacy help cards (SEO + returning users): compact --}}
    <x-sur.section :padded="true">
        <div class="grid gap-6 md:grid-cols-2">
            <x-sur.reveal>
                <div class="sur-card-interactive h-full p-6 sm:p-8">
                    <h2 class="mb-4 text-xl font-bold text-white sm:text-2xl">{{ __('frontend.help_smashup_header') }}</h2>
                    <p class="mb-3 text-sm leading-relaxed text-zinc-400">{{ __('frontend.help_smashup_body') }}</p>
                    <p class="text-sm leading-relaxed text-zinc-500">{{ __('frontend.help_smashup_function') }}</p>
                </div>
            </x-sur.reveal>
            <x-sur.reveal :delay="80">
                <div class="sur-card-interactive flex h-full flex-col p-6 sm:p-8">
                    <h2 class="mb-4 text-xl font-bold text-white sm:text-2xl">{{ __('frontend.help_howto_header') }}</h2>
                    <p class="mb-3 text-sm leading-relaxed text-zinc-400">{{ __('frontend.help_howto_body') }}</p>
                    <p class="mb-6 text-sm leading-relaxed text-zinc-500">{{ __('frontend.help_howto_fun') }}</p>
                    <div class="mt-auto text-center">
                        <button type="button" class="js-open-shuffle sur-btn-primary w-full min-h-12 sm:w-auto">
                            {{ __('frontend.shuffle_button') }}
                        </button>
                    </div>
                </div>
            </x-sur.reveal>
        </div>
    </x-sur.section>

    <dialog
        id="shuffle-modal"
        class="shuffle-modal-dialog shadow-2xl"
        aria-labelledby="shuffleModalTitle"
        aria-describedby="shuffleModalSubtitle"
        data-step-badge-template="{{ e(__('frontend.shuffle_wizard_step_badge_template')) }}"
    >
        <div class="isolate flex max-h-[min(90vh,52rem)] flex-col overflow-hidden rounded-2xl border border-white/10 bg-zinc-950 shadow-[0_24px_80px_-12px_rgba(0,0,0,0.65)] ring-1 ring-white/10">
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

            <form class="shuffle-wizard-form flex min-h-0 flex-1 flex-col" method="POST" action="{{ route('shuffle-result') }}" novalidate>
                @csrf
                <div class="shuffle-modal-scroll sur-scrollbar min-h-0 flex-1 overflow-y-auto overflow-x-hidden px-5 py-6 sm:px-8 sm:py-8">
                    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
                        <p id="shuffle-wizard-badge" class="text-sm font-medium text-zinc-300" aria-live="polite"></p>
                    </div>

                    <nav class="shuffle-wizard-stepper mb-8" aria-label="{{ __('frontend.shuffle_wizard_nav_aria') }}">
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
                        <h3 class="mb-4 text-lg font-semibold text-white sm:text-xl">{{ __('frontend.shuffle_wizard_heading_include') }}</h3>
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
                        <h3 class="mb-4 text-lg font-semibold text-white sm:text-xl">{{ __('frontend.shuffle_wizard_heading_exclude') }}</h3>
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
                        <button type="submit" id="shuffle-submit" class="sur-btn-primary inline-flex min-h-12 w-full items-center justify-center gap-2 min-w-[10rem] sm:w-auto" hidden>
                            <i class="fa-solid fa-shuffle" aria-hidden="true"></i>{{ __('frontend.shuffle_wizard_run') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </dialog>
</x-layouts.main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const shuffleDialog = document.getElementById('shuffle-modal');
        const contents = document.querySelectorAll('.shuffle-step-content');
        const stepEls = document.querySelectorAll('[data-shuffle-step]');
        const badgeEl = document.getElementById('shuffle-wizard-badge');
        const prevBtn = document.getElementById('shuffle-prev');
        const nextBtn = document.getElementById('shuffle-next');
        const submitBtn = document.getElementById('shuffle-submit');
        const playerFieldset = document.getElementById('shuffle-player-fieldset');
        const stepTemplate = shuffleDialog?.dataset.stepBadgeTemplate || 'Step :current of :total';

        const totalSteps = contents.length;

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
                submitBtn.hidden = step !== totalSteps;
            }
        }

        function getVisibleStepIndex() {
            const visible = document.querySelector('.shuffle-step-content:not(.hidden)');
            return visible ? Array.from(contents).indexOf(visible) : 0;
        }

        function animateContentChange(currentEl, nextEl, done) {
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
            updateChrome(1);
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
            btn.addEventListener('click', () => shuffleDialog?.close());
        });

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

        document.getElementById('selectAllInclude')?.addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('.include-faction');
            const allChecked = Array.from(checkboxes).every((cb) => cb.checked);
            checkboxes.forEach((cb) => {
                cb.checked = !allChecked;
            });
        });

        document.getElementById('selectAllExclude')?.addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('.exclude-faction');
            const allChecked = Array.from(checkboxes).every((cb) => cb.checked);
            checkboxes.forEach((cb) => {
                cb.checked = !allChecked;
            });
        });

        resetShuffleWizard();
    });
</script>
