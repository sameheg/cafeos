<?php

namespace Modules\Inventory\Tests\Unit;

use Illuminate\Support\Facades\Event;
use Modules\Inventory\Events\StockUpdated;
use Modules\Inventory\Models\InventoryItem;
use Modules\Inventory\Observers\InventoryItemObserver;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InventoryObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_dispatches_stock_updated_event(): void
    {
        InventoryItem::observe(InventoryItemObserver::class);
        Event::fake([StockUpdated::class]);

        $item = InventoryItem::create([
            'tenant_id' => 't1',
            'name' => 'Flour',
            'quantity' => 5,
            'unit' => 'kg',
            'reorder_level' => 2,
        ]);

        $item->update(['quantity' => 3]);

        Event::assertDispatched(StockUpdated::class);
    }
}
