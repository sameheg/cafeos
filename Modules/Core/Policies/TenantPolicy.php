<?php

namespace Modules\Core\Policies;

class TenantPolicy extends BasePolicy
{
    protected static string $model = \App\Models\Tenant::class;
}
