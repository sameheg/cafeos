<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Business;
use Spatie\Activitylog\Models\Activity;
use Carbon\Carbon;

class CleanActivityLog extends Command
{
    protected $signature = 'activitylog:clean';

    protected $description = 'Delete activity log entries older than retention period';

    public function handle(): int
    {
        $businesses = Business::all();

        foreach ($businesses as $business) {
            $settings = $business->common_settings ?? [];
            $days = $settings['activity_log_retention_days'] ?? null;

            if (! empty($days)) {
                $date = Carbon::now()->subDays((int) $days);
                Activity::where('business_id', $business->id)
                    ->where('created_at', '<', $date)
                    ->delete();
            }
        }

        $this->info('Activity logs cleaned.');

        return Command::SUCCESS;
    }
}

