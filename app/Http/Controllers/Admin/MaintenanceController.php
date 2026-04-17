<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class MaintenanceController extends Controller
{
    /**
     * Read-only reference of common Artisan tasks (run via CLI / DDEV).
     */
    public function __invoke(): View
    {
        $commands = [
            [
                'command' => 'php artisan factions:import',
                'description' => __('backend.cli_factions_import'),
            ],
            [
                'command' => 'php artisan factions:enrich',
                'description' => __('backend.cli_factions_enrich'),
            ],
            [
                'command' => 'php artisan factions:rewrite',
                'description' => __('backend.cli_factions_rewrite'),
            ],
            [
                'command' => 'php artisan factions:icons',
                'description' => __('backend.cli_factions_icons'),
            ],
            [
                'command' => 'php artisan factions:images',
                'description' => __('backend.cli_factions_images'),
            ],
            [
                'command' => 'php artisan users:promote user@example.com',
                'description' => __('backend.cli_users_promote'),
            ],
            [
                'command' => 'php artisan generate:sitemap',
                'description' => __('backend.cli_generate_sitemap'),
            ],
            [
                'command' => 'php artisan email:test',
                'description' => __('backend.cli_email_test'),
            ],
        ];

        return view('backend.maintenance', [
            'commands' => $commands,
        ]);
    }
}
