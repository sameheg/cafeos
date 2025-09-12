<?php

namespace Modules\FloorPlanDesigner\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\FloorPlanDesigner\Models\Furniture;
use Modules\FloorPlanDesigner\Events\FurnitureUpdated;

class HandlePosOrderClosed implements ShouldQueue
{
    public function handle(object $event): void
    {
        $posTableId = $event->pos_table_id ?? null;
        if (!$posTableId) return;
        $f = Furniture::where('pos_table_id',$posTableId)->first();
        if (!$f) return;
        $f->update(['status'=>'available']);
        event(new FurnitureUpdated($f));
    }
}
