<?php

namespace Modules\Loyalty\Tests\Contract;

use Modules\Loyalty\Events\PointsEarned;
use Tests\TestCase;

class LoyaltyEventSchemaTest extends TestCase
{
    public function test_points_earned_schema(): void
    {
        $event = new PointsEarned('cust-1', 10);
        $this->assertEquals('loyalty.points.earned', $event->broadcastAs());
        $this->assertSame(['customer_id' => 'cust-1', 'points' => 10], $event->broadcastWith());
    }
}
