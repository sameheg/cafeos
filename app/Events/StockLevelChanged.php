<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StockLevelChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $productId;
    public $locationId;
    public $quantity;

    public function __construct($productId, $locationId, $quantity)
    {
        $this->productId = $productId;
        $this->locationId = $locationId;
        $this->quantity = $quantity;
    }

    public function broadcastOn()
    {
        return new Channel('stock');
    }
}
