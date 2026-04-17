<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class EnrichFactionsCommandTest extends TestCase
{
    use RefreshDatabase;

    private string $aliensWikitext;
    private string $tmpDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->aliensWikitext = file_get_contents(base_path('tests/Fixtures/aliens-wikitext.txt'));

        // Create a temporary data directory with a minimal JSON file for testing
        $this->tmpDir = sys_get_temp_dir() . '/smashup_enrich_test_' . uniqid();
        mkdir($this->tmpDir, 0755, true);
    }

    protected function tearDown(): void
    {
        // Clean up temp files
        array_map('unlink', glob("{$this->tmpDir}/*.json"));
        @rmdir($this->tmpDir);

        parent::tearDown();
    }

    // --- Helper ---

    /**
     * Write a minimal faction JSON to the real data path for integration-style tests,
     * but mock the HTTP call to avoid real network requests.
     */
    private function mockWikiResponse(string $factionName, ?string $wikitext = null): void
    {
        if ($wikitext === null) {
            Http::fake([
                '*' => Http::response(['error' => ['code' => 'missingtitle']], 200),
            ]);
            return;
        }

        Http::fake([
            '*' => Http::response([
                'parse' => [
                    'title'    => $factionName,
                    'wikitext' => ['*' => $wikitext],
                ],
            ], 200),
        ]);
    }

    // --- Exit codes ---

    public function test_command_exits_successfully_with_skip_import(): void
    {
        $this->mockWikiResponse('Aliens', $this->aliensWikitext);

        $this->artisan('factions:enrich', [
            '--faction'     => 'Aliens',
            '--skip-import' => true,
            '--dry-run'     => true,
        ])->assertExitCode(0);
    }

    public function test_command_fails_when_faction_not_found_in_json(): void
    {
        $this->artisan('factions:enrich', ['--faction' => 'NonExistentFaction12345'])
            ->assertExitCode(1);
    }

    // --- Dry run ---

    public function test_dry_run_does_not_modify_json_files(): void
    {
        $this->mockWikiResponse('Aliens', $this->aliensWikitext);

        // Capture the modification time before
        $dataPath = database_path('data/factions');
        $jsonFile = $dataPath . '/core-set.json';
        $mtimeBefore = filemtime($jsonFile);

        $this->artisan('factions:enrich', [
            '--faction'  => 'Aliens',
            '--dry-run'  => true,
        ])->assertExitCode(0);

        clearstatcache(true, $jsonFile);
        $this->assertSame($mtimeBefore, filemtime($jsonFile), 'JSON file was modified during dry run');
    }

    // --- Missing wiki page ---

    public function test_command_warns_and_continues_when_wiki_page_missing(): void
    {
        $this->mockWikiResponse('Aliens', null); // triggers missingtitle error

        $this->artisan('factions:enrich', ['--faction' => 'Aliens', '--skip-import' => true])
            ->assertExitCode(0)
            ->expectsOutputToContain('not found');
    }

    // --- HTTP 500 / failure handling ---

    public function test_command_handles_http_failure_gracefully(): void
    {
        Http::fake([
            '*' => Http::response(null, 500),
        ]);

        $this->artisan('factions:enrich', ['--faction' => 'Aliens', '--skip-import' => true])
            ->assertExitCode(0);
    }

    // --- JSON file enrichment ---

    public function test_command_enriches_json_file_with_wiki_data(): void
    {
        $this->mockWikiResponse('Aliens', $this->aliensWikitext);

        $jsonFile = database_path('data/factions/core-set.json');
        $originalData = json_decode(file_get_contents($jsonFile), true);

        // Explicitly clear enrichable fields on Aliens so the test is state-independent
        $cleanData = array_map(static function (array $f) {
            if ($f['name'] === 'Aliens') {
                $f['description'] = '';
                $f['characters']  = '';
                $f['synergy']     = '';
            }
            return $f;
        }, $originalData);
        file_put_contents(
            $jsonFile,
            json_encode($cleanData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n"
        );

        $this->artisan('factions:enrich', [
            '--faction'     => 'Aliens',
            '--skip-import' => true,
        ])->assertExitCode(0);

        $updatedData = json_decode(file_get_contents($jsonFile), true);
        $aliensAfter = collect($updatedData)->firstWhere('name', 'Aliens');

        $this->assertNotEmpty($aliensAfter['description']);
        $this->assertNotEmpty($aliensAfter['characters']);
        $this->assertNotEmpty($aliensAfter['synergy']);

        // Restore original file
        file_put_contents(
            $jsonFile,
            json_encode($originalData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n"
        );
    }

    public function test_command_does_not_overwrite_non_empty_fields(): void
    {
        $this->mockWikiResponse('Aliens', $this->aliensWikitext);

        $jsonFile = database_path('data/factions/core-set.json');
        $originalData = json_decode(file_get_contents($jsonFile), true);

        // Pre-fill the teaser with a custom value
        $customTeaser = 'My custom teaser that should not be overwritten.';
        foreach ($originalData as &$entry) {
            if ($entry['name'] === 'Aliens') {
                $entry['teaser'] = $customTeaser;
            }
        }
        unset($entry);
        file_put_contents(
            $jsonFile,
            json_encode($originalData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "\n"
        );

        $this->artisan('factions:enrich', [
            '--faction'     => 'Aliens',
            '--skip-import' => true,
        ])->assertExitCode(0);

        $updatedData = json_decode(file_get_contents($jsonFile), true);
        $aliensAfter = collect($updatedData)->firstWhere('name', 'Aliens');

        $this->assertSame($customTeaser, $aliensAfter['teaser']);

        // Restore original file
        file_put_contents(
            $jsonFile,
            json_encode(
                collect($originalData)->map(static function (array $f) use ($customTeaser) {
                    if ($f['name'] === 'Aliens') {
                        $f['teaser'] = 'Return minions in play to their owners\' hands, gain a bonus for returning your own, and manipulate bases.';
                    }
                    return $f;
                })->all(),
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
            ) . "\n"
        );
    }

    // --- --skip-import flag ---

    public function test_skip_import_flag_does_not_call_factions_import(): void
    {
        $this->mockWikiResponse('Aliens', $this->aliensWikitext);

        // Use --dry-run so no JSON files are modified; --skip-import is the subject under test.
        // If factions:import were called despite both flags it would touch the DB.
        $this->artisan('factions:enrich', [
            '--faction'     => 'Aliens',
            '--skip-import' => true,
            '--dry-run'     => true,
        ])->assertExitCode(0);

        // Database should be untouched (RefreshDatabase gives us empty DB)
        $this->assertDatabaseCount('decks', 0);
    }
}
