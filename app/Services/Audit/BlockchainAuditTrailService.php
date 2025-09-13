<?php

namespace App\Services\Audit;

use Illuminate\Support\Facades\Log;

class BlockchainAuditTrailService implements AuditTrailService
{
    public function record(string $action, array $payload = []): void
    {
        Log::info('Blockchain audit entry', [
            'action' => $action,
            'payload' => $payload,
        ]);
    }
}
