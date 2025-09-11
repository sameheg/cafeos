<?php

namespace Tests\Modules\Core\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Tenant;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RBACTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function owner_role_can_access_route(): void
    {
        $tenant = Tenant::create(['name' => 'A', 'slug' => 'a', 'status' => 'active']);
        app()->instance('currentTenant', $tenant);
        $user = User::factory()->create();
        Role::create(['name' => 'owner', 'guard_name' => 'web']);
        $user->assignRole('owner');

        $this->actingAs($user)->withHeader('X-Tenant', 'a')->getJson('/v1/rbac-ping')->assertOk();
    }

    /** @test */
    public function missing_role_is_forbidden(): void
    {
        $tenant = Tenant::create(['name' => 'A', 'slug' => 'a', 'status' => 'active']);
        app()->instance('currentTenant', $tenant);
        $user = User::factory()->create();

        $this->actingAs($user)->withHeader('X-Tenant', 'a')->getJson('/v1/rbac-ping')->assertForbidden();
    }
}
