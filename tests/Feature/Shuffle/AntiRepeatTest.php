<?php

declare(strict_types=1);

namespace Tests\Feature\Shuffle;

use App\Models\Deck;
use App\Models\ShuffleHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AntiRepeatTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Seed N factions with optional expansion label.
     *
     * @param  list<string>  $names
     */
    private function seedFactions(array $names, string $expansion = 'Core'): void
    {
        foreach ($names as $name) {
            Deck::query()->create(['name' => $name, 'expansion' => $expansion]);
        }
    }

    /**
     * Write a shuffle history row for a user (2 players, 2 factions each).
     *
     * @param  list<string>  $factionNames  Exactly 4 names (player1×2, player2×2)
     */
    private function seedHistory(User $user, array $factionNames): void
    {
        ShuffleHistory::query()->create([
            'user_id' => $user->id,
            'player_count' => 2,
            'results' => [
                [['name' => $factionNames[0]], ['name' => $factionNames[1]]],
                [['name' => $factionNames[2]], ['name' => $factionNames[3]]],
            ],
        ]);
    }

    // -----------------------------------------------------------------------
    // Wizard POST (POST /shuffle/result)
    // -----------------------------------------------------------------------

    public function test_wizard_anti_repeat_excludes_recent_factions_from_result(): void
    {
        // 8 factions available; 4 were played recently
        $this->seedFactions(['Old1', 'Old2', 'Old3', 'Old4', 'New1', 'New2', 'New3', 'New4']);

        $user = User::factory()->create();
        $this->seedHistory($user, ['Old1', 'Old2', 'Old3', 'Old4']);

        $response = $this->actingAs($user)->post(route('shuffle-result'), [
            'numberOfPlayers' => '2',
            'avoidRecent' => '1',
        ]);

        $response->assertOk();
        $response->assertViewIs('shuffle.shuffle-decks');

        $drawn = collect($response->viewData('selectedDecks'))
            ->flatten(1)
            ->pluck('name')
            ->all();

        foreach ($drawn as $name) {
            $this->assertStringStartsWith('New', $name, "Recent faction [{$name}] should not appear when anti-repeat is active");
        }
    }

    public function test_wizard_anti_repeat_fallback_when_pool_too_small(): void
    {
        // Only 4 factions; all 4 in recent history → anti-repeat would leave 0
        $this->seedFactions(['A', 'B', 'C', 'D']);

        $user = User::factory()->create();
        $this->seedHistory($user, ['A', 'B', 'C', 'D']);

        $response = $this->actingAs($user)->post(route('shuffle-result'), [
            'numberOfPlayers' => '2',
            'avoidRecent' => '1',
        ]);

        $response->assertOk();
        // Fallback engaged: view receives antiRepeatFallback = true
        $this->assertTrue($response->viewData('antiRepeatFallback'), 'Fallback flag should be set when anti-repeat empties the pool');
        // Shuffle still produces a valid result
        $this->assertCount(2, $response->viewData('selectedDecks'));
    }

    public function test_wizard_anti_repeat_no_op_for_guest_even_with_flag(): void
    {
        // Guests have no history — avoidRecent flag should be silently ignored
        $this->seedFactions(['A', 'B', 'C', 'D']);

        $response = $this->post(route('shuffle-result'), [
            'numberOfPlayers' => '2',
            'avoidRecent' => '1',
        ]);

        $response->assertOk();
        $this->assertFalse($response->viewData('antiRepeatFallback'));
    }

    public function test_wizard_anti_repeat_no_op_with_empty_history(): void
    {
        $this->seedFactions(['A', 'B', 'C', 'D']);

        $user = User::factory()->create();
        // No history rows created

        $response = $this->actingAs($user)->post(route('shuffle-result'), [
            'numberOfPlayers' => '2',
            'avoidRecent' => '1',
        ]);

        $response->assertOk();
        $this->assertFalse($response->viewData('antiRepeatFallback'));
        $this->assertCount(2, $response->viewData('selectedDecks'));
    }

    public function test_wizard_without_flag_does_not_restrict_recent_factions(): void
    {
        // With flag off, even recently-played factions can be drawn
        $this->seedFactions(['A', 'B', 'C', 'D']);

        $user = User::factory()->create();
        $this->seedHistory($user, ['A', 'B', 'C', 'D']);

        $response = $this->actingAs($user)->post(route('shuffle-result'), [
            'numberOfPlayers' => '2',
            // avoidRecent not sent
        ]);

        $response->assertOk();
        $this->assertFalse($response->viewData('antiRepeatFallback'));
        $this->assertCount(2, $response->viewData('selectedDecks'));
    }

    // -----------------------------------------------------------------------
    // Quick shuffle (GET /random)
    // -----------------------------------------------------------------------

    public function test_quick_shuffle_auto_applies_anti_repeat_for_logged_in_user(): void
    {
        // 8 factions; 4 recent
        $this->seedFactions(['Old1', 'Old2', 'Old3', 'Old4', 'New1', 'New2', 'New3', 'New4']);

        $user = User::factory()->create();
        $this->seedHistory($user, ['Old1', 'Old2', 'Old3', 'Old4']);

        $response = $this->actingAs($user)->get(route('random'));

        $response->assertOk();

        $drawn = collect($response->viewData('selectedDecks'))
            ->flatten(1)
            ->pluck('name')
            ->all();

        foreach ($drawn as $name) {
            $this->assertStringStartsWith('New', $name, "Recent faction [{$name}] should not appear in quick shuffle");
        }
    }

    public function test_quick_shuffle_falls_back_to_full_pool_when_anti_repeat_leaves_too_few(): void
    {
        // Only 4 factions, all played recently
        $this->seedFactions(['A', 'B', 'C', 'D']);

        $user = User::factory()->create();
        $this->seedHistory($user, ['A', 'B', 'C', 'D']);

        $response = $this->actingAs($user)->get(route('random'));

        $response->assertOk();
        $this->assertTrue($response->viewData('antiRepeatFallback'));
        $this->assertCount(2, $response->viewData('selectedDecks'));
    }

    public function test_quick_shuffle_guest_has_no_anti_repeat(): void
    {
        $this->seedFactions(['A', 'B', 'C', 'D']);

        $response = $this->get(route('random'));

        $response->assertOk();
        $this->assertFalse($response->viewData('antiRepeatFallback'));
    }
}
