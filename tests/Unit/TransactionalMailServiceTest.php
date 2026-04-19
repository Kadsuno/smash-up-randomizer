<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Services\TransactionalMailService;
use Illuminate\Support\Facades\Mail;
use Mockery;
use Tests\TestCase;

class TransactionalMailServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * Mail::fake() does not record closure-based Mail::send(); assert the facade is invoked.
     */
    public function test_send_invokes_mail_facade_with_plain_body(): void
    {
        Mail::shouldReceive('send')
            ->once()
            ->with([], [], Mockery::type('Closure'));

        $service = new TransactionalMailService;
        $ok = $service->send('recipient@example.com', 'Subject line', 'Plain body', null, []);

        $this->assertTrue($ok);
    }

    public function test_send_invokes_mail_facade_with_html_view(): void
    {
        Mail::shouldReceive('send')
            ->once()
            ->with([], [], Mockery::type('Closure'));

        $service = new TransactionalMailService;
        $ok = $service->send(
            'recipient@example.com',
            'Test',
            'Plain fallback',
            'emails.test',
            ['timestamp' => '2026-01-01 00:00:00']
        );

        $this->assertTrue($ok);
    }
}
