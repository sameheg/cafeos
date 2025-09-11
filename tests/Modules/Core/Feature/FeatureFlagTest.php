<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class FeatureFlagTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tenant_can_toggle_feature_flags(): void
    {
        $tenant = Tenant::create(['name' => 'A', 'slug' => 'a', 'status' => 'active']);
        app()->instance('currentTenant', $tenant);

        $this->withHeader('X-Tenant', 'a')->putJson('/v1/feature-flags/foo', ['value' => true])->assertOk();
        $this->withHeader('X-Tenant', 'a')->getJson('/v1/feature-flags')->assertJsonFragment(['key' => 'foo', 'value' => true]);
    }
}
