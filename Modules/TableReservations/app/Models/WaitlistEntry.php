<?php

namespace Modules\TableReservations\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Membership\Enums\MembershipTier;

class WaitlistEntry extends Model
{
    protected $fillable = ['customer_name', 'phone', 'party_size', 'status', 'membership_tier'];

    protected $casts = [
        'membership_tier' => MembershipTier::class,
    ];

    public function getPriorityAttribute(): int
    {
        return $this->membership_tier?->priority() ?? 0;
    }
}
