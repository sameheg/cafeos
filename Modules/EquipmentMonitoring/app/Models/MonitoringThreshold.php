<?php

namespace Modules\EquipmentMonitoring\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringThreshold extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'monitoring_thresholds';
    public $timestamps = false;

    protected $fillable = [
        'tenant_id',
        'metric',
        'min',
        'max',
    ];

    protected $casts = [
        'min' => 'decimal:2',
        'max' => 'decimal:2',
    ];
}
