<?php

namespace Modules\FloorPlanDesigner\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CursorMoved implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public function __construct(public string $tenantId, public string $userName, public array $pos) {}

    public function broadcastOn(): array { return ['tenant.'.$this->tenantId.'.floorplan']; }
    public function broadcastAs(): string { return 'cursor.moved'; }
    public function broadcastWith(): array { return ['user'=>$this->userName,'x'=>$this->pos['x'] ?? 0,'y'=>$this->pos['y'] ?? 0]; }
}
