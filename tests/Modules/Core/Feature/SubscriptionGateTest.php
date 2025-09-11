<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class SubscriptionGateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function suspended_tenant_is_blocked(): void
    {
        $tenant = Tenant::create(['name' => 'A', 'slug' => 'a', 'status' => 'suspended']);
        app()->instance('currentTenant', $tenant);

        $this->withHeader('X-Tenant', 'a')->getJson('/v1/modules')->assertPaymentRequired();
    }
}
