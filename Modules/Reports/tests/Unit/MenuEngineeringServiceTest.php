<?php

namespace Modules\Reports\Tests\Unit;

use Modules\Reports\Services\MenuEngineeringService;
use Tests\TestCase;

class MenuEngineeringServiceTest extends TestCase
{
    public function test_calculates_profitability_and_popularity(): void
    {
        $service = new MenuEngineeringService();
        $items = [
            ['name' => 'Coffee', 'price' => 5, 'cost' => 2, 'sales' => 100],
            ['name' => 'Tea', 'price' => 3, 'cost' => 1, 'sales' => 50],
        ];

        $result = $service->calculate($items);

        $this->assertCount(2, $result);
        $this->assertEquals(3.0, $result[0]['profitability']);
        $this->assertEqualsWithDelta(100/150, $result[0]['popularity'], 0.0001);
    }
}
