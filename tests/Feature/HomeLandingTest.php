<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
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
        $response->assertSee('slide-01-faction-pirates.png', false);
        $response->assertSee(__('frontend.shuffle_modal_subtitle'), false);
    }

    public function test_home_page_renders_stats_bar(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(__('frontend.landing_stats_free'), false);
        $response->assertSee(__('frontend.landing_stats_no_account'), false);
        $response->assertSee(__('frontend.landing_stats_expansions'), false);
    }

    public function test_home_page_renders_how_it_works(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(__('frontend.landing_howto_title'), false);
        $response->assertSee(__('frontend.landing_howto_step1_title'), false);
        $response->assertSee(__('frontend.landing_howto_step2_title'), false);
        $response->assertSee(__('frontend.landing_howto_step3_title'), false);
    }

    public function test_home_page_renders_combo_examples(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(__('frontend.landing_combos_title'), false);
        $response->assertSee(__('frontend.landing_combo_1_name'), false);
        $response->assertSee(__('frontend.landing_combo_2_name'), false);
        $response->assertSee(__('frontend.landing_combo_3_name'), false);
    }

    public function test_home_page_renders_faction_teaser_strip(): void
    {
        DB::table('decks')->insert([['name' => 'Ninjas'], ['name' => 'Zombies'], ['name' => 'Aliens']]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(__('frontend.landing_factions_title'), false);
        $response->assertSee('Ninjas', false);
        $response->assertSee('Zombies', false);
        $response->assertSee('Aliens', false);
    }

    public function test_home_page_stats_bar_shows_dynamic_faction_count(): void
    {
        DB::table('decks')->insert([['name' => 'Pirates'], ['name' => 'Robots']]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('2', false);
        $response->assertSee(__('frontend.landing_stats_factions'), false);
    }
}
