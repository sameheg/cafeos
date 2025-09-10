<?php

namespace Modules\FloorPlanDesigner\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\FloorPlanDesigner\Models\FloorLayout;

class FloorLayoutPolicy extends BasePolicy
{
    protected static string $model = FloorLayout::class;
}
