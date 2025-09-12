<?php

namespace Modules\SuperAdmin\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Modules\SuperAdmin\Filament\Resources\UserResource;

class ManageUsers extends ManageRecords
{
    protected static string $resource = UserResource::class;
}
