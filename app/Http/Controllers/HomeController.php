<?php

namespace App\Http\Controllers;

use App\Models\Deck;

class HomeController extends Controller
{
    /**
     * Display the home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $factions = Deck::all();

        $landingSlides = [
            ['id' => 1, 'src' => asset('images/landing/slide-01-mashup-bases.png')],
            ['id' => 2, 'src' => asset('images/landing/slide-02-faction-stacks.png')],
            ['id' => 3, 'src' => asset('images/landing/slide-03-house-rules-table.png')],
            ['id' => 4, 'src' => asset('images/landing/slide-04-pairings-clear.png')],
        ];

        return view('start.home', compact('factions', 'landingSlides'));
    }
}
