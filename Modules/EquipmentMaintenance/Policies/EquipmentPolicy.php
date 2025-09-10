<?php

namespace Modules\EquipmentMaintenance\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\EquipmentMaintenance\Models\Equipment;

class EquipmentPolicy extends BasePolicy
{
    protected static string $model = Equipment::class;
}
