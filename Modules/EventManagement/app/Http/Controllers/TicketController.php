<?php

namespace Modules\EventManagement\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Laravel\Pennant\Feature;
use Modules\EventManagement\Models\Event;
use Modules\EventManagement\Models\EventTicket;
use Modules\EventManagement\Services\CapacityChecker;
use Modules\EventManagement\Services\WaitlistService;

class TicketController
{
    public function store(Request $request, CapacityChecker $checker, WaitlistService $waitlist): JsonResponse
    {
        $data = $request->validate([
            'event_id' => 'required|string',
        ]);

        $event = Event::findOrFail($data['event_id']);

        if (! $checker->hasCapacity($event)) {
            if (Feature::active('event_waitlists')) {
                $waitlist->add($event->id, 'anonymous');
            }

            return response()->json(['message' => 'Sold Out'], 410);
        }

        $ticket = EventTicket::create([
            'tenant_id' => $event->tenant_id,
            'event_id' => $event->id,
            'attendee_id' => Crypt::encryptString('anonymous'),
        ]);

        return response()->json(['ticket_id' => $ticket->id]);
    }
}
