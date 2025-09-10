<?php

namespace Modules\Pos\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Pos\Models\MenuItem;

class MenuItemPolicy extends BasePolicy
{
    protected static string $model = MenuItem::class;
}
