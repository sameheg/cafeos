<?php

namespace Modules\Reporting\Services;

use App\Transaction;
use App\VariationLocationDetails;

class ForecastService
{
    public function forecast(): array
    {
        $sales = Transaction::where('type', 'sell')->sum('final_total');
        $inventory = VariationLocationDetails::sum('qty_available');

        $forecast = $sales > 0 ? $inventory / $sales : 0;

        return [
            'sales' => $sales,
            'inventory' => $inventory,
            'forecast' => $forecast,
        ];
    }
}
