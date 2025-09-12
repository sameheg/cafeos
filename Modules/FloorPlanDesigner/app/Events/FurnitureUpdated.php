<?php

namespace Modules\FloorPlanDesigner\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Modules\FloorPlanDesigner\Models\Furniture;

class FurnitureUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(public Furniture $f) {}

    public function broadcastOn(): array { return ['tenant.'.$this->f->tenant_id.'.floorplan']; }
    public function broadcastAs(): string { return 'floorplan.table.updated@v1'; }
    public function broadcastWith(): array { return $this->f->toArray(); }
}
