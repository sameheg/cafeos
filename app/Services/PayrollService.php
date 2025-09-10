<?php

namespace App\Services;

use App\Models\Attendance;
use App\Support\CurrencyFormatter;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class PayrollService
{
    /**
     * Calculate total wages from a set of attendances and tips.
     *
     * @param  iterable<Attendance|array{clock_in:mixed,clock_out:mixed}>  $attendances
     */
    public function calculateWages(iterable $attendances, float $hourlyRate, float $tips = 0.0): float
    {
        $hours = $this->calculateHours($attendances);

        return $hours * $hourlyRate + $tips;
    }

    /**
     * Generate a payout report summarizing hours and wages.
     *
     * @param  iterable<Attendance|array{clock_in:mixed,clock_out:mixed}>  $attendances
     * @return array{hours: float, wage: float, formatted_wage: string}
     */
    public function generatePayoutReport(iterable $attendances, float $hourlyRate, float $tips = 0.0): array
    {
        $hours = $this->calculateHours($attendances);
        $wage = $hours * $hourlyRate + $tips;

        return [
            'hours' => $hours,
            'wage' => $wage,
            'formatted_wage' => CurrencyFormatter::format($wage),
        ];
    }

    /**
     * Export payout reports to a CSV string for accounting systems.
     *
     * @param  iterable<array{hours: float, wage: float}>  $reports
     */
    public function exportForAccounting(iterable $reports): string
    {
        $csv = "hours,wage\n";
        foreach ($reports as $report) {
            $csv .= $report['hours'] . ',' . $report['wage'] . "\n";
        }

        return $csv;
    }

    /**
     * Calculate total hours from the provided attendances.
     *
     * @param  iterable<Attendance|array{clock_in:mixed,clock_out:mixed}>  $attendances
     */
    private function calculateHours(iterable $attendances): float
    {
        $hours = 0.0;
        foreach ($attendances as $attendance) {
            $clockIn = $attendance instanceof Attendance ? $attendance->clock_in : $attendance['clock_in'];
            $clockOut = $attendance instanceof Attendance ? $attendance->clock_out : $attendance['clock_out'];

            if (! $clockIn instanceof CarbonInterface) {
                $clockIn = Carbon::parse($clockIn);
            }

            if (! $clockOut instanceof CarbonInterface) {
                $clockOut = Carbon::parse($clockOut);
            }

            $hours += $clockOut->diffInMinutes($clockIn, true) / 60;
        }

        return $hours;
    }
}

