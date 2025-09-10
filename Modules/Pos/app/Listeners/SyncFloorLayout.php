<?php

namespace Modules\Pos\Listeners;

use Modules\FloorPlanDesigner\Events\FloorLayoutUpdated;

class SyncFloorLayout
{
    public function handle(FloorLayoutUpdated $event): void
    {
        \Log::info('Floor layout synced', ['tenant_id' => $event->layout->tenant_id]);
    }
}
