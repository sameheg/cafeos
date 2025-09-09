<?php

namespace App\Filament\Resources\Modules\Marketplace\Pages;

use App\Filament\Resources\Modules\Marketplace\ListingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateListing extends CreateRecord
{
    protected static string $resource = ListingResource::class;
}
