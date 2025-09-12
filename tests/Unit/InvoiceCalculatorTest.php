<?php

namespace Tests\Unit;

use Modules\Billing\Services\InvoiceCalculator;
use PHPUnit\Framework\TestCase;

class InvoiceCalculatorTest extends TestCase
{
    public function test_proration_applies_when_enabled(): void
    {
        $calc = new InvoiceCalculator(true);
        $this->assertSame(50.0, $calc->calculate(100, 0.5));
    }

    public function test_proration_skipped_when_disabled(): void
    {
        $calc = new InvoiceCalculator(false);
        $this->assertSame(100.0, $calc->calculate(100, 0.5));
    }
}
