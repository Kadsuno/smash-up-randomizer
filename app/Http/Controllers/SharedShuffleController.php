<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\SharedShuffleResult;
use Illuminate\Http\Response;

class SharedShuffleController extends Controller
{
    /**
     * Show a previously saved shuffle assignment by public id.
     *
     * @param  string  $publicId  Opaque ULID stored in `shared_shuffle_results.public_id`
     * @return \Illuminate\Http\Response Rendered shuffle result view or 404
     */
    public function show(string $publicId): Response
    {
        $shared = SharedShuffleResult::query()->where('public_id', $publicId)->first();

        if ($shared === null) {
            abort(404);
        }

        /** @var array<int, array<int, array{name: string}>> $selectedDecks */
        $selectedDecks = $shared->results;

        return response()->view('shuffle.shuffle-decks', [
            'selectedDecks' => $selectedDecks,
            'sharePublicId' => $shared->public_id,
            'sharePlainText' => SharedShuffleResult::plainTextSummary($selectedDecks),
            'metaRobots' => 'noindex, follow',
        ]);
    }
}
