<?php

namespace Modules\Procurement\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Procurement\Models\PurchaseOrder;

class PurchaseOrderPolicy extends BasePolicy
{
    protected static string $model = PurchaseOrder::class;
}
