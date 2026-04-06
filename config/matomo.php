<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Matomo web analytics
    |--------------------------------------------------------------------------
    |
    | Self-hosted Matomo (first-party). Set MATOMO_ENABLED=false in local .env
    | to avoid loading the tracker during development.
    |
    */

    'enabled' => filter_var(
        env('MATOMO_ENABLED', 'true'),
        FILTER_VALIDATE_BOOLEAN
    ),

    'site_id' => env('MATOMO_SITE_ID', '1'),

    'tracker_url' => rtrim((string) env(
        'MATOMO_TRACKER_URL',
        'https://analytics.kadsuno.com'
    ), '/') . '/',

];
