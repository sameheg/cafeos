<?php

namespace App\Filament\Resources\Modules\Core\Pages;

use App\Filament\Resources\Modules\Core\PermissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    protected static string $resource = PermissionResource::class;
}
