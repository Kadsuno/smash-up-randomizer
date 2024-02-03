<x-layouts.main>
    <div class="container-fluid my-5 pt-5">
        <div class="row">
            <div class="col-md ms-5">
                <h1>
                    {{ __('frontend.imprint_header') }}
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid-margin">
        <div class="row">
            <div class="col-md-12">
                <p>
                    {{ __('frontend.imprint_tmg') }}
                </p>
                <p>
                    Mike Rauch <br>
                    Im Turmswinkel 12<br>
                    38122 Braunschweig <br>
                </p>
                <p>
                    <strong>
                        {{ __('frontend.imprint_represent') }}:
                    </strong><br>
                    Mike Rauch<br>
                </p>
                <p>
                    <strong>
                        {{ __('frontend.imprint_contact') }}:
                    </strong> <br>
                    {{ __('frontend.imprint_phone') }}: 0531-21939351<br>
                    {{ __('frontend.imprint_email') }}:
                    <a class="text-white" href='mailto:mike.rauch@proton.me'>
                        mike.rauch@proton.me
                    </a>
                </p>
                <h2 class="my-5">
                    {{ __('frontend.imprint_disclaimer') }}:
                </h2>
                <h3 class="mb-3">
                    {{ __('frontend.imprint_content_header') }}
                </h3>
                <p class="mb-5">
                    {{ __('frontend.imprint_content_body') }}
                </p>
                <h3 class="mb-3">
                    {{ __('frontend.imprint_copyright_header') }}
                </h3>
                <p class="mb-5">
                    {{ __('frontend.imprint_copyright_body') }}
                </p>
                <h3 class="mb-3">
                    {{ __('frontend.imprint_data_header') }}
                </h3>
                <p>
                    {{ __('frontend.imprint_data_body_1') }}
                </p>
                <p>
                    {{ __('frontend.imprint_data_body_2') }}
                </p>
                <p>
                    {{ __('frontend.imprint_data_body_3') }}
                </p>
            </div>
        </div>
    </div>
</x-layouts.main>