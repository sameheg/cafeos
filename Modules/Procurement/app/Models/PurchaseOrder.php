<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = ['supplier_id', 'status', 'items'];

    protected $casts = [
        'items' => 'array',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

