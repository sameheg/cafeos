<?php

namespace Modules\Notifications\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GenericNotification extends Notification
{
    public function __construct(public string $content, public string $channel) {}

    public function via(object $notifiable): array
    {
        return [$this->channel];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->line($this->content);
    }

    public function toTwilio(object $notifiable)
    {
        return (new \NotificationChannels\Twilio\TwilioSmsMessage)->content($this->content);
    }
}
