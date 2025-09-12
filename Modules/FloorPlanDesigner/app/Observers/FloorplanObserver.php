<?php

namespace Modules\FloorPlanDesigner\Observers;

use Modules\FloorPlanDesigner\Events\FloorplanUpdated;
use Modules\FloorPlanDesigner\Models\Floorplan;

class FloorplanObserver
{
    public function updated(Floorplan $plan): void
    {
        event(new FloorplanUpdated($plan, $plan->getChanges()));
    }
}
