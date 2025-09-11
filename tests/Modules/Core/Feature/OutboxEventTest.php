<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class OutboxEventTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function domain_events_are_recorded_to_outbox(): void
    {
        $this->postJson('/v1/tenants', ['name' => 'A', 'slug' => 'a'])->assertCreated();
        $tenant = Tenant::first();
        app()->instance('currentTenant', $tenant);

        $this->withHeader('X-Tenant', 'a')->postJson('/v1/modules/core/toggle');

        $this->assertDatabaseCount('outbox_events', 2);
    }
}
