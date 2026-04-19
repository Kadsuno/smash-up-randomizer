<?php

namespace Database\Seeders;

use App\Models\Deck;
use Illuminate\Database\Seeder;

class DeckSeeder extends Seeder
{
    /**
     * Seed all factions from versioned JSON data files.
     *
     * Each JSON file in database/data/factions/ contains an array of faction
     * objects mapping directly to Deck fillable fields. Runs idempotently via
     * updateOrCreate on the faction name.
     */
    public function run(): void
    {
        $dataPath = database_path('data/factions');
        $files = glob("{$dataPath}/*.json");

        if (empty($files)) {
            $this->command->warn('No faction JSON files found in database/data/factions/.');

            return;
        }

        $imported = 0;
        $updated = 0;

        foreach ($files as $file) {
            $factions = json_decode(file_get_contents($file), true);

            if (! is_array($factions)) {
                $this->command->warn('Skipping invalid JSON file: '.basename($file));

                continue;
            }

            foreach ($factions as $faction) {
                if (empty($faction['name'])) {
                    continue;
                }

                $name = $faction['name'];
                $attributes = array_filter(
                    $faction,
                    static fn (string $key) => $key !== 'name' && ! str_starts_with($key, '__'),
                    ARRAY_FILTER_USE_KEY
                );

                $deck = Deck::updateOrCreate(['name' => $name], $attributes);

                if ($deck->wasRecentlyCreated) {
                    $imported++;
                } else {
                    $updated++;
                }
            }
        }

        $this->command->info("Factions seeded: {$imported} created, {$updated} updated.");
    }
}
