<?php

namespace Modules\FloorPlanDesigner\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\FloorPlanDesigner\Models\Furniture;
use Modules\FloorPlanDesigner\Events\FurnitureUpdated;

class HandlePosOrderStarted implements ShouldQueue
{
    public function handle(object $event): void
    {
        // Expecting $event to carry pos_table_id or furniture id
        $posTableId = $event->pos_table_id ?? null;
        if (!$posTableId) return;
        $f = Furniture::where('pos_table_id',$posTableId)->first();
        if (!$f) return;
        $f->update(['status'=>'occupied']);
        event(new FurnitureUpdated($f));
    }
}
