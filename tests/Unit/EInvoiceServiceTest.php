<?php

namespace Tests\Unit;

use InvalidArgumentException;
use Modules\Compliance\Services\EInvoiceService;
use PHPUnit\Framework\TestCase;

class EInvoiceServiceTest extends TestCase
{
    public function test_generate_saudi_invoice()
    {
        $service = new EInvoiceService();
        $invoice = $service->generate([
            'number' => 'INV1',
            'seller_name' => 'Coffee Shop',
            'seller_tax_number' => '1234567890',
            'invoice_date' => '2024-01-01T00:00:00Z',
            'total' => 100,
            'vat_total' => 15,
        ], 'SA');

        $this->assertEquals('ZATCA', $invoice['schema']);
        $this->assertNotEmpty($invoice['qr']);

        $this->expectException(InvalidArgumentException::class);
        $service->generate([], 'SA');
    }

    public function test_generate_uae_invoice()
    {
        $service = new EInvoiceService();
        $invoice = $service->generate([
            'number' => 'INV2',
            'tax_registration_number' => 'TRN123',
        ], 'AE');

        $this->assertEquals('UAE', $invoice['schema']);
        $this->assertNotEmpty($invoice['qr']);

        $this->expectException(InvalidArgumentException::class);
        $service->generate(['number' => 'INV3'], 'AE');
    }

    public function test_generate_egypt_invoice()
    {
        $service = new EInvoiceService();
        $invoice = $service->generate([
            'number' => 'INV4',
            'registration_number' => 'EG123',
        ], 'EG');

        $this->assertEquals('EGYPT', $invoice['schema']);
        $this->assertNotEmpty($invoice['qr']);

        $this->expectException(InvalidArgumentException::class);
        $service->generate(['number' => 'INV5'], 'EG');
    }
}

