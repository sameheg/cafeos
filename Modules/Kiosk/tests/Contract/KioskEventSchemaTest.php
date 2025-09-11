<?php

namespace Modules\Kiosk\Tests\Contract;

use Modules\Kiosk\Events\KioskOrderCompleted;
use Modules\Kiosk\Models\KioskOrder;
use Tests\TestCase;

class KioskEventSchemaTest extends TestCase
{
    public function test_schema(): void
    {
        $order = KioskOrder::make([
            'kiosk_id' => 'k1',
            'tenant_id' => 't1',
            'total' => 1,
            'status' => 'queued',
        ]);
        $order->id = 'o1';

        $event = new KioskOrderCompleted($order);
        $this->assertSame([
            'kiosk_id' => 'k1',
            'order_id' => 'o1',
        ], $event->toArray());
    }
}
