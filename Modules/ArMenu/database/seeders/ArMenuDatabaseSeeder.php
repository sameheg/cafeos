<?php

namespace Modules\ArMenu\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ArMenu\Models\ArAsset;

class ArMenuDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        ArAsset::factory()->create([
            'tenant_id' => '00000000-0000-0000-0000-000000000001',
            'item_id' => 'sample',
            'url' => 'https://cdn.example.com/sample.glb',
            'type' => 'ar',
        ]);
    }
}
