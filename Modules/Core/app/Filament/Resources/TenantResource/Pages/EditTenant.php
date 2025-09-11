<?php

namespace Modules\Core\Filament\Resources\TenantResource\Pages;

use Filament\Resources\Pages\EditRecord;
use Modules\Core\Filament\Resources\TenantResource;

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;
}
