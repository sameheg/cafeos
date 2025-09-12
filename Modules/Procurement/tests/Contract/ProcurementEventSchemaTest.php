<?php

namespace Modules\Procurement\Tests\Contract;

use Modules\Procurement\Events\PoCreated;
use Modules\Procurement\Models\Bid;
use Modules\Procurement\Models\Po;
use Modules\Procurement\Models\PoStatus;
use Modules\Procurement\Models\Rfq;
use Tests\TestCase;

class ProcurementEventSchemaTest extends TestCase
{
    public function test_po_created_event_payload(): void
    {
        $rfq = Rfq::create([
            'tenant_id' => 't1',
            'items' => [],
            'status' => 'open',
        ]);

        $bid = Bid::create([
            'tenant_id' => 't1',
            'rfq_id' => $rfq->id,
            'supplier_id' => 'sup1',
            'price' => 5,
        ]);

        $po = Po::create([
            'tenant_id' => 't1',
            'bid_id' => $bid->id,
            'amount' => 5,
            'status' => PoStatus::Draft,
        ]);

        $payload = (new PoCreated($po))->toPayload();

        $this->assertSame('procurement.po.created', $payload['event']);
        $this->assertSame((string) $po->id, $payload['data']['po_id']);
        $this->assertSame('sup1', $payload['data']['supplier_id']);
    }
}
