<?php

namespace App\Events;

use App\Restaurant\TableOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TableOrderPlaced implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public TableOrder $tableOrder;

    public function __construct(TableOrder $tableOrder)
    {
        $this->tableOrder = $tableOrder;
    }

    public function broadcastOn()
    {
        return new Channel('kitchen-orders');
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->tableOrder->id,
            'table_id' => $this->tableOrder->table_id,
            'status' => $this->tableOrder->status,
        ];
    }

    public function broadcastAs()
    {
        return 'TableOrderPlaced';
    }
}
