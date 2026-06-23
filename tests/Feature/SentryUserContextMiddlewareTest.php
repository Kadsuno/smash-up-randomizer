<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SentryUserContextMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_request_does_not_throw(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertOk();
    }

    public function test_unauthenticated_request_does_not_throw(): void
    {
        $response = $this->get('/');

        $response->assertOk();
    }
}
