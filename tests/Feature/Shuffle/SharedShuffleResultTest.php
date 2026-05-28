<?php

declare(strict_types=1);

namespace Tests\Feature\Shuffle;

use App\Models\Deck;
use App\Models\SharedShuffleResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SharedShuffleResultTest extends TestCase
{
    use RefreshDatabase;

    private function seedFactionsForTwoPlayers(): void
    {
        foreach (['A1', 'A2', 'A3', 'A4'] as $name) {
            Deck::query()->create(['name' => $name, 'expansion' => 'Core']);
        }
    }

    public function test_shuffle_result_creates_shared_row(): void
    {
        $this->seedFactionsForTwoPlayers();

        $response = $this->post(route('shuffle-result'), [
            'numberOfPlayers' => '2',
            'includeFactions' => [],
            'excludeFactions' => [],
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('shared_shuffle_results', [
            'player_count' => 2,
        ]);
        $this->assertSame(1, SharedShuffleResult::query()->count());
        $publicId = SharedShuffleResult::query()->value('public_id');
        $this->assertNotEmpty($publicId);
    }

    public function test_random_creates_shared_shuffle_result(): void
    {
        $this->seedFactionsForTwoPlayers();

        $this->get(route('random'))->assertOk();

        $this->assertSame(1, SharedShuffleResult::query()->count());
        $this->assertSame(2, SharedShuffleResult::query()->value('player_count'));
    }

    public function test_share_page_shows_faction_names(): void
    {
        $this->seedFactionsForTwoPlayers();

        $this->post(route('shuffle-result'), [
            'numberOfPlayers' => '2',
            'includeFactions' => [],
            'excludeFactions' => [],
        ])->assertOk();

        $publicId = SharedShuffleResult::query()->value('public_id');
        $show = $this->get(route('shuffle.share', ['publicId' => $publicId]));
        $show->assertOk();
        $results = SharedShuffleResult::query()->where('public_id', $publicId)->value('results');
        $this->assertIsArray($results);
        foreach ($results as $pair) {
            foreach ($pair as $slot) {
                $show->assertSee($slot['name'], false);
            }
        }
    }

    public function test_share_page_returns_404_for_unknown_id(): void
    {
        $this->get(route('shuffle.share', ['publicId' => '01ARZ3NDEKTSV4RRFFQ69G5FAV']))->assertNotFound();
    }

    public function test_shuffle_redirects_with_conflict_when_every_included_faction_is_excluded(): void
    {
        $this->seedFactionsForTwoPlayers();
        $names = ['A1', 'A2', 'A3', 'A4'];

        $response = $this->post(route('shuffle-result'), [
            'numberOfPlayers' => '2',
            'includeFactions' => $names,
            'excludeFactions' => $names,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', __('frontend.shuffle_error_include_exclude_conflict'));
    }

    public function test_shuffle_redirects_with_pool_empty_when_all_factions_excluded(): void
    {
        $this->seedFactionsForTwoPlayers();
        $names = ['A1', 'A2', 'A3', 'A4'];

        $response = $this->post(route('shuffle-result'), [
            'numberOfPlayers' => '2',
            'includeFactions' => [],
            'excludeFactions' => $names,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', __('frontend.shuffle_error_pool_empty'));
    }

    public function test_shuffle_redirects_when_pool_too_small_for_player_count(): void
    {
        foreach (['B1', 'B2', 'B3'] as $name) {
            Deck::query()->create(['name' => $name, 'expansion' => 'Core']);
        }

        $response = $this->post(route('shuffle-result'), [
            'numberOfPlayers' => '2',
            'includeFactions' => [],
            'excludeFactions' => [],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', __('frontend.shuffle_error_not_enough_factions'));
    }
}
