<?php

namespace Modules\Pos\Services;

class CashierAuditLogger
{
    protected string $logFile;

    public function __construct(?string $logFile = null)
    {
        $this->logFile = $logFile ?? sys_get_temp_dir() . '/cashier_audit.log';
    }

    /**
     * Record an audit entry for a cashier and return the logged data.
     */
    public function log(int $cashierId, float $expected, float $actual): array
    {
        $entry = [
            'cashier_id' => $cashierId,
            'expected' => $expected,
            'actual' => $actual,
            'discrepancy' => $actual - $expected,
            'timestamp' => date(DATE_ATOM),
        ];

        file_put_contents($this->logFile, json_encode($entry) . PHP_EOL, FILE_APPEND);

        return $entry;
    }
}
