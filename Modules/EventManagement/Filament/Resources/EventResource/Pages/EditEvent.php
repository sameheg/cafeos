<?php

namespace Modules\EventManagement\Filament\Resources\EventResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Modules\EventManagement\Filament\Resources\EventResource;

class EditEvent extends EditRecord
{
    protected static string $resource = EventResource::class;
}
