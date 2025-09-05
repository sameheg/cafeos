<?php

namespace App\Http\Controllers;

use App\Charts\CommonChart;
use App\Contact;
use App\Product;
use App\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Display dashboard metrics.
     */
    public function index()
    {
        $totalSales = Cache::remember('dashboard.total_sales', 3600, function () {
            return Transaction::where('type', 'sell')->sum('final_total');
        });

        $totalPurchases = Cache::remember('dashboard.total_purchases', 3600, function () {
            return Transaction::where('type', 'purchase')->sum('final_total');
        });

        $customerCount = Cache::remember('dashboard.customer_count', 3600, function () {
            return Contact::whereIn('type', ['customer', 'both'])->count();
        });

        $productCount = Cache::remember('dashboard.product_count', 3600, function () {
            return Product::count();
        });

        $chart = Cache::remember('dashboard.sales_chart', 3600, function () {
            $labels = [];
            $values = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $labels[] = Carbon::now()->subDays($i)->format('d M');
                $values[] = Transaction::where('type', 'sell')
                    ->whereDate('transaction_date', $date)
                    ->sum('final_total');
            }
            $chart = new CommonChart();
            $chart->labels($labels);
            $chart->dataset(__('dashboard.sales_last_7_days'), 'line', $values);
            return $chart;
        });

        return view('dashboard', [
            'totalSales' => $totalSales,
            'totalPurchases' => $totalPurchases,
            'customerCount' => $customerCount,
            'productCount' => $productCount,
            'chart' => $chart,
        ]);
    }
}
