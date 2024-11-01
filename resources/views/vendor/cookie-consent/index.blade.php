@php
    $locale = $app->getLocale();
@endphp

<div role="dialog" aria-labelledby="lcc-modal-alert-label" aria-describedby="lcc-modal-alert-desc" aria-modal="true"
    class="lcc-modal lcc-modal--alert js-lcc-modal js-lcc-modal-alert bg-dark text-white shadow-lg rounded-lg" style="display: none;"
    data-cookie-key="{{ config('cookie-consent.cookie_key') }}"
    data-cookie-value-analytics="{{ config('cookie-consent.cookie_value_analytics') }}"
    data-cookie-value-marketing="{{ config('cookie-consent.cookie_value_marketing') }}"
    data-cookie-value-both="{{ config('cookie-consent.cookie_value_both') }}"
    data-cookie-value-none="{{ config('cookie-consent.cookie_value_none') }}"
    data-cookie-expiration-days="{{ config('cookie-consent.cookie_expiration_days') }}"
    data-gtm-event="{{ config('cookie-consent.gtm_event') }}"
    data-ignored-paths="{{ implode(',', config('cookie-consent.ignored_paths', [])) }}">
    <div class="lcc-modal__content p-6">
        <h2 id="lcc-modal-alert-label" class="lcc-modal__title text-2xl font-bold mb-4">
            @lang('cookie-consent::texts.alert_title')
        </h2>
        <p id="lcc-modal-alert-desc" class="lcc-text mb-6">
            {!! trans('cookie-consent::texts.alert_text') !!}
        </p>
    </div>
    <div class="lcc-modal__actions bg-secondary p-4">
        <div class="flex flex-col space-y-3">
            <button type="button" class="js-lcc-accept btn btn-primary w-full">
                @lang('cookie-consent::texts.alert_accept')
            </button>
            <button type="button" class="js-lcc-essentials btn btn-outline-light w-full">
                @lang('cookie-consent::texts.alert_essential_only')
            </button>
            <button type="button" class="js-lcc-settings-toggle btn btn-link text-white w-full">
                @lang('cookie-consent::texts.alert_settings')
            </button>
        </div>
    </div>
</div>

<div role="dialog" aria-labelledby="lcc-modal-settings-label" aria-describedby="lcc-modal-settings-desc"
    aria-modal="true" class="lcc-modal lcc-modal--settings js-lcc-modal js-lcc-modal-settings bg-dark text-white shadow-lg rounded-lg" style="display: none;">
    <button class="lcc-modal__close js-lcc-settings-toggle absolute top-4 right-4 text-white hover:text-gray-300" type="button">
        <span class="lcc-u-sr-only">
            @lang('cookie-consent::texts.settings_close')
        </span>
        &times;
    </button>
    <div class="lcc-modal__content p-6">
        <h2 id="lcc-modal-settings-label" class="lcc-modal__title text-2xl font-bold mb-4">
            @lang('cookie-consent::texts.settings_title')
        </h2>
        <p id="lcc-modal-settings-desc" class="lcc-text mb-6">
            {!! trans('cookie-consent::texts.settings_text', ['policyUrl' => config("cookie-consent.policy_url_$locale")]) !!}
        </p>
        <div class="lcc-modal__section text-center mb-6">
            <button type="button" class="js-lcc-accept btn btn-primary">
                @lang('cookie-consent::texts.settings_accept_all')
            </button>
        </div>
        <div class="space-y-4">
            @foreach(['essential', 'functional', 'analytics', 'marketing'] as $cookieType)
                <div class="lcc-modal__section">
                    <label for="lcc-checkbox-{{ $cookieType }}" class="lcc-label flex items-center">
                        <input type="checkbox" id="lcc-checkbox-{{ $cookieType }}" 
                               class="form-checkbox h-5 w-5 text-primary"
                               {{ in_array($cookieType, ['essential', 'functional']) ? 'disabled checked' : '' }}>
                        <span class="ml-2">@lang("cookie-consent::texts.setting_$cookieType")</span>
                    </label>
                    <p class="lcc-text mt-1">
                        @lang("cookie-consent::texts.setting_{$cookieType}_text")
                    </p>
                </div>
            @endforeach
        </div>
    </div>
    <div class="lcc-modal__actions p-4 text-center">
        <button type="button" class="js-lcc-settings-save btn btn-primary mx-auto">
            @lang('cookie-consent::texts.settings_save')
        </button>
    </div>
</div>

<div class="lcc-backdrop js-lcc-backdrop fixed inset-0 bg-black bg-opacity-50" style="display: none;"></div>
<script type="text/javascript" src="{{ asset('vendor/cookie-consent/js/cookie-consent.js') }}"></script>
