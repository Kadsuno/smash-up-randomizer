<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth\Concerns;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

trait RedirectsAfterFrontendAuth
{
    /**
     * Redirect the authenticated frontend user to the appropriate home (admin dashboard, verification, or account).
     */
    protected function redirectAfterFrontendAuthenticated(): RedirectResponse
    {
        $user = Auth::user();
        if ($user === null) {
            return redirect()->route('login');
        }

        if ($user->isAdmin()) {
            return redirect()->intended(route('dashboard'));
        }

        if (! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }

        return redirect()->intended(route('account'));
    }
}
