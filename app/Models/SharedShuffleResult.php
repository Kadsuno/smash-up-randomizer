<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SharedShuffleResult extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = [
        'public_id',
        'player_count',
        'results',
    ];

    /**
     * Build a localized multi-line summary for chat paste (one line per player).
     *
     * @param  array<int, array<int, array{name: string}>>  $results
     */
    public static function plainTextSummary(array $results): string
    {
        $lines = [];
        foreach ($results as $i => $playerDecks) {
            $names = array_map(fn (array $d) => $d['name'], $playerDecks);
            $lines[] = __('frontend.shuffle_share_line_player', [
                'num' => $i + 1,
                'factions' => implode(' + ', $names),
            ]);
        }

        return implode("\n", $lines);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'results' => 'array',
        ];
    }
}
