<?php

namespace Modules\EventManagement\Observers;

use Illuminate\Support\Str;
use Laravel\Pennant\Feature;
use Modules\EventManagement\Events\TicketSold;
use Modules\EventManagement\Models\EventTicket;
use Modules\EventManagement\Services\CapacityChecker;
use Modules\EventManagement\Services\WaitlistService;
use Modules\EventManagement\Enums\TicketStatus;

class EventTicketObserver
{
    public function creating(EventTicket $ticket): void
    {
        if (! app(CapacityChecker::class)->hasCapacity($ticket->event)) {
            if (Feature::active('event_waitlists')) {
                app(WaitlistService::class)->add($ticket->event_id, $ticket->attendee_id);
            }
            throw new \RuntimeException('Sold out');
        }

        $ticket->id ??= Str::ulid();
        $ticket->status = TicketStatus::SOLD;
    }

    public function created(EventTicket $ticket): void
    {
        event(new TicketSold($ticket->id, $ticket->event_id));
    }
}
