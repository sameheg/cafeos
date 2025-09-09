<?php

namespace App\Filament\Resources\Modules\Jobs\Pages;

use App\Filament\Resources\Modules\Jobs\JobResource;
use Filament\Resources\Pages\ListRecords;

class ListJobs extends ListRecords
{
    protected static string $resource = JobResource::class;
}
