<?php

namespace Modules\Notifications\Listeners;

use Modules\Notifications\Services\NotificationService;
use Modules\Inventory\Events\LowStockAlert;
use Modules\Billing\Events\UnpaidBillAlert;
use Modules\Pos\Events\TableOpened;
use Modules\Membership\Events\SubscriptionExpiring;
use Modules\Crm\Events\LowSurveyScore;

class SendNotification
{
    public function __construct(private NotificationService $notifications)
    {
    }

    public function handle(object $event): void
    {
        $message = match (true) {
            $event instanceof LowStockAlert => 'Low stock for '.$event->item->name,
            $event instanceof UnpaidBillAlert => 'Unpaid bill for order #'.$event->order->id,
            $event instanceof TableOpened => 'Table opened for order #'.$event->order->id,
            $event instanceof SubscriptionExpiring => 'Subscription for '.$event->customerId.' expires on '.$event->expiresAt->toDateString(),
            $event instanceof LowSurveyScore => 'Low survey score: '.$event->response->rating,
            default => 'Notification',
        };

        $channels = config('notifications.channels', ['in-app']);
        $this->notifications->send($message, $channels);
    }
}
