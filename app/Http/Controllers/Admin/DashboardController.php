<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Deck;
use App\Models\ShuffleHistory;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Admin dashboard with aggregate stats and quick links.
     */
    public function __invoke(): View
    {
        $total = Deck::query()->count();
        $withTeaser = Deck::query()->whereNotNull('teaser')->where('teaser', '!=', '')->count();
        $withDesc = Deck::query()->whereNotNull('description')->where('description', '!=', '')->count();
        $withoutDetails = Deck::query()
            ->where(function ($q): void {
                $q->where(function ($q2): void {
                    $q2->whereNull('teaser')->orWhere('teaser', '');
                })->where(function ($q2): void {
                    $q2->whereNull('description')->orWhere('description', '');
                });
            })
            ->count();

        $contactsTotal = Contact::query()->count();
        $usersTotal = User::query()->count();
        $adminsTotal = User::query()->where('role', 'admin')->count();
        $shuffleTotal = ShuffleHistory::query()->count();

        $shuffleByPlayers = ShuffleHistory::query()
            ->select('player_count', DB::raw('count(*) as cnt'))
            ->groupBy('player_count')
            ->orderBy('player_count')
            ->pluck('cnt', 'player_count')
            ->all();

        $recentContacts = Contact::query()
            ->latest()
            ->limit(5)
            ->get();

        return view('backend.dashboard', [
            'total' => $total,
            'withTeaser' => $withTeaser,
            'withDesc' => $withDesc,
            'withoutDetails' => $withoutDetails,
            'contactsTotal' => $contactsTotal,
            'usersTotal' => $usersTotal,
            'adminsTotal' => $adminsTotal,
            'shuffleTotal' => $shuffleTotal,
            'shuffleByPlayers' => $shuffleByPlayers,
            'recentContacts' => $recentContacts,
        ]);
    }
}
