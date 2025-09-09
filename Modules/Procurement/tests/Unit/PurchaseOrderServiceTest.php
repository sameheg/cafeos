<?php

namespace Modules\Procurement\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Procurement\Models\Supplier;
use Modules\Procurement\Services\PurchaseOrderService;
use Modules\Core\Contracts\InventoryServiceInterface;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PurchaseOrderServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app->register(\Modules\Procurement\Providers\ProcurementServiceProvider::class);
        $this->artisan('migrate', ['--path' => 'Modules/Procurement/database/migrations', '--realpath' => true]);
    }

    #[Test]
    public function it_restocks_inventory_when_order_completed(): void
    {
        $items = [['id' => 1, 'quantity' => 10, 'unit_cost' => 0]];
        $inventory = \Mockery::mock(InventoryServiceInterface::class);
        $inventory->shouldReceive('restock')->once()->with($items);
        $this->app->instance(InventoryServiceInterface::class, $inventory);

        $service = $this->app->make(PurchaseOrderService::class);

        $supplier = Supplier::create(['name' => 'Acme Supplies']);

        $order = $service->createOrder([
            'supplier_id' => $supplier->id,
            'items' => $items,
        ]);

        $service->completeOrder($order);

        $this->assertEquals('completed', $order->fresh()->status);
    }
}

