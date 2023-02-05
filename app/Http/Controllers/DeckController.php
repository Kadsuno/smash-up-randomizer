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
}