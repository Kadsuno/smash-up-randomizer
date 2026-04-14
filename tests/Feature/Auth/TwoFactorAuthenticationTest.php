<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Services\TwoFactorAuthenticationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PragmaRX\Google2FA\Google2FA;
use Tests\TestCase;

class TwoFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_login_redirects_to_challenge_when_mfa_enabled(): void
    {
        $google2fa = new Google2FA;
        $secret = $google2fa->generateSecretKey();

        $user = User::factory()->create([
            'role' => 'user',
            'two_factor_secret' => $secret,
            'two_factor_confirmed_at' => now(),
            'two_factor_recovery_codes' => [],
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('two-factor.login'));
        $this->assertGuest();
    }

    public function test_challenge_accepts_valid_totp_and_logs_in(): void
    {
        $google2fa = new Google2FA;
        $secret = $google2fa->generateSecretKey();

        $user = User::factory()->create([
            'role' => 'user',
            'two_factor_secret' => $secret,
            'two_factor_confirmed_at' => now(),
            'two_factor_recovery_codes' => [],
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $code = $google2fa->getCurrentOtp($secret);

        $response = $this->post(route('two-factor.login.store'), [
            'code' => $code,
        ]);

        $response->assertRedirect(route('account'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_challenge_accepts_recovery_code(): void
    {
        $google2fa = new Google2FA;
        $secret = $google2fa->generateSecretKey();
        $service = new TwoFactorAuthenticationService;
        $plain = $service->generatePlainRecoveryCodes();
        $hashed = $service->hashRecoveryCodes($plain);

        $user = User::factory()->create([
            'role' => 'user',
            'two_factor_secret' => $secret,
            'two_factor_confirmed_at' => now(),
            'two_factor_recovery_codes' => $hashed,
        ]);

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response = $this->post(route('two-factor.login.store'), [
            'code' => $plain[0],
        ]);

        $response->assertRedirect(route('account'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_two_factor_challenge_requires_pending_session(): void
    {
        $this->get(route('two-factor.login'))->assertRedirect(route('login'));
    }

    public function test_user_without_mfa_logs_in_directly(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('account'));
        $this->assertAuthenticatedAs($user);
    }
}
