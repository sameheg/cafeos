<?php

namespace Modules\Inventory\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Inventory\Models\InventoryItem;

class InventoryItemPolicy extends BasePolicy
{
    protected static string $model = InventoryItem::class;
}
