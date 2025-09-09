<?php

declare(strict_types=1);

namespace App\Models;

use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;
use Spatie\Translatable\HasTranslations;

class Tenant extends BaseTenant
{
    use HasDatabase, HasDomains, HasTranslations;

    /**
     * The attributes that are translatable.
     *
     * @var list<string>
     */
    protected array $translatable = ['name'];
}

