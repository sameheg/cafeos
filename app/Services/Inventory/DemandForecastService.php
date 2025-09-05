<?php

namespace App\Services\Inventory;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DemandForecastService
{
    /**
     * Generate forecasted demand for products based on past sales.
     *
     * @param int $days Number of days to look back for sales data.
     * @return \Illuminate\Support\Collection
     */
    public function generate(int $days = 30)
    {
        $startDate = Carbon::now()->subDays($days);

        $sales = DB::table('transaction_sell_lines')
            ->join('transactions', 'transaction_sell_lines.transaction_id', '=', 'transactions.id')
            ->where('transactions.type', 'sell')
            ->where('transactions.status', 'final')
            ->whereDate('transactions.transaction_date', '>=', $startDate->toDateString())
            ->select('transaction_sell_lines.product_id', DB::raw('SUM(transaction_sell_lines.quantity) as qty'))
            ->groupBy('transaction_sell_lines.product_id')
            ->get();

        return $sales->mapWithKeys(function ($row) {
            return [$row->product_id => (float) $row->qty];
        });
    }

    /**
     * Update the forecasted_demands table using the latest forecasts.
     *
     * @return void
     */
    public function updateForecastedDemands(): void
    {
        $forecasts = $this->generate();

        foreach ($forecasts as $productId => $qty) {
            $businessId = DB::table('products')->where('id', $productId)->value('business_id');

            DB::table('forecasted_demands')->updateOrInsert(
                ['product_id' => $productId, 'business_id' => $businessId],
                ['forecast_quantity' => $qty, 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}
