<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FactionDeckController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ShuffleStatsController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\DeckController;
use App\Http\Controllers\SharedShuffleController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Web routes are loaded from `bootstrap/app.php` with the `web` middleware group.
|
*/

Route::get('/', [
    HomeController::class,
    'index'
])->name('home');

Route::middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/admin/backend', DashboardController::class)->name('dashboard');

    Route::get('/admin/backend/contacts', [ContactMessageController::class, 'index'])
        ->name('admin.contacts.index');
    Route::get('/admin/backend/contacts/{contact}', [ContactMessageController::class, 'show'])
        ->name('admin.contacts.show');

    Route::get('/admin/backend/users', [UserAdminController::class, 'index'])
        ->name('admin.users.index');
    Route::post('/admin/backend/users/role', [UserAdminController::class, 'updateRole'])
        ->name('admin.users.update-role');

    Route::get('/admin/backend/shuffle-stats', ShuffleStatsController::class)
        ->name('admin.shuffle-stats');

    Route::get('/admin/backend/maintenance', MaintenanceController::class)
        ->name('admin.maintenance');

    Route::get('/admin/backend/decks-manager', [FactionDeckController::class, 'index'])
        ->name('decks-manager');
    Route::get('/admin/backend/decks-manager/add-deck', [FactionDeckController::class, 'create'])
        ->name('add-deck');
    Route::post('/admin/backend/decks-manager/store-deck', [FactionDeckController::class, 'store'])
        ->name('store-deck');
    Route::post('/admin/backend/decks-manager/add-deck-csv', [FactionDeckController::class, 'importCsv'])
        ->name('add-deck-csv');
    Route::delete('/admin/backend/decks-manager/decks/{name}', [FactionDeckController::class, 'destroy'])
        ->name('delete-decks');
    Route::get('/admin/backend/decks-manager/decks/{name}/edit', [FactionDeckController::class, 'edit'])
        ->name('edit-deck');
    Route::post('/admin/backend/decks-manager/decks/{name}/update', [FactionDeckController::class, 'update'])
        ->name('update-deck');
});

Route::get('/shuffle', function () {
    return view('shuffle.form');
})->name('shuffle-form');

Route::post('/shuffle/result', [
    DeckController::class,
    'shuffle'
])->name('shuffle-result');

Route::get('/shuffle/share/{publicId}', [SharedShuffleController::class, 'show'])
    ->name('shuffle.share');

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

Route::get('/expansions', [
    DeckController::class,
    'expansions'
])->name('expansions');

Route::get('/expansions/{slug}', [
    DeckController::class,
    'expansion'
])->name('expansion');

Route::get('/random', [
    DeckController::class,
    'quickShuffle'
])->name('random');

Route::get('/about', function () {
    $factionCount = \App\Models\Deck::count();

    return view('legal.about', compact('factionCount'));
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

    $sitemap->add(Url::create('/expansions')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
        ->setPriority(0.9));

    $sitemap->add(Url::create('/random')
        ->setLastModificationDate(now())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
        ->setPriority(0.7));

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

    $expansionNames = \App\Models\Deck::whereNotNull('expansion')
        ->where('expansion', '!=', '')
        ->distinct()
        ->pluck('expansion');
    foreach ($expansionNames as $name) {
        $sitemap->add(Url::create('/expansions/' . \Illuminate\Support\Str::slug($name))
            ->setLastModificationDate(now())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            ->setPriority(0.7));
    }

    return $sitemap->toResponse(request());
});

require __DIR__ . '/auth.php';
require __DIR__ . '/frontend-auth.php';
