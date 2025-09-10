<?php

namespace Modules\TableReservations\Models;

use App\Models\TenantModel;
use Modules\Membership\Enums\MembershipTier;

class WaitlistEntry extends TenantModel
{
    protected $fillable = ['tenant_id', 'customer_name', 'phone', 'party_size', 'status', 'membership_tier'];

    protected $casts = [
        'membership_tier' => MembershipTier::class,
    ];

    public function getPriorityAttribute(): int
    {
        return $this->membership_tier?->priority() ?? 0;
    }
}
