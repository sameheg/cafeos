<?php

namespace Modules\EquipmentMonitoring\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id',
        'temperature',
        'status',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
