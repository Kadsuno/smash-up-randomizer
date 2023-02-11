<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeckController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::get('/', function () {
    return view('start.home');
})->name('home');

Route::get('/help/smash-up', function () {
    return view('help.smash_up');
})->name('smash-up');

Route::get('/help/smash-up-randomizer', function () {
    return view('help.smash_up_randomizer');
})->name('smash-up-randomizer');

Route::get('/backend', function () {
    return view('backend.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/backend/decks-manager', [DeckController::class, 'index'
])->middleware(['auth'])->name('decks-manager');

Route::get('/backend/decks-manager/add-deck', [DeckController::class, 'add'
])->middleware(['auth'])->name('add-deck');

Route::get('/backend/decks-manager/delete/{name}', [DeckController::class, 'delete'
])->middleware(['auth'])->name('delete-decks');

Route::get('/shuffle', [DeckController::class, 'shuffle'
])->name('shuffle-decks');

Route::get('/imprint', function () {
    return view('components.layouts.bottom-navigation.imprint');
})->name('imprint');

require __DIR__.'/auth.php';
