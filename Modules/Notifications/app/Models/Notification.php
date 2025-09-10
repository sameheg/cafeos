<?php

namespace Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;

class Notification extends Model
{
    use BelongsToTenant;

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
