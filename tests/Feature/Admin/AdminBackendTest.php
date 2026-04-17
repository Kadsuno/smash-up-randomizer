<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use App\Models\Contact;
use App\Models\Deck;
use App\Models\ShuffleHistory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminBackendTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_contacts(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->get(route('admin.contacts.index'))->assertForbidden();
    }

    public function test_admin_can_list_and_show_contacts(): void
    {
        $admin = User::factory()->admin()->create();
        $contact = Contact::factory()->create();

        $this->actingAs($admin)->get(route('admin.contacts.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.contacts.show', $contact))->assertOk();
    }

    public function test_admin_can_open_shuffle_stats(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create(['role' => 'user']);

        ShuffleHistory::query()->create([
            'user_id' => $user->id,
            'player_count' => 2,
            'results' => [
                [['name' => 'Faction A'], ['name' => 'Faction B']],
                [['name' => 'Faction C'], ['name' => 'Faction D']],
            ],
        ]);

        $this->actingAs($admin)->get(route('admin.shuffle-stats'))->assertOk();
    }

    public function test_admin_can_open_maintenance_page(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('admin.maintenance'))->assertOk();
    }

    public function test_admin_can_delete_faction_with_delete_method(): void
    {
        $admin = User::factory()->admin()->create();
        $deck = Deck::query()->create([
            'name' => 'Delete Me Faction',
            'image' => 'https://example.test/images/factions/delete-me-faction.png',
        ]);

        $this->actingAs($admin)
            ->delete(route('delete-decks', ['name' => $deck->name]))
            ->assertRedirect(route('decks-manager'));

        $this->assertDatabaseMissing('decks', ['id' => $deck->id]);
    }

    public function test_get_delete_route_is_removed(): void
    {
        $admin = User::factory()->admin()->create();
        $deck = Deck::query()->create([
            'name' => 'Legacy Delete',
            'image' => 'https://example.test/images/factions/legacy-delete.png',
        ]);

        $this->actingAs($admin)
            ->get('/admin/backend/decks-manager/delete/'.$deck->name)
            ->assertNotFound();
    }

    public function test_cannot_demote_last_admin(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->post(route('admin.users.update-role'), [
            'user_id' => $admin->id,
            'role' => 'user',
        ])->assertSessionHasErrors('role');

        $this->assertTrue($admin->fresh()->isAdmin());
    }

    public function test_admin_can_promote_user(): void
    {
        $admin = User::factory()->admin()->create();
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)->post(route('admin.users.update-role'), [
            'user_id' => $user->id,
            'role' => 'admin',
        ])->assertRedirect(route('admin.users.index'));

        $this->assertTrue($user->fresh()->isAdmin());
    }

    public function test_csv_import_requires_valid_file(): void
    {
        $admin = User::factory()->admin()->create();

        $file = UploadedFile::fake()->create('doc.pdf', 10, 'application/pdf');

        $this->actingAs($admin)
            ->post(route('add-deck-csv'), ['csv' => $file])
            ->assertSessionHasErrors('csv');
    }

    public function test_decks_manager_supports_filters(): void
    {
        $admin = User::factory()->admin()->create();
        Deck::query()->create([
            'name' => 'Alpha Filter Test',
            'image' => 'https://example.test/x.png',
            'teaser' => 't',
            'description' => 'd',
        ]);
        Deck::query()->create([
            'name' => 'Beta Filter Test',
            'image' => 'https://example.test/y.png',
            'expansion' => 'Test Expansion',
        ]);

        $this->actingAs($admin)
            ->get(route('decks-manager', ['q' => 'Alpha', 'filter' => 'all', 'expansion' => '']))
            ->assertOk()
            ->assertSee('Alpha Filter Test', false)
            ->assertDontSee('Beta Filter Test', false);

        $this->actingAs($admin)
            ->get(route('decks-manager', ['filter' => 'missing', 'expansion' => 'Test Expansion']))
            ->assertOk()
            ->assertSee('Beta Filter Test', false);
    }
}
