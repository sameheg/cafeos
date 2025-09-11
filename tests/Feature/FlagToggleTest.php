<?php

namespace Tests\Feature;

use Laravel\Pennant\Feature;
use Modules\Core\Models\FeatureFlag;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class FlagToggleTest extends TestCase
{
    public function test_flag_toggles_per_tenant(): void
    {
        $tenant = Tenant::create(['name' => 'Acme', 'subdomain' => 'acme']);
        app()->instance('tenant', $tenant);

        FeatureFlag::create([
            'tenant_id' => $tenant->id,
            'name' => 'core_multi_tenancy',
            'enabled' => true,
        ]);

        $this->assertTrue(Feature::active('core_multi_tenancy'));

        FeatureFlag::where('tenant_id', $tenant->id)->where('name', 'core_multi_tenancy')->update(['enabled' => false]);
        Feature::forget('core_multi_tenancy');

        $this->assertFalse(Feature::active('core_multi_tenancy'));
    }
}
