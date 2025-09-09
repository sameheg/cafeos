<?php

namespace Modules\Billing\Tests\Unit;

use Illuminate\Support\Facades\Event;
use Modules\Billing\Events\UnpaidBillAlert;
use Modules\Pos\Models\Order;
use Tests\TestCase;

class UnpaidBillAlertTest extends TestCase
{
    public function test_event_dispatches_with_order(): void
    {
        Event::fake();
        $order = Order::factory()->make();

        event(new UnpaidBillAlert($order));

        Event::assertDispatched(UnpaidBillAlert::class, fn ($e) => $e->order === $order);
    }
}
