<?php

namespace Modules\EventManagement\Filament\Resources\EventResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\EventManagement\Filament\Resources\EventResource;

class CreateEvent extends CreateRecord
{
    protected static string $resource = EventResource::class;
}
