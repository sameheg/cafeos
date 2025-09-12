<?php

namespace Modules\Reports\Console;

use Illuminate\Console\Command;
use Modules\Reports\Models\Report;
use Modules\Reports\Models\ReportSchedule;
use Illuminate\Support\Facades\Notification;
use Modules\Reports\Notifications\ReportDelivered;

class SendScheduledReportsCommand extends Command
{
    protected $signature = 'reports:send-scheduled';
    protected $description = 'Send scheduled report exports';

    public function handle(): int
    {
        ReportSchedule::chunk(100, function ($schedules) {
            foreach ($schedules as $schedule) {
                $report = Report::find($schedule->report_id);
                if ($report) {
                    $report->export();
                    Notification::route('mail', 'reports@example.com')->notify(new ReportDelivered($report));
                }
            }
        });
        return self::SUCCESS;
    }
}
