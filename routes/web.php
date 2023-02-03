<?php

use Illuminate\Support\Facades\Route;

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
    return view('index');
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

Route::get('/backend/decks-manager', function () {
    return view('backend.decks-manager');
})->middleware(['auth'])->name('decks-manager');

require __DIR__.'/auth.php';