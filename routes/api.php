<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| API routes are loaded from `bootstrap/app.php` with the `api` middleware group.
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
