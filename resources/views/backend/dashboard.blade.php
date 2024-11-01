<x-layouts.backend.backendMain>
    <div class="container text-white animate__animated animate__fadeIn">
        <div class="row mb-5">
            <div class="col-12">
                <h1 class="display-4 fw-bold text-center">
                    {{ __('backend.dashboard_header') }}
                </h1>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-md-8">
                <p class="lead">
                    {{ __('backend.dashboard_body') }}
                </p>
                <p>
                    {{ __('backend.dashboard_welcome') }}
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('backend.dashboard_quick_stats') }}</h5>
                        <p class="card-text">{{ __('backend.dashboard_stats_description') }}</p>
                        <a href="#" class="btn btn-outline-light">{{ __('backend.view_stats') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('backend.dashboard_recent_activity') }}</h5>
                        <p class="card-text">{{ __('backend.dashboard_activity_description') }}</p>
                        <a href="#" class="btn btn-outline-light">{{ __('backend.view_activity') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card bg-dark text-white">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('backend.dashboard_quick_actions') }}</h5>
                        <p class="card-text">{{ __('backend.dashboard_actions_description') }}</p>
                        <a href="#" class="btn btn-outline-light">{{ __('backend.perform_action') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.backend.backendMain>