<?php
namespace Modules\Pos\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Pos\App\Models\Order;
use Modules\Pos\App\Models\OrderItem;

class PosSeeder extends Seeder
{
    public function run(): void
    {
        $order = Order::create([
            'tenant_id' => 1,
            'table_id' => 5,
            'status' => 'paid',
            'subtotal' => 100,
            'total' => 100,
            'paid_total' => 100,
            'paid_at' => now(),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'sku' => 'SKU-COFFEE',
            'name' => 'Cappuccino',
            'qty' => 2,
            'price' => 50,
            'line_total' => 100,
        ]);
    }
}
