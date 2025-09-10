<?php

namespace Tests\Unit;

use App\Services\ZonePricingService;
use Tests\TestCase;

class ZonePricingServiceTest extends TestCase
{
    public function test_calculates_price_between_zones(): void
    {
        $service = new ZonePricingService;
        $price = $service->calculatePrice('zone_1', 'zone_2');
        $this->assertSame(5.0, $price);
    }
}
