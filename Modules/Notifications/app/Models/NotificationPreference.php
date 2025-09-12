<?php

namespace Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationPreference extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'notifications_preferences';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'channel',
        'opt_out',
    ];

    protected $casts = [
        'opt_out' => 'boolean',
    ];
}
