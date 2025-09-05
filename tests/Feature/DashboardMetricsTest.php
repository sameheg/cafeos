<?php

namespace Tests\Feature;

use App\Charts\CommonChart;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class DashboardMetricsTest extends TestCase
{
    public function test_dashboard_displays_cached_metrics()
    {
        $chart = new CommonChart();
        $chart->labels(['Day 1']);
        $chart->dataset('Sales', 'line', [1]);

        Cache::shouldReceive('remember')
            ->andReturn(10, 20, 5, 8, $chart);

        $response = $this->withoutMiddleware()->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('10');
        $response->assertSee('20');
        $response->assertSee('5');
        $response->assertSee('8');
    }
}
