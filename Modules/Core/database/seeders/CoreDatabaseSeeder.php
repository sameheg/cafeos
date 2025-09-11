<?php

namespace Modules\Core\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Core\Models\Tenant;
use Modules\Core\Models\FeatureFlag;
use Spatie\Permission\Models\Role;

class CoreDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::create([
            'name' => 'Acme Inc',
            'subdomain' => 'acme',
        ]);

        $adminRole = Role::firstOrCreate(['name' => 'TenantAdmin']);
        Role::firstOrCreate(['name' => 'Staff']);

        $admin = User::create([
            'name' => 'Tenant Admin',
            'email' => 'admin@acme.test',
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
        ]);
        $admin->assignRole($adminRole);

        FeatureFlag::create([
            'tenant_id' => $tenant->id,
            'name' => 'core_multi_tenancy',
            'enabled' => true,
        ]);
    }
}
