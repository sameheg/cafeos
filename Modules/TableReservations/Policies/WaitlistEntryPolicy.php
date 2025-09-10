<?php

namespace Modules\TableReservations\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\TableReservations\Models\WaitlistEntry;

class WaitlistEntryPolicy extends BasePolicy
{
    protected static string $model = WaitlistEntry::class;
}
