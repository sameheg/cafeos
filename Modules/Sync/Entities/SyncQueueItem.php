<?php

namespace Modules\Sync\Entities;

use Illuminate\Database\Eloquent\Model;

class SyncQueueItem extends Model
{
    protected $fillable = [
        'url',
        'payload',
        'method',
        'error_message',
        'failed_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'failed_at' => 'datetime',
    ];
}
