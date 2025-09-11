<?php

namespace Modules\Core\Filament\Resources\TenantResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Modules\Core\Filament\Resources\TenantResource;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;
}
