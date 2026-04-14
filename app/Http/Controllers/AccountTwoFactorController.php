<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\TwoFactorAuthenticationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AccountTwoFactorController extends Controller
{
    public function __construct(
        private TwoFactorAuthenticationService $twoFactor
    ) {}

    /**
     * Show QR setup (also used when returning from POST start).
     */
    public function showSetup(Request $request): View
    {
        $user = $request->user();
        $secret = $request->session()->get('two_factor_setup_secret');
        if (! is_string($secret) || $secret === '') {
            abort(404);
        }

        return view('account.two-factor-setup', [
            'user' => $user,
            'secret' => $secret,
            'qrSvg' => $this->twoFactor->getQrCodeInline($user->email, $secret),
        ]);
    }

    /**
     * Begin MFA enrollment: generate secret and redirect to setup view.
     */
    public function start(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user->hasTwoFactorEnabled()) {
            return redirect()->route('account.edit');
        }

        $secret = $this->twoFactor->generateSecret();
        $request->session()->put('two_factor_setup_secret', $secret);

        return redirect()->route('account.two-factor.setup');
    }

    /**
     * Confirm enrollment with a valid TOTP and persist secrets + recovery codes.
     */
    public function confirm(Request $request): RedirectResponse
    {
        $user = $request->user();
        if ($user->hasTwoFactorEnabled()) {
            return redirect()->route('account.edit');
        }

        $secret = $request->session()->get('two_factor_setup_secret');
        if (! is_string($secret) || $secret === '') {
            return redirect()->route('account.edit')
                ->withErrors(['code' => __('frontend.two_factor_setup_expired')], 'twoFactor');
        }

        $request->validate([
            'code' => ['required', 'string'],
        ]);

        if (! $this->twoFactor->verifyTotpWithSecret($secret, (string) $request->input('code'))) {
            return redirect()->route('account.two-factor.setup')
                ->withErrors(['code' => __('frontend.two_factor_invalid_code')], 'twoFactor');
        }

        $plainRecovery = $this->twoFactor->generatePlainRecoveryCodes();
        $user->forceFill([
            'two_factor_secret' => $secret,
            'two_factor_recovery_codes' => $this->twoFactor->hashRecoveryCodes($plainRecovery),
            'two_factor_confirmed_at' => now(),
        ])->save();

        $request->session()->forget('two_factor_setup_secret');

        return redirect()->route('account.edit')->with('mfa_recovery_codes', $plainRecovery);
    }

    /**
     * Cancel in-progress enrollment.
     */
    public function cancelSetup(Request $request): RedirectResponse
    {
        $request->session()->forget('two_factor_setup_secret');

        return redirect()->route('account.edit');
    }

    /**
     * Disable MFA for the account.
     */
    public function disable(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (! $user->hasTwoFactorEnabled()) {
            return redirect()->route('account.edit');
        }

        $request->validate([
            'password' => ['nullable', 'string'],
            'code' => ['nullable', 'string', 'max:64'],
        ]);

        $hasPassword = $user->password !== null;

        if ($hasPassword) {
            $request->validate([
                'password' => ['required', 'string'],
            ]);
            if (! Hash::check((string) $request->input('password'), $user->password)) {
                return redirect()->route('account.edit')
                    ->withErrors(['password' => __('frontend.account_password_wrong_current')], 'twoFactorDisable');
            }
        } else {
            $request->validate([
                'code' => ['required', 'string', 'max:64'],
            ]);
            $code = trim((string) $request->input('code'));
            $ok = $this->twoFactor->verifyTotp($user, $code);
            if (! $ok) {
                $ok = $this->twoFactor->verifyAndConsumeRecoveryCode($user, $code);
            }
            if (! $ok) {
                return redirect()->route('account.edit')
                    ->withErrors(['code' => __('frontend.two_factor_invalid_code')], 'twoFactorDisable');
            }
        }

        $user->forceFill([
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
        ])->save();

        return redirect()->route('account.edit')->with('mfa_disabled', true);
    }

    /**
     * Regenerate recovery codes (requires current TOTP).
     */
    public function regenerateRecoveryCodes(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (! $user->hasTwoFactorEnabled()) {
            return redirect()->route('account.edit');
        }

        $request->validate([
            'code' => ['required', 'string'],
        ]);

        if (! $this->twoFactor->verifyTotp($user, (string) $request->input('code'))) {
            return redirect()->route('account.edit')
                ->withErrors(['code' => __('frontend.two_factor_invalid_code')], 'twoFactorRecovery');
        }

        $plainRecovery = $this->twoFactor->generatePlainRecoveryCodes();
        $user->forceFill([
            'two_factor_recovery_codes' => $this->twoFactor->hashRecoveryCodes($plainRecovery),
        ])->save();

        return redirect()->route('account.edit')->with('mfa_recovery_codes', $plainRecovery);
    }
}
