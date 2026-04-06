<?php

namespace App\Providers;

use App\Mail\Transport\BrevoApiTransport;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('pagination::tailwind');
        Paginator::defaultSimpleView('pagination::simple-tailwind');

        Schema::defaultStringLength(191);

        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });

        view()->composer('components.layouts.header', function ($view) {
            $view->with('current_locale', app()->getLocale());
            $view->with('available_locales', config('app.available_locales'));
        });

        $this->configureMailTransports();
    }

    /**
     * Register custom mail transports (Brevo HTTP API — same approach as Issue Forge).
     */
    protected function configureMailTransports(): void
    {
        Mail::extend('brevo', function (array $config) {
            $apiKey = $config['api_key'] ?? config('services.brevo.api_key');

            if (empty($apiKey)) {
                throw new \RuntimeException(
                    'Brevo API key is not configured. Please set BREVO_API_KEY in your .env file.'
                );
            }

            return new BrevoApiTransport(apiKey: $apiKey);
        });
    }
}
