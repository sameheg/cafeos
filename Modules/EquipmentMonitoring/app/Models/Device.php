<?php

namespace Modules\EquipmentMonitoring\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Device extends TenantModel
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'name',
        'location',
        'temperature_threshold',
    ];

    public function readings()
    {
        return $this->hasMany(Reading::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}
