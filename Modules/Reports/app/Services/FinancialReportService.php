<?php

namespace Modules\Reports\Services;

class FinancialReportService
{
    /**
     * Generate aggregate financial report.
     *
     * @param  array  $transactions  Each transaction contains revenue and cost.
     */
    public function generateReport(array $transactions): array
    {
        $totals = ['revenue' => 0, 'cost' => 0];

        foreach ($transactions as $transaction) {
            $totals['revenue'] += $transaction['revenue'];
            $totals['cost'] += $transaction['cost'];
        }

        $totals['profit'] = $totals['revenue'] - $totals['cost'];

        return $totals;
    }

    /**
     * Forecast revenue using a simple moving average.
     *
     * @param  array  $monthlyRevenue  Historical revenue values.
     * @param  int  $months  Number of months to forecast.
     */
    public function forecastRevenue(array $monthlyRevenue, int $months = 1): array
    {
        $forecast = [];
        $data = $monthlyRevenue;

        for ($i = 0; $i < $months; $i++) {
            $average = array_sum($data) / count($data);
            $forecast[] = $average;
            $data[] = $average;
            array_shift($data);
        }

        return $forecast;
    }
}
