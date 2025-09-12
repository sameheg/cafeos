<?php

namespace Modules\FloorPlanDesigner\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\FloorPlanDesigner\Models\Floorplan;

class FloorplanUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public string $planId;
    public array $changes;
    public string $event = 'floorplan.updated@v1';

    public function __construct(Floorplan $plan, array $changes)
    {
        $this->planId = (string) $plan->id;
        $this->changes = $changes;
    }

    public function toArray(): array
    {
        return [
            'plan_id' => $this->planId,
            'changes' => $this->changes,
        ];
    }
}
