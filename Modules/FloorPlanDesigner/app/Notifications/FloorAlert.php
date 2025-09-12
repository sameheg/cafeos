<?php

namespace Modules\FloorPlanDesigner\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FloorAlert extends Notification
{
    use Queueable;

    public function __construct(public string $message) {}

    public function via(object $notifiable): array { return ['mail']; }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->subject('FloorPlan Alert')->line($this->message);
    }
}
