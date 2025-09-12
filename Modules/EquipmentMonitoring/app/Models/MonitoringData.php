<?php

namespace Modules\EquipmentMonitoring\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringData extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'equipment_monitoring';
    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'equipment_id',
        'metric',
        'value',
        'timestamp',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'timestamp' => 'datetime',
    ];
}
