<?php

namespace Modules\Notifications\Database\Seeders;

use Illuminate\Database\Seeder;

class NotificationsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Modules\Notifications\Models\NotificationTemplate::create([
            'tenant_id' => (string) \Illuminate\Support\Str::uuid(),
            'name' => 'welcome',
            'content' => 'Welcome to EliteSaaS',
        ]);
    }
}
