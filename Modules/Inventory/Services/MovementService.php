<?php

namespace Modules\Inventory\Services;

use Illuminate\Support\Facades\DB;

class MovementService
{
    public function recordMovement(string $item, int $change): void
    {
        DB::table('inventory_movements')->insert([
            'item' => $item,
            'change' => $change,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
