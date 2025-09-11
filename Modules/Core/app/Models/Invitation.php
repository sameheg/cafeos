<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Core\Models\Traits\BelongsToTenant;

class Invitation extends Model
{
    use BelongsToTenant;

    protected $fillable = ['tenant_id', 'email', 'role', 'token', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function ($invitation) {
            $invitation->token ??= Str::random(40);
        });
    }
}
