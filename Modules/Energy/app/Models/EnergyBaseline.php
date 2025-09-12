<?php

namespace Modules\Energy\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class EnergyBaseline extends Model
{
    use HasUlids;

    protected $fillable = [
        'tenant_id',
        'period',
        'value',
    ];

    public $timestamps = false;
}
