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
            ['id' => 1, 'src' => asset('images/smashup_hero.png')],
            ['id' => 2, 'src' => asset('images/smashup_1.png')],
            ['id' => 3, 'src' => asset('images/smashup_2.png')],
            ['id' => 4, 'src' => asset('images/result.png')],
        ];

        return view('start.home', compact('factions', 'landingSlides'));
    }
}
