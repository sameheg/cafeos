<?php

namespace Modules\Loyalty\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;

class LoyaltyPoint extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'customer_id',
        'tenant_id',
        'points',
    ];
}
