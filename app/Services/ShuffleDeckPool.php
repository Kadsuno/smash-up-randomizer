<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Deck;
use App\Models\ShuffleHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ShuffleDeckPool
{
    /**
     * Base query for factions available to the user before include/exclude filters.
     *
     * @return Builder<Deck>
     */
    public function baseQuery(?User $user): Builder
    {
        $query = Deck::query();

        if ($user !== null && $user->hasExpansionCollection()) {
            $query->whereIn('expansion', $user->ownedExpansionNames());
        }

        return $query;
    }

    /**
     * Faction names played in the user's most recent history rows.
     *
     * @param  positive-int  $window  Number of history rows to inspect
     * @return list<string>
     */
    public function recentFactionNames(?User $user, int $window): array
    {
        if ($user === null) {
            return [];
        }

        return $user->shuffleHistories()
            ->orderByDesc('created_at')
            ->limit($window)
            ->get()
            ->flatMap(
                fn (ShuffleHistory $history) => collect($history->results)
                    ->flatten(1)
                    ->pluck('name')
            )
            ->unique()
            ->values()
            ->all();
    }

    /**
     * Factions eligible for shuffle after include/exclude and optional anti-repeat filters.
     *
     * @param  list<string>  $includedFactions
     * @param  list<string>  $excludedFactions
     * @param  bool  $avoidRecent  Exclude faction names from the user's recent history
     * @return Collection<int, Deck>
     */
    public function eligibleDecks(
        ?User $user,
        array $includedFactions,
        array $excludedFactions,
        bool $avoidRecent = false,
    ): Collection {
        $query = $this->baseQuery($user);

        if ($includedFactions !== []) {
            $query->whereIn('name', $includedFactions);
        }

        if ($excludedFactions !== []) {
            $query->whereNotIn('name', $excludedFactions);
        }

        if ($avoidRecent) {
            $recent = $this->recentFactionNames($user, config('shuffle.anti_repeat_window', 5));
            if ($recent !== []) {
                $query->whereNotIn('name', $recent);
            }
        }

        return $query->get();
    }
}
