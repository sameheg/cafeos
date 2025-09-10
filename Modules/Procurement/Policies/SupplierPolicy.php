<?php

namespace Modules\Procurement\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Procurement\Models\Supplier;

class SupplierPolicy extends BasePolicy
{
    protected static string $model = Supplier::class;
}
