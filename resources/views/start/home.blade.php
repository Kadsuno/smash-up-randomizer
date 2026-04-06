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

    <dialog id="shuffle-modal" aria-labelledby="shuffleModalTitle" class="shadow-2xl">
        <div class="flex max-h-[90vh] flex-col">
            <div class="flex items-center justify-between gap-4 border-b border-white/10 px-4 py-4 sm:px-6">
                <h2 class="text-lg font-semibold" id="shuffleModalTitle">{{ __('frontend.shuffle') }}</h2>
                <button type="button" class="flex h-11 min-w-11 items-center justify-center rounded-lg text-zinc-400 transition hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400/60" data-close-shuffle-modal aria-label="Close">
                    <span class="text-xl leading-none" aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class="needs-validation flex min-h-0 flex-1 flex-col" method="POST" action="{{ route('shuffle-result') }}" novalidate>
                @csrf
                <div class="sur-scrollbar min-h-0 flex-1 overflow-y-auto px-4 py-4 sm:px-6">
                    <div class="sur-progress-track mb-4">
                        <div class="sur-progress-fill shuffle-progress-bar progress-bar" style="width: 33%;" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Step 1 of 3</div>
                    </div>

                    <div class="mb-6 flex justify-between gap-2 text-xs text-zinc-500 sm:text-sm">
                        <span class="shuffle-step-label active font-medium text-indigo-400">Number of Players</span>
                        <span class="shuffle-step-label">Include Factions</span>
                        <span class="shuffle-step-label">Exclude Factions</span>
                    </div>

                    <div class="shuffle-step-content" id="step1-content">
                        <h3 class="mb-3 text-base font-semibold text-white sm:text-lg">Step 1: Number of Players</h3>
                        <div class="mb-4">
                            <label for="numberOfPlayers" class="mb-2 block text-sm text-zinc-300">{{ __('frontend.number_players') }}</label>
                            <select class="sur-input" name="numberOfPlayers" id="numberOfPlayers" required>
                                <option value="">Choose...</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <button type="button" class="sur-btn-primary next-step">Next</button>
                    </div>

                    <div class="shuffle-step-content hidden" id="step2-content">
                        <h3 class="mb-3 text-base font-semibold text-white sm:text-lg">Step 2: Include Factions</h3>
                        <div class="mb-4">
                            <div class="mb-2 flex flex-wrap items-center justify-between gap-2">
                                <label class="text-sm text-zinc-300">Include Factions</label>
                                <button type="button" class="sur-btn-ghost min-h-9 px-3 py-1 text-xs" id="selectAllInclude">Select All</button>
                            </div>
                            <div class="faction-grid">
                                @foreach($factions as $faction)
                                    <div class="faction-item">
                                        <input class="peer sr-only include-faction" type="checkbox" name="includeFactions[]" value="{{ $faction->name }}" id="include{{ $faction->id }}">
                                        <label class="flex w-full min-h-11 cursor-pointer items-center justify-center rounded-xl border border-white/15 bg-zinc-800/80 px-2 py-2 text-center text-xs font-medium text-zinc-200 transition hover:border-indigo-500/40 peer-checked:border-indigo-500 peer-checked:bg-indigo-500/15 peer-checked:text-indigo-200 sm:text-sm" for="include{{ $faction->id }}">
                                            {{ $faction->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" class="sur-btn-secondary prev-step">Previous</button>
                            <button type="button" class="sur-btn-primary next-step">Next</button>
                        </div>
                    </div>

                    <div class="shuffle-step-content hidden" id="step3-content">
                        <h3 class="mb-3 text-base font-semibold text-white sm:text-lg">Step 3: Exclude Factions</h3>
                        <div class="mb-4">
                            <div class="mb-2 flex flex-wrap items-center justify-between gap-2">
                                <label class="text-sm text-zinc-300">Exclude Factions</label>
                                <button type="button" class="sur-btn-ghost min-h-9 px-3 py-1 text-xs" id="selectAllExclude">Select All</button>
                            </div>
                            <div class="faction-grid">
                                @foreach($factions as $faction)
                                    <div class="faction-item">
                                        <input class="peer sr-only exclude-faction" type="checkbox" name="excludeFactions[]" value="{{ $faction->name }}" id="exclude{{ $faction->id }}">
                                        <label class="flex w-full min-h-11 cursor-pointer items-center justify-center rounded-xl border border-white/15 bg-zinc-800/80 px-2 py-2 text-center text-xs font-medium text-zinc-200 transition hover:border-indigo-500/40 peer-checked:border-indigo-500 peer-checked:bg-indigo-500/15 peer-checked:text-indigo-200 sm:text-sm" for="exclude{{ $faction->id }}">
                                            {{ $faction->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            <button type="button" class="sur-btn-secondary prev-step">Previous</button>
                            <button type="submit" class="sur-btn-primary inline-flex items-center gap-2">
                                <i class="fa-solid fa-shuffle" aria-hidden="true"></i>{{ __('frontend.shuffle') }}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </dialog>
</x-layouts.main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const shuffleDialog = document.getElementById('shuffle-modal');
        document.querySelectorAll('.js-open-shuffle').forEach((btn) => {
            btn.addEventListener('click', () => {
                if (shuffleDialog && typeof shuffleDialog.showModal === 'function') {
                    shuffleDialog.showModal();
                }
            });
        });
        document.querySelectorAll('[data-close-shuffle-modal]').forEach((btn) => {
            btn.addEventListener('click', () => shuffleDialog?.close());
        });

        const contents = document.querySelectorAll('.shuffle-step-content');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        const progressBar = document.querySelector('.progress-bar');
        const stepLabels = document.querySelectorAll('.shuffle-step-label');

        function updateProgress(step) {
            if (!progressBar) return;
            const width = (step / contents.length) * 100;
            progressBar.style.width = `${width}%`;
            progressBar.setAttribute('aria-valuenow', String(width));
            progressBar.textContent = `Step ${step} of ${contents.length}`;

            stepLabels.forEach((label, index) => {
                if (index < step) {
                    label.classList.add('active');
                } else {
                    label.classList.remove('active');
                }
            });
        }

        function animateContentChange(currentStep, nextStep) {
            currentStep.classList.add('slide-out');
            setTimeout(() => {
                currentStep.classList.add('hidden');
                currentStep.classList.remove('slide-out');
                nextStep.classList.remove('hidden');
                nextStep.classList.add('slide-in');
                setTimeout(() => {
                    nextStep.classList.remove('slide-in');
                }, 300);
            }, 300);
        }

        nextButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const currentStep = document.querySelector('.shuffle-step-content:not(.hidden)');
                const currentIndex = Array.from(contents).indexOf(currentStep);
                if (currentIndex < contents.length - 1) {
                    animateContentChange(currentStep, contents[currentIndex + 1]);
                    updateProgress(currentIndex + 2);
                }
            });
        });

        prevButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const currentStep = document.querySelector('.shuffle-step-content:not(.hidden)');
                const currentIndex = Array.from(contents).indexOf(currentStep);
                if (currentIndex > 0) {
                    animateContentChange(currentStep, contents[currentIndex - 1]);
                    updateProgress(currentIndex);
                }
            });
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
    });
</script>
