<?php

namespace App\Services\Compliance;

class GdprComplianceService
{
    public function anonymize(string $value): string
    {
        return hash('sha256', $value);
    }
}
