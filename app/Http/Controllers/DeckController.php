<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Deck;
use Illuminate\Http\Request;

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
     * Add action to add new factions
     * @param Request $request Request object
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Request $request): \Illuminate\Http\RedirectResponse
    {
        $deck = Deck::where('name', $request->deckName)->first();

        if ($deck) {
            Deck::where('name', $request->deckName)->update([
                'image' => $request->deckImage,
                'teaser' => $request->deckTeaser,
                'description' => $request->deckDescription,
                'strengths' => $request->deckStrengths,
                'weaknesses' => $request->deckWeaknesses,
                'strategy' => $request->deckStrategy,
                'counterStrategy' => $request->deckCounterStrategy,
                'deckType' => $request->deckType,
                'synergy' => $request->deckSynergy,
                'antiSynergy' => $request->deckAntiSynergy,
                'tips' => $request->deckTips
            ]);

            session()->flash('success', 'Faction (' . $deck->name . ', ID: ' . $deck->id . ') already exists, updated successfully!');
        }
        else {
            Deck::create([
                'name' => $request->deckName,
                'image' => $request->deckImage,
                'teaser' => $request->deckTeaser,
                'description' => $request->deckDescription,
                'strengths' => $request->deckStrengths,
                'weaknesses' => $request->deckWeaknesses,
                'strategy' => $request->deckStrategy,
                'counterStrategy' => $request->deckCounterStrategy,
                'deckType' => $request->deckType,
                'synergy' => $request->deckSynergy,
                'antiSynergy' => $request->deckAntiSynergy,
                'tips' => $request->deckTips
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
    public function delete(int $id): \Illuminate\Http\RedirectResponse
    {
        $deck = Deck::where('id', $id)->first();

        Deck::where('id', $id)->delete();

        session()->flash('success', 'Deleted faction (' . $deck->name . ', ID: ' . $deck->id . ') successfully!');

        return redirect()->route('decks-manager');
    }

    /**
     * Shuffle action to shuffle random factions and assign to players
     * @return \Illuminate\Contracts\View\View
     */
    public function shuffle(): \Illuminate\Contracts\View\View
    {
        $numberOfPlayers = $_GET['numberOfPlayers'];

        $decks = Deck::all();
        $selectedDecks = [];
        $playerPointer = 1;

        for ($i = 1; $i <= $numberOfPlayers; $i++) {
            $index = 1;
            $random1 = random_int(1, count($decks));
            while (!isset($decks[$random1])) {
                $random1 = random_int(1, count($decks));
            }

            $selectedDecks[$playerPointer][$index]['player'] = $i;
            $selectedDecks[$playerPointer][$index]['name'] = $decks[$random1]->name;
            $index++;
            unset($decks[$random1]);

            $random2 = random_int(1, count($decks));
            while (!isset($decks[$random2])) {
                $random2 = random_int(1, count($decks));
            }

            $selectedDecks[$playerPointer][$index]['player'] = $i;
            $selectedDecks[$playerPointer][$index]['name'] = $decks[$random2]->name;
            unset($decks[$random2]);

            $playerPointer++;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Request $request): \Illuminate\Http\RedirectResponse
    {
        $deck = Deck::where('name', $request->name)->first();

        Deck::where('name', $request->name)->update([
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
