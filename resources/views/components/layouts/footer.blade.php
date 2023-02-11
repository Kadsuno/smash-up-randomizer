<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<footer class="footer px-5 container">
    <div class="container-fluid">
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
                </ul>
            </div>
        </div>
    </div>
</footer>