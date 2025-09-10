<?php

namespace Modules\Kds\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Kds\Models\KitchenStation;

class KitchenStationPolicy extends BasePolicy
{
    protected static string $model = KitchenStation::class;
}
