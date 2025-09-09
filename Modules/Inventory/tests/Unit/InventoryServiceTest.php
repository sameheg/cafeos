<?php

namespace Modules\Inventory\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\Inventory\Events\LowStockAlert;
use Modules\Inventory\Models\InventoryItem;
use Modules\Inventory\Models\StockMovement;
use Modules\Inventory\Services\InventoryService;
use Tests\TestCase;

class InventoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected InventoryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(\Modules\Inventory\Providers\InventoryServiceProvider::class);
        $this->artisan('migrate', ['--path' => 'Modules/Inventory/database/migrations', '--realpath' => true]);
        $this->service = new InventoryService();
    }

    /** @test */
    public function it_deducts_stock_using_fifo(): void
    {
        $item = InventoryItem::create(['tenant_id' => 1, 'name' => 'Beans', 'quantity' => 0, 'alert_threshold' => 0]);
        StockMovement::create(['tenant_id' => 1, 'inventory_item_id' => $item->id, 'type' => 'in', 'quantity' => 10, 'remaining_quantity' => 10, 'unit_cost' => 5]);
        StockMovement::create(['tenant_id' => 1, 'inventory_item_id' => $item->id, 'type' => 'in', 'quantity' => 10, 'remaining_quantity' => 10, 'unit_cost' => 6]);
        $item->quantity = 20;
        $item->save();

        $this->service->deductStock([['id' => $item->id, 'quantity' => 15]], 'FIFO');

        $item->refresh();
        $this->assertEquals(5, $item->quantity);

        $first = StockMovement::where('inventory_item_id', $item->id)->where('type', 'in')->orderBy('id')->first();
        $last = StockMovement::where('inventory_item_id', $item->id)->where('type', 'in')->orderByDesc('id')->first();

        $this->assertEquals(0, $first->remaining_quantity);
        $this->assertEquals(5, $last->remaining_quantity);
    }

    /** @test */
    public function it_deducts_stock_using_lifo(): void
    {
        $item = InventoryItem::create(['tenant_id' => 1, 'name' => 'Beans', 'quantity' => 0, 'alert_threshold' => 0]);
        StockMovement::create(['tenant_id' => 1, 'inventory_item_id' => $item->id, 'type' => 'in', 'quantity' => 10, 'remaining_quantity' => 10, 'unit_cost' => 5]);
        StockMovement::create(['tenant_id' => 1, 'inventory_item_id' => $item->id, 'type' => 'in', 'quantity' => 10, 'remaining_quantity' => 10, 'unit_cost' => 6]);
        $item->quantity = 20;
        $item->save();

        $this->service->deductStock([['id' => $item->id, 'quantity' => 15]], 'LIFO');

        $item->refresh();
        $this->assertEquals(5, $item->quantity);

        $first = StockMovement::where('inventory_item_id', $item->id)->where('type', 'in')->orderBy('id')->first();
        $last = StockMovement::where('inventory_item_id', $item->id)->where('type', 'in')->orderByDesc('id')->first();

        $this->assertEquals(5, $first->remaining_quantity);
        $this->assertEquals(0, $last->remaining_quantity);
    }

    /** @test */
    public function it_dispatches_low_stock_alert(): void
    {
        Event::fake([LowStockAlert::class]);

        $item = InventoryItem::create(['tenant_id' => 1, 'name' => 'Beans', 'quantity' => 0, 'alert_threshold' => 5]);
        StockMovement::create(['tenant_id' => 1, 'inventory_item_id' => $item->id, 'type' => 'in', 'quantity' => 10, 'remaining_quantity' => 10, 'unit_cost' => 5]);
        $item->quantity = 10;
        $item->save();

        $this->service->deductStock([['id' => $item->id, 'quantity' => 6]], 'FIFO');

        Event::assertDispatched(LowStockAlert::class);
    }
}
