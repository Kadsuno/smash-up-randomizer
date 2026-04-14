<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Frontend\Auth\Concerns\RedirectsAfterFrontendAuth;
use App\Models\User;
use App\Services\TwoFactorAuthenticationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class FrontendTwoFactorChallengeController extends Controller
{
    use RedirectsAfterFrontendAuth;

    public function __construct(
        private TwoFactorAuthenticationService $twoFactor
    ) {}

    /**
     * Show the MFA code entry form (pending login must exist in session).
     */
    public function create(Request $request): View|RedirectResponse
    {
        $user = $this->resolvePendingUser($request);
        if ($user === null) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge', [
            'email' => $user->email,
        ]);
    }

    /**
     * Complete login after a valid TOTP or recovery code.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $this->resolvePendingUser($request);
        if ($user === null) {
            return redirect()->route('login');
        }

        $this->ensureIsNotRateLimited($request, $user);

        $request->validate([
            'code' => ['required', 'string', 'max:64'],
        ]);

        $code = trim((string) $request->input('code'));
        $valid = false;

        if (preg_match('/^\d{6}$/', preg_replace('/\s+/', '', $code) ?? '')) {
            $digits = preg_replace('/\s+/', '', $code) ?? '';
            $valid = $this->twoFactor->verifyTotp($user, $digits);
        }

        if (! $valid) {
            $valid = $this->twoFactor->verifyAndConsumeRecoveryCode($user, $code);
        }

        if (! $valid) {
            RateLimiter::hit($this->throttleKey($request, $user));
            throw ValidationException::withMessages([
                'code' => __('frontend.two_factor_invalid_code'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($request, $user));

        $remember = (bool) $request->session()->pull('two_factor.login.remember', false);
        $request->session()->forget('two_factor.login.id');

        Auth::login($user, $remember);
        $request->session()->regenerate();

        return $this->redirectAfterFrontendAuthenticated();
    }

    /**
     * Resolve the user for the pending MFA login, or null if invalid.
     */
    private function resolvePendingUser(Request $request): ?User
    {
        $id = $request->session()->get('two_factor.login.id');
        if (! is_numeric($id)) {
            return null;
        }

        $user = User::query()->find((int) $id);
        if ($user === null || ! $user->hasTwoFactorEnabled()) {
            $request->session()->forget(['two_factor.login.id', 'two_factor.login.remember']);

            return null;
        }

        return $user;
    }

    private function throttleKey(Request $request, User $user): string
    {
        return 'two-factor:'.$user->getKey().'|'.$request->ip();
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    private function ensureIsNotRateLimited(Request $request, User $user): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request, $user), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request, $user));

        throw ValidationException::withMessages([
            'code' => __('frontend.two_factor_throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }
}
