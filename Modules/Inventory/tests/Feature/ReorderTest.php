<?php

namespace Modules\Inventory\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Inventory\Models\InventoryItem;
use Tests\TestCase;

class ReorderTest extends TestCase
{
    use RefreshDatabase;

    public function test_low_stock_endpoint(): void
    {
        InventoryItem::create([
            'tenant_id' => 't1',
            'name' => 'Sugar',
            'quantity' => 1,
            'unit' => 'kg',
            'reorder_level' => 5,
        ]);

        $response = $this->getJson('/api/v1/inventory/low-stock');
        $response->assertStatus(200)->assertJsonCount(1, 'items');
    }
}
