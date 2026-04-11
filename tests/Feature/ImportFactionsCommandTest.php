<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Deck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ImportFactionsCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_exits_successfully(): void
    {
        $this->artisan('factions:import')
            ->assertExitCode(0);
    }

    public function test_command_imports_all_106_factions(): void
    {
        $this->artisan('factions:import')->assertExitCode(0);

        $this->assertSame(106, Deck::count());
    }

    public function test_command_is_idempotent(): void
    {
        $this->artisan('factions:import')->assertExitCode(0);
        $this->artisan('factions:import')->assertExitCode(0);

        $this->assertSame(106, Deck::count());
    }

    public function test_core_set_factions_have_correct_expansion(): void
    {
        $this->artisan('factions:import')->assertExitCode(0);

        $coreSetFactions = Deck::where('expansion', 'Core Set')->get();

        $this->assertSame(8, $coreSetFactions->count());

        $expectedNames = ['Aliens', 'Dinosaurs', 'Ninjas', 'Pirates', 'Robots', 'Tricksters', 'Wizards', 'Zombies'];
        sort($expectedNames);
        $actualNames = $coreSetFactions->pluck('name')->sort()->values()->all();

        $this->assertSame($expectedNames, $actualNames);
    }

    public function test_faction_fields_are_populated(): void
    {
        $this->artisan('factions:import')->assertExitCode(0);

        $aliens = Deck::where('name', 'Aliens')->firstOrFail();

        $this->assertSame('Core Set', $aliens->expansion);
        $this->assertNotEmpty($aliens->teaser);
        $this->assertNotEmpty($aliens->mechanics);
        $this->assertNotEmpty($aliens->playstyle);
    }

    public function test_dry_run_does_not_write_to_database(): void
    {
        $this->artisan('factions:import --dry-run')->assertExitCode(0);

        $this->assertSame(0, Deck::count());
    }

    public function test_marvel_set_has_eight_factions(): void
    {
        $this->artisan('factions:import')->assertExitCode(0);

        $this->assertSame(8, Deck::where('expansion', 'Smash Up: Marvel')->count());
    }
}
