<x-layouts.main>
    <div class="container mt-5 pt-5 text-black">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card bg-dark text-white shadow-lg mb-5">
                    <div class="card-body">
                        <h1 class="card-title text-center mb-4">
                            {{ __('frontend.privacyPolicy_header') }}
                        </h1>
                        <p class="lead text-center mb-5">
                            {{ __('frontend.privacyPolicy_teaser') }}
                        </p>

                        <div class="accordion" id="privacyAccordion">
                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingDataCollection">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDataCollection" aria-expanded="true" aria-controls="collapseDataCollection">
                                        {{ __('frontend.privacyPolicy_dataCollection_header') }}
                                    </button>
                                </h2>
                                <div id="collapseDataCollection" class="accordion-collapse collapse show" aria-labelledby="headingDataCollection" data-bs-parent="#privacyAccordion">
                                    <div class="accordion-body">
                                        <p>{{ __('frontend.privacyPolicy_dataCollection_body') }}</p>
                                        <p>{{ __('frontend.privacyPolicy_cookiebot_body') }}</p>
                                        <p>{{ __('frontend.privacyPolicy_matomo_body') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingSecurity">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSecurity" aria-expanded="false" aria-controls="collapseSecurity">
                                        {{ __('frontend.privacyPolicy_security_header') }}
                                    </button>
                                </h2>
                                <div id="collapseSecurity" class="accordion-collapse collapse" aria-labelledby="headingSecurity" data-bs-parent="#privacyAccordion">
                                    <div class="accordion-body">
                                        <p>{{ __('frontend.privacyPolicy_security_body') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingCookies">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCookies" aria-expanded="false" aria-controls="collapseCookies">
                                        {{ __('frontend.privacyPolicy_cookies_header') }}
                                    </button>
                                </h2>
                                <div id="collapseCookies" class="accordion-collapse collapse" aria-labelledby="headingCookies" data-bs-parent="#privacyAccordion">
                                    <div class="accordion-body">
                                        <p>{{ __('frontend.privacyPolicy_cookies_body') }}</p>
                                        <p>{{ __('frontend.privacyPolicy_cookiebot_cookies_body') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingRights">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRights" aria-expanded="false" aria-controls="collapseRights">
                                        {{ __('frontend.privacyPolicy_rights_header') }}
                                    </button>
                                </h2>
                                <div id="collapseRights" class="accordion-collapse collapse" aria-labelledby="headingRights" data-bs-parent="#privacyAccordion">
                                    <div class="accordion-body">
                                        <p>{{ __('frontend.privacyPolicy_rights_body') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item mb-3">
                                <h2 class="accordion-header" id="headingDataSharing">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDataSharing" aria-expanded="false" aria-controls="collapseDataSharing">
                                        {{ __('frontend.privacyPolicy_dataSharing_header') }}
                                    </button>
                                </h2>
                                <div id="collapseDataSharing" class="accordion-collapse collapse" aria-labelledby="headingDataSharing" data-bs-parent="#privacyAccordion">
                                    <div class="accordion-body">
                                        <p>{{ __('frontend.privacyPolicy_dataSharing_body') }}</p>
                                        <p>{{ __('frontend.privacyPolicy_matomo_dataSharing_body') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p class="mt-5 text-center">
                            {{ __('frontend.privacyPolicy_lastWords') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>