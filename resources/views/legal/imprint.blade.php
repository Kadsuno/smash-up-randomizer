<x-layouts.main>
    <div class="container my-5 pt-5">
        <div class="row">
            <div class="col-md">
                <h1 class="mb-4">
                    {{ __('frontend.imprint_header') }}
                </h1>
            </div>
        </div>
    </div>
    <div class="container text-black">
        <div class="row">
            <div class="col-md-12">
                <div class="card bg-dark text-white shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-3">{{ __('frontend.imprint_tmg') }}</h2>
                        <p class="card-text">
                            Mike Rauch <br>
                            Im Turmswinkel 12<br>
                            38122 Braunschweig <br>
                        </p>
                    </div>
                </div>

                <div class="card bg-dark text-white shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-3">{{ __('frontend.imprint_represent') }}</h2>
                        <p class="card-text">Mike Rauch</p>
                    </div>
                </div>

                <div class="card bg-dark text-white shadow-sm mb-4">
                    <div class="card-body">
                        <h2 class="card-title h4 mb-3">{{ __('frontend.imprint_contact') }}</h2>
                        <p class="card-text mb-2">
                            <i class="fas fa-phone-alt me-2"></i>{{ __('frontend.imprint_phone') }}: 0531-21939351
                        </p>
                        <p class="card-text">
                            <i class="fas fa-envelope me-2"></i>{{ __('frontend.imprint_email') }}:
                            <a href='mailto:mike.rauch@proton.me' class="text-primary">
                                mike.rauch@proton.me
                            </a>
                        </p>
                    </div>
                </div>

                <h2 class="my-5">{{ __('frontend.imprint_disclaimer') }}</h2>

                <div class="accordion" id="disclaimerAccordion">
                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingContent">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContent" aria-expanded="true" aria-controls="collapseContent">
                                {{ __('frontend.imprint_content_header') }}
                            </button>
                        </h3>
                        <div id="collapseContent" class="accordion-collapse collapse show" aria-labelledby="headingContent" data-bs-parent="#disclaimerAccordion">
                            <div class="accordion-body">
                                <p>{{ __('frontend.imprint_content_body') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingCopyright">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCopyright" aria-expanded="false" aria-controls="collapseCopyright">
                                {{ __('frontend.imprint_copyright_header') }}
                            </button>
                        </h3>
                        <div id="collapseCopyright" class="accordion-collapse collapse" aria-labelledby="headingCopyright" data-bs-parent="#disclaimerAccordion">
                            <div class="accordion-body">
                                <p>{{ __('frontend.imprint_copyright_body') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h3 class="accordion-header" id="headingData">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseData" aria-expanded="false" aria-controls="collapseData">
                                {{ __('frontend.imprint_data_header') }}
                            </button>
                        </h3>
                        <div id="collapseData" class="accordion-collapse collapse" aria-labelledby="headingData" data-bs-parent="#disclaimerAccordion">
                            <div class="accordion-body">
                                <p>{{ __('frontend.imprint_data_body_1') }}</p>
                                <p>{{ __('frontend.imprint_data_body_2') }}</p>
                                <p>{{ __('frontend.imprint_data_body_3') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>