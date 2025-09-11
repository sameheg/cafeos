<?php

namespace Modules\Pos\Filament\Resources\PosOrderResource\Pages;

use Filament\Resources\Pages\ListRecords;
use Modules\Pos\Filament\Resources\PosOrderResource;

class ListPosOrders extends ListRecords
{
    protected static string $resource = PosOrderResource::class;
}
