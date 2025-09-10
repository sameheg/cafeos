<?php

namespace Modules\Pos\Events;

use App\Models\Tenant;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Pos\Models\Order;

class TableOpened
{
    use Dispatchable, SerializesModels;

    public function __construct(public Order $order, public ?Tenant $tenant = null) {}
}
