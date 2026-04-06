@if (config('matomo.enabled'))
    @php
        $surMatomoConfig = [
            'trackerUrl' => rtrim((string) config('matomo.tracker_url'), '/') . '/',
            'siteId' => config('matomo.site_id'),
        ];
    @endphp
    <script type="application/json" id="sur-matomo-config">{!! json_encode($surMatomoConfig) !!}</script>

    {{-- Bottom strip (Cookiebot-style); hidden via inline script if consent already stored --}}
    <div id="sur-cookie-consent-bar"
        class="sur-cookie-bar position-fixed bottom-0 start-0 end-0 bg-dark text-white py-3 px-3"
        role="region"
        aria-label="{{ __('frontend.cookie_banner_title') }}">
        <div class="container">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center gap-3">
                <div class="flex-grow-1 small">
                    <strong class="d-block mb-1 text-uppercase text-secondary"
                        style="letter-spacing: 0.06em; font-size: 0.7rem;">{{ __('frontend.cookie_banner_title') }}</strong>
                    <span>{{ __('frontend.cookie_banner_bar_lead') }}</span>
                    <a href="{{ route('privacy-policy') }}" class="link-light text-decoration-underline ms-1"
                        target="_blank" rel="noopener noreferrer">{{ __('frontend.cookie_banner_privacy_link') }}</a>
                </div>
                <div class="sur-cookie-bar__actions d-flex flex-column flex-sm-row gap-2">
                    <button type="button" class="btn btn-sm btn-outline-light"
                        data-sur-action="bar-reject">{{ __('frontend.cookie_banner_reject_optional') }}</button>
                    <button type="button" class="btn btn-sm btn-sur-cookie-outline"
                        data-sur-action="bar-customize">{{ __('frontend.cookie_banner_customize') }}</button>
                    <button type="button" class="btn btn-sm btn-sur-cookie-primary"
                        data-sur-action="bar-accept-all">{{ __('frontend.cookie_banner_accept_all') }}</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        (function () {
            try {
                var raw = localStorage.getItem('sur_cookie_consent_v1');
                if (!raw) {
                    return;
                }
                var d = JSON.parse(raw);
                if (typeof d.analytics === 'boolean') {
                    var bar = document.getElementById('sur-cookie-consent-bar');
                    if (bar) {
                        bar.classList.add('d-none');
                    }
                }
            } catch (e) {}
        })();
    </script>

    <div class="modal fade sur-cookie-modal text-white" id="surCookieConsentModal" tabindex="-1" role="dialog"
        aria-labelledby="surCookieConsentTitle" aria-modal="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header border-secondary">
                    <div>
                        <h2 class="modal-title h5 mb-0" id="surCookieConsentTitle">{{ __('frontend.cookie_banner_modal_title') }}</h2>
                        <p class="small text-secondary mb-0 mt-1">{{ __('frontend.cookie_banner_modal_subtitle') }}</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="{{ __('frontend.cookie_banner_close') }}"></button>
                </div>
                <div class="modal-body">
                    <p class="small text-secondary mb-4">{{ __('frontend.cookie_banner_settings_intro') }}</p>

                    <div class="sur-cookie-category">
                        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                            <div>
                                <span class="fw-semibold">{{ __('frontend.cookie_banner_essential_label') }}</span>
                                <span class="badge bg-secondary ms-2">{{ __('frontend.cookie_banner_always_active') }}</span>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" checked disabled id="surEssentialSwitch"
                                    aria-disabled="true">
                            </div>
                        </div>
                        <p class="small text-secondary mt-2 mb-0">{{ __('frontend.cookie_banner_essential_help') }}</p>
                    </div>

                    <div class="sur-cookie-category">
                        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                            <div>
                                <label class="fw-semibold mb-0" for="surAnalyticsCheckbox">{{ __('frontend.cookie_banner_analytics_label') }}</label>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" id="surAnalyticsCheckbox"
                                    data-sur-analytics-checkbox>
                            </div>
                        </div>
                        <p class="small text-secondary mt-2 mb-0">{{ __('frontend.cookie_banner_analytics_help') }}</p>
                    </div>

                    <div class="sur-cookie-category opacity-75">
                        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                            <div>
                                <span class="fw-semibold">{{ __('frontend.cookie_banner_marketing_label') }}</span>
                                <span class="badge bg-secondary ms-2">{{ __('frontend.cookie_banner_not_used') }}</span>
                            </div>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input" type="checkbox" disabled id="surMarketingSwitch"
                                    aria-disabled="true">
                            </div>
                        </div>
                        <p class="small text-secondary mt-2 mb-0">{{ __('frontend.cookie_banner_marketing_disabled') }}</p>
                    </div>
                </div>
                <div class="modal-footer border-secondary flex-column flex-sm-row align-items-stretch gap-2">
                    <button type="button" class="btn btn-outline-light order-2 order-sm-1"
                        data-sur-action="modal-cancel">{{ __('frontend.cookie_banner_cancel') }}</button>
                    <div class="d-flex flex-column flex-sm-row gap-2 order-1 order-sm-2 ms-sm-auto">
                        <button type="button" class="btn btn-sur-cookie-outline"
                            data-sur-action="modal-reject">{{ __('frontend.cookie_banner_reject_optional') }}</button>
                        <button type="button" class="btn btn-sur-cookie-primary"
                            data-sur-action="save-settings">{{ __('frontend.cookie_banner_save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
