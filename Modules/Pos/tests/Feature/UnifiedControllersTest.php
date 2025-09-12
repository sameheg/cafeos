<?php
namespace Modules\Pos\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Pos\App\Models\Order;
use Modules\Pos\App\Models\OrderItem;
use Modules\Pos\App\Contracts\BillingGateway;
use Modules\Pos\App\Contracts\InventoryGateway;

class UnifiedControllersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->bind(BillingGateway::class, function () {
            return new class implements BillingGateway {
                public function createInvoice(Order $order, array $lines, array $meta = []): array {
                    return ['invoice_id' => 'INV-123', 'number' => '2025-0001', 'total' => $order->total];
                }
            };
        });

        $this->app->bind(InventoryGateway::class, function () {
            return new class implements InventoryGateway {
                public function consumeItems(array $items, array $meta = []): bool { return true; }
                public function reserveItems(array $items, array $meta = []): bool { return true; }
                public function releaseReservation(array $items, array $meta = []): bool { return true; }
            };
        });
    }

    public function test_open_add_pay_refund_flow()
    {
        // open
        $resOpen = $this->postJson('/api/v1/pos/tables/start', ['table_id'=>3]);
        $resOpen->assertStatus(201);
        $orderId = $resOpen->json('id');

        // add item
        $resItem = $this->postJson("/api/v1/pos/orders/{$orderId}/items", [
            'sku' => 'SKU-1',
            'name' => 'Latte',
            'qty' => 2,
            'price' => 40,
        ]);
        $resItem->assertStatus(201);

        // pay
        $resPay = $this->postJson("/api/v1/pos/orders/{$orderId}/pay", [
            'amount' => 80,
            'method' => 'cash',
        ]);
        $resPay->assertStatus(200);

        // refund partial
        $resRefund = $this->postJson("/api/v1/pos/orders/{$orderId}/refund", [
            'amount' => 20,
            'reason' => 'customer change',
        ]);
        $resRefund->assertStatus(201);
    }

    public function test_refund_cannot_exceed_paid_total()
    {
        $resOpen = $this->postJson('/api/v1/pos/tables/start', ['table_id'=>3]);
        $orderId = $resOpen->json('id');

        $this->postJson("/api/v1/pos/orders/{$orderId}/items", [
            'sku' => 'SKU-1','name'=>'Latte','qty'=>1,'price'=>50
        ]);

        $this->postJson("/api/v1/pos/orders/{$orderId}/pay", ['amount'=>50]);

        $resRefund = $this->postJson("/api/v1/pos/orders/{$orderId}/refund", ['amount'=>60]);
        $resRefund->assertStatus(422);
    }
}
