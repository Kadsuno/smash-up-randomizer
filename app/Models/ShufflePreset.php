<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShufflePreset extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'player_count',
        'include_factions',
        'exclude_factions',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'include_factions' => 'array',
            'exclude_factions' => 'array',
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
