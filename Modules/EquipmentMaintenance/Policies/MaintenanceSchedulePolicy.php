<?php

namespace Modules\EquipmentMaintenance\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\EquipmentMaintenance\Models\MaintenanceSchedule;

class MaintenanceSchedulePolicy extends BasePolicy
{
    protected static string $model = MaintenanceSchedule::class;
}
