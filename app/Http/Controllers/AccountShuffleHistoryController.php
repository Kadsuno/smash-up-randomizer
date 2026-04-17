<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountShuffleHistoryController extends Controller
{
    /**
     * Recent shuffle results for the account.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        $history = $user->shuffleHistories()
            ->orderByDesc('created_at')
            ->limit(50)
            ->get();

        return view('account.history', [
            'user' => $user,
            'history' => $history,
        ]);
    }
}
