<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Deck;
use Illuminate\Http\Request;

use function Psy\debug;

class DeckController extends Controller
{
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
        $decks = Deck::all();

        $decks = $decks->sortBy('name');

        return view('decks.list', ['decks' => $decks]);
    }

    /**
     * Detail action to send the faction to the view
     * @param string $name Name of the faction
     * @return \Illuminate\Contracts\View\View
     */
    public function detail(string $name): \Illuminate\Contracts\View\View
    {
        $deck = Deck::where('name', $name)->first();
        return view('decks.detail', ['deck' => $deck]);
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
     * Shuffle action to shuffle random factions and assign to players
     * @param Request $request Request object
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
     */
    public function shuffle(Request $request): \Illuminate\Http\RedirectResponse|\Illuminate\Contracts\View\View
    {
        $numberOfPlayers = $request->input('numberOfPlayers');
        $includedFactions = $request->input('includeFactions', []);
        $excludedFactions = $request->input('excludeFactions', []);

        $decks = Deck::when(!empty($includedFactions), function ($query) use ($includedFactions) {
                return $query->whereIn('name', $includedFactions);
            })
            ->when(!empty($excludedFactions), function ($query) use ($excludedFactions) {
                return $query->whereNotIn('name', $excludedFactions);
            })
            ->get();

        if ($decks->count() < $numberOfPlayers * 2) {
            return back()->with('error', 'Not enough factions available for the selected number of players.');
        }

        $selectedDecks = [];

        for ($i = 1; $i <= $numberOfPlayers; $i++) {
            $playerDecks = $decks->random(2);
            $selectedDecks[] = $playerDecks->map(function ($deck) {
                return ['name' => $deck->name];
            })->toArray();
            $decks = $decks->diff($playerDecks);
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
