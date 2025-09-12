<?php

namespace Modules\Marketplace\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Marketplace\Models\MarketplaceStore;

class MarketplaceDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        MarketplaceStore::create([
            'tenant_id' => 't1',
            'supplier_id' => 'sup1',
            'name' => 'Default Store',
            'tier' => 'basic',
        ]);
    }
}
