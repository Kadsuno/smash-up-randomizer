<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class MatomoTrackingTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_includes_matomo_snippet_when_enabled(): void
    {
        Config::set('matomo.enabled', true);
        Config::set('matomo.tracker_url', 'https://analytics.kadsuno.com/');
        Config::set('matomo.site_id', '1');

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('sur-matomo-config', false);
        $response->assertSee('analytics.kadsuno.com', false);
        $response->assertSee('surCookieConsentModal', false);
    }

    public function test_home_page_excludes_matomo_when_disabled(): void
    {
        Config::set('matomo.enabled', false);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertDontSee('sur-matomo-config');
        $response->assertDontSee('surCookieConsentModal');
    }
}
