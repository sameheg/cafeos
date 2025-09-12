<?php

namespace Modules\HRJobs\Tests\Unit;

use Carbon\Carbon;
use Modules\HRJobs\Models\Shift;
use Modules\HRJobs\Services\PayrollCalculator;
use Tests\TestCase;

class PayrollCalculatorTest extends TestCase
{
    /** @test */
    public function it_calculates_payroll_from_shift_duration(): void
    {
        $shift = new Shift([
            'start' => Carbon::parse('2024-01-01 09:00:00'),
            'end' => Carbon::parse('2024-01-01 17:00:00'),
        ]);

        $calc = new PayrollCalculator();

        $this->assertEquals(120.0, $calc->calculate($shift));
    }
}

