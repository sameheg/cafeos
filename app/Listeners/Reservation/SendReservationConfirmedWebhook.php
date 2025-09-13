<?php

namespace App\Listeners\Reservation;

use App\Events\Reservation\ReservationConfirmed;
use App\Services\WebhookService;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReservationConfirmedWebhook implements ShouldQueue
{
    public function __construct(private WebhookService $webhookService) {}

    public function handle(ReservationConfirmed $event): void
    {
        $this->webhookService->send('reservation_confirmed', $event->reservation);
    }
}
