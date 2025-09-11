<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Modules\Core\Models\Tenant;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RbacGateTest extends TestCase
{
    public function test_staff_cannot_manage_tenants(): void
    {
        $tenant = Tenant::create(['name' => 'Acme', 'subdomain' => 'acme']);

        $adminRole = Role::create(['name' => 'TenantAdmin']);
        $staffRole = Role::create(['name' => 'Staff']);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@acme.test',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
        ]);
        $admin->assignRole($adminRole);

        $staff = User::create([
            'name' => 'Staff',
            'email' => 'staff@acme.test',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
        ]);
        $staff->assignRole($staffRole);

        $this->actingAs($staff);
        $this->assertFalse(Gate::allows('manage-tenants'));

        $this->actingAs($admin);
        $this->assertTrue(Gate::allows('manage-tenants'));
    }
}
