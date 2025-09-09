<?php

namespace Modules\Pos\Tests\Unit;

use Illuminate\Support\Facades\Event;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Modules\Billing\Events\UnpaidBillAlert;
use Modules\Pos\Models\Order;
use Modules\Pos\Services\BillingService;
use Tests\TestCase;

class BillingServiceTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function test_split_bill_creates_parts()
    {
        $order = new Order(['total' => 100]);
        $service = new BillingService();
        $parts = $service->splitBill($order, 2);
        $this->assertCount(2, $parts);
        $this->assertEquals(50, $parts[0]);
    }

    public function test_mark_as_debt_persists_and_dispatches_event()
    {
        Event::fake();

        $order = Mockery::mock(Order::class)->makePartial();
        $order->total = 100;
        $order->shouldReceive('save')->once()->andReturnTrue();

        $service = new BillingService();
        $service->markAsDebt($order);

        $this->assertTrue($order->is_debt);

        Event::assertDispatched(UnpaidBillAlert::class, function ($event) use ($order) {
            return $event->order === $order;
        });
    }

    public function test_mark_as_debt_skips_when_already_flagged()
    {
        Event::fake();

        $order = Mockery::mock(Order::class)->makePartial();
        $order->is_debt = true;
        $order->shouldNotReceive('save');

        $service = new BillingService();
        $service->markAsDebt($order);

        Event::assertNotDispatched(UnpaidBillAlert::class);
    }
}
