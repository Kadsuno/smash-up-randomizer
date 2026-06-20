<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Deck;
use App\Models\ShuffleHistory;
use App\Models\User;
use App\Services\ShuffleDeckPool;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShuffleDeckPoolTest extends TestCase
{
    use RefreshDatabase;

    private ShuffleDeckPool $pool;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pool = new ShuffleDeckPool();
    }

    // -----------------------------------------------------------------------
    // recentFactionNames
    // -----------------------------------------------------------------------

    public function test_recent_faction_names_returns_empty_for_guest(): void
    {
        $this->assertSame([], $this->pool->recentFactionNames(null, 5));
    }

    public function test_recent_faction_names_returns_empty_for_user_with_no_history(): void
    {
        $user = User::factory()->create();

        $this->assertSame([], $this->pool->recentFactionNames($user, 5));
    }

    public function test_recent_faction_names_flattens_all_players_from_one_row(): void
    {
        $user = User::factory()->create();

        ShuffleHistory::query()->create([
            'user_id' => $user->id,
            'player_count' => 2,
            'results' => [
                [['name' => 'Ninjas'], ['name' => 'Zombies']],
                [['name' => 'Aliens'], ['name' => 'Pirates']],
            ],
        ]);

        $names = $this->pool->recentFactionNames($user, 5);

        $this->assertEqualsCanonicalizing(['Ninjas', 'Zombies', 'Aliens', 'Pirates'], $names);
    }

    public function test_recent_faction_names_deduplicates_across_rows(): void
    {
        $user = User::factory()->create();

        // Two history rows that share faction names
        foreach ([['A', 'B', 'C', 'D'], ['C', 'D', 'E', 'F']] as $factions) {
            ShuffleHistory::query()->create([
                'user_id' => $user->id,
                'player_count' => 2,
                'results' => [
                    [['name' => $factions[0]], ['name' => $factions[1]]],
                    [['name' => $factions[2]], ['name' => $factions[3]]],
                ],
            ]);
        }

        $names = $this->pool->recentFactionNames($user, 5);

        // C and D appear in both rows — should only be in result once
        $this->assertEqualsCanonicalizing(['A', 'B', 'C', 'D', 'E', 'F'], $names);
        $this->assertCount(6, $names);
    }

    public function test_recent_faction_names_respects_window_limit(): void
    {
        $user = User::factory()->create();

        // 5 history rows — window = 2 should only return names from the 2 newest
        for ($i = 1; $i <= 5; $i++) {
            ShuffleHistory::query()->create([
                'user_id' => $user->id,
                'player_count' => 2,
                'results' => [
                    [['name' => "Old{$i}a"], ['name' => "Old{$i}b"]],
                    [['name' => "Old{$i}c"], ['name' => "Old{$i}d"]],
                ],
            ]);
        }

        $names = $this->pool->recentFactionNames($user, 2);

        // Only 2 rows = 8 faction slots (may be fewer after dedup)
        $this->assertLessThanOrEqual(8, count($names));
        // Names from the oldest rows (window 3–5) must NOT appear
        $this->assertNotContains('Old1a', $names);
        $this->assertNotContains('Old2a', $names);
        $this->assertNotContains('Old3a', $names);
    }

    // -----------------------------------------------------------------------
    // eligibleDecks — avoidRecent with include/exclude combinations
    // -----------------------------------------------------------------------

    public function test_eligible_decks_avoids_recent_while_respecting_include_list(): void
    {
        foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $name) {
            Deck::query()->create(['name' => $name, 'expansion' => 'Core']);
        }

        $user = User::factory()->create();

        // Mark A+B+C+D as recent
        ShuffleHistory::query()->create([
            'user_id' => $user->id,
            'player_count' => 2,
            'results' => [
                [['name' => 'A'], ['name' => 'B']],
                [['name' => 'C'], ['name' => 'D']],
            ],
        ]);

        // Include A, B, E, F — anti-repeat should strip A and B → only E, F eligible
        $decks = $this->pool->eligibleDecks($user, ['A', 'B', 'E', 'F'], [], avoidRecent: true);

        $this->assertEqualsCanonicalizing(['E', 'F'], $decks->pluck('name')->all());
    }

    public function test_eligible_decks_avoids_recent_while_respecting_exclude_list(): void
    {
        foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $name) {
            Deck::query()->create(['name' => $name, 'expansion' => 'Core']);
        }

        $user = User::factory()->create();

        ShuffleHistory::query()->create([
            'user_id' => $user->id,
            'player_count' => 2,
            'results' => [
                [['name' => 'A'], ['name' => 'B']],
                [['name' => 'C'], ['name' => 'D']],
            ],
        ]);

        // Exclude E — anti-repeat removes A,B,C,D → only F should remain
        $decks = $this->pool->eligibleDecks($user, [], ['E'], avoidRecent: true);

        $this->assertEqualsCanonicalizing(['F'], $decks->pluck('name')->all());
    }
}
