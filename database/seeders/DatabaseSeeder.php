<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Stancl\Tenancy\Contracts\Tenant as TenantContract;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('tenants')->insert([
            'id' => 1,
            'name' => json_encode([
                'en' => 'Test Tenant',
                'ar' => 'مستأجر تجريبي',
            ]),
            'domain' => 'tenant.test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tenant = Tenant::find(1);
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
