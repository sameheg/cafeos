<?php

namespace Modules\Pos\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Pos\Models\PosOrder;
use Modules\Pos\Models\PosItem;

class PosSeeder extends Seeder
{
    public function run(): void
    {
        $order = PosOrder::create(['tenant_id' => 't1', 'total' => 15]);
        PosItem::create(['order_id' => $order->id, 'product_id' => 'p1', 'qty' => 3, 'price' => 5]);
    }
}
