<?php

declare(strict_types=1);

namespace Tests\Feature\Account;

use App\Models\Deck;
use App\Models\User;
use App\Models\UserExpansion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountShuffleFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_collection(): void
    {
        $this->get(route('account.collection'))->assertRedirect(route('login'));
    }

    public function test_verified_user_can_save_expansion_collection(): void
    {
        $user = User::factory()->create();
        Deck::query()->create([
            'name' => 'TestFactionA',
            'expansion' => 'Core Set',
        ]);

        $this->actingAs($user);

        $response = $this->put(route('account.collection.update'), [
            'expansions' => ['Core Set'],
        ]);

        $response->assertRedirect(route('account.collection'));
        $this->assertDatabaseHas('user_expansions', [
            'user_id' => $user->id,
            'expansion' => 'Core Set',
        ]);
    }

    public function test_shuffle_respects_user_collection(): void
    {
        $user = User::factory()->create();

        foreach (['C1', 'C2', 'C3', 'C4'] as $name) {
            Deck::query()->create(['name' => $name, 'expansion' => 'Core Set']);
        }
        foreach (['O1', 'O2', 'O3', 'O4'] as $name) {
            Deck::query()->create(['name' => $name, 'expansion' => 'Other Set']);
        }

        UserExpansion::query()->create([
            'user_id' => $user->id,
            'expansion' => 'Core Set',
        ]);

        $this->actingAs($user);

        $this->post(route('shuffle-result'), [
            'numberOfPlayers' => '2',
            'includeFactions' => [],
            'excludeFactions' => [],
        ])->assertOk();

        $this->assertDatabaseHas('shuffle_histories', [
            'user_id' => $user->id,
            'player_count' => 2,
        ]);
    }
}
