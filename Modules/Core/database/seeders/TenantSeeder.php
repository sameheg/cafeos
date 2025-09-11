<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Core\Models\Tenant;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        Tenant::factory()->count(10)->create();
    }
}
