<?php

namespace App\Services\Compliance;

class PciComplianceService
{
    public function maskCardNumber(string $number): string
    {
        $last4 = substr($number, -4);
        return str_repeat('*', max(0, strlen($number) - 4)) . $last4;
    }
}
