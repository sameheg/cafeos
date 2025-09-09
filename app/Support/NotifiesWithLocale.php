<?php

namespace App\Support;

use Illuminate\Notifications\Notification;

trait NotifiesWithLocale
{
    /**
     * Send the given notification using the recipient's preferred locale.
     */
    public function notifyWithLocale(Notification $notification, ?string $locale = null): void
    {
        $locale = $locale ?? $this->locale ?? app()->getLocale();

        $this->notify($notification->locale($locale));
    }
}
