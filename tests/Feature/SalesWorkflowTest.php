<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Transaction;
use App\TransactionSellLine;
use App\Product;

class SalesWorkflowTest extends TestCase
{
    public function test_sales_workflow_links_product_with_transaction()
    {
        $transaction = new Transaction();
        $product = new Product(['name' => 'Coffee']);
        $sellLine = new TransactionSellLine(['product_id' => 1]);
        $sellLine->setRelation('product', $product);
        $transaction->setRelation('sell_lines', collect([$sellLine]));
        $this->assertEquals('Coffee', $transaction->sell_lines->first()->product->name);
    }
}
