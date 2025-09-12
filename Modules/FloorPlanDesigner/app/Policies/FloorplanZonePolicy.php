<?php

namespace Modules\FloorPlanDesigner\Policies;

use App\Models\User;
use Modules\FloorPlanDesigner\Models\FloorplanZone;

class FloorplanZonePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('floorplan.zone.view');
    }

    public function view(User $user, FloorplanZone $zone): bool
    {
        return $user->can('floorplan.zone.view') && $user->tenant_id === $zone->tenant_id;
    }

    public function create(User $user): bool
    {
        return $user->can('floorplan.zone.create');
    }

    public function update(User $user, FloorplanZone $zone): bool
    {
        return $user->can('floorplan.zone.update') && $user->tenant_id === $zone->tenant_id;
    }

    public function delete(User $user, FloorplanZone $zone): bool
    {
        return $user->can('floorplan.zone.delete') && $user->tenant_id === $zone->tenant_id;
    }
}
