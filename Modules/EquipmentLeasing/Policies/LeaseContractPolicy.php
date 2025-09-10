<?php

namespace Modules\EquipmentLeasing\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\EquipmentLeasing\Models\LeaseContract;

class LeaseContractPolicy extends BasePolicy
{
    protected static string $model = LeaseContract::class;
}
