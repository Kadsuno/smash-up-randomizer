<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RewriteFactionsCommandTest extends TestCase
{
    use RefreshDatabase;

    private const GROQ_RESPONSE = [
        'choices' => [
            [
                'message' => [
                    'content' => 'The Aliens are masters of abduction, yanking enemy forces from bases and scoring VP for their own returned minions.',
                ],
            ],
        ],
    ];

    protected function setUp(): void
    {
        parent::setUp();

        // Ensure an API key is configured for the tests
        config([
            'services.ai_rewrite.provider' => 'groq',
            'services.ai_rewrite.key' => 'test-key',
            'services.ai_rewrite.model' => 'llama-3.3-70b-versatile',
        ]);
    }

    // --- helpers ---

    private function fakeGroqSuccess(?string $text = null): void
    {
        $response = self::GROQ_RESPONSE;
        if ($text !== null) {
            $response['choices'][0]['message']['content'] = $text;
        }

        Http::fake(['*groq.com*' => Http::response($response, 200)]);
    }

    // --- tests ---

    public function test_fails_without_api_key(): void
    {
        config(['services.ai_rewrite.key' => '']);

        $this->artisan('factions:rewrite', [
            '--faction' => 'Aliens',
            '--skip-import' => true,
        ])->assertFailed();
    }

    public function test_fails_when_faction_not_found(): void
    {
        Http::fake();

        $this->artisan('factions:rewrite', [
            '--faction' => 'NonExistentFaction12345',
            '--skip-import' => true,
        ])->assertFailed();
    }

    public function test_fails_with_invalid_field_name(): void
    {
        Http::fake();

        $this->artisan('factions:rewrite', [
            '--field' => 'nonexistent_field',
            '--faction' => 'Aliens',
            '--skip-import' => true,
        ])->assertFailed();
    }

    public function test_dry_run_calls_api_but_does_not_write(): void
    {
        $this->fakeGroqSuccess();

        // Read the current description to verify it does not change
        $jsonPath = base_path('database/data/factions/core-set.json');
        $before = file_get_contents($jsonPath);
        $beforeData = json_decode($before, true);
        $aliens = collect($beforeData)->firstWhere('name', 'Aliens');
        $originalDesc = $aliens['description'] ?? '';

        $this->artisan('factions:rewrite', [
            '--faction' => 'Aliens',
            '--field' => 'description',
            '--dry-run' => true,
            '--skip-import' => true,
        ])->assertSuccessful();

        // JSON must be unchanged
        $afterData = json_decode(file_get_contents($jsonPath), true);
        $aliensAfter = collect($afterData)->firstWhere('name', 'Aliens');
        $this->assertSame($originalDesc, $aliensAfter['description']);
    }

    public function test_rewrites_field_and_marks_as_rewritten(): void
    {
        $newText = 'Aliens abduct minions and score points — a ruthless disruption machine.';
        $this->fakeGroqSuccess($newText);

        $jsonPath = base_path('database/data/factions/core-set.json');
        $before = json_decode(file_get_contents($jsonPath), true);

        $this->artisan('factions:rewrite', [
            '--faction' => 'Aliens',
            '--field' => 'description',
            '--force' => true,
            '--skip-import' => true,
        ])->assertSuccessful();

        $after = json_decode(file_get_contents($jsonPath), true);
        $aliensAfter = collect($after)->firstWhere('name', 'Aliens');

        $this->assertSame($newText, $aliensAfter['description']);
        $this->assertContains('description', $aliensAfter['__rewritten'] ?? []);

        // Restore original content to avoid polluting the real data
        file_put_contents($jsonPath, json_encode($before, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n");
    }

    public function test_skips_already_rewritten_fields_without_force(): void
    {
        $jsonPath = base_path('database/data/factions/core-set.json');
        $data = json_decode(file_get_contents($jsonPath), true);

        // Manually mark Aliens description as already rewritten
        foreach ($data as &$entry) {
            if ($entry['name'] === 'Aliens') {
                $entry['__rewritten'] = ['description'];
            }
        }
        unset($entry);
        file_put_contents($jsonPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n");

        Http::fake(); // No API calls expected

        $this->artisan('factions:rewrite', [
            '--faction' => 'Aliens',
            '--field' => 'description',
            '--skip-import' => true,
        ])
            ->expectsOutputToContain('already rewritten')
            ->assertSuccessful();

        Http::assertNothingSent();

        // Restore
        foreach ($data as &$entry) {
            if ($entry['name'] === 'Aliens') {
                unset($entry['__rewritten']);
            }
        }
        unset($entry);
        file_put_contents($jsonPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n");
    }

    public function test_handles_api_error_gracefully(): void
    {
        Http::fake(['*groq.com*' => Http::response(['error' => 'rate limit'], 429)]);

        $this->artisan('factions:rewrite', [
            '--faction' => 'Aliens',
            '--field' => 'description',
            '--force' => true,
            '--skip-import' => true,
        ])
            ->expectsOutputToContain('fail')
            ->assertSuccessful(); // Command itself should not fail, just log the error
    }
}
