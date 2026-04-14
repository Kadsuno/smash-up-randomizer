<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ShufflePreset;
use App\Services\ShuffleDeckPool;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountShufflePresetController extends Controller
{
    public function __construct(
        private readonly ShuffleDeckPool $shufflePool
    ) {}

    /**
     * List presets and show create form.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $factions = $this->shufflePool->baseQuery($user)->orderBy('name')->get();

        return view('account.presets', [
            'user' => $user,
            'presets' => $user->shufflePresets()->orderBy('name')->get(),
            'factions' => $factions,
        ]);
    }

    /**
     * Store a new shuffle preset.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        $allowedNames = $this->shufflePool->baseQuery($user)->pluck('name')->all();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'player_count' => ['required', 'integer', 'in:2,3,4'],
            'include_factions' => ['nullable', 'array'],
            'include_factions.*' => ['string'],
            'exclude_factions' => ['nullable', 'array'],
            'exclude_factions.*' => ['string'],
        ]);

        $include = array_values(array_intersect($validated['include_factions'] ?? [], $allowedNames));
        $exclude = array_values(array_intersect($validated['exclude_factions'] ?? [], $allowedNames));

        $user->shufflePresets()->create([
            'name' => $validated['name'],
            'player_count' => $validated['player_count'],
            'include_factions' => $include === [] ? null : $include,
            'exclude_factions' => $exclude === [] ? null : $exclude,
        ]);

        return redirect()
            ->route('account.presets')
            ->with('preset_status', __('frontend.account_preset_saved'));
    }

    /**
     * Delete a preset.
     */
    public function destroy(Request $request, ShufflePreset $preset): RedirectResponse
    {
        if ($preset->user_id !== $request->user()->id) {
            abort(403);
        }

        $preset->delete();

        return redirect()
            ->route('account.presets')
            ->with('preset_status', __('frontend.account_preset_deleted'));
    }
}
