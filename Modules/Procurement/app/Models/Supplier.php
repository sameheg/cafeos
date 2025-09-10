<?php

namespace Modules\Procurement\Models;

use App\Models\TenantModel;

class Supplier extends TenantModel
{
    protected $fillable = ['tenant_id', 'name', 'contact'];
}

