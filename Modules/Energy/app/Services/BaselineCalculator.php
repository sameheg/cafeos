<?php

namespace Modules\Energy\Services;

use Modules\Energy\Models\EnergyLog;

class BaselineCalculator
{
    /**
     * Calculate a simple baseline using the average of the last five logs.
     */
    public function forTenant(string $tenantId): ?float
    {
        $values = EnergyLog::where('tenant_id', $tenantId)
            ->orderByDesc('logged_at')
            ->limit(5)
            ->pluck('kwh');

        if ($values->isEmpty()) {
            return null;
        }

        return $values->average();
    }
}
