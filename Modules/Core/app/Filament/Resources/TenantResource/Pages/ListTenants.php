<?php

namespace Modules\Core\Filament\Resources\TenantResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Core\Filament\Resources\TenantResource;

class ListTenants extends ListRecords
{
    protected static string $resource = TenantResource::class;
}
