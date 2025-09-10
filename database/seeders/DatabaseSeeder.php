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

        DB::table('tenants')->insert([
            'id' => 1,
            'name' => 'Test Tenant',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $tenant = new Tenant(['id' => 1, 'name' => 'Test Tenant']);
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
