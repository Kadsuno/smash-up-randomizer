@if (config('matomo.enabled'))
    @php
        $surMatomoConfig = [
            'trackerUrl' => rtrim((string) config('matomo.tracker_url'), '/') . '/',
            'siteId' => config('matomo.site_id'),
        ];
    @endphp
    <script type="application/json" id="sur-matomo-config">{!! json_encode($surMatomoConfig) !!}</script>
@endif

<div class="modal fade text-dark" id="surCookieConsentModal" tabindex="-1" role="dialog"
    aria-labelledby="surCookieConsentTitle" aria-modal="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content bg-light">
            <div class="modal-header border-secondary">
                <h2 class="modal-title h5" id="surCookieConsentTitle">{{ __('frontend.cookie_banner_title') }}</h2>
            </div>
            <div class="modal-body">
                <div data-sur-panel="welcome">
                    <p class="mb-3">{{ __('frontend.cookie_banner_intro') }}</p>
                    <p class="small mb-3">
                        <a href="{{ route('privacy-policy') }}" class="link-info" target="_blank" rel="noopener noreferrer">
                            {{ __('frontend.cookie_banner_privacy_link') }}
                        </a>
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-sur-action="essential">
                            {{ __('frontend.cookie_banner_essential_only') }}
                        </button>
                        <button type="button" class="btn btn-info text-dark" data-sur-action="accept-analytics">
                            {{ __('frontend.cookie_banner_accept_analytics') }}
                        </button>
                    </div>
                </div>
                <div data-sur-panel="settings" class="d-none">
                    <p class="mb-3">{{ __('frontend.cookie_banner_settings_intro') }}</p>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="surAnalyticsCheckbox"
                            data-sur-analytics-checkbox>
                        <label class="form-check-label" for="surAnalyticsCheckbox">
                            {{ __('frontend.cookie_banner_analytics_label') }}
                        </label>
                        <p class="small text-muted mt-1 mb-0">{{ __('frontend.cookie_banner_analytics_help') }}</p>
                    </div>
                    <button type="button" class="btn btn-primary" data-sur-action="save-settings">
                        {{ __('frontend.cookie_banner_save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
