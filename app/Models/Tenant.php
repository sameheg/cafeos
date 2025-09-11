<?php

declare(strict_types=1);

namespace App\Models;

use Laravel\Cashier\Billable;
use Spatie\Translatable\HasTranslations;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase
{
    use Billable, HasDatabase, HasDomains, HasTranslations;

    /**
     * The attributes that are translatable.
     *
     * @var list<string>
     */
    protected array $translatable = ['name'];

    public static function getCustomColumns(): array
    {
        return array_merge(parent::getCustomColumns(), [
            'name',
            'domain',
            'plan_type',
            'created_at',
            'updated_at',
            'deleted_at',
        ]);
    }

    public function allowsModule(string $module): bool
    {
        $subscription = $this->subscriptions()->active()->first();

        return $subscription?->allowsModule($module) ?? false;
    }
}
