<x-layouts.main>
    <div id="hero-header" class="animate__animated animate__fadeIn">
        <div class="relative w-full overflow-hidden">
            <div class="hero-height bg-options min-h-[70vh] sm:min-h-[80vh]" id="hero-js" style="background-image: url('{{ asset('images/smashup_hero.png') }}')">
                <div class="mx-auto flex h-full max-w-7xl items-center px-4 sm:px-6">
                    <div class="w-full py-8 sm:py-12">
                        <div class="max-w-xl rounded-2xl border border-white/10 bg-black/70 p-6 shadow-2xl backdrop-blur-md animate__animated animate__slideInLeft sm:p-8">
                            <h1 class="mb-4 text-3xl font-extrabold tracking-tight text-white sm:text-4xl md:text-5xl">
                                {{ __('frontend.start_header') }}
                            </h1>
                            <p class="text-base leading-relaxed text-zinc-200 sm:text-lg">
                                {{ __('frontend.start_teaser') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6">
        <div class="grid gap-6 md:grid-cols-2">
            <div class="sur-card-interactive animate__animated animate__fadeInLeft p-6 sm:p-8">
                <h2 class="mb-4 text-xl font-bold text-white sm:text-2xl">
                    {{ __('frontend.help_smashup_header') }}
                </h2>
                <p class="mb-3 text-sm leading-relaxed text-zinc-300">{{ __('frontend.help_smashup_body') }}</p>
                <p class="text-sm leading-relaxed text-zinc-300">{{ __('frontend.help_smashup_function') }}</p>
            </div>
            <div class="sur-card-interactive animate__animated animate__fadeInRight p-6 sm:p-8">
                <h2 class="mb-4 text-xl font-bold text-white sm:text-2xl">
                    {{ __('frontend.help_howto_header') }}
                </h2>
                <p class="mb-3 text-sm leading-relaxed text-zinc-300">{{ __('frontend.help_howto_body') }}</p>
                <p class="mb-6 text-sm leading-relaxed text-zinc-300">{{ __('frontend.help_howto_fun') }}</p>
                <div class="text-center">
                    <button type="button" id="open-shuffle-modal" class="sur-btn-primary w-full min-h-12 animate__animated animate__pulse animate__infinite sm:w-auto">
                        {{ __('frontend.shuffle_button') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

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
                <div class="min-h-0 flex-1 overflow-y-auto px-4 py-4 sm:px-6">
                    <div class="sur-progress-track mb-4">
                        <div class="sur-progress-fill progress-bar" style="width: 33%;" role="progressbar" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Step 1 of 3</div>
                    </div>

                    <div class="mb-6 flex justify-between gap-2 text-xs text-zinc-500 sm:text-sm">
                        <span class="step-label active font-medium text-indigo-400">Number of Players</span>
                        <span class="step-label">Include Factions</span>
                        <span class="step-label">Exclude Factions</span>
                    </div>

                    <div class="step-content" id="step1-content">
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

                    <div class="step-content hidden" id="step2-content">
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

                    <div class="step-content hidden" id="step3-content">
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

<style>
    .hero-height {
        background-size: cover;
        background-position: center;
    }
    .bg-options {
        background-repeat: no-repeat;
        background-position: center;
    }
    .hover-card {
        transition: transform 0.3s ease-in-out;
    }
    .hover-card:hover {
        transform: translateY(-5px);
    }
    .animate__animated {
        animation-duration: 0.5s;
    }
    .progress-bar {
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
        color: #eef2ff;
    }
    .step-labels {
        display: flex;
        justify-content: space-between;
    }
    .step-label {
        flex: 1;
        text-align: center;
        color: #71717a;
    }
    .step-label.active {
        color: #a5b4fc;
        font-weight: 600;
    }
    .faction-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
        gap: 0.5rem;
    }
    @media (min-width: 640px) {
        .faction-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 0.625rem;
        }
    }
    .faction-item {
        text-align: center;
    }
    .step-content {
        transition: opacity 0.3s ease, transform 0.3s ease;
    }
    .step-content.slide-out {
        opacity: 0;
        transform: translateX(-100%);
    }
    .step-content.slide-in {
        opacity: 1;
        transform: translateX(0);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const shuffleDialog = document.getElementById('shuffle-modal');
        const openBtn = document.getElementById('open-shuffle-modal');
        openBtn?.addEventListener('click', () => {
            if (shuffleDialog && typeof shuffleDialog.showModal === 'function') {
                shuffleDialog.showModal();
            }
        });
        document.querySelectorAll('[data-close-shuffle-modal]').forEach((btn) => {
            btn.addEventListener('click', () => shuffleDialog?.close());
        });

        const cards = document.querySelectorAll('.hover-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.2}s`;
        });

        const contents = document.querySelectorAll('.step-content');
        const nextButtons = document.querySelectorAll('.next-step');
        const prevButtons = document.querySelectorAll('.prev-step');
        const progressBar = document.querySelector('.progress-bar');
        const stepLabels = document.querySelectorAll('.step-label');

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
                const currentStep = document.querySelector('.step-content:not(.hidden)');
                const currentIndex = Array.from(contents).indexOf(currentStep);
                if (currentIndex < contents.length - 1) {
                    animateContentChange(currentStep, contents[currentIndex + 1]);
                    updateProgress(currentIndex + 2);
                }
            });
        });

        prevButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const currentStep = document.querySelector('.step-content:not(.hidden)');
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
