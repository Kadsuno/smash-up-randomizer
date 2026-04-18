<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    */

    'name' => env('APP_NAME', 'Smash Up Randomizer'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    */

    'url' => env('APP_URL', 'https://smash-up-randomizer.ddev.site/'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Available locales
    |--------------------------------------------------------------------------
    */

    'available_locales' => [
        'English' => 'en',
    ],

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Social share image cache buster (Open Graph / Twitter)
    |--------------------------------------------------------------------------
    |
    | Query string appended to images/og-share.png. Bump OG_SHARE_VERSION in .env
    | (or this default) after replacing the PNG so crawlers refetch (e.g. Discord).
    |
    */

    'og_share_version' => env('OG_SHARE_VERSION', '2'),

];
