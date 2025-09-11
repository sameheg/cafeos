<?php

namespace Modules\Pos\Tests\Unit;

use Illuminate\Support\Facades\Event;
use Modules\Pos\Events\OrderPaid;
use Modules\Pos\Models\PosOrder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosOrderObserverTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_dispatches_order_paid_event(): void
    {
        Event::fake();

        $order = PosOrder::create([
            'tenant_id' => 't1',
            'total' => 10,
        ]);

        event(new OrderPaid($order));

        Event::assertDispatched(OrderPaid::class);
    }
}
