<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\Concerns\ManagesFactionJsonFiles;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FactionIcons extends Command
{
    use ManagesFactionJsonFiles;

    /**
     * @var string
     */
    protected $signature = 'factions:icons
                            {--faction= : Generate icon for only a single faction by name}
                            {--skip-import : Update JSON files only; do not trigger factions:import}
                            {--dry-run : Show what would be generated without writing}
                            {--force : Overwrite existing SVG files}';

    /**
     * @var string
     */
    protected $description = 'Download game-icons.net SVGs and generate coloured badge icons for each faction.';

    private const GITHUB_BASE = 'https://raw.githubusercontent.com/game-icons/icons/master';
    private const DELAY_MS    = 150_000; // 150 ms between downloads

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $mapping = $this->loadMapping();

        if (empty($mapping)) {
            $this->error('Icon mapping not found at database/data/faction-icons.json.');
            return self::FAILURE;
        }

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
                $this->error("Faction \"{$filterName}\" not found.");
                return self::FAILURE;
            }
        }

        $isDryRun = (bool) $this->option('dry-run');
        $force    = (bool) $this->option('force');

        if ($isDryRun) {
            $this->warn('[Dry run] No files will be written or updated.');
        }

        $iconDir = public_path('images/factions');
        if (!$isDryRun && !is_dir($iconDir)) {
            mkdir($iconDir, 0755, true);
        }

        $generated = 0;
        $skipped   = 0;
        $failed    = 0;

        foreach ($factions as $faction) {
            $name = $faction['name'];
            $def  = $mapping[$name] ?? null;

            if (!$def) {
                $this->warn("[skip] {$name}: not in icon mapping");
                $skipped++;
                continue;
            }

            $slug      = Str::slug($name);
            $localPath = "/images/factions/{$slug}.svg";
            $absPath   = public_path("images/factions/{$slug}.svg");

            if ($isDryRun) {
                $this->line("[dry]  <fg=cyan>{$name}</> → {$localPath}");
                $this->line("       icon={$def['icon']}  color={$def['color']}");
                continue;
            }

            if (!$force && file_exists($absPath)) {
                if (empty($faction['image']) || !str_ends_with((string) $faction['image'], '.svg')) {
                    $this->updateJsonFile($faction, ['image' => $localPath], false);
                }
                $this->line("[exists] {$name}");
                $skipped++;
                continue;
            }

            $svg = $this->buildBadgeSvg($def['icon'], $def['color']);

            if ($svg === null) {
                $this->warn("[fail]  {$name}: could not fetch icon {$def['icon']}");
                $failed++;
                usleep(self::DELAY_MS);
                continue;
            }

            file_put_contents($absPath, $svg);
            $this->updateJsonFile($faction, ['image' => $localPath], $force);
            $this->line("<fg=green>[ok]</>    {$name} → {$localPath}");
            $generated++;

            usleep(self::DELAY_MS);
        }

        $this->newLine();
        $this->info("Done. Generated: {$generated}, skipped: {$skipped}, failed: {$failed}.");

        if (!$isDryRun && !(bool) $this->option('skip-import')) {
            $this->info('Running factions:import...');
            return $this->call('factions:import');
        }

        return self::SUCCESS;
    }

    /**
     * Fetch a game-icons.net SVG from GitHub and recolour it as a badge.
     *
     * The source SVGs have this structure:
     *   <path d="M0 0h512v512H0z"/>           ← full-bleed background (black)
     *   <path fill="#fff" d="..."/>            ← the actual icon (white)
     *
     * We replace the background rectangle with a rounded-square in the faction
     * colour and keep the white icon path unchanged.
     *
     * @return string|null  Coloured SVG markup, or null on fetch failure.
     */
    private function buildBadgeSvg(string $iconPath, string $color): ?string
    {
        $url = self::GITHUB_BASE . '/' . $iconPath . '.svg';

        try {
            $response = Http::timeout(15)->get($url);

            if (!$response->successful()) {
                return null;
            }

            $svg = $response->body();

            // Replace the solid black background rect with a rounded-square badge
            $svg = preg_replace(
                '/<path\s+d="M0\s+0h512v512H0z"\s*\/>/',
                '<rect width="512" height="512" rx="96" ry="96" fill="' . htmlspecialchars($color, ENT_XML1) . '"/>',
                $svg
            );

            // Ensure the icon path stays white (some SVGs omit fill="#fff")
            if (!str_contains($svg, 'fill="#fff"') && !str_contains($svg, "fill='#fff'")) {
                $svg = str_replace('<path d="', '<path fill="#fff" d="', $svg);
            }

            return $svg;
        } catch (\Exception) {
            return null;
        }
    }

    /**
     * Load the faction → icon mapping from database/data/faction-icons.json.
     *
     * @return array<string, array{icon: string, color: string}>
     */
    private function loadMapping(): array
    {
        $file = database_path('data/faction-icons.json');

        if (!file_exists($file)) {
            return [];
        }

        return json_decode(file_get_contents($file), true) ?? [];
    }
}
