<?php

namespace Modules\Kds\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Kds\Models\KdsTicket;

class TicketCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public KdsTicket $ticket)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('kds.tickets.' . $this->ticket->station);
    }

    public function broadcastAs(): string
    {
        return 'kds.ticket.completed';
    }

    public function broadcastWith(): array
    {
        return [
            'ticket_id' => $this->ticket->id,
            'station' => $this->ticket->station,
        ];
    }
}
