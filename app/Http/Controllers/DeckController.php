<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Deck;
use App\Models\ShuffleHistory;
use App\Services\ShuffleDeckPool;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeckController extends Controller
{
    public function __construct(
        private readonly ShuffleDeckPool $shufflePool
    ) {}

    /**
     * Index action to send the factions to the view
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $decks = Deck::all();

        $decks = $decks->sortBy('name');

        return view('backend.decks-manager', ['decks' => $decks]);
    }

    /**
     * Index action to send the factions to the view
     * @return \Illuminate\Contracts\View\View
     */
    public function list(): \Illuminate\Contracts\View\View
    {
        $decks = Deck::all()->sortBy('name');

        return view('decks.list', [
            'decks'       => $decks,
            'total'       => $decks->count(),
            'withDetails' => $decks->filter(fn ($d) => !empty($d->teaser))->count(),
        ]);
    }

    /**
     * Detail action to send the faction to the view
     * @param string $name Name of the faction
     * @return \Illuminate\Contracts\View\View
     */
    public function detail(string $name): \Illuminate\Contracts\View\View
    {
        $deck = Deck::where('name', $name)->firstOrFail();
        return view('decks.detail', ['deck' => $deck]);
    }

    /**
     * List all expansion sets grouped by name.
     * @return \Illuminate\Contracts\View\View
     */
    public function expansions(): \Illuminate\Contracts\View\View
    {
        $expansions = Deck::whereNotNull('expansion')
            ->where('expansion', '!=', '')
            ->get()
            ->groupBy('expansion')
            ->map(fn ($factions) => [
                'name'    => $factions->first()->expansion,
                'slug'    => Str::slug($factions->first()->expansion),
                'count'   => $factions->count(),
                'preview' => $factions->filter(fn ($d) => !empty($d->image))->take(4)->values(),
            ])
            ->sortKeys();

        return view('expansions.index', compact('expansions'));
    }

    /**
     * Show all factions for a single expansion set.
     * @param string $slug URL slug of the expansion name
     * @return \Illuminate\Contracts\View\View
     */
    public function expansion(string $slug): \Illuminate\Contracts\View\View
    {
        $expansionNames = Deck::whereNotNull('expansion')
            ->where('expansion', '!=', '')
            ->distinct()
            ->pluck('expansion');

        $expansionName = $expansionNames->first(
            fn ($name) => Str::slug($name) === $slug
        );

        if (!$expansionName) {
            abort(404);
        }

        $decks = Deck::where('expansion', $expansionName)
            ->orderBy('name')
            ->get();

        return view('expansions.show', [
            'expansionName' => $expansionName,
            'expansionSlug' => $slug,
            'decks'         => $decks,
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

        return view('shuffle.shuffle-decks', compact('selectedDecks'));
    }

    /**
     * Add action to add new factions
     * @return \Illuminate\Contracts\View\View
     */
    public function add(): \Illuminate\Contracts\View\View
    {
        return view('decks.add');
    }

    /**
     * Create action to create a new faction
     * @param Request $request Request object
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $deck = Deck::where('name', $request->name)->first();

        $imageUrl = config('app.url') . '/images/factions/' . strtolower($request->name) . '.png';

        if ($deck) {
            Deck::where('name', $request->name)->update([
                'image' => $imageUrl,
                'teaser' => $request->teaser,
                'description' => $request->description,
                'cardsTeaser' => $request->cardsTeaser,
                'actionTeaser' => $request->actionTeaser,
                'actionList' => $request->actionList,
                'actions' => $request->actions,
                'characters' => $request->characters,
                'bases' => $request->bases,
                'clarifications' => $request->clarifications,
                'suggestionTeaser' => $request->suggestionTeaser,
                'synergy' => $request->synergy,
                'tips' => $request->tips,
                'mechanics' => $request->mechanics,
                'expansion' => $request->expansion,
                'effects' => $request->effects,
                'playstyle' => $request->playstyle
            ]);

            session()->flash('success', 'Faction (' . $deck->name . ', ID: ' . $deck->id . ') already exists, updated successfully!');
        }
        else {
            $deck = Deck::create([
                'name' => $request->name,
                'image' => $imageUrl,
                'teaser' => $request->teaser,
                'description' => $request->description,
                'cardsTeaser' => $request->cardsTeaser,
                'actionTeaser' => $request->actionTeaser,
                'actionList' => $request->actionList,
                'actions' => $request->actions,
                'characters' => $request->characters,
                'bases' => $request->bases,
                'clarifications' => $request->clarifications,
                'suggestionTeaser' => $request->suggestionTeaser,
                'synergy' => $request->synergy,
                'tips' => $request->tips,
                'mechanics' => $request->mechanics,
                'expansion' => $request->expansion,
                'effects' => $request->effects,
                'playstyle' => $request->playstyle
            ]);

            session()->flash('success', 'Created faction (' . $deck->name . ', ID: ' . $deck->id . ') successfully!');
        }

        return redirect()->route('decks-manager');
    }

    /**
     * Delete action to delete a selected faction
     * @param id $id ID of the faction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(string $name): \Illuminate\Http\RedirectResponse
    {
        $deck = Deck::where('name', $name)->first();

        Deck::where('name', $name)->delete();

        session()->flash('success', 'Deleted faction (' . $deck->name . ', ID: ' . $deck->id . ') successfully!');

        return redirect()->route('decks-manager');
    }

    /**
     * Shuffle action to shuffle random factions and assign to players.
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

        return view('shuffle.shuffle-decks', ['selectedDecks' => $selectedDecks]);
    }

    /**
     * AddCsv action to import faction via CSV file
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addCsv(): \Illuminate\Http\RedirectResponse
    {
        $tmpName = $_FILES['csv']['tmp_name'];
        $factionCsv = array_map('str_getcsv', file($tmpName));
        foreach ($factionCsv as $factionArray) {
            $deckExists = FALSE;

            if ($factionArray[1] != '') {
                $deckName = $factionArray[1];

                $decks = Deck::all();

                foreach ($decks as $deck) {
                    if ($deck->name == $deckName) {
                        $deckExists = TRUE;
                    }
                }

                if (!$deckExists) {
                    $deck = new Deck();
                    $deck->name = $deckName;
                    $deck->save();
                }
            }
        }

        session()->flash('success', 'Imported factions via CSV successfully!');

        return redirect()->route('decks-manager');
    }

    /**
     * Edit action to edit selected faction
     * @param Request $request Request object
     * @param string $name Name of the faction
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request, string $name): \Illuminate\Contracts\View\View
    {
        $deck = Deck::where('name', $request->name)->first();

        return view('decks.edit', ['deck' => $deck]);
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {
        $deck = Deck::where('name', $request->name)->first();
        $imageUrl = config('app.url') . '/images/factions/' . strtolower($request->name) . '.png';

        Deck::where('name', $request->name)->update([
            'image' => $imageUrl,
            'teaser' => $request->teaser,
            'description' => $request->description,
            'cardsTeaser' => $request->cardsTeaser,
            'actionTeaser' => $request->actionTeaser,
            'actionList' => $request->actionList,
            'actions' => $request->actions,
            'characters' => $request->characters,
            'bases' => $request->bases,
            'clarifications' => $request->clarifications,
            'suggestionTeaser' => $request->suggestionTeaser,
            'synergy' => $request->synergy,
            'tips' => $request->tips,
            'mechanics' => $request->mechanics,
            'expansion' => $request->expansion,
            'effects' => $request->effects,
            'playstyle' => $request->playstyle
        ]);

        session()->flash('success', 'Updated faction (' . $deck->name . ', ID: ' . $deck->id . ') successfully!');

        return redirect()->route('decks-manager');
    }
}
