<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (! DB::table('tenants')->exists()) {
            DB::table('tenants')->insert([
                'id' => 1,
                'name' => 'Test Tenant',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->call(RolesAndPermissionsSeeder::class);
    }
}
