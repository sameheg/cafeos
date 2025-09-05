<?php

namespace Tests\Unit;

use App\Notifications\InventoryAlertNotification;
use App\Product;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\Inventory\Services\AlertService;
use Tests\TestCase;

class AlertServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite.database', ':memory:');

        Schema::create('inventory_alerts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('type');
            $table->string('message');
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('inventory_alerts');
        parent::tearDown();
    }

    public function test_logs_and_notifies_when_stock_is_low()
    {
        Notification::fake();

        $product = new Product([
            'name' => 'Coffee',
            'quantity_available' => 5,
            'alert_quantity' => 10,
        ]);
        $product->id = 1;

        $service = new AlertService();
        $service->checkProductStock($product);

        $this->assertDatabaseHas('inventory_alerts', [
            'product_id' => 1,
            'type' => 'stock',
        ]);

        Notification::assertSentOnDemand(InventoryAlertNotification::class);
    }

    public function test_logs_and_notifies_when_sales_exceed_limit()
    {
        Notification::fake();

        $product = new Product([
            'name' => 'Tea',
            'alert_sales_quantity' => 50,
        ]);
        $product->id = 2;

        $service = new AlertService();
        $service->checkProductSales($product, 55);

        $this->assertDatabaseHas('inventory_alerts', [
            'product_id' => 2,
            'type' => 'sales',
        ]);

        Notification::assertSentOnDemand(InventoryAlertNotification::class);
    }
}
