<?php

namespace Modules\SuperAdmin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\SuperAdmin\Models\Flag;

class SuperAdminDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Flag::create([
            'module' => 'pos',
            'tenant_id' => Str::uuid()->toString(),
            'enabled' => false,
        ]);
    }
}
