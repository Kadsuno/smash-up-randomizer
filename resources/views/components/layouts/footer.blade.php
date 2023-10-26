<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

<footer class="footer px-5 container-fluid">
    <div class="row">
        <div class="col">
            <hr>
        </div>
    </div>
    <div class="row pb-3">
        <div class="col-12 col-md-auto text-center text-md-left">
            <ul class="list-inline">
                <li class="list-inline-item">
                    <a class="text-white nav-link" href="{{ route('imprint') }}">
                        {{ __('frontend.imprint_header') }}
                    </a>
                </li>
                <li class="list-inline-item">
                    |
                </li>
                <li class="list-inline-item">
                    <a class="text-white nav-link" href="{{ route('privacyPolicy') }}">
                        {{ __('frontend.privacyPolicy_header') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row text-center">
        <div class="col">
            <a href="javascript:void(0)" class="js-lcc-settings-toggle">@lang('cookie-consent::texts.alert_settings')</a>
        </div>
    </div>
</footer>