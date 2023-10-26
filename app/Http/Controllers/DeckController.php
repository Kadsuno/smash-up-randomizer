<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Factory;

class DeckController extends Controller
{
    /**
     * Index action to send the factions
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        $decks = DB::table('decks')->get();

        return view('backend.decks-manager', ['decks' => $decks]);
    }

    /**
     * Add action to add new factions
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(): \Illuminate\Http\RedirectResponse
    {
        $deckExists = FALSE;

        if ($_GET['deckName'] != '') {
            $deckName = $_GET['deckName'];

            $decks = DB::table('decks')->get();

            foreach ($decks as $deck) {
                if ($deck->name == $deckName) {
                    $deckExists = TRUE;
                }
            }

            if (!$deckExists) {
                DB::table('decks')->insert([
                    'name' => $deckName
                ]);
            }
        }

        return redirect()->route('decks-manager');
    }

    /**
     * Delete action to delete a selected faction
     * @param string $name Name of the faction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(string $name): \Illuminate\Http\RedirectResponse
    {
        $deleted = DB::table('decks')->where('name', '=', $name)->delete();

        return redirect()->route('decks-manager');
    }

    /**
     * Shuffle action to shuffle random factions and assign to players
     * @return \Illuminate\Contracts\View\View
     */
    public function shuffle(): \Illuminate\Contracts\View\View
    {
        $numberOfPlayers = $_GET['numberOfPlayers'];

        $decks = DB::table('decks')->get();
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

                $decks = DB::table('decks')->get();

                foreach ($decks as $deck) {
                    if ($deck->name == $deckName) {
                        $deckExists = TRUE;
                    }
                }

                if (!$deckExists) {
                    DB::table('decks')->insert([
                        'name' => $deckName
                    ]);
                }
            }
        }

        return redirect()->route('decks-manager');
    }

    /**
     * Edit action to edit selected faction
     * @param string $name Name of the faction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(string $name): \Illuminate\Http\RedirectResponse
    {
        $deckName = $_GET['deckName'];
        
        $affected = DB::update(
            'update decks set name = "' . $deckName . '" where name = ?',
            [$name]
        );

        return redirect()->route('decks-manager');
    }
}
