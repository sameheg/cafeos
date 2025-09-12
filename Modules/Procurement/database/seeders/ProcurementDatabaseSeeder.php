<?php

namespace Modules\Procurement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Procurement\Models\Bid;
use Modules\Procurement\Models\Po;
use Modules\Procurement\Models\PoStatus;
use Modules\Procurement\Models\Rfq;

class ProcurementDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $rfq = Rfq::create([
            'tenant_id' => 't1',
            'items' => [['item' => 'Widget', 'qty' => 10]],
            'status' => 'open',
        ]);

        $bid = Bid::create([
            'tenant_id' => 't1',
            'rfq_id' => $rfq->id,
            'supplier_id' => 'sup1',
            'price' => 100,
        ]);

        Po::create([
            'tenant_id' => 't1',
            'bid_id' => $bid->id,
            'amount' => $bid->price,
            'status' => PoStatus::Draft,
        ]);
    }
}
