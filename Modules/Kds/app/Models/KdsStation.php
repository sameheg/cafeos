<?php

namespace Modules\Kds\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KdsStation extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'kds_stations';

    protected $fillable = [
        'tenant_id',
        'name',
        'overload_threshold',
    ];
}
