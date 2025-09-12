<?php

namespace Modules\Notifications\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationTemplate extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'notifications_templates';

    protected $fillable = [
        'tenant_id',
        'name',
        'content',
    ];

    protected $casts = [
        'content' => 'encrypted',
    ];
}
