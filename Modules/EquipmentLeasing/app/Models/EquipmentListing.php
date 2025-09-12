<?php

namespace Modules\EquipmentLeasing\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentListing extends Model
{
    protected $table = 'equipment_listings';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'tenant_id',
        'name',
        'available',
    ];

    protected $casts = [
        'available' => 'boolean',
    ];
}

