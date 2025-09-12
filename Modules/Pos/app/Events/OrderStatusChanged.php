<?php

namespace Modules\Pos\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Modules\Pos\Models\PosOrder;

class OrderStatusChanged implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    public function __construct(public PosOrder $order) {}
    public function broadcastOn(): array { return ['tenant.'.$this->order->tenant_id.'.kds']; }
    public function broadcastAs(): string { return 'pos.order.status'; }
    public function broadcastWith(): array { return ['order_id'=>$this->order->id,'status'=>$this->order->status]; }
}
