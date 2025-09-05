<?php

namespace Tests\Unit;

use App\Events\OrderStatusUpdated;
use Tests\TestCase;

class OrderStatusUpdatedTest extends TestCase
{
    public function test_broadcast_data()
    {
        $event = new OrderStatusUpdated(5, 'served', 1);
        $this->assertEquals('orders', $event->broadcastOn()->name);
        $this->assertEquals([
            'orderId' => 5,
            'status' => 'served',
            'lineId' => 1,
        ], $event->broadcastWith());
        $this->assertEquals('OrderStatusUpdated', $event->broadcastAs());
    }
}
