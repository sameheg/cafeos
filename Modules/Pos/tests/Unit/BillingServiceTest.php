<?php

namespace Modules\Pos\Tests\Unit;

use Modules\Pos\Models\Order;
use Modules\Pos\Services\BillingService;
use Tests\TestCase;

class BillingServiceTest extends TestCase
{
    public function test_split_bill_creates_parts()
    {
        $order = new Order(['total' => 100]);
        $service = new BillingService();
        $parts = $service->splitBill($order, 2);
        $this->assertCount(2, $parts);
        $this->assertEquals(50, $parts[0]);
    }

    public function test_mark_as_debt_sets_flag()
    {
        $order = new Order(['total' => 100]);
        $service = new BillingService();
        $service->markAsDebt($order);
        $this->assertTrue($order->is_debt);
    }
}
