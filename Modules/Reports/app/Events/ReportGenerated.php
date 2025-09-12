<?php

namespace Modules\Reports\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Reports\Models\Report;

class ReportGenerated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $event = 'reports.generated@v1';

    public function __construct(public Report $report)
    {
    }

    public function broadcastOn(): array
    {
        return [];
    }

    public function broadcastWith(): array
    {
        return [
            'report_id' => (string) $this->report->id,
            'type' => $this->report->type,
        ];
    }
}
