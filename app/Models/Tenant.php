<?php

declare(strict_types=1);

namespace App\Models;

use Stancl\Tenancy\Database\Models\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Models\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    use HasDatabase, HasDomains;
}

