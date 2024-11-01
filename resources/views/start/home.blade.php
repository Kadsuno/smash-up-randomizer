<x-layouts.main>
    <div id="hero-header" class="animate__animated animate__fadeIn">
        <div class="position-relative w-100 overflow-hidden hero-height">
            <div class="hero-height bg-options" id="hero-js" style="background-image: url('{{ asset('images/smashup_hero.png') }}')">
                <div class="container h-100 d-flex align-items-center">
                    <div class="row w-100">
                        <div class="col-md-8 col-lg-6">
                            <div class="text-white bg-black bg-opacity-75 rounded-3 p-5 animate__animated animate__slideInLeft">
                                <h1 class="mb-4 display-4 fw-bold">
                                    {{ __('frontend.start_header') }}
                                </h1>
                                <p class="lead">
                                    {{ __('frontend.start_teaser') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="row align-items-md-stretch">
                <div class="col-md-6 mb-4">
                    <div class="h-100 p-5 bg-dark rounded-3 text-white shadow-lg hover-card animate__animated animate__fadeInLeft">
                        <h2 class="mb-4">
                            {{ __('frontend.help_smashup_header') }}
                        </h2>
                        <p>{{ __('frontend.help_smashup_body') }}</p>
                        <p>{{ __('frontend.help_smashup_function') }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="h-100 p-5 bg-dark text-white rounded-3 shadow-lg hover-card animate__animated animate__fadeInRight">
                        <h2 class="mb-4">
                            {{ __('frontend.help_howto_header') }}
                        </h2>
                        <p>{{ __('frontend.help_howto_body') }}</p>
                        <p>{{ __('frontend.help_howto_fun') }}</p>
                        <div class="text-center mt-4">
                            <a class="btn btn-lg btn-light text-center animate__animated animate__pulse animate__infinite" data-bs-toggle="modal" data-bs-target="#shuffle-modal">{{ __('frontend.shuffle_button') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="shuffle-modal" tabindex="-1" aria-labelledby="shuffle-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-dark text-white border-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="shuffleModal">{{ __('frontend.shuffle') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form class="needs-validation" method="POST" action="{{ route('shuffle-result') }}" novalidate>
                    @csrf   
                    <div class="modal-body">
                        <div class="progress mb-4">
                            <div class="progress-bar" role="progressbar" style="width: 33%;" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100">Step 1 of 3</div>
                        </div>

                        <div class="step-labels mb-4">
                            <span class="step-label active">Number of Players</span>
                            <span class="step-label">Include Factions</span>
                            <span class="step-label">Exclude Factions</span>
                        </div>

                        <div class="step-content" id="step1-content">
                            <h4 class="mb-3">Step 1: Number of Players</h4>
                            <div class="mb-3">
                                <label for="numberOfPlayers" class="form-label">{{ __('frontend.number_players') }}</label>
                                <select class="form-select bg-dark text-white border-secondary" name="numberOfPlayers" required>
                                    <option value="">Choose...</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please choose the number of players.
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary next-step">Next</button>
                        </div>

                        <div class="step-content d-none" id="step2-content">
                            <h4 class="mb-3">Step 2: Include Factions</h4>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0">Include Factions</label>
                                    <button type="button" class="btn btn-sm btn-outline-light" id="selectAllInclude">Select All</button>
                                </div>
                                <div class="faction-grid">
                                    @foreach($factions as $faction)
                                        <div class="faction-item">
                                            <input class="btn-check include-faction" type="checkbox" name="includeFactions[]" value="{{ $faction->name }}" id="include{{ $faction->id }}">
                                            <label class="btn btn-outline-light w-100" for="include{{ $faction->id }}">
                                                {{ $faction->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                            <button type="button" class="btn btn-primary next-step">Next</button>
                        </div>

                        <div class="step-content d-none" id="step3-content">
                            <h4 class="mb-3">Step 3: Exclude Factions</h4>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label class="form-label mb-0">Exclude Factions</label>
                                    <button type="button" class="btn btn-sm btn-outline-light" id="selectAllExclude">Select All</button>
                                </div>
                                <div class="faction-grid">
                                    @foreach($factions as $faction)
                                        <div class="faction-item">
                                            <input class="btn-check exclude-faction" type="checkbox" name="excludeFactions[]" value="{{ $faction->name }}" id="exclude{{ $faction->id }}">
                                            <label class="btn btn-outline-light w-100" for="exclude{{ $faction->id }}">
                                                {{ $faction->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary prev-step">Previous</button>
                            <button type="submit" class="btn btn-light"><i class="fa-solid fa-shuffle me-2"></i>{{ __('frontend.shuffle') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.main>

<style>
    .hero-height {
        min-height: 80vh;
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
    .progress {
        height: 20px;
        background-color: #6c757d;
    }
    .progress-bar {
        background-color: #007bff;
        transition: width 0.3s ease-in-out;
    }
    .step-labels {
        display: flex;
        justify-content: space-between;
    }
    .step-label {
        flex: 1;
        text-align: center;
        color: #6c757d;
    }
    .step-label.active {
        color: #007bff;
        font-weight: bold;
    }
    .faction-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
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
    document.addEventListener('DOMContentLoaded', (event) => {
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
            const width = (step / contents.length) * 100;
            progressBar.style.width = `${width}%`;
            progressBar.setAttribute('aria-valuenow', width);
            progressBar.textContent = `Step ${step} of ${contents.length}`;

            stepLabels.forEach((label, index) => {
                if (index < step) {
                    label.classList.add('active');
                } else {
                    label.classList.remove('active');
                }
            });
        }

        function animateContentChange(currentStep, nextStep, direction) {
            currentStep.classList.add('slide-out');
            setTimeout(() => {
                currentStep.classList.add('d-none');
                currentStep.classList.remove('slide-out');
                nextStep.classList.remove('d-none');
                nextStep.classList.add('slide-in');
                setTimeout(() => {
                    nextStep.classList.remove('slide-in');
                }, 300);
            }, 300);
        }

        nextButtons.forEach(button => {
            button.addEventListener('click', () => {
                const currentStep = document.querySelector('.step-content:not(.d-none)');
                const currentIndex = Array.from(contents).indexOf(currentStep);
                if (currentIndex < contents.length - 1) {
                    animateContentChange(currentStep, contents[currentIndex + 1], 'next');
                    updateProgress(currentIndex + 2);
                }
            });
        });

        prevButtons.forEach(button => {
            button.addEventListener('click', () => {
                const currentStep = document.querySelector('.step-content:not(.d-none)');
                const currentIndex = Array.from(contents).indexOf(currentStep);
                if (currentIndex > 0) {
                    animateContentChange(currentStep, contents[currentIndex - 1], 'prev');
                    updateProgress(currentIndex);
                }
            });
        });

        document.getElementById('selectAllInclude').addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('.include-faction');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        });

        document.getElementById('selectAllExclude').addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('.exclude-faction');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        });
    });
</script>