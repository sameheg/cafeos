<?php

namespace App\Filament\Resources\Modules\Core\Pages;

use App\Filament\Resources\Modules\Core\PermissionResource;
use Filament\Resources\Pages\ListRecords;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;
}
