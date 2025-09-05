<?php

namespace Tests\Unit;

use Modules\POS\Services\InvoiceService;
use Modules\Compliance\Services\EInvoiceService;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
    public function test_qr_payload_contains_required_fields(): void
    {
        $invoice = ['number' => 'INV123', 'total' => 150];

        $service = new InvoiceService($this->createMock(EInvoiceService::class));
        $ref = new \ReflectionClass($service);
        $payloadMethod = $ref->getMethod('qrPayload');
        $payloadMethod->setAccessible(true);

        $payload = $payloadMethod->invoke($service, $invoice);
        $this->assertJsonStringEqualsJsonString('{"number":"INV123","total":150}', $payload);
    }

    public function test_generate_qr_code_returns_data_uri(): void
    {
        $invoice = ['number' => 'INV123', 'total' => 150];
        $service = new InvoiceService($this->createMock(EInvoiceService::class));

        $ref = new \ReflectionClass($service);
        $method = $ref->getMethod('generateQrCode');
        $method->setAccessible(true);
        $dataUri = $method->invoke($service, $invoice);

        $this->assertStringStartsWith('data:image/png;base64,', $dataUri);
        $img = imagecreatefromstring(base64_decode(substr($dataUri, strpos($dataUri, ',') + 1)));
        $this->assertInstanceOf(\GdImage::class, $img);
        imagedestroy($img);
    }
}

