<?php

namespace Modules\Inventory\Tests\Contract;

use Illuminate\Support\Facades\Event;
use Modules\Inventory\Events\StockUpdated;
use Modules\Inventory\Models\InventoryItem;
use Modules\Inventory\Observers\InventoryItemObserver;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StockEventSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_payload_matches_schema(): void
    {
        InventoryItem::observe(InventoryItemObserver::class);
        Event::fake([StockUpdated::class]);

        $item = InventoryItem::create([
            'tenant_id' => 't1',
            'name' => 'Butter',
            'quantity' => 2,
            'unit' => 'kg',
            'reorder_level' => 1,
        ]);

        $item->update(['quantity' => 1]);

        Event::assertDispatched(StockUpdated::class, function ($event) {
            return isset($event->broadcastWith()['item_id']) && isset($event->broadcastWith()['quantity']);
        });
    }
}
