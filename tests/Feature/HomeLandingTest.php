<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeLandingTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_marketing_landing_copy(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(__('frontend.landing_hero_title'), false);
        $response->assertSee(__('frontend.landing_slide_1_title'), false);
        $response->assertSee('slide-01-board-game-night.jpg', false);
    }
}
