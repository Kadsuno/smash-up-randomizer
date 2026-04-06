<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;

class MailConfigTest extends TestCase
{
    public function test_brevo_mailer_uses_api_transport(): void
    {
        $brevo = config('mail.mailers.brevo');
        $this->assertIsArray($brevo);
        $this->assertSame('brevo', $brevo['transport']);
        $this->assertArrayHasKey('api_key', $brevo);
    }
}
