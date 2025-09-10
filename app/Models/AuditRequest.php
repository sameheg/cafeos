<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditRequest extends Model
{
    protected $fillable = [
        'tenant_id',
        'action',
        'status',
        'requested_at',
        'processed_at',
        'expires_at',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'processed_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
}
