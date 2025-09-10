<?php

namespace Modules\Kds\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KitchenStation extends TenantModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
    ];
}
