<?php

namespace Modules\FloorPlanDesigner\Policies;

use App\Models\User;
use Modules\FloorPlanDesigner\Models\Furniture;

class FurniturePolicy
{
    public function viewAny(User $user): bool { return $user->can('floorplan.furniture.view'); }
    public function view(User $user, Furniture $f): bool { return $user->can('floorplan.furniture.view') && $user->tenant_id === $f->tenant_id; }
    public function create(User $user): bool { return $user->can('floorplan.furniture.create'); }
    public function update(User $user, Furniture $f): bool { return $user->can('floorplan.furniture.update') && $user->tenant_id === $f->tenant_id; }
    public function delete(User $user, Furniture $f): bool { return $user->can('floorplan.furniture.delete') && $user->tenant_id === $f->tenant_id; }
}
