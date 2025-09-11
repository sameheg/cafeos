<?php

namespace Modules\Kds\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Kds\Models\KdsStation;

class KdsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KdsStation::create([
            'tenant_id' => 'tenant-demo',
            'name' => 'hot',
            'overload_threshold' => 10,
        ]);
    }
}
