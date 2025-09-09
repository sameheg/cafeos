<?php

namespace Modules\EquipmentMaintenance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'equipment_id',
        'performed_at',
        'notes',
    ];

    protected $casts = [
        'performed_at' => 'date',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
