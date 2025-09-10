<?php

namespace Modules\Core\Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Core\Models\Permission;
use Modules\Core\Models\Role;
use Tests\TestCase;
use Spatie\Permission\PermissionRegistrar;

class PermissionPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_manage_permissions(): void
    {
        $superAdminRole = Role::create(['name' => 'Super Admin', 'guard_name' => 'web']);
        $user = User::factory()->create();
        $registrar = app(PermissionRegistrar::class);
        $registrar->setPermissionsTeamId($user->tenant_id);
        $registrar->forgetCachedPermissions();
        $user->assignRole($superAdminRole);
        $permission = Permission::create(['name' => 'edit posts', 'guard_name' => 'web']);

        $this->assertTrue($user->can('viewAny', Permission::class));
        $this->assertTrue($user->can('view', $permission));
        $this->assertTrue($user->can('create', Permission::class));
        $this->assertTrue($user->can('update', $permission));
        $this->assertTrue($user->can('delete', $permission));
    }

    public function test_non_admin_cannot_manage_permissions(): void
    {
        $permission = Permission::create(['name' => 'edit posts', 'guard_name' => 'web']);
        $user = User::factory()->create();

        $this->assertFalse($user->can('viewAny', Permission::class));
        $this->assertFalse($user->can('view', $permission));
        $this->assertFalse($user->can('create', Permission::class));
        $this->assertFalse($user->can('update', $permission));
        $this->assertFalse($user->can('delete', $permission));
    }
}
