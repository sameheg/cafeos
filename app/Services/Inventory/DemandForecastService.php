<?php

namespace App\Services\Inventory;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DemandForecastService
{
    /**
     * Generate forecasted demand for products based on past sales.
     *
     * @param int      $days       Number of days to look back for sales data.
     * @param int|null $businessId Optional business identifier to filter results.
     * @return \Illuminate\Support\Collection
     */
    public function generate(int $days = 30, ?int $businessId = null)
    {
        $startDate = Carbon::now()->subDays($days);

        $query = DB::table('transaction_sell_lines')
            ->join('transactions', 'transaction_sell_lines.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_sell_lines.product_id', '=', 'products.id')
            ->where('transactions.type', 'sell')
            ->where('transactions.status', 'final')
            ->whereDate('transactions.transaction_date', '>=', $startDate->toDateString())
            ->select(
                'transaction_sell_lines.product_id',
                'products.business_id',
                DB::raw('SUM(transaction_sell_lines.quantity) as qty')
            )
            ->groupBy('transaction_sell_lines.product_id', 'products.business_id');

        if ($businessId !== null) {
            $query->where('products.business_id', $businessId);
        }

        $sales = $query->get();

        if ($businessId !== null) {
            return $sales->mapWithKeys(function ($row) {
                return [$row->product_id => (float) $row->qty];
            });
        }

        return $sales->groupBy('business_id')->map(function ($group) {
            return $group->mapWithKeys(function ($row) {
                return [$row->product_id => (float) $row->qty];
            });
        });
    }

    /**
     * Update the forecasted_demands table using the latest forecasts.
     *
     * @param int|null $businessId Optional business identifier to limit updates.
     * @return void
     */
    public function updateForecastedDemands(?int $businessId = null): void
    {
        $forecasts = $this->generate(businessId: $businessId);

        if ($businessId !== null) {
            foreach ($forecasts as $productId => $qty) {
                DB::table('forecasted_demands')->updateOrInsert(
                    ['product_id' => $productId, 'business_id' => $businessId],
                    ['forecast_quantity' => $qty, 'updated_at' => now(), 'created_at' => now()]
                );
            }

            return;
        }

        foreach ($forecasts as $bizId => $products) {
            foreach ($products as $productId => $qty) {
                DB::table('forecasted_demands')->updateOrInsert(
                    ['product_id' => $productId, 'business_id' => $bizId],
                    ['forecast_quantity' => $qty, 'updated_at' => now(), 'created_at' => now()]
                );
            }
        }
    }
}
