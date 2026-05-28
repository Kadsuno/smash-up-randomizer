<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    /** Valid payload that passes all spam layers. */
    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name'    => 'Test User',
            'email'   => 'test@gmail.com',
            'subject' => 'Bug report',
            'message' => 'This is a valid test message with enough characters.',
            'context' => '',
        ], $overrides);
    }

    /** Seed the session timing key with a timestamp 10 seconds in the past. */
    private function seedTiming(int $secondsAgo = 10): void
    {
        session(['contact_form_start' => now()->timestamp - $secondsAgo]);
    }

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
        Cache::flush();
    }

    // -------------------------------------------------------------------------
    // GET /contact-us
    // -------------------------------------------------------------------------

    public function test_contact_form_is_accessible(): void
    {
        $response = $this->get('/contact-us');

        $response->assertOk();
        $response->assertSee('contact', false);
    }

    public function test_contact_page_seeds_session_timing(): void
    {
        $before = now()->timestamp;

        $this->get('/contact-us');

        $start = session('contact_form_start');
        $this->assertNotNull($start);
        $this->assertGreaterThanOrEqual($before, $start);
    }

    // -------------------------------------------------------------------------
    // POST /contact-us — happy path
    // -------------------------------------------------------------------------

    public function test_valid_submission_stores_contact_and_redirects(): void
    {
        $this->seedTiming();

        $response = $this->post('/contact-us', $this->validPayload());

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contacts', ['email' => 'test@gmail.com']);
    }

    // -------------------------------------------------------------------------
    // Honeypot
    // -------------------------------------------------------------------------

    public function test_honeypot_filled_is_rejected(): void
    {
        $this->seedTiming();

        $response = $this->post('/contact-us', $this->validPayload(['context' => 'bot-fill']));

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('contacts', ['email' => 'test@gmail.com']);
    }

    // -------------------------------------------------------------------------
    // Session-based timing
    // -------------------------------------------------------------------------

    public function test_submission_too_fast_is_rejected(): void
    {
        // Seed timing to "just now" so elapsed < 3 s.
        session(['contact_form_start' => now()->timestamp]);

        $response = $this->post('/contact-us', $this->validPayload());

        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertDatabaseMissing('contacts', ['email' => 'test@example.com']);
    }

    public function test_submission_without_session_timing_is_rejected(): void
    {
        // No call to seedTiming() → session key absent → defaults to 0 → always < 3 s.
        $response = $this->post('/contact-us', $this->validPayload());

        $response->assertRedirect();
        $response->assertSessionHas('error');
    }

    // -------------------------------------------------------------------------
    // Validation
    // -------------------------------------------------------------------------

    public function test_invalid_subject_is_rejected(): void
    {
        $this->seedTiming();

        $response = $this->post('/contact-us', $this->validPayload(['subject' => 'Spam subject']));

        $response->assertSessionHasErrors(['subject']);
    }

    public function test_message_too_short_is_rejected(): void
    {
        $this->seedTiming();

        $response = $this->post('/contact-us', $this->validPayload(['message' => 'Too short']));

        $response->assertSessionHasErrors(['message']);
    }

    public function test_invalid_email_syntax_is_rejected(): void
    {
        $this->seedTiming();

        $response = $this->post('/contact-us', $this->validPayload(['email' => 'not-an-email']));

        $response->assertSessionHasErrors(['email']);
    }

    public function test_required_fields_are_enforced(): void
    {
        $this->seedTiming();

        $response = $this->post('/contact-us', []);

        $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);
    }

    // -------------------------------------------------------------------------
    // Rate limiting
    // -------------------------------------------------------------------------

    public function test_rate_limit_blocks_after_five_requests(): void
    {
        // Make 5 valid submissions (each creates a DB record and consumes a rate-limit token).
        for ($i = 0; $i < 5; $i++) {
            $this->seedTiming();
            $this->post('/contact-us', $this->validPayload(['email' => "user{$i}@gmail.com"]));
        }

        // 6th request must be throttled.
        $this->seedTiming();
        $response = $this->post('/contact-us', $this->validPayload(['email' => 'user5@gmail.com']));

        $response->assertStatus(429);
    }

    // -------------------------------------------------------------------------
    // Turnstile (auto-passes in test environment)
    // -------------------------------------------------------------------------

    public function test_turnstile_is_bypassed_in_test_environment(): void
    {
        $this->seedTiming();

        // No cf-turnstile-response field — verifyTurnstile() returns true in testing env.
        $response = $this->post('/contact-us', $this->validPayload());

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
}
