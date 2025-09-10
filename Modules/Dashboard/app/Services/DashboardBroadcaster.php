<?php

namespace Modules\Dashboard\Services;

use Modules\Dashboard\Events\DashboardUpdated;

class DashboardBroadcaster
{
    public function broadcast(array $data): void
    {
        DashboardUpdated::dispatch($data);
    }
}
