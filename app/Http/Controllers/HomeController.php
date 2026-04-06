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
            ['id' => 1, 'src' => asset('images/landing/slide-01-ai-game-night.png')],
            ['id' => 2, 'src' => asset('images/landing/slide-02-ai-cards-table.png')],
            ['id' => 3, 'src' => asset('images/landing/slide-03-ai-friends-cards.png')],
            ['id' => 4, 'src' => asset('images/landing/slide-04-ai-smartphone.png')],
        ];

        return view('start.home', compact('factions', 'landingSlides'));
    }
}
