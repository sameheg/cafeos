<?php

namespace Tests\Modules\Core\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Tenant;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tenants_manage_their_own_settings(): void
    {
        $a = Tenant::create(['name' => 'A', 'slug' => 'a']);
        $b = Tenant::create(['name' => 'B', 'slug' => 'b']);

        $this->withHeader('X-Tenant', 'a')
            ->putJson('/v1/settings', [
                'settings' => ['app.timezone' => 'UTC'],
            ])->assertNoContent();

        $this->withHeader('X-Tenant', 'b')
            ->getJson('/v1/settings')
            ->assertExactJson([]);

        $this->withHeader('X-Tenant', 'a')
            ->getJson('/v1/settings')
            ->assertJson(['app.timezone' => 'UTC']);
    }
}
