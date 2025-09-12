<?php

namespace Modules\HotelPms\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Sync extends Model
{
    use HasUlids;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'pms_syncs';

    protected $fillable = [
        'tenant_id',
        'folio_id',
        'external_id',
    ];

    protected $casts = [
        'id' => 'string',
        'tenant_id' => 'string',
        'folio_id' => 'string',
    ];
}
