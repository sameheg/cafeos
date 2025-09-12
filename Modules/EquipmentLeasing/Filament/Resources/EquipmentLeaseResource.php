<?php

namespace Modules\EquipmentLeasing\Filament\Resources;

use Filament\Resources\Resource;
use Modules\EquipmentLeasing\Models\EquipmentLease;

class EquipmentLeaseResource extends Resource
{
    protected static ?string $model = EquipmentLease::class;
}

