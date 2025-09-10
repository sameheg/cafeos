<?php

namespace Modules\Franchise\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Franchise\Models\Franchise;

class FranchisePolicy extends BasePolicy
{
    protected static string $model = Franchise::class;
}
