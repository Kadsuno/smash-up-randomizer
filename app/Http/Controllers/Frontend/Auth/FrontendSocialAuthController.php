<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Auth\Concerns\RedirectsAfterFrontendAuth;
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
    use RedirectsAfterFrontendAuth;

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
            return $this->loginOrTwoFactorChallenge($user, true);
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

            return $this->loginOrTwoFactorChallenge($existing, true);
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

        return $this->loginOrTwoFactorChallenge($user, true);
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

    /**
     * Log in or require MFA challenge when enabled.
     */
    private function loginOrTwoFactorChallenge(User $user, bool $remember): RedirectResponse
    {
        if ($user->hasTwoFactorEnabled()) {
            session([
                'two_factor.login.id' => $user->getKey(),
                'two_factor.login.remember' => $remember,
            ]);

            return redirect()->route('two-factor.login');
        }

        Auth::login($user, $remember);

        return $this->redirectAfterFrontendAuthenticated();
    }
}
