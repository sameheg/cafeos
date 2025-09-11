<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\ModuleRegistry;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function models_are_scoped_by_tenant(): void
    {
        $tenantA = Tenant::create(['name' => 'A', 'slug' => 'a']);
        $tenantB = Tenant::create(['name' => 'B', 'slug' => 'b']);

        app()->instance('currentTenant', $tenantA);
        ModuleRegistry::create(['module' => 'core']);

        app()->instance('currentTenant', $tenantB);
        ModuleRegistry::create(['module' => 'core']);

        app()->instance('currentTenant', $tenantA);
        $this->assertCount(1, ModuleRegistry::all());
    }
}
