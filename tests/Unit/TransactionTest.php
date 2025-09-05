<?php

namespace Tests\Unit;

use App\Transaction;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    public function test_transaction_relations(): void
    {
        $transaction = new Transaction();

        $this->assertInstanceOf(HasMany::class, $transaction->purchase_lines());
        $this->assertInstanceOf(HasMany::class, $transaction->sell_lines());
        $this->assertInstanceOf(BelongsTo::class, $transaction->contact());
        $this->assertInstanceOf(BelongsTo::class, $transaction->tax());
    }

    public function test_document_name_accessor(): void
    {
        $transaction = new Transaction();
        $transaction->document = '123_invoice.pdf';

        $this->assertEquals('invoice.pdf', $transaction->document_name);
    }

    public function test_shipping_address_helper(): void
    {
        $transaction = new Transaction();
        $transaction->order_addresses = json_encode([
            'shipping_address' => [
                'shipping_name' => 'John Doe',
                'company' => 'ACME',
                'shipping_address_line_1' => '123 Street',
                'shipping_city' => 'City',
                'shipping_state' => 'State',
                'shipping_country' => 'Country',
                'shipping_zip_code' => '00000',
            ],
        ]);

        $array = $transaction->shipping_address(true);
        $this->assertEquals('John Doe', $array['name']);
        $this->assertStringContainsString('John Doe', $transaction->shipping_address());
    }

    public function test_document_name_strips_prefix(): void
    {
        $transaction = new Transaction(['document' => '12345_invoice.pdf']);

        $this->assertEquals('invoice.pdf', $transaction->getDocumentNameAttribute());
    }

    public function test_document_path_returns_asset_url(): void
    {
        config(['app.url' => 'http://example.com']);
        $transaction = new Transaction(['document' => 'invoice.pdf']);

        $this->assertEquals(
            'http://example.com/uploads/documents/invoice.pdf',
            $transaction->getDocumentPathAttribute()
        );
    }
}

