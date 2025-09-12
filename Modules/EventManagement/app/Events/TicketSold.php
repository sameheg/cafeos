<?php

namespace Modules\EventManagement\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketSold
{
    use Dispatchable, SerializesModels;

    public function __construct(public string $ticketId, public string $eventId)
    {
    }

    public function payload(): array
    {
        return [
            'ticket_id' => $this->ticketId,
            'event_id' => $this->eventId,
        ];
    }
}
