<?php

namespace Modules\EquipmentMonitoring\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'device_id',
        'message',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
