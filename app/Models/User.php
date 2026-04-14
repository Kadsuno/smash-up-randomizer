<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\Contracts\OAuthenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail, OAuthenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'provider',
        'provider_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'two_factor_confirmed_at' => 'datetime',
        'two_factor_secret' => 'encrypted',
        'two_factor_recovery_codes' => 'encrypted:array',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Whether TOTP MFA is fully enabled for this account.
     */
    public function hasTwoFactorEnabled(): bool
    {
        return $this->two_factor_secret !== null
            && $this->two_factor_confirmed_at !== null;
    }

    /**
     * Expansion sets the user marked as owned (drives shuffle pool when non-empty).
     *
     * @return HasMany<UserExpansion, $this>
     */
    public function userExpansions(): HasMany
    {
        return $this->hasMany(UserExpansion::class);
    }

    /**
     * @return HasMany<ShufflePreset, $this>
     */
    public function shufflePresets(): HasMany
    {
        return $this->hasMany(ShufflePreset::class);
    }

    /**
     * @return HasMany<ShuffleHistory, $this>
     */
    public function shuffleHistories(): HasMany
    {
        return $this->hasMany(ShuffleHistory::class);
    }

    /**
     * Whether the user configured at least one owned expansion (shuffle uses this pool).
     */
    public function hasExpansionCollection(): bool
    {
        return $this->userExpansions()->exists();
    }

    /**
     * Distinct expansion names selected for this user (matches `decks.expansion`).
     *
     * @return list<string>
     */
    public function ownedExpansionNames(): array
    {
        return $this->userExpansions()
            ->pluck('expansion')
            ->unique()
            ->values()
            ->all();
    }
}
