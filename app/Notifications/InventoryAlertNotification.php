<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InventoryAlertNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $product, public string $message)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Inventory Alert')
            ->line($this->message);
    }

    public function toArray($notifiable): array
    {
        return [
            'product_id' => $this->product->id ?? null,
            'message' => $this->message,
        ];
    }
}
