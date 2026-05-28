<?php

declare(strict_types=1);

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class DeckSeederTest extends TestCase
{
    private string $dataPath = __DIR__.'/../../database/data/factions';

    /**
     * Verify that every faction JSON file contains valid JSON and required fields.
     */
    public function test_all_json_files_are_valid(): void
    {
        $files = glob("{$this->dataPath}/*.json");

        $this->assertNotEmpty($files, 'No faction JSON files found.');

        foreach ($files as $file) {
            $content = file_get_contents($file);
            $factions = json_decode($content, true);

            $this->assertIsArray($factions, 'Invalid JSON in: '.basename($file));
            $this->assertNotEmpty($factions, 'Empty faction list in: '.basename($file));

            foreach ($factions as $faction) {
                $this->assertArrayHasKey('name', $faction, "Missing 'name' key in ".basename($file));
                $this->assertArrayHasKey('expansion', $faction, "Missing 'expansion' key in ".basename($file));
                $this->assertArrayHasKey('teaser', $faction, "Missing 'teaser' key in ".basename($file));
                $this->assertNotEmpty($faction['name'], "Empty 'name' in ".basename($file));
                $this->assertNotEmpty($faction['expansion'], "Empty 'expansion' in ".basename($file));
            }
        }
    }

    /**
     * Verify the total faction count across all JSON files equals 106.
     */
    public function test_total_faction_count_is_106(): void
    {
        $files = glob("{$this->dataPath}/*.json");
        $total = 0;

        foreach ($files as $file) {
            $factions = json_decode(file_get_contents($file), true);
            if (is_array($factions)) {
                $total += count($factions);
            }
        }

        $this->assertSame(106, $total);
    }

    /**
     * Verify all faction names within a single file are unique.
     */
    public function test_no_duplicate_names_within_files(): void
    {
        $files = glob("{$this->dataPath}/*.json");

        foreach ($files as $file) {
            $factions = json_decode(file_get_contents($file), true);
            if (! is_array($factions)) {
                continue;
            }

            $names = array_column($factions, 'name');
            $this->assertSame(
                count($names),
                count(array_unique($names)),
                'Duplicate faction names found in: '.basename($file)
            );
        }
    }

    /**
     * Verify all faction names across all files are globally unique.
     */
    public function test_no_duplicate_names_across_all_files(): void
    {
        $files = glob("{$this->dataPath}/*.json");
        $allNames = [];

        foreach ($files as $file) {
            $factions = json_decode(file_get_contents($file), true);
            if (! is_array($factions)) {
                continue;
            }
            $allNames = array_merge($allNames, array_column($factions, 'name'));
        }

        $this->assertSame(
            count($allNames),
            count(array_unique($allNames)),
            'Duplicate faction names found across JSON files.'
        );
    }
}
