<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
 
class DeckController extends Controller
{
    public function index()
    {


        $decks = DB::table('decks')->get();
 
        return view('backend.decks-manager', ['decks' => $decks]);
    }

    public function add()
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

    public function delete($name)
    {
        $deleted = DB::table('decks')->where('name', '=', $name)->delete();

        return redirect()->route('decks-manager');
    }

    public function shuffle()
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

        return view('start.shuffle-deck', ['selectedDecks' => $selectedDecks]);
    }
}