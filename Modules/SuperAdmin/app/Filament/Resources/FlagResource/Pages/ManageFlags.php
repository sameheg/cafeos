<?php

namespace Modules\SuperAdmin\Filament\Resources\FlagResource\Pages;

use Filament\Resources\Pages\ManageRecords;
use Modules\SuperAdmin\Filament\Resources\FlagResource;

class ManageFlags extends ManageRecords
{
    protected static string $resource = FlagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}

