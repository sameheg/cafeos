<?php

namespace App\Charts;

use App\TransactionSellLine;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TopItemsChart
{
    /**
     * Build top items chart data.
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
        $limit = $filters['limit'] ?? 5;

        $cacheKey = sprintf(
            'charts.top_items.%s.%s.%d',
            $start->toDateString(),
            $end->toDateString(),
            $limit
        );

        return Cache::remember($cacheKey, 3600, function () use ($start, $end, $limit) {
            $lines = TransactionSellLine::select('product_id', DB::raw('SUM(quantity) as total'))
                ->whereHas('transaction', function ($query) use ($start, $end) {
                    $query->where('type', 'sell')
                        ->whereBetween('transaction_date', [$start->toDateString(), $end->toDateString()]);
                })
                ->groupBy('product_id')
                ->orderByDesc('total')
                ->with('product:id,name')
                ->limit($limit)
                ->get();

            $labels = $lines->pluck('product.name')->toArray();
            $values = $lines->pluck('total')->map(fn ($v) => (float) $v)->toArray();

            return [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => __('dashboard.top_items'),
                        'data' => $values,
                    ],
                ],
            ];
        });
    }
}
