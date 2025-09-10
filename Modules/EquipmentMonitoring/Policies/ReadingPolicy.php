<?php

namespace Modules\EquipmentMonitoring\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\EquipmentMonitoring\Models\Reading;

class ReadingPolicy extends BasePolicy
{
    protected static string $model = Reading::class;
}
