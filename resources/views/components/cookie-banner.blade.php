@if (config('matomo.enabled'))
    @php
        $surMatomoConfig = [
            'trackerUrl' => rtrim((string) config('matomo.tracker_url'), '/') . '/',
            'siteId' => config('matomo.site_id'),
        ];
    @endphp
    <script type="application/json" id="sur-matomo-config">{!! json_encode($surMatomoConfig) !!}</script>

    {{-- Bottom strip; hidden via inline script if consent already stored --}}
    <div id="sur-cookie-consent-bar"
        class="sur-cookie-bar fixed bottom-0 left-0 right-0 z-[1040] bg-zinc-950/95 px-3 py-3 text-white"
        role="region"
        aria-label="{{ __('frontend.cookie_banner_title') }}">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 lg:flex-row lg:items-center">
            <div class="min-w-0 flex-1 text-sm">
                <strong class="mb-1 block text-[0.7rem] font-semibold uppercase tracking-wider text-zinc-400"
                    style="letter-spacing: 0.06em;">{{ __('frontend.cookie_banner_title') }}</strong>
                <span>{{ __('frontend.cookie_banner_bar_lead') }}</span>
                <a href="{{ route('privacy-policy') }}" class="ms-1 text-cyan-400 underline decoration-cyan-500/50 underline-offset-2 transition hover:text-cyan-300"
                    target="_blank" rel="noopener noreferrer">{{ __('frontend.cookie_banner_privacy_link') }}</a>
            </div>
            <div class="flex flex-shrink-0 flex-col gap-2 sm:flex-row sm:flex-wrap">
                <button type="button" class="btn-sur-cookie-outline min-h-11 px-4"
                    data-sur-action="bar-reject">{{ __('frontend.cookie_banner_reject_optional') }}</button>
                <button type="button" class="btn-sur-cookie-outline min-h-11 px-4"
                    data-sur-action="bar-customize">{{ __('frontend.cookie_banner_customize') }}</button>
                <button type="button" class="btn-sur-cookie-primary min-h-11 px-4"
                    data-sur-action="bar-accept-all">{{ __('frontend.cookie_banner_accept_all') }}</button>
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
                        bar.classList.add('hidden');
                    }
                }
            } catch (e) {}
        })();
    </script>

    <dialog id="surCookieConsentModal" class="sur-cookie-dialog text-white" aria-labelledby="surCookieConsentTitle" aria-modal="true">
        <div class="flex max-h-[min(90vh,48rem)] flex-col">
            <div class="flex items-start justify-between gap-4 border-b border-white/10 px-5 py-4">
                <div class="min-w-0">
                    <h2 class="text-lg font-semibold leading-tight" id="surCookieConsentTitle">{{ __('frontend.cookie_banner_modal_title') }}</h2>
                    <p class="mt-1 text-sm text-zinc-400">{{ __('frontend.cookie_banner_modal_subtitle') }}</p>
                </div>
                <button type="button" class="flex h-11 min-w-11 shrink-0 items-center justify-center rounded-lg text-zinc-400 transition hover:bg-white/10 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-cyan-400/60"
                    data-sur-action="modal-close" aria-label="{{ __('frontend.cookie_banner_close') }}">
                    <span class="text-xl leading-none" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="min-h-0 flex-1 overflow-y-auto px-5 py-4">
                <p class="mb-4 text-sm text-zinc-400">{{ __('frontend.cookie_banner_settings_intro') }}</p>

                <div class="sur-cookie-category">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <span class="font-semibold">{{ __('frontend.cookie_banner_essential_label') }}</span>
                            <span class="ms-2 inline-flex rounded-md bg-zinc-700 px-2 py-0.5 text-xs text-zinc-300">{{ __('frontend.cookie_banner_always_active') }}</span>
                        </div>
                        <input type="checkbox" class="h-5 w-9 shrink-0 cursor-not-allowed rounded-full accent-cyan-500 opacity-70" checked disabled id="surEssentialSwitch" aria-disabled="true">
                    </div>
                    <p class="mt-2 text-sm text-zinc-400">{{ __('frontend.cookie_banner_essential_help') }}</p>
                </div>

                <div class="sur-cookie-category">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <label class="font-semibold" for="surAnalyticsCheckbox">{{ __('frontend.cookie_banner_analytics_label') }}</label>
                        <input class="h-5 w-9 cursor-pointer rounded-full accent-cyan-500" type="checkbox" id="surAnalyticsCheckbox"
                            data-sur-analytics-checkbox>
                    </div>
                    <p class="mt-2 text-sm text-zinc-400">{{ __('frontend.cookie_banner_analytics_help') }}</p>
                </div>

                <div class="sur-cookie-category opacity-75">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <span class="font-semibold">{{ __('frontend.cookie_banner_marketing_label') }}</span>
                            <span class="ms-2 inline-flex rounded-md bg-zinc-700 px-2 py-0.5 text-xs text-zinc-300">{{ __('frontend.cookie_banner_not_used') }}</span>
                        </div>
                        <input type="checkbox" class="h-5 w-9 shrink-0 cursor-not-allowed rounded-full accent-cyan-500 opacity-70" disabled id="surMarketingSwitch"
                            aria-disabled="true">
                    </div>
                    <p class="mt-2 text-sm text-zinc-400">{{ __('frontend.cookie_banner_marketing_disabled') }}</p>
                </div>
            </div>
            <div class="flex flex-col gap-2 border-t border-white/10 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <button type="button" class="sur-btn-ghost order-2 w-full sm:order-1 sm:w-auto"
                    data-sur-action="modal-cancel">{{ __('frontend.cookie_banner_cancel') }}</button>
                <div class="order-1 flex w-full flex-col gap-2 sm:order-2 sm:ml-auto sm:w-auto sm:flex-row">
                    <button type="button" class="btn-sur-cookie-outline min-h-11 w-full sm:w-auto"
                        data-sur-action="modal-reject">{{ __('frontend.cookie_banner_reject_optional') }}</button>
                    <button type="button" class="btn-sur-cookie-primary min-h-11 w-full sm:w-auto"
                        data-sur-action="save-settings">{{ __('frontend.cookie_banner_save') }}</button>
                </div>
            </div>
        </div>
    </dialog>

    <button type="button" id="sur-cookie-fab" class="sur-cookie-fab" data-sur-open-cookie-settings
        aria-label="{{ __('frontend.cookie_footer_cookie_settings') }}">
        <i class="fas fa-cookie-bite fa-lg" aria-hidden="true"></i>
    </button>
@endif
