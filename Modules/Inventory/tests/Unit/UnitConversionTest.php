<?php

namespace Modules\Inventory\Tests\Unit;

use Modules\Inventory\Services\UnitConversionService;
use PHPUnit\Framework\TestCase;

class UnitConversionTest extends TestCase
{
    public function test_converts_kg_to_g(): void
    {
        $service = new UnitConversionService();
        $this->assertEquals(1000, $service->convert(1, 'kg', 'g'));
    }
}
