<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Nwidart\Modules\Facades\Module;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->setPermissionsTeamId(tenant('id'));

        $allPermissions = [];
        foreach (Module::all() as $module) {
            $key = strtolower($module->getName()).'.permissions';
            $permissions = config($key, []);
            foreach ($permissions as $permission) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'web',
                    'tenant_id' => tenant('id'),
                ]);
            }
            $allPermissions = array_merge($allPermissions, $permissions);
        }

        $manager = Role::firstOrCreate([
            'name' => 'Manager',
            'guard_name' => 'web',
            'tenant_id' => tenant('id'),
        ]);
        $manager->givePermissionTo($allPermissions);

        foreach (['Cashier', 'Waiter', 'Chef', 'Delivery'] as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
                'tenant_id' => tenant('id'),
            ]);
        }
    }
}
