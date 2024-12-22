<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
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

Route::get('/', [
    HomeController::class,
    'index'
])->name('home');

Route::get('/admin/backend', function () {
    return view('backend.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin/backend/decks-manager', [
    DeckController::class,
    'index'
])->middleware(['auth'])->name('decks-manager');

Route::get('/admin/backend/decks-manager/add-deck', [
    DeckController::class,
    'add'
])->middleware(['auth'])->name('add-deck');

Route::post('/admin/backend/decks-manager/store-deck', [
    DeckController::class,
    'store'
])->middleware(['auth'])->name('store-deck');

Route::post('/admin/backend/decks-manager/add-deck-csv', [
    DeckController::class,
    'addCsv'
])->middleware(['auth'])->name('add-deck-csv');

Route::get('/admin/backend/decks-manager/delete/{name}', [
    DeckController::class,
    'delete'
])->middleware(['auth'])->name('delete-decks');

Route::get('/admin/backend/decks-manager/decks/{name}/edit', [
    DeckController::class,
    'edit'
])->middleware(['auth'])->name('edit-deck');

Route::post('/admin/backend/decks-manager/decks/{name}/update', [
    DeckController::class,
    'update'
])->middleware(['auth'])->name('update-deck');

Route::get('/shuffle', function () {
    return view('shuffle.form');
})->name('shuffle-form');

Route::post('/shuffle/result', [
    DeckController::class,
    'shuffle'
])->name('shuffle-result');

Route::get('/imprint', function () {
    return view('legal.imprint');
})->name('imprint');

Route::get('/privacy-policy', function () {
    return view('legal.privacyPolicy');
})->name('privacy-policy');

Route::get('contact-us', [
    ContactController::class,
    'index'
])->name('contact');
Route::post('contact-us', [
    ContactController::class,
    'store'
])
    ->middleware('throttle:5,1')
    ->name('contact.us.store');

Route::get('/factions', [
    DeckController::class,
    'list'
])->name('factionList');

Route::get('/factions/{name}', [
    DeckController::class,
    'detail'
])->name('factionDetail');

Route::get('/about', function () {
    return view('legal.about');
})->name('about');

Route::get('/sitemap', function () {
    $sitemap = Sitemap::create();

    // Beispiel: Seiten hinzufügen
    $sitemap->add(Url::create('/')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        ->setPriority(1.0));

    $sitemap->add(Url::create('/factions')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        ->setPriority(1.0));

    $sitemap->add(Url::create('/about')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        ->setPriority(1.0));

    $sitemap->add(Url::create('/contact-us')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        ->setPriority(1.0));

    $sitemap->add(Url::create('/imprint')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        ->setPriority(1.0));

    $sitemap->add(Url::create('/privacy-policy')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
        ->setPriority(1.0));

    // Fügen Sie dynamische Seiten, z. B. aus Ihrer Datenbank, hinzu
    $decks = \App\Models\Deck::all();
    $date = null;
    foreach ($decks as $deck) {
        if ($deck->updated_at) {
            $date = $deck->updated_at;
        } else {
            $date = now();
        }

        $sitemap->add(Url::create("/factions/{$deck->name}")
            ->setLastModificationDate($date)
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.8));
    }

    return $sitemap->toResponse(request());
});

require __DIR__ . '/auth.php';
