<?php

namespace Modules\Loyalty\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Loyalty\Listeners\EarnPointsFromOrder;
use Modules\Loyalty\Models\LoyaltyPoint;
use Modules\Loyalty\Models\LoyaltyRule;
use Modules\Pos\Events\OrderPaid;
use Modules\Pos\Models\PosOrder;
use Tests\TestCase;

class PointsRuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_applies_earn_rate(): void
    {
        LoyaltyRule::create([
            'tenant_id' => 'tenant-demo',
            'name' => 'default',
            'earn_rate' => 2,
            'stackable' => true,
        ]);

        $order = new PosOrder(['tenant_id' => 'tenant-demo', 'total' => 10]);
        $order->customer_id = 'cust-1';
        $listener = new EarnPointsFromOrder();
        $listener->handle(new OrderPaid($order));

        $this->assertDatabaseHas('loyalty_points', [
            'customer_id' => 'cust-1',
            'balance' => 20,
        ]);
    }
}
