<?php

namespace Modules\Core\Filament\Resources\UserResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Core\Filament\Resources\UserResource;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;
}
