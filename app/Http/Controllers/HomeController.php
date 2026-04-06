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
            ['id' => 1, 'src' => asset('images/landing/slide-01-board-game-night.jpg')],
            ['id' => 2, 'src' => asset('images/landing/slide-02-cards-on-table.jpg')],
            ['id' => 3, 'src' => asset('images/landing/slide-03-group-card-game.jpg')],
            ['id' => 4, 'src' => asset('images/landing/slide-04-friends-smartphone.jpg')],
        ];

        return view('start.home', compact('factions', 'landingSlides'));
    }
}
