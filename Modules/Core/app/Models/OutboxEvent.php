<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Models\Traits\BelongsToTenant;

class OutboxEvent extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id', 'event', 'payload'];

    protected $casts = [
        'payload' => 'array',
    ];
}
