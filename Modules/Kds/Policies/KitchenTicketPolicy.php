<?php

namespace Modules\Kds\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Kds\Models\KitchenTicket;

class KitchenTicketPolicy extends BasePolicy
{
    protected static string $model = KitchenTicket::class;
}
