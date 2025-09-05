<?php

namespace Modules\Inventory\Services;

use Illuminate\Support\Facades\DB;

class InventoryLevelService
{
    public function getLevels()
    {
        return DB::table('inventory_movements')
            ->select('item', DB::raw('SUM(change) as quantity'))
            ->groupBy('item')
            ->get();
    }
}
