<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
 
class DeckController extends Controller
{
    public function index()
    {
        $deckExists = FALSE;

        if (isset($_GET['deckName']) && $_GET['deckName'] != '') {
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

        $decks = DB::table('decks')->get();
 
        return view('backend.decks-manager', ['decks' => $decks, 'deckExists' => $deckExists]);
    }
}