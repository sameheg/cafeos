<?php

namespace Modules\Energy\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class EnergyLog extends Model
{
    use HasUlids;

    protected $fillable = [
        'tenant_id',
        'kwh',
        'logged_at',
        'is_anomaly',
    ];

    protected $casts = [
        'kwh' => 'float',
        'logged_at' => 'datetime',
        'is_anomaly' => 'boolean',
    ];

    public $timestamps = false;

    protected static function booted(): void
    {
        static::creating(function (EnergyLog $log) {
            if (empty($log->logged_at)) {
                $log->logged_at = now();
            }
        });
    }
}
