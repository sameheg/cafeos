<?php

namespace Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications_inbox';

    protected $fillable = [
        'tenant_id',
        'message',
        'role',
        'status',
        'acknowledged_at',
        'escalated_at',
    ];
}
