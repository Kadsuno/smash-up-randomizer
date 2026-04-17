<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class QuickShuffleTest extends TestCase
{
    use RefreshDatabase;

    public function test_random_page_returns_ok_with_enough_factions(): void
    {
        DB::table('decks')->insert([
            ['name' => 'Ninjas'],
            ['name' => 'Zombies'],
            ['name' => 'Aliens'],
            ['name' => 'Pirates'],
        ]);

        $response = $this->get('/random');

        $response->assertOk();
    }

    public function test_random_page_renders_two_players_result(): void
    {
        DB::table('decks')->insert([
            ['name' => 'Ninjas'],
            ['name' => 'Zombies'],
            ['name' => 'Aliens'],
            ['name' => 'Pirates'],
        ]);

        $response = $this->get('/random');

        $response->assertOk();
        $response->assertViewIs('shuffle.shuffle-decks');

        $selectedDecks = $response->viewData('selectedDecks');
        $this->assertCount(2, $selectedDecks, 'Quick shuffle should produce results for 2 players');
        $this->assertCount(2, $selectedDecks[0], 'Each player should have 2 factions');
        $this->assertCount(2, $selectedDecks[1], 'Each player should have 2 factions');
    }

    public function test_random_page_assigns_unique_factions_across_players(): void
    {
        DB::table('decks')->insert([
            ['name' => 'Ninjas'],
            ['name' => 'Zombies'],
            ['name' => 'Aliens'],
            ['name' => 'Pirates'],
        ]);

        $response = $this->get('/random');

        $selectedDecks = $response->viewData('selectedDecks');
        $allNames = array_merge(
            array_column($selectedDecks[0], 'name'),
            array_column($selectedDecks[1], 'name'),
        );

        $this->assertCount(4, array_unique($allNames), 'All 4 assigned factions should be unique');
    }

    public function test_random_page_with_sur_screenshot_omits_cookie_banner_when_matomo_enabled(): void
    {
        Config::set('matomo.enabled', true);

        DB::table('decks')->insert([
            ['name' => 'Ninjas'],
            ['name' => 'Zombies'],
            ['name' => 'Aliens'],
            ['name' => 'Pirates'],
        ]);

        $withBar = $this->get('/random');
        $withBar->assertOk();
        $withBar->assertSee('id="sur-cookie-consent-bar"', false);

        $preview = $this->get('/random?sur_screenshot=1');
        $preview->assertOk();
        $preview->assertDontSee('id="sur-cookie-consent-bar"', false);
        $preview->assertDontSee('id="sur-cookie-fab"', false);
    }
}
