<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Deck;
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
     * Factions eligible for shuffle after include/exclude (faction names) are applied.
     *
     * @param  list<string>  $includedFactions
     * @param  list<string>  $excludedFactions
     * @return Collection<int, Deck>
     */
    public function eligibleDecks(?User $user, array $includedFactions, array $excludedFactions): Collection
    {
        $query = $this->baseQuery($user);

        if ($includedFactions !== []) {
            $query->whereIn('name', $includedFactions);
        }

        if ($excludedFactions !== []) {
            $query->whereNotIn('name', $excludedFactions);
        }

        return $query->get();
    }
}
