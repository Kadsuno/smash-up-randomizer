<?php

declare(strict_types=1);

namespace App\Console\Concerns;

/**
 * Shared JSON-file management helpers for Artisan commands that operate on
 * the faction seed files in database/data/factions/.
 *
 * Commands using this trait must be Illuminate\Console\Command instances so
 * that $this->option() is available.
 */
trait ManagesFactionJsonFiles
{
    /**
     * Load all factions from every JSON file in database/data/factions/.
     * Each entry gets a '__file__' key so callers know which file to update.
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
            if (! is_array($factions)) {
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
     * Merge $fields into the matching faction entry inside its JSON file.
     *
     * By default, only empty fields are overwritten; pass $force = true to
     * overwrite all fields regardless of current value.
     *
     * @param  array<string, mixed>  $faction  Faction data incl. '__file__' key
     * @param  array<string, string>  $fields  Fields to write
     */
    private function updateJsonFile(array $faction, array $fields, bool $force = false): bool
    {
        $file = $faction['__file__'];
        $factions = json_decode(file_get_contents($file), true);

        if (! is_array($factions)) {
            return false;
        }

        $updated = false;

        foreach ($factions as &$entry) {
            if ($entry['name'] !== $faction['name']) {
                continue;
            }

            foreach ($fields as $field => $value) {
                if (empty($entry[$field]) || $force) {
                    $entry[$field] = $value;
                    $updated = true;
                }
            }
        }
        unset($entry);

        if ($updated) {
            file_put_contents(
                $file,
                json_encode($factions, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n"
            );
        }

        return $updated;
    }
}
