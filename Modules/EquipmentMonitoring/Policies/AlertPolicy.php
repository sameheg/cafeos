<?php

namespace Modules\EquipmentMonitoring\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\EquipmentMonitoring\Models\Alert;

class AlertPolicy extends BasePolicy
{
    protected static string $model = Alert::class;
}
