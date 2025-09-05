<?php

namespace App\Charts;

use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SalesTrendChart
{
    /**
     * Build sales trend chart data.
     *
     * @param  array  $filters
     * @return array
     */
    public function data(array $filters = []): array
    {
        $start = isset($filters['start_date'])
            ? Carbon::parse($filters['start_date'])
            : Carbon::now()->subDays(6)->startOfDay();
        $end = isset($filters['end_date'])
            ? Carbon::parse($filters['end_date'])
            : Carbon::now()->endOfDay();

        $cacheKey = sprintf(
            'charts.sales_trend.%s.%s',
            $start->toDateString(),
            $end->toDateString()
        );

        return Cache::remember($cacheKey, 3600, function () use ($start, $end) {
            $labels = [];
            $values = [];

            $period = $start->copy();
            while ($period->lte($end)) {
                $labels[] = $period->format('d M');
                $values[] = Transaction::where('type', 'sell')
                    ->whereDate('transaction_date', $period->toDateString())
                    ->sum('final_total');
                $period->addDay();
            }

            return [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => __('dashboard.sales_trend'),
                        'data' => $values,
                    ],
                ],
            ];
        });
    }
}
