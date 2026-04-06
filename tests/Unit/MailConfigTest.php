<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;

class MailConfigTest extends TestCase
{
    public function test_brevo_mailer_is_defined_as_smtp(): void
    {
        $brevo = config('mail.mailers.brevo');
        $this->assertIsArray($brevo);
        $this->assertSame('smtp', $brevo['transport']);
        $this->assertArrayHasKey('host', $brevo);
    }
}
