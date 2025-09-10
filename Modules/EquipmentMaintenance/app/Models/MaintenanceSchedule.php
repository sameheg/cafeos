<?php

namespace Modules\EquipmentMaintenance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;

class MaintenanceSchedule extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'equipment_id',
        'scheduled_at',
        'notes',
        'alerted',
    ];

    protected $casts = [
        'scheduled_at' => 'date',
        'alerted' => 'boolean',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
