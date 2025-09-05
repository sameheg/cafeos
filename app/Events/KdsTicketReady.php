<?php

namespace App\Events;

use App\Restaurant\TableOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KdsTicketReady implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public TableOrder $order;

    public function __construct(TableOrder $order)
    {
        $this->order = $order;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('waiter-notifications');
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->order->id,
            'table_id' => $this->order->table_id,
            'status' => $this->order->status,
        ];
    }

    public function broadcastAs(): string
    {
        return 'kds.ticket.ready';
    }
}
