<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class SocialAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_google_redirect_returns_redirect_when_configured(): void
    {
        config([
            'services.google.client_id' => 'test-client-id',
            'services.google.client_secret' => 'secret',
        ]);

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('redirect')->once()->andReturn(redirect('https://oauth.example/authorize'));

        Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

        $this->get('/auth/google/redirect')->assertRedirect('https://oauth.example/authorize');
    }

    public function test_google_redirect_returns_404_when_not_configured(): void
    {
        config(['services.google.client_id' => null]);

        $this->get('/auth/google/redirect')->assertNotFound();
    }

    public function test_invalid_provider_returns_404(): void
    {
        config(['services.twitter.client_id' => 'x']); // irrelevant — route should not match
        $this->get('/auth/twitter/redirect')->assertNotFound();
    }

    public function test_google_callback_creates_user_and_logs_in(): void
    {
        config([
            'services.google.client_id' => 'test-client-id',
            'services.google.client_secret' => 'secret',
        ]);

        $social = new SocialiteUser;
        $social->id = 'google-sub-1';
        $social->name = 'OAuth User';
        $social->email = 'oauth-new@example.com';
        $social->user = ['email_verified' => true];

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('user')->once()->andReturn($social);

        Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

        $this->get('/auth/google/callback')->assertRedirect(route('account'));

        $this->assertAuthenticated();

        $user = User::query()->where('email', 'oauth-new@example.com')->first();
        $this->assertNotNull($user);
        $this->assertSame('google', $user->provider);
        $this->assertSame('google-sub-1', $user->provider_id);
        $this->assertNull($user->password);
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_google_callback_links_existing_email_user(): void
    {
        config([
            'services.google.client_id' => 'test-client-id',
            'services.google.client_secret' => 'secret',
        ]);

        $existing = User::factory()->create([
            'email' => 'same@example.com',
            'password' => 'password',
            'provider' => null,
        ]);

        $social = new SocialiteUser;
        $social->id = 'google-sub-2';
        $social->name = 'Google Name';
        $social->email = 'same@example.com';
        $social->user = ['email_verified' => true];

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('user')->once()->andReturn($social);

        Socialite::shouldReceive('driver')->once()->with('google')->andReturn($provider);

        $this->get('/auth/google/callback')->assertRedirect(route('account'));

        $existing->refresh();
        $this->assertSame('google', $existing->provider);
        $this->assertSame('google-sub-2', $existing->provider_id);
    }
}
