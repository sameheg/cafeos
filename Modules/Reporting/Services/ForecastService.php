<?php

namespace Modules\Reporting\Services;

use App\Models\Sale;
use App\Models\Inventory;

class ForecastService
{
    public function forecast(): array
    {
        $sales = Sale::query()->sum('amount');
        $inventory = Inventory::query()->sum('quantity');

        $forecast = $sales > 0 ? $inventory / $sales : 0;

        return [
            'sales' => $sales,
            'inventory' => $inventory,
            'forecast' => $forecast,
        ];
    }
}
