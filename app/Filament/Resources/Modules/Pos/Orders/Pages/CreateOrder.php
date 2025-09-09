<?php

namespace App\Filament\Resources\Modules\Pos\Orders\Pages;

use App\Filament\Resources\Modules\Pos\Orders\OrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
}
