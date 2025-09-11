<?php

namespace Modules\Inventory\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Inventory\Models\InventoryItem;

class StockUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $event = 'inventory.stock.updated';
    public InventoryItem $item;

    public function __construct(InventoryItem $item)
    {
        $this->item = $item;
    }

    public function broadcastOn(): array
    {
        return ['inventory'];
    }

    public function broadcastWith(): array
    {
        return [
            'item_id' => $this->item->id,
            'quantity' => $this->item->quantity,
        ];
    }
}
