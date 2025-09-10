<?php

namespace App\Filament\Resources\Modules\Core\Pages;

use App\Filament\Resources\Modules\Core\PermissionResource;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    protected static string $resource = PermissionResource::class;
}
