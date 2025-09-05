<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $orderId;
    public $status;
    public $lineId;

    public function __construct($orderId, $status, $lineId = null)
    {
        $this->orderId = $orderId;
        $this->status = $status;
        $this->lineId = $lineId;
    }

    public function broadcastOn()
    {
        return new Channel('orders');
    }

    public function broadcastWith()
    {
        return [
            'orderId' => $this->orderId,
            'status' => $this->status,
            'lineId' => $this->lineId,
        ];
    }

    public function broadcastAs()
    {
        return 'OrderStatusUpdated';
    }
}
