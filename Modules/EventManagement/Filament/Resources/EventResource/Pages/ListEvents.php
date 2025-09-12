<?php

namespace Modules\EventManagement\Filament\Resources\EventResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\EventManagement\Filament\Resources\EventResource;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;
}
