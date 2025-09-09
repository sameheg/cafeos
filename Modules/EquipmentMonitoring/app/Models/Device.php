<?php

namespace Modules\EquipmentMonitoring\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
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
