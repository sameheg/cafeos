<?php

namespace Modules\FloorPlanDesigner\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\FloorPlanDesigner\Models\FloorLayout;

class FloorLayoutUpdated
{
    use Dispatchable, SerializesModels;

    public FloorLayout $layout;

    public function __construct(FloorLayout $layout)
    {
        $this->layout = $layout;
    }
}
