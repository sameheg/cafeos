<?php

namespace Modules\EquipmentLeasing\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaseContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'product_id',
        'quantity',
        'schedule',
        'start_date',
        'end_date',
        'total',
    ];

    protected $casts = [
        'schedule' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}
