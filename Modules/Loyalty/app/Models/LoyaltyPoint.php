<?php

namespace Modules\Loyalty\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    use HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'loyalty_points';

    protected $fillable = [
        'tenant_id',
        'customer_id',
        'balance',
        'expiry',
    ];

    protected $casts = [
        'id' => 'string',
        'tenant_id' => 'string',
        'customer_id' => 'string',
        'balance' => 'integer',
        'expiry' => 'date',
    ];
}
