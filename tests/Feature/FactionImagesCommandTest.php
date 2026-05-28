<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FactionImagesCommandTest extends TestCase
{
    use RefreshDatabase;

    private string $tmpDir;

    private string $tmpImageDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tmpDir = sys_get_temp_dir().'/smashup_images_test_'.uniqid();
        $this->tmpImageDir = sys_get_temp_dir().'/smashup_images_pub_'.uniqid();
        mkdir($this->tmpDir, 0755, true);
        mkdir($this->tmpImageDir, 0755, true);
    }

    protected function tearDown(): void
    {
        array_map('unlink', glob("{$this->tmpDir}/*.json") ?: []);
        array_map('unlink', glob("{$this->tmpImageDir}/*") ?: []);
        @rmdir($this->tmpDir);
        @rmdir($this->tmpImageDir);

        parent::tearDown();
    }

    // --- helpers ---

    private function makeJsonFile(string $factionName = 'Aliens'): string
    {
        $file = "{$this->tmpDir}/core-set.json";
        file_put_contents($file, json_encode([
            [
                'name' => $factionName,
                'expansion' => 'Core Set',
                'image' => '',
            ],
        ], JSON_PRETTY_PRINT)."\n");

        return $file;
    }

    /**
     * Fake the pageimages API to return a known URL for a given faction title.
     */
    private function fakePageImages(string $title, string $imageUrl): void
    {
        Http::fake([
            '*' => Http::response([
                'query' => [
                    'pages' => [
                        '1' => [
                            'pageid' => 1,
                            'title' => $title,
                            'original' => ['source' => $imageUrl, 'width' => 300, 'height' => 420],
                        ],
                    ],
                ],
            ]),
        ]);
    }

    // --- tests ---

    public function test_dry_run_shows_image_url_without_downloading(): void
    {
        $this->makeJsonFile();
        $imageUrl = 'https://static.wikia.nocookie.net/smashup/images/8/88/Invader.jpg/revision/latest?cb=123';
        $this->fakePageImages('Aliens', $imageUrl);

        $this->artisan('factions:images', [
            '--dry-run' => true,
            '--skip-import' => true,
        ])
            ->expectsOutputToContain('[Dry run]')
            ->expectsOutputToContain('/images/factions/aliens.jpg')
            ->assertSuccessful();
    }

    public function test_command_exits_successfully_with_mocked_http(): void
    {
        $imageUrl = 'https://static.wikia.nocookie.net/smashup/images/8/88/Invader.jpg/revision/latest?cb=123';

        Http::fake([
            '*' => Http::response([
                'query' => [
                    'pages' => [
                        '1' => [
                            'pageid' => 1,
                            'title' => 'Aliens',
                            'original' => ['source' => $imageUrl],
                        ],
                    ],
                ],
            ]),
        ]);

        $this->artisan('factions:images', [
            '--faction' => 'Aliens',
            '--dry-run' => true,
            '--skip-import' => true,
        ])->assertSuccessful();
    }

    public function test_skips_faction_with_no_wiki_image(): void
    {
        $this->makeJsonFile('Aliens');

        Http::fake([
            '*' => Http::response([
                'query' => ['pages' => ['-1' => ['pageid' => -1, 'title' => 'Aliens']]],
            ]),
        ]);

        $this->artisan('factions:images', [
            '--dry-run' => true,
            '--skip-import' => true,
        ])
            ->expectsOutputToContain('no image found on wiki')
            ->assertSuccessful();
    }

    public function test_filters_to_single_faction_via_option(): void
    {
        $this->makeJsonFile('Aliens');

        Http::fake([
            '*' => Http::response([
                'query' => [
                    'pages' => [
                        '1' => [
                            'pageid' => 1,
                            'title' => 'Aliens',
                            'original' => ['source' => 'https://example.com/aliens.jpg'],
                        ],
                    ],
                ],
            ]),
        ]);

        $this->artisan('factions:images', [
            '--faction' => 'Aliens',
            '--dry-run' => true,
            '--skip-import' => true,
        ])
            ->expectsOutputToContain('Aliens')
            ->assertSuccessful();
    }

    public function test_fails_when_faction_not_found(): void
    {
        $this->makeJsonFile('Aliens');
        Http::fake(); // shouldn't even be called

        $this->artisan('factions:images', ['--faction' => 'Nonexistent'])
            ->assertFailed();
    }
}
