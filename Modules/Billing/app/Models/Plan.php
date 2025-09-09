<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'trial_days',
    ];

    protected static function newFactory(): \Modules\Billing\Database\Factories\PlanFactory
    {
        return \Modules\Billing\Database\Factories\PlanFactory::new();
    }
}
