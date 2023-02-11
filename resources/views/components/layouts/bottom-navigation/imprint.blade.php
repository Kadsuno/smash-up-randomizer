<x-layouts.main>
    <div class="container-fluid mb-5">
        <div class="row">
            <h1>
                {{ __('frontend.imprint_header') }}
            </h1> 
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
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
            <p>
                <strong>
                    {{ __('frontend.imprint_disclaimer') }}: 
                </strong><br><br>
                <strong>
                    {{ __('frontend.imprint_content_header') }}
                </strong><br><br>
                {{ __('frontend.imprint_content_body') }}<br><br>
                <strong>
                    {{ __('frontend.imprint_copyright_header') }}
                </strong><br><br>
                {{ __('frontend.imprint_copyright_body') }}<br><br>
                <strong>
                    {{ __('frontend.imprint_data_header') }}
                </strong><br><br>
                {{ __('frontend.imprint_data_body_1') }}<br>
                {{ __('frontend.imprint_data_body_2') }}<br>
                {{ __('frontend.imprint_data_body_3') }}<br>
            </p>
        </div>
    </div>
</x-layouts.main>
     