<?php

namespace Modules\EquipmentMonitoring\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reading extends TenantModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'device_id',
        'temperature',
        'status',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
