<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class ModuleApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_toggle_modules_per_tenant(): void
    {
        $tenant = Tenant::create(['name' => 'A', 'slug' => 'a']);

        $this->withHeader('X-Tenant', 'a')
            ->postJson('/v1/modules/sample/toggle')
            ->assertJson(['module' => 'sample', 'enabled' => true]);

        $this->withHeader('X-Tenant', 'a')
            ->postJson('/v1/modules/sample/toggle')
            ->assertJson(['module' => 'sample', 'enabled' => false]);

        $this->withHeader('X-Tenant', 'a')
            ->getJson('/v1/modules')
            ->assertJson([['module' => 'sample', 'enabled' => false]]);
    }
}
