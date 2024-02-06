@vite(['resources/js/app.js', 'resources/js/bootstrap.js', 'resources/js/form.js', 'resources/js/hero.js', 'resources/js/nav.js'])

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
                    <a class="nav-link" href="{{ route('imprint') }}">
                        {{ __('frontend.imprint_header') }}
                    </a>
                </li>
                <li class="list-inline-item">
                    |
                </li>
                <li class="list-inline-item">
                    <a class="nav-link" href="{{ route('privacyPolicy') }}">
                        {{ __('frontend.privacyPolicy_header') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            
        </div>
    </div>
</footer>
<div class="fixed-bottom">
    <a href="javascript:void(0)" class="js-lcc-settings-toggle btn btn-success"><i class="fa-solid fa-cookie fa-2xl"></i></a>
</div>
