<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'stripe_price_id',
        'price',
        'trial_days',
        'modules',
    ];

    protected $casts = [
        'modules' => 'array',
    ];

    public function includesModule(string $module): bool
    {
        return in_array($module, $this->modules ?? []);
    }

    protected static function newFactory(): \Modules\Billing\Database\Factories\PlanFactory
    {
        return \Modules\Billing\Database\Factories\PlanFactory::new();
    }
}
