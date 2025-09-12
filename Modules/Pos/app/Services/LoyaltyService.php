<?php

namespace Modules\Pos\Services;

use Modules\Pos\Models\PosOrder;

class LoyaltyService
{
    public static function awardPoints(PosOrder $order): void
    {
        // TODO: call Loyalty module with amount/points rules
    }
}
