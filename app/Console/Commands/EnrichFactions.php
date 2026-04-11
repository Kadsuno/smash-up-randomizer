<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\WikitextParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class EnrichFactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factions:enrich
                            {--faction= : Enrich only a single faction by name}
                            {--skip-import : Update JSON files only; do not trigger factions:import}
                            {--dry-run : Print parsed fields without writing files or importing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch faction data from the Smash Up Wiki and enrich the JSON seed files, then import to DB.';

    private const WIKI_API = 'https://smashup.fandom.com/api.php';
    private const DELAY_MS = 300_000; // 300 ms between requests
    private const MAX_RETRIES = 3;

    /**
     * Execute the console command.
     */
    public function handle(WikitextParser $parser): int
    {
        $factions = $this->loadAllFactions();

        if (empty($factions)) {
            $this->error('No factions found in database/data/factions/. Run factions:import first.');
            return self::FAILURE;
        }

        $filterName = $this->option('faction');
        if ($filterName) {
            $factions = array_filter(
                $factions,
                static fn(array $f) => strcasecmp($f['name'], $filterName) === 0
            );

            if (empty($factions)) {
                $this->error("Faction \"{$filterName}\" not found in JSON files.");
                return self::FAILURE;
            }
        }

        $isDryRun = (bool) $this->option('dry-run');
        if ($isDryRun) {
            $this->warn('[Dry run] No files will be written or imported.');
        }

        $enriched = 0;
        $failed = 0;

        foreach ($factions as $faction) {
            $name = $faction['name'];
            $this->line("Fetching: <fg=yellow>{$name}</>");

            $wikitext = $this->fetchWikitext($name);

            if ($wikitext === null) {
                $this->warn("  → Wiki page not found or request failed for: {$name}");
                $failed++;
                usleep(self::DELAY_MS);
                continue;
            }

            $parsed = $parser->parse($wikitext);

            if (empty($parsed)) {
                $this->warn("  → No extractable content for: {$name}");
                usleep(self::DELAY_MS);
                continue;
            }

            if ($isDryRun) {
                foreach ($parsed as $field => $value) {
                    $preview = mb_substr(str_replace("\n", ' ', $value), 0, 80);
                    $this->line("  <fg=cyan>{$field}</>: {$preview}");
                }
                usleep(self::DELAY_MS);
                continue;
            }

            if ($this->updateJsonFile($faction, $parsed)) {
                $this->line("  → <fg=green>Updated</>");
                $enriched++;
            }

            usleep(self::DELAY_MS);
        }

        $this->newLine();
        $this->info("Done. Enriched: {$enriched}, failed: {$failed}.");

        if (!$isDryRun && !(bool) $this->option('skip-import')) {
            $this->info('Running factions:import...');
            return $this->call('factions:import');
        }

        return self::SUCCESS;
    }

    /**
     * Fetch the raw wikitext for a faction page from the MediaWiki API.
     * Retries up to MAX_RETRIES times with exponential backoff on 429 or timeout.
     *
     * @return string|null  Null if the page is missing or all retries failed.
     */
    private function fetchWikitext(string $factionName): ?string
    {
        $attempt = 0;
        $delay = self::DELAY_MS;

        while ($attempt < self::MAX_RETRIES) {
            try {
                $response = Http::timeout(15)->get(self::WIKI_API, [
                    'action' => 'parse',
                    'page'   => $factionName,
                    'prop'   => 'wikitext',
                    'format' => 'json',
                ]);

                if ($response->status() === 429) {
                    $attempt++;
                    usleep($delay);
                    $delay *= 2;
                    continue;
                }

                if (!$response->successful()) {
                    $attempt++;
                    usleep($delay);
                    $delay *= 2;
                    continue;
                }

                $data = $response->json();

                // API returns {"error":{"code":"missingtitle",...}} for unknown pages
                if (isset($data['error'])) {
                    return null;
                }

                return $data['parse']['wikitext']['*'] ?? null;

            } catch (\Exception) {
                $attempt++;
                usleep($delay);
                $delay *= 2;
            }
        }

        return null;
    }

    /**
     * Load all factions from all JSON files in database/data/factions/.
     * Each faction entry retains the '__file__' key pointing to its source file.
     *
     * @return array<int, array<string, mixed>>
     */
    private function loadAllFactions(): array
    {
        $dataPath = database_path('data/factions');
        $files = glob("{$dataPath}/*.json");
        $result = [];

        foreach ($files as $file) {
            $factions = json_decode(file_get_contents($file), true);
            if (!is_array($factions)) {
                continue;
            }
            foreach ($factions as $faction) {
                $faction['__file__'] = $file;
                $result[] = $faction;
            }
        }

        return $result;
    }

    /**
     * Merge parsed wiki fields into the faction's JSON file entry.
     * Only non-empty parsed values are written; existing non-empty fields are preserved.
     *
     * @param  array<string, mixed>   $faction  Original faction data (includes __file__)
     * @param  array<string, string>  $parsed   Fields extracted by WikitextParser
     */
    private function updateJsonFile(array $faction, array $parsed): bool
    {
        $file = $faction['__file__'];
        $factions = json_decode(file_get_contents($file), true);

        if (!is_array($factions)) {
            return false;
        }

        $updated = false;

        foreach ($factions as &$entry) {
            if ($entry['name'] !== $faction['name']) {
                continue;
            }

            foreach ($parsed as $field => $value) {
                // Only overwrite if the existing value is empty
                if (empty($entry[$field])) {
                    $entry[$field] = $value;
                    $updated = true;
                }
            }
        }
        unset($entry);

        if ($updated) {
            file_put_contents(
                $file,
                json_encode($factions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n"
            );
        }

        return $updated;
    }
}
