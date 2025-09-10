<?php

namespace Modules\EquipmentMaintenance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;

class Equipment extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'name',
        'serial_number',
        'description',
        'purchased_at',
    ];

    protected $casts = [
        'purchased_at' => 'date',
    ];

    public function schedules()
    {
        return $this->hasMany(MaintenanceSchedule::class);
    }

    public function logs()
    {
        return $this->hasMany(MaintenanceLog::class);
    }
}
