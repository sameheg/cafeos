<?php

namespace Modules\EquipmentMaintenance\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'tenant_id',
        'equipment_id',
        'next_date',
    ];
}
