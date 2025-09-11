<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class HealthCheckTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function health_endpoint_returns_ok(): void
    {
        Tenant::create(['name' => 'T1', 'slug' => 't1']);

        $response = $this->withHeader('X-Tenant', 't1')->getJson('/v1/healthz');
        $response->assertOk();
        $response->assertJson([
            'status' => 'ok',
            'message' => 'OK',
            'checks' => [
                'database' => true,
                'cache' => true,
                'queue' => true,
            ],
        ]);
    }
}
