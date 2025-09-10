<?php

namespace Modules\TableReservations\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\TableReservations\Models\Table;

class TablePolicy extends BasePolicy
{
    protected static string $model = Table::class;
}
