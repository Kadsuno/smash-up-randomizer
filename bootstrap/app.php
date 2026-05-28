<?php

use App\Http\Middleware\Authenticate;
use App\Http\Middleware\EnsurePendingTwoFactorLogin;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\Localization;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Sentry\Laravel\Integration;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(
            at: '*',
            headers: Request::HEADER_X_FORWARDED_FOR
                | Request::HEADER_X_FORWARDED_HOST
                | Request::HEADER_X_FORWARDED_PORT
                | Request::HEADER_X_FORWARDED_PROTO
                | Request::HEADER_X_FORWARDED_AWS_ELB
        );
        $middleware->web(append: [
            Localization::class,
        ]);
        $middleware->alias([
            'auth' => Authenticate::class,
            'guest' => RedirectIfAuthenticated::class,
            'admin' => EnsureUserIsAdmin::class,
            'two-factor.pending' => EnsurePendingTwoFactorLogin::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule): void {
        $schedule->command('email:test')
            ->daily()
            ->at('09:00')
            ->emailOutputOnFailure(config('mail.admin_email', 'info@smash-up-randomizer.com'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        Integration::handles($exceptions);
    })->create();
