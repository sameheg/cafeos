<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Transaction;
use App\PurchaseLine;

class PurchaseWorkflowTest extends TestCase
{
    public function test_purchase_workflow_links_line()
    {
        $transaction = new Transaction();
        $line = new PurchaseLine(['product_id' => 1]);
        $transaction->setRelation('purchase_lines', collect([$line]));
        $this->assertCount(1, $transaction->purchase_lines);
    }
}
