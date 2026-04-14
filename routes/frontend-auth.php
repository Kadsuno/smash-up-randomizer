<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Frontend\Auth\FrontendAuthenticatedSessionController;
use App\Http\Controllers\Frontend\Auth\FrontendEmailVerificationNotificationController;
use App\Http\Controllers\Frontend\Auth\FrontendEmailVerificationPromptController;
use App\Http\Controllers\Frontend\Auth\FrontendNewPasswordController;
use App\Http\Controllers\Frontend\Auth\FrontendPasswordResetLinkController;
use App\Http\Controllers\Frontend\Auth\FrontendRegisteredUserController;
use App\Http\Controllers\Frontend\Auth\FrontendVerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [FrontendRegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [FrontendRegisteredUserController::class, 'store']);

    Route::get('/login', [FrontendAuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [FrontendAuthenticatedSessionController::class, 'store']);

    Route::get('/forgot-password', [FrontendPasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('/forgot-password', [FrontendPasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [FrontendNewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('/reset-password', [FrontendNewPasswordController::class, 'store'])
        ->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/email/verify', [FrontendEmailVerificationPromptController::class, '__invoke'])
        ->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [FrontendVerifyEmailController::class, '__invoke'])
        ->middleware('signed')
        ->name('verification.verify');

    Route::post('/email/verification-notification', [FrontendEmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::post('/frontend-logout', [FrontendAuthenticatedSessionController::class, 'destroy'])
        ->name('frontend.logout');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/account', [AccountController::class, 'index'])
        ->name('account');

    Route::get('/account/edit', [AccountController::class, 'edit'])
        ->name('account.edit');

    Route::patch('/account/profile', [AccountController::class, 'updateProfile'])
        ->name('account.profile.update');

    Route::patch('/account/password', [AccountController::class, 'updatePassword'])
        ->name('account.password.update');
});
