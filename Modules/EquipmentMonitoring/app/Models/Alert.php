<?php

namespace Modules\EquipmentMonitoring\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alert extends TenantModel
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'tenant_id',
        'device_id',
        'message',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
