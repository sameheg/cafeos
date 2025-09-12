<?php

namespace Modules\Pos\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Modules\Pos\Models\PosItem;

class ItemKitchenUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;
    public function __construct(public PosItem $item) {}
    public function broadcastOn(): array { return ['tenant.'.$this->item->tenant_id.'.kds']; }
    public function broadcastAs(): string { return 'pos.item.kitchen'; }
    public function broadcastWith(): array { return ['item_id'=>$this->item->id,'status'=>$this->item->kitchen_status]; }
}
