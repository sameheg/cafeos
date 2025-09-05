<?php

namespace Tests\Unit;

use App\Transaction;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function test_document_name_strips_prefix()
    {
        $transaction = new Transaction(['document' => '12345_invoice.pdf']);
        $this->assertEquals('invoice.pdf', $transaction->getDocumentNameAttribute());
    }

    public function test_document_path_returns_asset_url()
    {
        config(['app.url' => 'http://example.com']);
        $transaction = new Transaction(['document' => 'invoice.pdf']);
        $this->assertEquals('http://example.com/uploads/documents/invoice.pdf', $transaction->getDocumentPathAttribute());
    }
}
