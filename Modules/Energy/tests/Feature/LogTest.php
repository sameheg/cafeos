<?php

namespace Modules\Energy\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_log(): void
    {
        $response = $this->postJson('/api/v1/energy/logs', ['kwh' => 10], ['X-Tenant-ID' => 't1']);

        $response->assertStatus(200)->assertJsonStructure(['log_id']);
        $this->assertDatabaseHas('energy_logs', ['id' => $response->json('log_id'), 'kwh' => 10]);
    }

    public function test_validation_error(): void
    {
        $response = $this->postJson('/api/v1/energy/logs', ['kwh' => 0], ['X-Tenant-ID' => 't1']);
        $response->assertStatus(422);
    }
}
