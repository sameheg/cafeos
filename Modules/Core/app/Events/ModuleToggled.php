<?php

namespace Modules\Core\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Modules\Core\Models\Tenant;

class ModuleToggled
{
    use Dispatchable;

    public function __construct(public Tenant $tenant, public string $module, public bool $enabled) {}
}
