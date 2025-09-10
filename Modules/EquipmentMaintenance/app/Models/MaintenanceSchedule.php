<?php

namespace Modules\EquipmentMaintenance\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    use BelongsToTenant, HasFactory;

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
