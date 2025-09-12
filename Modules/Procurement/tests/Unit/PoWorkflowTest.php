<?php

namespace Modules\Procurement\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Procurement\Models\Bid;
use Modules\Procurement\Models\Po;
use Modules\Procurement\Models\PoStatus;
use Modules\Procurement\Models\Rfq;
use Tests\TestCase;

class PoWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_state_transitions(): void
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
            'price' => 10,
        ]);

        $po = Po::create([
            'tenant_id' => 't1',
            'bid_id' => $bid->id,
            'amount' => 10,
            'status' => PoStatus::Draft,
        ]);

        $po->send();
        $this->assertEquals(PoStatus::Sent, $po->fresh()->status);

        $po->receive();
        $this->assertEquals(PoStatus::Received, $po->fresh()->status);

        $po->match();
        $this->assertEquals(PoStatus::Matched, $po->fresh()->status);
    }
}
