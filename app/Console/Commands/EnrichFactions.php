<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\Concerns\ManagesFactionJsonFiles;
use App\Services\WikitextParser;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class EnrichFactions extends Command
{
    use ManagesFactionJsonFiles;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factions:enrich
                            {--faction= : Enrich only a single faction by name}
                            {--skip-import : Update JSON files only; do not trigger factions:import}
                            {--dry-run : Print parsed fields without writing files or importing}
                            {--force : Overwrite existing non-empty fields (useful after parser fixes)}';

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

            if ($this->updateJsonFile($faction, $parsed, (bool) $this->option('force'))) {
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
     * If the exact name returns a missing-page error, retries with Unicode apostrophe variant.
     *
     * @return string|null  Null if the page is missing or all retries failed.
     */
    private function fetchWikitext(string $factionName): ?string
    {
        // Some wiki pages use the Unicode right single quotation mark (U+2019) instead of ASCII apostrophe
        $namesToTry = array_unique([
            $factionName,
            str_replace("'", "\u{2019}", $factionName),
        ]);

        foreach ($namesToTry as $name) {
            $result = $this->fetchWikitextByName($name);
            if ($result !== null) {
                return $result;
            }
        }

        return null;
    }

    /**
     * Perform the actual HTTP fetch for a given page name.
     *
     * @return string|null  Null on missing page or repeated failure.
     */
    private function fetchWikitextByName(string $factionName): ?string
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


}
