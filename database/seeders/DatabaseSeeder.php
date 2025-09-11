<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Stancl\Tenancy\Contracts\Tenant as TenantContract;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $tenant = Tenant::withoutEvents(function () {
            $tenant = Tenant::create([
                'id' => '1',
                'name' => [
                    'en' => 'Test Tenant',
                    'ar' => 'مستأجر تجريبي',
                ],
                'domain' => 'test.localhost',
            ]);

            $tenant->domains()->create(['domain' => 'test.localhost']);

            return $tenant;
        });

        app()->instance(TenantContract::class, $tenant);

        $this->call([
            RolesAndPermissionsSeeder::class,
            TenantModulesSeeder::class,
        ]);

        User::factory()->create([
            'name' => [
                'en' => 'Test User',
                'ar' => 'مستخدم تجريبي',
            ],
            'email' => 'test@example.com',
            'tenant_id' => $tenant->id,
        ]);
    }
}
