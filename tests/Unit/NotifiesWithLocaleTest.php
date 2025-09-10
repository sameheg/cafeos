<?php

namespace Tests\Unit;

use App\Support\NotifiesWithLocale;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Tests\TestCase;

class NotifiesWithLocaleTest extends TestCase
{
    public function test_notification_uses_recipient_locale(): void
    {
        $user = new class
        {
            use Notifiable;
            use NotifiesWithLocale;

            public string $locale = 'fr';
        };

        $notification = new class extends Notification
        {
            public function via($notifiable): array
            {
                return [];
            }

            public function getLocale(): ?string
            {
                return $this->locale;
            }
        };

        $user->notifyWithLocale($notification);

        $this->assertSame('fr', $notification->getLocale());
    }
}
