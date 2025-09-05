<?php

namespace Modules\POS\Events;

use App\Restaurant\TableOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderCompleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public TableOrder $order;

    public function __construct(TableOrder $order)
    {
        $this->order = $order;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('pos.orders');
    }

    public function broadcastAs(): string
    {
        return 'pos.order.completed';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->order->id,
            'table_id' => $this->order->table_id,
            'status' => $this->order->status,
        ];
    }
}
