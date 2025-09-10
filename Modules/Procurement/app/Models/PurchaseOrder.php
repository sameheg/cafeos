<?php

namespace Modules\Procurement\Models;

use App\Models\TenantModel;

class PurchaseOrder extends TenantModel
{
    protected $fillable = ['tenant_id', 'supplier_id', 'status', 'items'];

    protected $casts = [
        'items' => 'array',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
