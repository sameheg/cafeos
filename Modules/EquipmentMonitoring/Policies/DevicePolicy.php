<?php

namespace Modules\EquipmentMonitoring\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\EquipmentMonitoring\Models\Device;

class DevicePolicy extends BasePolicy
{
    protected static string $model = Device::class;
}
