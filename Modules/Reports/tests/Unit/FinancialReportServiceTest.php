<?php

namespace Modules\Reports\Tests\Unit;

use Modules\Reports\Services\FinancialReportService;
use Tests\TestCase;

class FinancialReportServiceTest extends TestCase
{
    public function test_generates_report_and_forecast(): void
    {
        $service = new FinancialReportService();
        $transactions = [
            ['revenue' => 1000, 'cost' => 400],
            ['revenue' => 1500, 'cost' => 500],
        ];

        $report = $service->generateReport($transactions);

        $this->assertSame(2500, $report['revenue']);
        $this->assertSame(900, $report['cost']);
        $this->assertSame(1600, $report['profit']);

        $forecast = $service->forecastRevenue([1000, 1200, 1300], 2);
        $this->assertCount(2, $forecast);
        $this->assertEqualsWithDelta(1166.6667, $forecast[0], 0.0001);
    }
}
