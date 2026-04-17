<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use Illuminate\Support\Str;
use PragmaRX\Google2FA\Google2FA as Google2FACore;
use PragmaRX\Google2FAQRCode\Google2FA;
use PragmaRX\Google2FAQRCode\QRCode\Bacon;

class TwoFactorAuthenticationService
{
    private const RECOVERY_CODE_COUNT = 8;

    private Google2FACore $core;

    private Google2FA $google2fa;

    public function __construct()
    {
        $this->core = new Google2FACore;
        $this->google2fa = new Google2FA(new Bacon(new SvgImageBackEnd));
    }

    /**
     * Generate a new shared secret for TOTP enrollment.
     */
    public function generateSecret(): string
    {
        return $this->google2fa->generateSecretKey();
    }

    /**
     * Inline SVG (or data URL) suitable for embedding in a Blade view.
     */
    public function getQrCodeInline(string $email, string $secret): string
    {
        return $this->google2fa->getQRCodeInline(
            config('app.name', 'App'),
            $email,
            $secret,
            192
        );
    }

    /**
     * Whether the user has completed MFA enrollment.
     */
    public function isEnabled(User $user): bool
    {
        return $user->two_factor_secret !== null
            && $user->two_factor_confirmed_at !== null;
    }

    /**
     * Verify a six-digit TOTP against the user's stored secret.
     */
    public function verifyTotp(User $user, string $code): bool
    {
        if ($user->two_factor_secret === null) {
            return false;
        }

        return $this->verifyTotpWithSecret($user->two_factor_secret, $code);
    }

    /**
     * Verify TOTP during enrollment before persisting the secret.
     */
    public function verifyTotpWithSecret(string $secret, string $code): bool
    {
        $code = preg_replace('/\s+/', '', $code) ?? '';

        return $this->core->verifyKey($secret, $code);
    }

    /**
     * Generate plain recovery codes (single-use); hash before storing on the user.
     *
     * @return list<string>
     */
    public function generatePlainRecoveryCodes(): array
    {
        $codes = [];
        for ($i = 0; $i < self::RECOVERY_CODE_COUNT; $i++) {
            $codes[] = strtoupper(Str::random(4)).'-'.strtoupper(Str::random(4));
        }

        return $codes;
    }

    /**
     * @param  list<string>  $plainCodes
     * @return list<string> bcrypt hashes
     */
    public function hashRecoveryCodes(array $plainCodes): array
    {
        return array_map(
            fn (string $plain): string => password_hash($plain, PASSWORD_BCRYPT),
            $plainCodes
        );
    }

    /**
     * Verify a recovery code and remove it from the user if valid.
     */
    public function verifyAndConsumeRecoveryCode(User $user, string $input): bool
    {
        $normalized = $this->normalizeRecoveryCodeInput($input);
        $hashes = $user->two_factor_recovery_codes;
        if (! is_array($hashes) || $hashes === []) {
            return false;
        }

        foreach ($hashes as $index => $hash) {
            if (! is_string($hash)) {
                continue;
            }
            if (password_verify($normalized, $hash)) {
                unset($hashes[$index]);
                $user->forceFill([
                    'two_factor_recovery_codes' => array_values($hashes),
                ])->save();

                return true;
            }
        }

        return false;
    }

    /**
     * Check recovery code without consuming (e.g. for disable when password is not set).
     */
    public function recoveryCodeMatches(User $user, string $input): bool
    {
        $normalized = $this->normalizeRecoveryCodeInput($input);
        $hashes = $user->two_factor_recovery_codes;
        if (! is_array($hashes)) {
            return false;
        }
        foreach ($hashes as $hash) {
            if (is_string($hash) && password_verify($normalized, $hash)) {
                return true;
            }
        }

        return false;
    }

    private function normalizeRecoveryCodeInput(string $code): string
    {
        $alnum = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', $code) ?? '');
        if (strlen($alnum) === 8) {
            return substr($alnum, 0, 4).'-'.substr($alnum, 4, 4);
        }

        return strtoupper(trim($code));
    }
}
