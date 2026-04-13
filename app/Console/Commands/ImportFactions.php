<?php

namespace App\Console\Commands;

use App\Models\Deck;
use Illuminate\Console\Command;

class ImportFactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factions:import
                            {--dry-run : Preview changes without writing to the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all factions from database/data/factions/*.json into the decks table (idempotent).';

    /**
     * Execute the console command.
     *
     * Reads every JSON file in database/data/factions/, then calls
     * updateOrCreate on each faction keyed by name. Safe to re-run at any
     * time without creating duplicate rows.
     */
    public function handle(): int
    {
        $isDryRun = (bool) $this->option('dry-run');
        $dataPath = database_path('data/factions');
        $files = glob("{$dataPath}/*.json");

        if (empty($files)) {
            $this->error('No faction JSON files found in database/data/factions/.');
            return self::FAILURE;
        }

        $imported = 0;
        $updated = 0;
        $skipped = 0;

        if ($isDryRun) {
            $this->warn('[Dry run] No changes will be written to the database.');
        }

        foreach ($files as $file) {
            $factions = json_decode(file_get_contents($file), true);

            if (!is_array($factions)) {
                $this->warn('Skipping invalid JSON: ' . basename($file));
                continue;
            }

            foreach ($factions as $faction) {
                if (empty($faction['name'])) {
                    $skipped++;
                    continue;
                }

                $name = $faction['name'];
                $attributes = array_filter(
                    $faction,
                    static fn(string $key) => $key !== 'name' && !str_starts_with($key, '__'),
                    ARRAY_FILTER_USE_KEY
                );

                if ($isDryRun) {
                    $exists = Deck::where('name', $name)->exists();
                    $this->line(($exists ? '[update] ' : '[create] ') . $name);
                    $exists ? $updated++ : $imported++;
                    continue;
                }

                $deck = Deck::updateOrCreate(['name' => $name], $attributes);

                if ($deck->wasRecentlyCreated) {
                    $imported++;
                    $this->line("<fg=green>[created]</> {$name}");
                } else {
                    $updated++;
                    $this->line("<fg=cyan>[updated]</> {$name}");
                }
            }
        }

        $this->newLine();
        $this->info("Done. Created: {$imported}, updated: {$updated}, skipped: {$skipped}.");

        return self::SUCCESS;
    }
}
