<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('admin', [AuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('admin', [AuthenticatedSessionController::class, 'store']);

    Route::get('admin/register', [RegisteredUserController::class, 'create'])
        ->name('admin.register');

    Route::post('admin/register', [RegisteredUserController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
