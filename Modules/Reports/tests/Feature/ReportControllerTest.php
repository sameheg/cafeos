<?php

namespace Modules\Reports\Tests\Feature;

use App\Http\Middleware\InitializeTenancyByDomain;
use App\Http\Middleware\SetUserLocale;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    public function test_index_returns_aggregated_reports(): void
    {
        $this->withoutMiddleware([InitializeTenancyByDomain::class, SetUserLocale::class]);
        $response = $this->getJson('/api/v1/reports');

        $response->assertOk();
        $response->assertJsonFragment(['module' => 'core']);
        $response->assertJsonFragment(['module' => 'pos']);
        $response->assertJsonFragment(['module' => 'crm']);
    }

    public function test_export_supports_multiple_formats(): void
    {
        $this->withoutMiddleware([InitializeTenancyByDomain::class, SetUserLocale::class]);

        $csv = $this->get('/api/v1/reports/export/csv');
        $csv->assertOk();
        $this->assertStringContainsString('text/csv', $csv->headers->get('Content-Type'));

        $excel = $this->get('/api/v1/reports/export/excel');
        $excel->assertOk();
        $this->assertStringContainsString('application/vnd.ms-excel', $excel->headers->get('Content-Type'));

        $pdf = $this->get('/api/v1/reports/export/pdf');
        $pdf->assertOk();
        $this->assertStringContainsString('application/pdf', $pdf->headers->get('Content-Type'));
    }
}
