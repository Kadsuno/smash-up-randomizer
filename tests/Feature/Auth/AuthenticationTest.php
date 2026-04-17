<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_frontend_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
    }

    public function test_regular_user_can_authenticate_via_frontend_login(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('account'));
    }

    public function test_admin_user_can_authenticate_via_admin_login(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->post(route('admin.login'), [
            'email'    => $admin->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }

    public function test_non_admin_user_cannot_use_admin_login_form(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->post(route('admin.login'), [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post(route('login'), [
            'email'    => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
