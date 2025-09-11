<?php

namespace Modules\Inventory\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Inventory\Models\InventoryItem;
use Modules\Inventory\Models\InventoryBatch;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $item = InventoryItem::create([
            'tenant_id' => 't1',
            'name' => 'Flour',
            'quantity' => 10,
            'unit' => 'kg',
            'reorder_level' => 5,
        ]);

        InventoryBatch::create([
            'tenant_id' => 't1',
            'item_id' => $item->id,
            'batch_number' => 'B1',
            'quantity' => 10,
            'expiry' => now()->addMonth(),
        ]);
    }
}
