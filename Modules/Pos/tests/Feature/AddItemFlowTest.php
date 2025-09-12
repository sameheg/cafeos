<?php
namespace Modules\Pos\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Pos\App\Models\Order;

class AddItemFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_item_updates_totals()
    {
        $order = Order::factory()->create();

        $res = $this->postJson("/api/v1/pos/orders/{$order->id}/items", [
            'sku' => 'SKU-COFFEE',
            'name' => 'Coffee',
            'qty' => 2,
            'price' => 25,
        ]);
        $res->assertStatus(201);

        $order->refresh();
        $this->assertEquals(50.00, (float)$order->total);
    }
}
