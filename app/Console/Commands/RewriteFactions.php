<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Console\Concerns\ManagesFactionJsonFiles;
use App\Services\AiRewriteService;
use Illuminate\Console\Command;

class RewriteFactions extends Command
{
    use ManagesFactionJsonFiles;

    /**
     * Fields sourced from the wiki that benefit from an AI rewrite.
     * Excluded: teaser, mechanics, playstyle (own seed data),
     *           actions, characters, bases (factual card text, AEG IP),
     *           clarifications (official rulebook quotes).
     */
    private const REWRITABLE_FIELDS = [
        'description',
        'effects',
        'cardsTeaser',
        'actionTeaser',
        'synergy',
        'tips',
        'suggestionTeaser',
    ];

    /**
     * Groq free-tier limit: 30 requests/min → wait 2.1 s between calls.
     * Gemini free-tier limit: 15 requests/min → wait 4.2 s between calls.
     */
    private const RATE_LIMIT_MS = [
        'groq' => 2_100_000,
        'gemini' => 4_200_000,
        'default' => 2_000_000,
    ];

    /**
     * @var string
     */
    protected $signature = 'factions:rewrite
                            {--faction= : Rewrite only a single faction by name}
                            {--field=   : Rewrite only a specific field (e.g. description)}
                            {--skip-import : Update JSON files only; do not trigger factions:import}
                            {--dry-run  : Print prompt + AI output without writing files}
                            {--force    : Overwrite fields that have already been rewritten}';

    /**
     * @var string
     */
    protected $description = 'Rewrite wiki-scraped faction text fields using an AI provider (Groq or Gemini).';

    /**
     * Execute the console command.
     */
    public function handle(AiRewriteService $ai): int
    {
        if (! $ai->isConfigured()) {
            $this->error('AI_REWRITE_KEY is not set. Add it to .env (see .env.example for instructions).');

            return self::FAILURE;
        }

        $factions = $this->loadAllFactions();

        if (empty($factions)) {
            $this->error('No factions found. Run factions:import first.');

            return self::FAILURE;
        }

        // --- faction filter ---
        $filterFaction = $this->option('faction');
        if ($filterFaction) {
            $factions = array_filter(
                $factions,
                static fn (array $f) => strcasecmp($f['name'], $filterFaction) === 0
            );

            if (empty($factions)) {
                $this->error("Faction \"{$filterFaction}\" not found in JSON files.");

                return self::FAILURE;
            }
        }

        // --- field filter ---
        $filterField = $this->option('field');
        if ($filterField && ! in_array($filterField, self::REWRITABLE_FIELDS, true)) {
            $valid = implode(', ', self::REWRITABLE_FIELDS);
            $this->error("Unknown field \"{$filterField}\". Valid fields: {$valid}");

            return self::FAILURE;
        }

        $fields = $filterField ? [$filterField] : self::REWRITABLE_FIELDS;
        $isDryRun = (bool) $this->option('dry-run');
        $force = (bool) $this->option('force');

        if ($isDryRun) {
            $this->warn('[Dry run] No files will be written or imported.');
        }

        $this->info("Provider: {$ai->providerName()} | Fields: ".implode(', ', $fields));
        $this->newLine();

        $delay = self::RATE_LIMIT_MS[$ai->providerName()] ?? self::RATE_LIMIT_MS['default'];
        $rewritten = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($factions as $faction) {
            $name = $faction['name'];
            $expansion = $faction['expansion'] ?? '';
            $updates = [];

            foreach ($fields as $field) {
                $original = trim((string) ($faction[$field] ?? ''));

                if ($original === '') {
                    continue;
                }

                if (! $force && $this->isAlreadyRewritten($faction, $field)) {
                    $this->line("  [skip] {$name} / {$field}: already rewritten (use --force to redo)");
                    $skipped++;

                    continue;
                }

                if ($isDryRun) {
                    $preview = mb_substr(str_replace("\n", ' ', $original), 0, 100);
                    $this->line("  [dry]  <fg=cyan>{$name}</> / <fg=yellow>{$field}</>");
                    $this->line("         original: {$preview}…");

                    try {
                        $rewritten_text = $ai->rewrite($name, $expansion, $field, $original);
                        $this->line('         rewrite:  '.mb_substr(str_replace("\n", ' ', $rewritten_text), 0, 100).'…');
                    } catch (\Exception $e) {
                        $this->warn("         error: {$e->getMessage()}");
                    }

                    usleep($delay);

                    continue;
                }

                try {
                    $rewritten_text = $ai->rewrite($name, $expansion, $field, $original);

                    if ($rewritten_text === '') {
                        $this->warn("  [fail] {$name} / {$field}: AI returned empty response");
                        $failed++;
                        usleep($delay);

                        continue;
                    }

                    $updates[$field] = $rewritten_text;
                    $this->line("  <fg=green>[ok]</>   {$name} / {$field}");
                    $rewritten++;
                } catch (\Exception $e) {
                    $this->warn("  [fail] {$name} / {$field}: {$e->getMessage()}");
                    $failed++;
                }

                usleep($delay);
            }

            if (! $isDryRun && ! empty($updates)) {
                $this->writeRewrittenFields($faction, $updates);
            }
        }

        $this->newLine();
        $this->info("Done. Rewritten: {$rewritten}, skipped: {$skipped}, failed: {$failed}.");

        if (! $isDryRun && ! (bool) $this->option('skip-import')) {
            $this->info('Running factions:import...');

            return $this->call('factions:import');
        }

        return self::SUCCESS;
    }

    /**
     * Detect whether a field was already rewritten in a previous run.
     *
     * Rewrites are tracked in a "__rewritten" array stored in the JSON entry.
     * This prevents double-rewriting when the command is run again without --force.
     *
     * @param  array<string, mixed>  $faction
     */
    private function isAlreadyRewritten(array $faction, string $field): bool
    {
        return in_array($field, (array) ($faction['__rewritten'] ?? []), true);
    }

    /**
     * Write rewritten fields back to the JSON file, also updating the __rewritten
     * marker so subsequent runs without --force skip already-processed fields.
     *
     * @param  array<string, mixed>  $faction
     * @param  array<string, string>  $updates
     */
    private function writeRewrittenFields(array $faction, array $updates): void
    {
        $file = $faction['__file__'];
        $factions = json_decode(file_get_contents($file), true);

        if (! is_array($factions)) {
            return;
        }

        foreach ($factions as &$entry) {
            if ($entry['name'] !== $faction['name']) {
                continue;
            }

            foreach ($updates as $field => $value) {
                $entry[$field] = $value;
            }

            // Accumulate the list of rewritten fields for idempotency tracking
            $alreadyMarked = (array) ($entry['__rewritten'] ?? []);
            $entry['__rewritten'] = array_values(array_unique(
                array_merge($alreadyMarked, array_keys($updates))
            ));
        }
        unset($entry);

        file_put_contents(
            $file,
            json_encode($factions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n"
        );
    }
}
