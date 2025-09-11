<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\ModuleRegistry;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class MetricsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function metrics_endpoint_returns_system_counts(): void
    {
        $tenantA = Tenant::create(['name' => 'A', 'slug' => 'a']);
        $tenantB = Tenant::create(['name' => 'B', 'slug' => 'b']);

        app()->instance('currentTenant', $tenantA);
        ModuleRegistry::create(['module' => 'core']);

        app()->instance('currentTenant', $tenantB);
        ModuleRegistry::create(['module' => 'core']);

        app()->forgetInstance('currentTenant');

        $response = $this->get('/v1/metrics');

        $response->assertOk();
        $response->assertJson([
            'tenants' => 2,
            'modules' => 2,
        ]);
    }
}
