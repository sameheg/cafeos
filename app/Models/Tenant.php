<?php

declare(strict_types=1);

namespace App\Models;

use Laravel\Cashier\Billable;
use Spatie\Translatable\HasTranslations;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    use Billable, HasDatabase, HasDomains, HasTranslations;

    /**
     * The attributes that are translatable.
     *
     * @var list<string>
     */
    protected array $translatable = ['name'];

    public function allowsModule(string $module): bool
    {
        $subscription = $this->subscriptions()->active()->first();

        return $subscription?->allowsModule($module) ?? false;
    }
}
