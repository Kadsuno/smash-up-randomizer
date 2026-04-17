<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportFactionCsvRequest;
use App\Http\Requests\Admin\StoreFactionRequest;
use App\Http\Requests\Admin\UpdateFactionRequest;
use App\Models\Deck;
use App\Services\FactionRequestAttributes;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FactionDeckController extends Controller
{
    /**
     * Paginated faction list with filters for the admin deck manager.
     */
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));
        $filter = (string) $request->query('filter', 'all');
        $expansion = trim((string) $request->query('expansion', ''));

        $deckStats = [
            'total' => Deck::query()->count(),
            'with_teaser' => Deck::query()->whereNotNull('teaser')->where('teaser', '!=', '')->count(),
            'with_desc' => Deck::query()->whereNotNull('description')->where('description', '!=', '')->count(),
            'complete' => Deck::query()
                ->whereNotNull('teaser')->where('teaser', '!=', '')
                ->whereNotNull('description')->where('description', '!=', '')
                ->count(),
            'missing' => Deck::query()
                ->where(function ($query): void {
                    $query->where(function ($q2): void {
                        $q2->whereNull('teaser')->orWhere('teaser', '');
                    })->where(function ($q2): void {
                        $q2->whereNull('description')->orWhere('description', '');
                    });
                })
                ->count(),
        ];

        $expansionOptions = Deck::query()
            ->whereNotNull('expansion')
            ->where('expansion', '!=', '')
            ->distinct()
            ->orderBy('expansion')
            ->pluck('expansion');

        $query = Deck::query()->orderBy('name');

        if ($q !== '') {
            $query->where('name', 'like', '%'.$q.'%');
        }

        if ($expansion !== '') {
            $query->where('expansion', $expansion);
        }

        match ($filter) {
            'missing' => $query->where(function ($query): void {
                $query->where(function ($q2): void {
                    $q2->whereNull('teaser')->orWhere('teaser', '');
                })->where(function ($q2): void {
                    $q2->whereNull('description')->orWhere('description', '');
                });
            }),
            'has_teaser' => $query->whereNotNull('teaser')->where('teaser', '!=', ''),
            'has_desc' => $query->whereNotNull('description')->where('description', '!=', ''),
            default => null,
        };

        $decks = $query->paginate(25)->withQueryString();

        return view('backend.decks-manager', [
            'decks' => $decks,
            'deckStats' => $deckStats,
            'expansionOptions' => $expansionOptions,
            'filters' => [
                'q' => $q,
                'filter' => $filter,
                'expansion' => $expansion,
            ],
        ]);
    }

    /**
     * Show the "add faction" form.
     */
    public function create(): View
    {
        return view('decks.add');
    }

    /**
     * Create or update a faction by name (upsert when name already exists).
     */
    public function store(StoreFactionRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $name = $validated['name'];
        $payload = FactionRequestAttributes::payload($validated, $name);

        $deck = Deck::query()->where('name', $name)->first();

        if ($deck !== null) {
            $deck->update($payload);
            session()->flash('success', __('backend.flash_faction_updated_existing', ['name' => $deck->name, 'id' => $deck->id]));
        } else {
            $deck = Deck::query()->create($payload);
            session()->flash('success', __('backend.flash_faction_created', ['name' => $deck->name, 'id' => $deck->id]));
        }

        return redirect()->route('decks-manager');
    }

    /**
     * Import faction names from CSV (column index 1 per legacy format).
     */
    public function importCsv(ImportFactionCsvRequest $request): RedirectResponse
    {
        $file = $request->file('csv');
        if ($file === null) {
            return redirect()->route('decks-manager')->withErrors(['csv' => __('backend.deck_csv_invalid')]);
        }

        $path = $file->getRealPath();
        if ($path === false) {
            return redirect()->route('decks-manager')->withErrors(['csv' => __('backend.deck_csv_invalid')]);
        }

        $imported = 0;
        $handle = fopen($path, 'rb');
        if ($handle === false) {
            return redirect()->route('decks-manager')->withErrors(['csv' => __('backend.deck_csv_invalid')]);
        }

        try {
            while (($row = fgetcsv($handle)) !== false) {
                if (! isset($row[1]) || trim((string) $row[1]) === '') {
                    continue;
                }
                $deckName = trim((string) $row[1]);
                $exists = Deck::query()->where('name', $deckName)->exists();
                if ($exists) {
                    continue;
                }
                $imageUrl = rtrim((string) config('app.url'), '/').'/images/factions/'.strtolower($deckName).'.png';
                Deck::query()->create([
                    'name' => $deckName,
                    'image' => $imageUrl,
                ]);
                $imported++;
            }
        } finally {
            fclose($handle);
        }

        session()->flash('success', __('backend.flash_csv_imported', ['count' => $imported]));

        return redirect()->route('decks-manager');
    }

    /**
     * Remove a faction by name.
     */
    public function destroy(string $name): RedirectResponse
    {
        $deck = Deck::query()->where('name', $name)->firstOrFail();
        $label = $deck->name;
        $id = $deck->id;
        $deck->delete();

        session()->flash('success', __('backend.flash_faction_deleted', ['name' => $label, 'id' => $id]));

        return redirect()->route('decks-manager');
    }

    /**
     * Show edit form for a faction.
     */
    public function edit(string $name): View
    {
        $deck = Deck::query()->where('name', $name)->firstOrFail();

        return view('decks.edit', ['deck' => $deck]);
    }

    /**
     * Persist changes to a faction (including optional rename).
     */
    public function update(UpdateFactionRequest $request, string $name): RedirectResponse
    {
        $deck = Deck::query()->where('name', $name)->firstOrFail();
        $validated = $request->validated();
        $imageBase = $validated['name'];
        $payload = FactionRequestAttributes::payload($validated, $imageBase);
        $deck->update($payload);

        session()->flash('success', __('backend.flash_faction_updated', ['name' => $deck->name, 'id' => $deck->id]));

        return redirect()->route('decks-manager');
    }
}
