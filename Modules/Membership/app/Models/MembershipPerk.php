<?php

namespace Modules\Membership\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class MembershipPerk extends Model
{
    use HasFactory;

    protected $table = 'membership_perks';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'tenant_id',
        'tier',
        'description',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $perk) {
            if (! $perk->id) {
                $perk->id = (string) Str::ulid();
            }
        });
    }
}
