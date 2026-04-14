<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExpansionsControllerTest extends TestCase
{
    use RefreshDatabase;

    // ---------------------------------------------------------------------------
    // /expansions index
    // ---------------------------------------------------------------------------

    public function test_expansions_index_returns_ok(): void
    {
        $response = $this->get('/expansions');

        $response->assertOk();
    }

    public function test_expansions_index_shows_expansion_names(): void
    {
        DB::table('decks')->insert([
            ['name' => 'Ninjas',    'expansion' => 'Core Set'],
            ['name' => 'Zombies',   'expansion' => 'Core Set'],
            ['name' => 'Bear Cavalry', 'expansion' => 'Awesome Level 9000'],
        ]);

        $response = $this->get('/expansions');

        $response->assertOk();
        $response->assertSee('Core Set', false);
        $response->assertSee('Awesome Level 9000', false);
    }

    public function test_expansions_index_shows_faction_count_for_each_set(): void
    {
        DB::table('decks')->insert([
            ['name' => 'Ninjas',  'expansion' => 'Core Set'],
            ['name' => 'Zombies', 'expansion' => 'Core Set'],
            ['name' => 'Robots',  'expansion' => 'Core Set'],
        ]);

        $response = $this->get('/expansions');

        $response->assertOk();
        $response->assertSee('3', false);
    }

    public function test_expansions_index_skips_factions_without_expansion(): void
    {
        DB::table('decks')->insert([
            ['name' => 'Unknown Faction', 'expansion' => ''],
            ['name' => 'Ninjas',          'expansion' => 'Core Set'],
        ]);

        $response = $this->get('/expansions');

        $response->assertOk();
        $response->assertSee('Core Set', false);
        $response->assertDontSee('Unknown Faction', false);
    }

    // ---------------------------------------------------------------------------
    // /expansions/{slug}
    // ---------------------------------------------------------------------------

    public function test_expansion_detail_returns_ok_for_valid_slug(): void
    {
        DB::table('decks')->insert([
            ['name' => 'Ninjas',  'expansion' => 'Core Set'],
            ['name' => 'Zombies', 'expansion' => 'Core Set'],
        ]);

        $response = $this->get('/expansions/core-set');

        $response->assertOk();
    }

    public function test_expansion_detail_shows_expansion_name_and_factions(): void
    {
        DB::table('decks')->insert([
            ['name' => 'Ninjas',  'expansion' => 'Core Set'],
            ['name' => 'Zombies', 'expansion' => 'Core Set'],
        ]);

        $response = $this->get('/expansions/core-set');

        $response->assertOk();
        $response->assertSee('Core Set', false);
        $response->assertSee('Ninjas', false);
        $response->assertSee('Zombies', false);
    }

    public function test_expansion_detail_does_not_show_factions_from_other_sets(): void
    {
        DB::table('decks')->insert([
            ['name' => 'Ninjas',       'expansion' => 'Core Set'],
            ['name' => 'Bear Cavalry', 'expansion' => 'Awesome Level 9000'],
        ]);

        $response = $this->get('/expansions/core-set');

        $response->assertOk();
        $response->assertSee('Ninjas', false);
        $response->assertDontSee('Bear Cavalry', false);
    }

    public function test_expansion_detail_returns_404_for_unknown_slug(): void
    {
        $response = $this->get('/expansions/does-not-exist');

        $response->assertNotFound();
    }

    public function test_expansion_detail_slug_maps_correctly_to_expansion_name(): void
    {
        DB::table('decks')->insert([
            ['name' => 'Bear Cavalry', 'expansion' => 'Awesome Level 9000'],
        ]);

        $response = $this->get('/expansions/awesome-level-9000');

        $response->assertOk();
        $response->assertSee('Awesome Level 9000', false);
        $response->assertSee('Bear Cavalry', false);
    }
}
