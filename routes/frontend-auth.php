<?php

use App\Http\Controllers\AccountCollectionController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountShuffleHistoryController;
use App\Http\Controllers\AccountShufflePresetController;
use App\Http\Controllers\AccountTwoFactorController;
use App\Http\Controllers\Frontend\Auth\FrontendAuthenticatedSessionController;
use App\Http\Controllers\Frontend\Auth\FrontendEmailVerificationNotificationController;
use App\Http\Controllers\Frontend\Auth\FrontendEmailVerificationPromptController;
use App\Http\Controllers\Frontend\Auth\FrontendNewPasswordController;
use App\Http\Controllers\Frontend\Auth\FrontendPasswordResetLinkController;
use App\Http\Controllers\Frontend\Auth\FrontendRegisteredUserController;
use App\Http\Controllers\Frontend\Auth\FrontendSocialAuthController;
use App\Http\Controllers\Frontend\Auth\FrontendTwoFactorChallengeController;
use App\Http\Controllers\Frontend\Auth\FrontendVerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/auth/{provider}/redirect', [FrontendSocialAuthController::class, 'redirect'])
        ->whereIn('provider', ['google', 'github'])
        ->name('social.redirect');

    Route::get('/auth/{provider}/callback', [FrontendSocialAuthController::class, 'callback'])
        ->whereIn('provider', ['google', 'github'])
        ->name('social.callback');

    Route::get('/register', [FrontendRegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [FrontendRegisteredUserController::class, 'store']);

    Route::get('/login', [FrontendAuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('/login', [FrontendAuthenticatedSessionController::class, 'store']);

    Route::middleware('two-factor.pending')->group(function () {
        Route::get('/login/two-factor', [FrontendTwoFactorChallengeController::class, 'create'])
            ->name('two-factor.login');

        Route::post('/login/two-factor', [FrontendTwoFactorChallengeController::class, 'store'])
            ->middleware('throttle:10,1')
            ->name('two-factor.login.store');
    });

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

    Route::post('/account/two-factor/start', [AccountTwoFactorController::class, 'start'])
        ->name('account.two-factor.start');

    Route::get('/account/two-factor/setup', [AccountTwoFactorController::class, 'showSetup'])
        ->name('account.two-factor.setup');

    Route::post('/account/two-factor/confirm', [AccountTwoFactorController::class, 'confirm'])
        ->name('account.two-factor.confirm');

    Route::post('/account/two-factor/cancel', [AccountTwoFactorController::class, 'cancelSetup'])
        ->name('account.two-factor.cancel');

    Route::post('/account/two-factor/disable', [AccountTwoFactorController::class, 'disable'])
        ->name('account.two-factor.disable');

    Route::post('/account/two-factor/recovery-codes', [AccountTwoFactorController::class, 'regenerateRecoveryCodes'])
        ->name('account.two-factor.recovery-codes');

    Route::get('/account/collection', [AccountCollectionController::class, 'edit'])
        ->name('account.collection');

    Route::put('/account/collection', [AccountCollectionController::class, 'update'])
        ->name('account.collection.update');

    Route::get('/account/presets', [AccountShufflePresetController::class, 'index'])
        ->name('account.presets');

    Route::post('/account/presets', [AccountShufflePresetController::class, 'store'])
        ->name('account.presets.store');

    Route::delete('/account/presets/{preset}', [AccountShufflePresetController::class, 'destroy'])
        ->name('account.presets.destroy');

    Route::get('/account/history', [AccountShuffleHistoryController::class, 'index'])
        ->name('account.history');
});
