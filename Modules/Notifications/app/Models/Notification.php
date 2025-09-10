<?php

namespace Modules\Notifications\Models;

use App\Models\TenantModel;

class Notification extends TenantModel
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
