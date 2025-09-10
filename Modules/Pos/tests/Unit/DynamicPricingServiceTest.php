<?php

namespace Modules\Pos\Tests\Unit;

use Modules\Pos\Services\DynamicPricingService;
use PHPUnit\Framework\TestCase;

class DynamicPricingServiceTest extends TestCase
{
    public function test_applies_time_rule(): void
    {
        $service = new DynamicPricingService([
            ['type' => 'time', 'start' => '18:00', 'end' => '20:00', 'multiplier' => 1.5],
        ]);

        $price = $service->calculate(10.0, null, new \DateTimeImmutable('2024-01-01 18:30'));

        $this->assertSame(15.0, $price);
    }

    public function test_applies_day_and_customer_rules(): void
    {
        $service = new DynamicPricingService([
            ['type' => 'day', 'days' => ['Monday'], 'multiplier' => 0.8],
            ['type' => 'customer', 'customer' => 'VIP', 'multiplier' => 0.5],
        ]);

        $price = $service->calculate(10.0, 'VIP', new \DateTimeImmutable('2024-01-01 10:00:00'));

        $this->assertSame(4.0, $price);
    }
}
