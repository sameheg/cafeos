<?php

namespace Modules\Loyalty\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class LoyaltyRule extends Model
{
    use HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'loyalty_rules';

    protected $fillable = [
        'tenant_id',
        'name',
        'earn_rate',
        'stackable',
    ];

    protected $casts = [
        'id' => 'string',
        'tenant_id' => 'string',
        'earn_rate' => 'float',
        'stackable' => 'boolean',
    ];
}
