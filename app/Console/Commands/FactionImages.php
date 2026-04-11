<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\Concerns\ManagesFactionJsonFiles;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FactionImages extends Command
{
    use ManagesFactionJsonFiles;

    /**
     * @var string
     */
    protected $signature = 'factions:images
                            {--faction= : Download image for only a single faction by name}
                            {--skip-import : Update JSON files only; do not trigger factions:import}
                            {--dry-run : Show URLs without downloading or writing}
                            {--force : Re-download images even if the local file already exists}';

    /**
     * @var string
     */
    protected $description = 'Download faction images from the Smash Up Wiki and store them in public/images/factions/.';

    private const WIKI_API   = 'https://smashup.fandom.com/api.php';
    private const BATCH_SIZE = 50;
    private const DELAY_MS   = 250_000; // 250 ms between HTTP calls

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $factions = $this->loadAllFactions();

        if (empty($factions)) {
            $this->error('No factions found. Run factions:import first.');
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
        $force    = (bool) $this->option('force');

        if ($isDryRun) {
            $this->warn('[Dry run] No files will be downloaded or updated.');
        }

        // Ensure output directory exists
        $imageDir = public_path('images/factions');
        if (!$isDryRun && !is_dir($imageDir)) {
            mkdir($imageDir, 0755, true);
        }

        // Batch-fetch all image URLs upfront (2–3 API calls for all 106 factions)
        $this->info('Fetching image URLs from wiki...');
        $names     = array_column(array_values($factions), 'name');
        $imageUrls = $this->batchFetchImageUrls($names);
        $this->info(count($imageUrls) . ' image URLs found.');
        $this->newLine();

        $downloaded = 0;
        $skipped    = 0;
        $failed     = 0;

        foreach ($factions as $faction) {
            $name = $faction['name'];
            $url  = $imageUrls[$name] ?? null;

            if (!$url) {
                $this->warn("[skip] {$name}: no image found on wiki");
                $skipped++;
                continue;
            }

            $ext       = $this->extractExtension($url);
            $slug      = Str::slug($name);
            $localPath = "/images/factions/{$slug}.{$ext}";
            $absPath   = public_path("images/factions/{$slug}.{$ext}");

            if ($isDryRun) {
                $this->line("[dry]  <fg=cyan>{$name}</> → {$localPath}");
                $this->line("       <fg=gray>{$url}</>");
                continue;
            }

            if (!$force && file_exists($absPath)) {
                // File already there; ensure the JSON field is set
                if (empty($faction['image'])) {
                    $this->updateJsonFile($faction, ['image' => $localPath]);
                }
                $this->line("[exists] {$name}");
                $skipped++;
                continue;
            }

            try {
                $response = Http::timeout(30)->get($url);

                if (!$response->successful()) {
                    $this->warn("[fail]  {$name}: HTTP {$response->status()}");
                    $failed++;
                    usleep(self::DELAY_MS);
                    continue;
                }

                file_put_contents($absPath, $response->body());
                $this->updateJsonFile($faction, ['image' => $localPath], $force);
                $this->line("<fg=green>[ok]</>    {$name} → {$localPath}");
                $downloaded++;
            } catch (\Exception $e) {
                $this->warn("[fail]  {$name}: {$e->getMessage()}");
                $failed++;
            }

            usleep(self::DELAY_MS);
        }

        $this->newLine();
        $this->info("Done. Downloaded: {$downloaded}, skipped: {$skipped}, failed: {$failed}.");

        if (!$isDryRun && !(bool) $this->option('skip-import')) {
            $this->info('Running factions:import...');
            return $this->call('factions:import');
        }

        return self::SUCCESS;
    }

    /**
     * Batch-fetch image URLs for all factions using the MediaWiki pageimages API.
     * Handles the Unicode apostrophe fallback for names like "Grimms' Fairy Tales".
     *
     * @param  string[]  $names
     * @return array<string, string>  ['FactionName' => 'https://...']
     */
    private function batchFetchImageUrls(array $names): array
    {
        $result = [];

        // First pass: fetch all names as-is
        foreach (array_chunk($names, self::BATCH_SIZE) as $chunk) {
            $this->fetchImageUrlBatch($chunk, $result);
            usleep(self::DELAY_MS);
        }

        // Second pass: retry missing names with Unicode right-single-quotation-mark (U+2019)
        $missing = [];
        foreach ($names as $name) {
            if (!isset($result[$name])) {
                $unicode = str_replace("'", "\u{2019}", $name);
                if ($unicode !== $name) {
                    $missing[$unicode] = $name; // unicode → original
                }
            }
        }

        if (!empty($missing)) {
            $unicodeResult = [];
            foreach (array_chunk(array_keys($missing), self::BATCH_SIZE) as $chunk) {
                $this->fetchImageUrlBatch($chunk, $unicodeResult);
                usleep(self::DELAY_MS);
            }

            foreach ($missing as $unicode => $original) {
                if (isset($unicodeResult[$unicode])) {
                    $result[$original] = $unicodeResult[$unicode];
                }
            }
        }

        return $result;
    }

    /**
     * Perform a single pageimages batch request and populate $result in-place.
     *
     * @param  string[]               $names
     * @param  array<string, string>  $result
     */
    private function fetchImageUrlBatch(array $names, array &$result): void
    {
        try {
            $response = Http::timeout(15)->get(self::WIKI_API, [
                'action' => 'query',
                'prop'   => 'pageimages',
                'piprop' => 'original',
                'titles' => implode('|', $names),
                'format' => 'json',
            ]);

            if (!$response->successful()) {
                return;
            }

            $data = $response->json();

            // Build a map from normalized → original title so we can key by the
            // name string our caller passed, not by the wiki's normalized title.
            $normalized = [];
            foreach ($data['query']['normalized'] ?? [] as $norm) {
                $normalized[$norm['to']] = $norm['from'];
            }

            foreach ($data['query']['pages'] ?? [] as $page) {
                if (!isset($page['original']['source'])) {
                    continue;
                }

                $title          = $normalized[$page['title']] ?? $page['title'];
                $result[$title] = $page['original']['source'];
            }
        } catch (\Exception) {
            // Silently continue; missing pages will show as skipped
        }
    }

    /**
     * Extract the file extension from a Wikia CDN URL.
     * URL format: https://static.wikia.nocookie.net/smashup/images/x/xx/File.jpg/revision/latest?cb=...
     */
    private function extractExtension(string $url): string
    {
        if (preg_match('/\.([a-z]{3,4})\/revision/i', $url, $m)) {
            return strtolower($m[1]);
        }

        if (preg_match('/\.([a-z]{3,4})(?:\?|$)/i', $url, $m)) {
            return strtolower($m[1]);
        }

        return 'jpg';
    }
}
