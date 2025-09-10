<?php

namespace Modules\EquipmentMaintenance\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\EquipmentMaintenance\Models\MaintenanceLog;

class MaintenanceLogPolicy extends BasePolicy
{
    protected static string $model = MaintenanceLog::class;
}
