<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\SharedShuffleResult;
use App\Models\ShuffleHistory;
use App\Services\ShuffleDeckPool;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeckController extends Controller
{
    public function __construct(
        private readonly ShuffleDeckPool $shufflePool
    ) {}

    /**
     * Public faction list (sorted by name).
     */
    public function list(): View
    {
        $decks = Deck::all()->sortBy('name');

        return view('decks.list', [
            'decks' => $decks,
            'total' => $decks->count(),
            'withDetails' => $decks->filter(fn ($d) => ! empty($d->teaser))->count(),
        ]);
    }

    /**
     * Public faction detail page.
     *
     * @param  string  $name  Name of the faction
     */
    public function detail(string $name): View
    {
        $deck = Deck::where('name', $name)->firstOrFail();

        return view('decks.detail', ['deck' => $deck]);
    }

    /**
     * List all expansion sets grouped by name.
     */
    public function expansions(): View
    {
        $expansions = Deck::whereNotNull('expansion')
            ->where('expansion', '!=', '')
            ->get()
            ->groupBy('expansion')
            ->map(fn ($factions) => [
                'name' => $factions->first()->expansion,
                'slug' => Str::slug($factions->first()->expansion),
                'count' => $factions->count(),
                'preview' => $factions->filter(fn ($d) => ! empty($d->image))->take(4)->values(),
            ])
            ->sortKeys();

        return view('expansions.index', compact('expansions'));
    }

    /**
     * Show all factions for a single expansion set.
     *
     * @param  string  $slug  URL slug of the expansion name
     */
    public function expansion(string $slug): View
    {
        $expansionNames = Deck::whereNotNull('expansion')
            ->where('expansion', '!=', '')
            ->distinct()
            ->pluck('expansion');

        $expansionName = $expansionNames->first(
            fn ($name) => Str::slug($name) === $slug
        );

        if (! $expansionName) {
            abort(404);
        }

        $decks = Deck::where('expansion', $expansionName)
            ->orderBy('name')
            ->get();

        return view('expansions.show', [
            'expansionName' => $expansionName,
            'expansionSlug' => $slug,
            'decks' => $decks,
        ]);
    }

    /**
     * Quick-shuffle two players using the eligible faction pool (respects logged-in user's collection).
     */
    public function quickShuffle(Request $request): View
    {
        $user = $request->user();
        $decks = $this->shufflePool->eligibleDecks($user, [], [])->shuffle();
        $selectedDecks = [];

        for ($i = 0; $i < 2; $i++) {
            $selectedDecks[] = $decks->splice(0, 2)
                ->map(fn ($d) => ['name' => $d->name])
                ->toArray();
        }

        if ($user !== null) {
            ShuffleHistory::query()->create([
                'user_id' => $user->id,
                'player_count' => 2,
                'results' => $selectedDecks,
            ]);
        }

        $share = SharedShuffleResult::query()->create([
            'public_id' => (string) Str::ulid(),
            'player_count' => 2,
            'results' => $selectedDecks,
        ]);

        return view('shuffle.shuffle-decks', [
            'selectedDecks' => $selectedDecks,
            'sharePublicId' => $share->public_id,
            'sharePlainText' => SharedShuffleResult::plainTextSummary($selectedDecks),
            'metaRobots' => 'index, follow',
        ]);
    }

    /**
     * Shuffle random factions and assign to players (wizard POST).
     *
     * @return RedirectResponse|View
     */
    public function shuffle(Request $request): RedirectResponse|View
    {
        $numberOfPlayers = (int) $request->input('numberOfPlayers');
        $includedFactions = array_values(array_filter((array) $request->input('includeFactions', [])));
        $excludedFactions = array_values(array_filter((array) $request->input('excludeFactions', [])));

        if (! in_array($numberOfPlayers, [2, 3, 4], true)) {
            return back()->with('error', __('frontend.shuffle_error_invalid_players'));
        }

        $user = $request->user();
        $decks = $this->shufflePool->eligibleDecks($user, $includedFactions, $excludedFactions);

        if ($decks->isEmpty()) {
            if ($includedFactions !== [] && array_diff($includedFactions, $excludedFactions) === []) {
                return back()->with('error', __('frontend.shuffle_error_include_exclude_conflict'));
            }

            return back()->with('error', __('frontend.shuffle_error_pool_empty'));
        }

        if ($decks->count() < $numberOfPlayers * 2) {
            return back()->with('error', __('frontend.shuffle_error_not_enough_factions'));
        }

        $selectedDecks = [];

        for ($i = 1; $i <= $numberOfPlayers; $i++) {
            $playerDecks = $decks->random(2);
            $selectedDecks[] = $playerDecks->map(function ($deck) {
                return ['name' => $deck->name];
            })->toArray();
            $decks = $decks->diff($playerDecks);
        }

        if ($user !== null) {
            ShuffleHistory::query()->create([
                'user_id' => $user->id,
                'player_count' => $numberOfPlayers,
                'results' => $selectedDecks,
            ]);
        }

        $share = SharedShuffleResult::query()->create([
            'public_id' => (string) Str::ulid(),
            'player_count' => $numberOfPlayers,
            'results' => $selectedDecks,
        ]);

        return view('shuffle.shuffle-decks', [
            'selectedDecks' => $selectedDecks,
            'sharePublicId' => $share->public_id,
            'sharePlainText' => SharedShuffleResult::plainTextSummary($selectedDecks),
            'metaRobots' => 'index, follow',
        ]);
    }
}
