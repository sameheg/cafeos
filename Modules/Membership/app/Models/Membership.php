<?php

namespace Modules\Membership\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Membership\Events\TierUpgraded;

class Membership extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'memberships';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'tenant_id',
        'customer_id',
        'tier',
        'expiry',
        'status',
    ];

    protected $casts = [
        'expiry' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $membership) {
            if (! $membership->id) {
                $membership->id = (string) Str::ulid();
            }
        });

        static::updated(function (self $membership) {
            if ($membership->wasChanged('tier')) {
                event(new TierUpgraded($membership));
            }
        });
    }
}
