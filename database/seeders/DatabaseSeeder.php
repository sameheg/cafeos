<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);

        User::factory()->create([
            'name' => [
                'en' => 'Test User',
                'ar' => 'مستخدم تجريبي',
            ],
            'email' => 'test@example.com',
            'tenant_id' => tenant('id'),
        ]);
    }
}
