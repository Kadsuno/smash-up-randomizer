<?php

declare(strict_types=1);

namespace Tests\Feature\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountProfileUpdateTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsVerifiedUser(): User
    {
        $user = User::factory()->create([
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        return $user;
    }

    public function test_profile_page_is_displayed(): void
    {
        $this->actingAsVerifiedUser();

        $this->get('/account')->assertOk();
    }

    public function test_user_can_update_name_and_email(): void
    {
        $user = $this->actingAsVerifiedUser();

        $this->patch('/account/profile', [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ])->assertRedirect();

        $user->refresh();
        $this->assertSame('Updated Name', $user->name);
        $this->assertSame('updated@example.com', $user->email);
    }

    public function test_email_change_marks_account_unverified(): void
    {
        $user = $this->actingAsVerifiedUser();

        $this->patch('/account/profile', [
            'name' => $user->name,
            'email' => 'new@example.com',
        ]);

        $user->refresh();
        $this->assertNull($user->email_verified_at);
    }

    public function test_email_change_redirects_to_verification_notice(): void
    {
        $user = $this->actingAsVerifiedUser();

        $this->patch('/account/profile', [
            'name' => $user->name,
            'email' => 'new@example.com',
        ])->assertRedirect(route('verification.notice'));
    }

    public function test_same_email_does_not_unverify(): void
    {
        $user = $this->actingAsVerifiedUser();
        $originalVerifiedAt = $user->email_verified_at;

        $this->patch('/account/profile', [
            'name' => 'New Name',
            'email' => $user->email,
        ]);

        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
        $this->assertTrue($originalVerifiedAt->eq($user->email_verified_at));
    }

    public function test_name_is_required(): void
    {
        $this->actingAsVerifiedUser();

        $this->patch('/account/profile', [
            'name' => '',
            'email' => 'test@example.com',
        ])->assertSessionHasErrors('name');
    }

    public function test_name_cannot_exceed_255_chars(): void
    {
        $this->actingAsVerifiedUser();

        $this->patch('/account/profile', [
            'name' => str_repeat('a', 256),
            'email' => 'test@example.com',
        ])->assertSessionHasErrors('name');
    }

    public function test_duplicate_email_is_rejected(): void
    {
        User::factory()->create(['email' => 'taken@example.com']);
        $this->actingAsVerifiedUser();

        $this->patch('/account/profile', [
            'name' => 'Test',
            'email' => 'taken@example.com',
        ])->assertSessionHasErrors('email');
    }

    public function test_own_email_is_accepted(): void
    {
        $user = $this->actingAsVerifiedUser();

        $this->patch('/account/profile', [
            'name' => 'New Name',
            'email' => $user->email,
        ])->assertRedirect(route('account.edit'));
    }

    public function test_unauthenticated_user_is_redirected(): void
    {
        $this->patch('/account/profile', [
            'name' => 'Test',
            'email' => 'test@example.com',
        ])->assertRedirect(route('login'));
    }
}
