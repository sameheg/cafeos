<?php

namespace App\Support {
    if (! function_exists(__NAMESPACE__ . '\\tenant')) {
        function tenant($key = null) {
            $tenant = \Tests\Unit\PayrollServiceTenantContext::$tenant;
            if (! $tenant) {
                return null;
            }
            return $key ? $tenant->{$key} : $tenant;
        }
    }
}

namespace Tests\Unit {

use App\Models\Attendance;
use App\Models\Tenant;
use App\Services\PayrollService;
use NumberFormatter;
use Tests\TestCase;

class PayrollServiceTenantContext
{
    public static ?Tenant $tenant = null;
}

class PayrollServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        PayrollServiceTenantContext::$tenant = null;
        app()->forgetInstance('tenant');
    }

    public function test_calculates_wages_generates_report_and_exports_csv_with_tenant_currency(): void
    {
        $tenant = new Tenant(['id' => 1, 'currency' => 'EUR']);
        PayrollServiceTenantContext::$tenant = $tenant;

        $attendances = [
            new Attendance(['clock_in' => '2024-01-01 08:00', 'clock_out' => '2024-01-01 12:00']),
            new Attendance(['clock_in' => '2024-01-02 09:00', 'clock_out' => '2024-01-02 12:30']),
        ];

        $service = new PayrollService();
        $report = $service->generatePayoutReport($attendances, 10, 5);

        $this->assertSame(7.5, $report['hours']);
        $this->assertSame(80.0, $report['wage']);

        $formatter = new NumberFormatter(app()->getLocale(), NumberFormatter::CURRENCY);
        $this->assertSame($formatter->formatCurrency(80, 'EUR'), $report['formatted_wage']);

        $csv = $service->exportForAccounting([$report]);
        $this->assertSame("hours,wage\n7.5,80\n", $csv);
    }
}

}

