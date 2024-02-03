<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\ContactController;

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

Route::get('/', function () {
    return view('start.home');
})->name('home');

Route::get('/help/smash-up', function () {
    return view('help.smash_up');
})->name('smash-up');

Route::get('/help/smash-up-randomizer', function () {
    return view('help.smash_up_randomizer');
})->name('smash-up-randomizer');

Route::get('/admin/backend', function () {
    return view('backend.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin/backend/decks-manager', [DeckController::class, 'index'
])->middleware(['auth'])->name('decks-manager');

Route::get('/admin/backend/decks-manager/add-deck', [DeckController::class, 'add'
])->middleware(['auth'])->name('add-deck');

Route::post('/admin/backend/decks-manager/add-deck-csv', [DeckController::class, 'addCsv'
])->middleware(['auth'])->name('add-deck-csv');

Route::get('/admin/backend/decks-manager/delete/{name}', [DeckController::class, 'delete'
])->middleware(['auth'])->name('delete-decks');

Route::get('/admin/backend/decks-manager/decks/{name}/edit', [DeckController::class, 'edit'
])->middleware(['auth'])->name('edit-deck');

Route::get('/shuffle', function () {
    return view('shuffle.form');
})->name('shuffle-form');

Route::get('/shuffle/result', [DeckController::class, 'shuffle'
])->name('shuffle-result');

Route::get('/imprint', function () {
    return view('components.layouts.bottom-navigation.imprint');
})->name('imprint');

Route::get('/privacy-policy', function () {
    return view('components.layouts.bottom-navigation.privacyPolicy');
})->name('privacyPolicy');

Route::get('contact-us', [ContactController::class, 'index'
])->name('contact');
Route::post('contact-us', [ContactController::class, 'store'
])->name('contact.us.store');

require __DIR__.'/auth.php';
