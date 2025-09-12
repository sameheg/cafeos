<?php

namespace Tests\Contract;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\Reports\Events\ReportGenerated;
use Modules\Reports\Models\Report;
use Tests\TestCase;

class ReportsEventSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_schema_matches(): void
    {
        Event::fake([ReportGenerated::class]);
        $report = Report::factory()->create();

        Event::assertDispatched(ReportGenerated::class, function ($event) use ($report) {
            return $event->broadcastWith() === [
                'report_id' => (string) $report->id,
                'type' => $report->type,
            ];
        });
    }
}
