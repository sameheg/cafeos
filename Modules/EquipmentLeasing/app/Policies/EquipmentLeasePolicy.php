<?php

namespace Modules\EquipmentLeasing\Policies;

use App\Models\User;
use Modules\EquipmentLeasing\Models\EquipmentLease;

class EquipmentLeasePolicy
{
    public function view(User $user, EquipmentLease $lease): bool
    {
        return $user->tenant_id === $lease->tenant_id;
    }
}

