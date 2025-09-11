<?php

namespace Modules\Pos\Tests\Contract;

use Modules\Pos\Events\OrderPaid;
use Modules\Pos\Models\PosItem;
use Modules\Pos\Models\PosOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosEventSchemaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function event_payload_matches_schema(): void
    {
        $order = PosOrder::create(['tenant_id' => 't1', 'total' => 20, 'status' => 'paid']);
        PosItem::create(['order_id' => $order->id, 'product_id' => 'p1', 'qty' => 2, 'price' => 10]);
        $event = new OrderPaid($order->load('items'));
        $payload = $event->broadcastWith();

        $this->assertArrayHasKey('order_id', $payload);
        $this->assertArrayHasKey('amount', $payload);
        $this->assertIsArray($payload['items']);
    }
}
