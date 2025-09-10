<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Stancl\Tenancy\Contracts\Tenant as TenantContract;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (! Schema::hasTable('tenants')) {
            Artisan::call('migrate', [
                '--path' => database_path('migrations/central'),
                '--realpath' => true,
                '--force' => true,
            ]);
        }

        $tenantData = [
            'id' => '1',
            'name' => json_encode([
                'en' => 'Test Tenant',
                'ar' => 'مستأجر تجريبي',
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (Schema::hasColumn('tenants', 'domain')) {
            $tenantData['domain'] = 'tenant.test';
        }

        DB::table('tenants')->insert($tenantData);

        if (Schema::hasTable('domains') && Schema::hasColumn('tenants', 'domain')) {
            DB::table('domains')->insert([
                'domain' => 'tenant.test',
                'tenant_id' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $tenantAttributes = [
            'id' => '1',
            'name' => [
                'en' => 'Test Tenant',
                'ar' => 'مستأجر تجريبي',
            ],
        ];

        if (isset($tenantData['domain'])) {
            $tenantAttributes['domain'] = 'tenant.test';
        }

        $tenant = new Tenant($tenantAttributes);
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
