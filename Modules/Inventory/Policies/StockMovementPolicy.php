<?php

namespace Modules\Inventory\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Inventory\Models\StockMovement;

class StockMovementPolicy extends BasePolicy
{
    protected static string $model = StockMovement::class;
}
