<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Reports\Exports\ReportExport;
use Modules\Reports\Models\Report;
use Tests\TestCase;

class ExportTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_can_be_exported(): void
    {
        Excel::fake();
        $report = Report::factory()->create();
        $report->export();
        Excel::assertDownloaded($report->id.'.xlsx');
    }
}
