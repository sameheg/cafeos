<?php

namespace App\Services\Audit;

use Illuminate\Support\Facades\Log;

class LogAuditTrailService implements AuditTrailService
{
    public function record(string $action, array $payload = []): void
    {
        Log::debug('Audit trail entry', [
            'action' => $action,
            'payload' => $payload,
        ]);
    }
}
