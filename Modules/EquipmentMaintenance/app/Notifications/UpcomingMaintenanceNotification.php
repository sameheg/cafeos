<?php

namespace Modules\EquipmentMaintenance\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\EquipmentMaintenance\Models\MaintenanceSchedule;

class UpcomingMaintenanceNotification extends Notification
{
    use Queueable;

    public function __construct(public MaintenanceSchedule $schedule) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Upcoming Maintenance Reminder')
            ->line('Equipment: '.$this->schedule->equipment->name)
            ->line('Scheduled for: '.$this->schedule->scheduled_at->toDateString())
            ->line('Thank you.');
    }
}
