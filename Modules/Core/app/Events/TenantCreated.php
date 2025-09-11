<?php

namespace Modules\Core\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\Core\Models\Tenant;

class TenantCreated
{
    use Dispatchable;

    public function __construct(public Tenant $tenant) {}
}
