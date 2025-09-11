<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Traits\BelongsToTenant;

class EventLog extends Model
{
    use HasUlids, BelongsToTenant;

    protected $table = 'events_log';

    protected $fillable = [
        'event_name',
        'data',
        'processed',
        'event_id',
    ];

    protected $casts = [
        'data' => 'array',
        'processed' => 'boolean',
    ];
}
