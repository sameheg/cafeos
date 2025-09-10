<?php

namespace Modules\Pos\Tests\Unit;

use Modules\Pos\Services\CashierAuditLogger;
use PHPUnit\Framework\TestCase;

class CashierAuditLoggerTest extends TestCase
{
    public function test_logs_discrepancy(): void
    {
        $file = tempnam(sys_get_temp_dir(), 'audit');
        $logger = new CashierAuditLogger($file);
        $entry = $logger->log(1, 100.0, 90.0);

        $this->assertSame(-10.0, $entry['discrepancy']);
        $contents = file_get_contents($file);
        $this->assertStringContainsString('cashier_id', $contents);
    }
}
