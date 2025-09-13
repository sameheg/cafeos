<?php

namespace App\Services\Audit;

interface AuditTrailService
{
    public function record(string $action, array $payload = []): void;
}
