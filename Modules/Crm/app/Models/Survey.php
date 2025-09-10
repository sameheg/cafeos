<?php

namespace Modules\Crm\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Survey extends TenantModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'branch_id',
        'question',
    ];
}
