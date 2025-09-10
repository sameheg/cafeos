<?php

namespace Modules\Core\Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class RolePolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_manage_roles(): void
    {
        $superAdminRole = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $registrar = app(PermissionRegistrar::class);
        $registrar->setPermissionsTeamId($user->tenant_id);
        $registrar->forgetCachedPermissions();
        $user->assignRole($superAdminRole);
        $role = Role::create(['name' => 'Manager', 'guard_name' => 'web']);

        $this->assertTrue($user->can('viewAny', Role::class));
        $this->assertTrue($user->can('view', $role));
        $this->assertTrue($user->can('create', Role::class));
        $this->assertTrue($user->can('update', $role));
        $this->assertTrue($user->can('delete', $role));
    }

    public function test_non_admin_cannot_manage_roles(): void
    {
        $role = Role::create(['name' => 'Manager']);
        $user = User::factory()->create();

        $this->assertFalse($user->can('viewAny', Role::class));
        $this->assertFalse($user->can('view', $role));
        $this->assertFalse($user->can('create', Role::class));
        $this->assertFalse($user->can('update', $role));
        $this->assertFalse($user->can('delete', $role));
    }
}
