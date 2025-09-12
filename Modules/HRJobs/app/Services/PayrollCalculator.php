<?php

namespace Modules\HRJobs\Services;

use Modules\HRJobs\Models\Shift;

class PayrollCalculator
{
    /**
     * Basic payroll calculation based on duration and a flat rate.
     */
    public function calculate(Shift $shift): float
    {
        $hours = $shift->start->diffInMinutes($shift->end) / 60;
        $rate = 15; // Flat hourly rate for MVP

        return round($hours * $rate, 2);
    }
}

