<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Deck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountCollectionController extends Controller
{
    /**
     * Show expansion checkboxes for the user's owned-sets collection.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $expansions = Deck::query()
            ->whereNotNull('expansion')
            ->where('expansion', '!=', '')
            ->distinct()
            ->orderBy('expansion')
            ->pluck('expansion')
            ->values();

        $selected = $user->userExpansions()->pluck('expansion')->all();

        return view('account.collection', [
            'user' => $user,
            'expansions' => $expansions,
            'selectedExpansions' => $selected,
        ]);
    }

    /**
     * Replace the user's owned expansion selection.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'expansions' => ['nullable', 'array'],
            'expansions.*' => ['string', 'max:191'],
        ]);

        $user = $request->user();
        $user->userExpansions()->delete();

        foreach ($validated['expansions'] ?? [] as $name) {
            if ($name === '') {
                continue;
            }
            $user->userExpansions()->create(['expansion' => $name]);
        }

        return redirect()
            ->route('account.collection')
            ->with('collection_status', __('frontend.account_collection_saved'));
    }
}
