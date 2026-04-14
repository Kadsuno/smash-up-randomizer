<?php

declare(strict_types=1);

namespace Tests\Feature\Account;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountPasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    private function actingAsVerifiedUser(string $password = 'current-password'): User
    {
        $user = User::factory()->create([
            'password'          => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $this->actingAs($user);

        return $user;
    }

    public function test_user_can_change_password(): void
    {
        $user = $this->actingAsVerifiedUser('current-password');

        $this->patch('/account/password', [
            'current_password'      => 'current-password',
            'password'              => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])->assertRedirect(route('account'));

        $user->refresh();
        $this->assertTrue(Hash::check('new-password-123', $user->password));
    }

    public function test_wrong_current_password_is_rejected(): void
    {
        $this->actingAsVerifiedUser('correct-password');

        $this->patch('/account/password', [
            'current_password'      => 'wrong-password',
            'password'              => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])->assertSessionHasErrors('current_password', errorBag: 'passwordErrors');
    }

    public function test_new_password_confirmation_must_match(): void
    {
        $this->actingAsVerifiedUser();

        $this->patch('/account/password', [
            'current_password'      => 'current-password',
            'password'              => 'new-password-123',
            'password_confirmation' => 'different-password',
        ])->assertSessionHasErrors('password');
    }

    public function test_new_password_minimum_length(): void
    {
        $this->actingAsVerifiedUser();

        $this->patch('/account/password', [
            'current_password'      => 'current-password',
            'password'              => 'short',
            'password_confirmation' => 'short',
        ])->assertSessionHasErrors('password');
    }

    public function test_current_password_is_required(): void
    {
        $this->actingAsVerifiedUser();

        $this->patch('/account/password', [
            'current_password'      => '',
            'password'              => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])->assertSessionHasErrors('current_password');
    }

    public function test_unauthenticated_user_is_redirected(): void
    {
        $this->patch('/account/password', [
            'current_password'      => 'any',
            'password'              => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])->assertRedirect(route('login'));
    }
}
