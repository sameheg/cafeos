<?php
namespace Modules\Pos\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Pos\App\Models\Order;
use Modules\Pos\App\Models\OrderItem;
use Modules\Pos\App\Contracts\BillingGateway;
use Modules\Pos\App\Contracts\InventoryGateway;

class PaymentFlowTest extends TestCase
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
                public function consumeItems(array $items, array $meta = []): bool {
                    return true;
                }
            };
        });
    }

    public function test_it_processes_payment_and_creates_invoice_and_consumes_inventory()
    {
        $order = Order::factory()->create(['status' => 'open', 'total' => 100]);
        OrderItem::factory()->create([
            'order_id' => $order->id,
            'sku' => 'SKU-1',
            'name' => 'Coffee',
            'qty' => 2,
            'price' => 50,
            'line_total' => 100,
        ]);

        $response = $this->postJson("/api/v1/pos/orders/{$order->id}/pay", [
            'amount' => 100,
            'method' => 'cash',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid',
            'invoice_id' => 'INV-123',
        ]);
    }

    public function test_it_rejects_insufficient_payment()
    {
        $order = Order::factory()->create(['status' => 'open', 'total' => 100]);
        $response = $this->postJson("/api/v1/pos/orders/{$order->id}/pay", [
            'amount' => 50,
        ]);
        $response->assertStatus(422);
    }

    public function test_it_blocks_double_payment()
    {
        $order = Order::factory()->create(['status' => 'paid', 'total' => 100]);

        $response = $this->postJson("/api/v1/pos/orders/{$order->id}/pay", [
            'amount' => 100,
        ]);

        $response->assertStatus(409);
    }
}
