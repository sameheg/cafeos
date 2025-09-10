<?php

namespace Modules\Membership\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Support\Carbon;

class SubscriptionExpiring
{
    use Dispatchable;

    public function __construct(public int|string $customerId, public Carbon $expiresAt) {}
}
