<?php

namespace Modules\Pos\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Modules\Pos\Models\PosOrder;

class OrderPaid implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public PosOrder $order)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('pos.orders');
    }

    public function broadcastAs(): string
    {
        return 'pos.order.paid';
    }

    public function broadcastWith(): array
    {
        return [
            'order_id' => $this->order->id,
            'amount' => $this->order->total,
            'items' => $this->order->items->map(fn($item) => [
                'id' => $item->product_id,
                'qty' => $item->qty,
            ])->toArray(),
        ];
    }
}
