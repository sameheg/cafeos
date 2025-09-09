<?php

namespace Modules\Inventory\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\Inventory\Events\LowStockAlert;
use Modules\Inventory\Models\InventoryItem;
use Modules\Inventory\Models\StockMovement;
use Modules\Inventory\Services\InventoryService;
use Modules\FoodSafety\Exceptions\ExpiredIngredientException;
use Modules\FoodSafety\Models\IngredientInfo;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InventoryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected InventoryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(\Modules\Inventory\Providers\InventoryServiceProvider::class);
        $this->app->register(\Modules\FoodSafety\Providers\FoodSafetyServiceProvider::class);
        $this->artisan('migrate', ['--path' => 'Modules/Inventory/database/migrations', '--realpath' => true]);
        $this->artisan('migrate', ['--path' => 'Modules/FoodSafety/database/migrations', '--realpath' => true]);
        $this->service = new InventoryService();
    }

    #[Test]
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

    #[Test]
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

    #[Test]
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

    #[Test]
    public function it_blocks_expired_items(): void
    {
        $item = InventoryItem::create(['tenant_id' => 1, 'name' => 'Milk', 'quantity' => 5, 'alert_threshold' => 0]);
        IngredientInfo::create([
            'inventory_item_id' => $item->id,
            'expiry_date' => now()->subDay(),
            'allergens' => [],
        ]);

        $this->expectException(ExpiredIngredientException::class);

        $this->service->deductStock([['id' => $item->id, 'quantity' => 1]], 'FIFO');
    }
}
