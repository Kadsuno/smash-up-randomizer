<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\ShufflePreset;
use App\Services\ShuffleDeckPool;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(
        private readonly ShuffleDeckPool $shufflePool
    ) {}

    /**
     * Display the home page (shuffle wizard uses faction list filtered by the user's collection when set).
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $shufflePresetPayload = null;
        $openShuffleWithPreset = false;

        if ($user !== null && $request->filled('shuffle_preset')) {
            $preset = ShufflePreset::query()
                ->where('user_id', $user->id)
                ->find($request->integer('shuffle_preset'));
            if ($preset !== null) {
                $shufflePresetPayload = [
                    'player_count' => $preset->player_count,
                    'include' => $preset->include_factions ?? [],
                    'exclude' => $preset->exclude_factions ?? [],
                ];
                $openShuffleWithPreset = true;
            }
        }

        $factions = $this->shufflePool->baseQuery($user)->orderBy('name')->get();

        return view('start.home', compact(
            'factions',
            'shufflePresetPayload',
            'openShuffleWithPreset'
        ));
    }
}
