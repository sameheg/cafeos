<?php

namespace Modules\Dashboard\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Tenant;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class CustomizeTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_customize_dashboard(): void
    {
        $tenant = Tenant::create(['name' => 'Acme', 'subdomain' => 'acme']);
        app()->instance('tenant', $tenant);

        $user = User::create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => bcrypt('secret'),
            'tenant_id' => $tenant->id,
        ]);
        Permission::create(['name' => 'customize_dashboard']);
        $user->givePermissionTo('customize_dashboard');
        Gate::define('customize_dashboard', fn () => true);

        config(['auth.guards.sanctum' => ['driver' => 'session', 'provider' => 'users']]);
        $this->actingAs($user);
        $response = $this->actingAs($user, 'sanctum')->patchJson('/api/v1/dashboard/customize', [
            'widgets' => ['sales' => true],
        ]);

        $response->assertStatus(200)->assertJson(['updated' => true]);
        $this->assertDatabaseHas('dashboard_configs', ['user_id' => $user->id]);
    }
}
