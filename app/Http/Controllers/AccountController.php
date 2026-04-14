<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('account.index', [
            'user' => $user,
            'statOwnedExpansions' => $user->userExpansions()->count(),
            'statShuffleCount' => $user->shuffleHistories()->count(),
            'statPresetCount' => $user->shufflePresets()->count(),
        ]);
    }

    public function edit(Request $request): View
    {
        return view('account.edit', [
            'user' => $request->user(),
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $emailChanged = $validated['email'] !== $user->email;

        $user->fill($validated);

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($emailChanged) {
            $user->sendEmailVerificationNotification();

            return redirect()->route('verification.notice')
                ->with('status', __('frontend.account_profile_email_changed'));
        }

        return redirect()->route('account.edit')->with('profile_status', __('frontend.account_profile_saved'));
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->password === null) {
            return redirect()->route('account.edit')->withErrors(
                ['current_password' => __('frontend.account_password_oauth_only')],
                'passwordErrors'
            );
        }

        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'confirmed', Password::min(8)],
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return redirect()->route('account.edit')->withErrors(
                ['current_password' => __('frontend.account_password_wrong_current')],
                'passwordErrors'
            );
        }

        $user->update(['password' => Hash::make($request->password)]);

        return redirect()->route('account.edit')->with('password_status', __('frontend.account_password_saved'));
    }
}
