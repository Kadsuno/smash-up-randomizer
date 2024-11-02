@vite(['resources/js/app.js', 'resources/js/bootstrap.js', 'resources/js/form.js', 'resources/js/hero.js', 'resources/js/nav.js'])

<footer class="footer container-fluid bg-black text-light py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3 mb-md-0">
                <h5 class="text-uppercase mb-3">Smash Up Randomizer</h5>
                <p class="small">Shuffle and assign factions for your next Smash Up game with ease.</p>
            </div>
            <div class="col-md-4 mb-3 mb-md-0">
                <h5 class="text-uppercase mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a class="text-light text-decoration-none hover-effect" href="{{ route('imprint') }}">{{ __('frontend.imprint_header') }}</a></li>
                    <li><a class="text-light text-decoration-none hover-effect" href="{{ route('privacy-policy') }}">{{ __('frontend.privacyPolicy_header') }}</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5 class="text-uppercase mb-3">Connect With Us</h5>
                <div class="d-flex justify-content-start">
                    <a href="https://www.facebook.com/SmashUpRandomizer/" class="text-light me-3 hover-effect"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/SmashUpRando" class="text-light me-3 hover-effect"><i class="fab fa-x-twitter"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>


<style>
    .hover-effect {
        transition: all 0.3s ease;
    }
    .hover-effect:hover {
        color: #17a2b8 !important;
        transform: translateY(-2px);
    }
</style>
