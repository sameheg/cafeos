<?php

namespace Modules\Billing\Models;

use App\Models\Concerns\BelongsToTenant;
use Laravel\Cashier\Subscription as CashierSubscription;

class Subscription extends CashierSubscription
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'plan_id',
        'name',
        'stripe_id',
        'stripe_status',
        'stripe_price',
        'quantity',
        'trial_ends_at',
        'ends_at',
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function allowsModule(string $module): bool
    {
        return $this->plan?->includesModule($module) ?? false;
    }
}
