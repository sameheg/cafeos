<?php

namespace Modules\EquipmentMaintenance\Console;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use Modules\EquipmentMaintenance\Models\MaintenanceSchedule;
use Modules\EquipmentMaintenance\Notifications\UpcomingMaintenanceNotification;

class CheckMaintenanceSchedules extends Command
{
    protected $signature = 'equipment-maintenance:check';

    protected $description = 'Send alerts for upcoming maintenance';

    public function handle(): int
    {
        $schedules = MaintenanceSchedule::where('scheduled_at', '<=', now()->addDays(7))
            ->where('alerted', false)
            ->get();

        if ($schedules->isEmpty()) {
            $this->info('No upcoming maintenance.');

            return self::SUCCESS;
        }

        $users = User::all();
        foreach ($schedules as $schedule) {
            Notification::send($users, new UpcomingMaintenanceNotification($schedule));
            $schedule->update(['alerted' => true]);
        }

        $this->info('Notifications sent.');

        return self::SUCCESS;
    }
}
