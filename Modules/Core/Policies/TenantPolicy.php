<?php

namespace Modules\Core\Policies;

use Modules\Core\Policies\BasePolicy;

class TenantPolicy extends BasePolicy
{
    protected static string $model = \App\Models\Tenant::class;
}
