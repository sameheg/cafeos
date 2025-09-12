<?php

namespace Modules\Loyalty\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Loyalty\Models\LoyaltyRule;

class LoyaltyDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        LoyaltyRule::firstOrCreate(
            ['tenant_id' => 'tenant-demo', 'name' => 'default'],
            ['earn_rate' => 1, 'stackable' => true]
        );
    }
}
