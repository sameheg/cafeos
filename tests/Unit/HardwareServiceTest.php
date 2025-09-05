<?php

namespace Tests\Unit;

use Modules\POS\Services\HardwareService;
use Tests\TestCase;

class HardwareServiceTest extends TestCase
{
    public function test_printer_returns_null_when_library_missing()
    {
        $service = new HardwareService([
            'test_printer' => ['driver' => 'FilePrintConnector', 'port' => 'php://stdout']
        ]);

        $printer = $service->printer('test_printer');

        if (class_exists(\Mike42\Escpos\Printer::class)) {
            $this->assertInstanceOf(\Mike42\Escpos\Printer::class, $printer);
        } else {
            $this->assertNull($printer);
        }
    }
}
