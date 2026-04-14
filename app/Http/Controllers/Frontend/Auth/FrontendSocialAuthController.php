<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirect;

class FrontendSocialAuthController extends Controller
{
    /** @var list<string> */
    private const ALLOWED = ['google', 'github'];

    /**
     * Send the user to the OAuth provider.
     */
    public function redirect(string $provider): RedirectResponse|SymfonyRedirect
    {
        $this->assertProvider($provider);
        $this->assertConfigured($provider);

        $driver = Socialite::driver($provider);

        if ($provider === 'github') {
            $driver->scopes(['read:user', 'user:email']);
        }

        return $driver->redirect();
    }

    /**
     * Handle OAuth callback: find or create user, log in, redirect.
     */
    public function callback(string $provider): RedirectResponse
    {
        $this->assertProvider($provider);
        $this->assertConfigured($provider);

        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (InvalidStateException) {
            return redirect()->route('login')
                ->withErrors(['email' => __('frontend.social_session_expired')]);
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('login')
                ->withErrors(['email' => __('frontend.social_login_failed')]);
        }

        $email = $socialUser->getEmail();
        if ($email === null || $email === '') {
            return redirect()->route('login')
                ->withErrors(['email' => __('frontend.social_email_required')]);
        }

        $email = Str::lower($email);

        $user = User::query()
            ->where('provider', $provider)
            ->where('provider_id', (string) $socialUser->getId())
            ->first();

        if ($user !== null) {
            Auth::login($user, true);

            return $this->authenticatedRedirect();
        }

        $existing = User::query()->where('email', $email)->first();

        if ($existing !== null) {
            if ($existing->provider !== null && $existing->provider !== $provider) {
                return redirect()->route('login')
                    ->withErrors(['email' => __('frontend.social_email_taken_other_provider')]);
            }

            $existing->forceFill([
                'provider'    => $provider,
                'provider_id' => (string) $socialUser->getId(),
                'name'        => filled($existing->name) ? $existing->name : ($socialUser->getName() ?: Str::before($email, '@')),
            ])->save();

            Auth::login($existing, true);

            return $this->authenticatedRedirect();
        }

        $name = $socialUser->getName()
            ?: $socialUser->getNickname()
            ?: Str::before($email, '@');

        $verified = $this->oauthEmailVerified($provider, $socialUser);

        $user = User::query()->create([
            'name'        => $name,
            'email'       => $email,
            'password'    => null,
            'role'        => 'user',
            'provider'    => $provider,
            'provider_id' => (string) $socialUser->getId(),
        ]);

        if ($verified) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, true);

        return $this->authenticatedRedirect();
    }

    /**
     * Whether the provider has confirmed the e-mail (used for MustVerifyEmail).
     */
    private function oauthEmailVerified(string $provider, SocialiteUserContract $socialUser): bool
    {
        if ($provider === 'google') {
            $raw = $socialUser instanceof \Laravel\Socialite\Two\User ? $socialUser->user : [];

            return (bool) ($raw['email_verified'] ?? false);
        }

        return true;
    }

    private function assertProvider(string $provider): void
    {
        if (! in_array($provider, self::ALLOWED, true)) {
            abort(404);
        }
    }

    private function assertConfigured(string $provider): void
    {
        if (empty(config('services.'.$provider.'.client_id'))) {
            abort(404);
        }
    }

    private function authenticatedRedirect(): RedirectResponse
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect()->route('login');
        }

        if ($user->isAdmin()) {
            return redirect()->intended(route('dashboard'));
        }

        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->intended(route('account'));
    }
}
