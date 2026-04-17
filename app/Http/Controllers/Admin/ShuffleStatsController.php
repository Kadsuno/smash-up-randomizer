<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShuffleHistory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class ShuffleStatsController extends Controller
{
    /**
     * Aggregate shuffle history for admins.
     */
    public function __invoke(): View
    {
        $total = ShuffleHistory::query()->count();

        $byPlayers = ShuffleHistory::query()
            ->select('player_count', DB::raw('count(*) as cnt'))
            ->groupBy('player_count')
            ->orderBy('player_count')
            ->get();

        $recent = ShuffleHistory::query()
            ->with(['user:id,name,email'])
            ->latest()
            ->limit(50)
            ->get();

        return view('backend.shuffle-stats', [
            'total' => $total,
            'byPlayers' => $byPlayers,
            'recent' => $recent,
        ]);
    }
}
