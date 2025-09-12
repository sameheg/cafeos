<?php

namespace Modules\EquipmentMonitoring\Services;

use Illuminate\Support\Facades\Cache;

class BufferHandler
{
    public function buffer(array $payload): void
    {
        $key = 'monitoring_buffer:'.$payload['tenant_id'];
        $buffer = Cache::get($key, []);
        $buffer[] = $payload;
        Cache::put($key, $buffer, 3600);
    }

    public function flush(string $tenantId): array
    {
        $key = 'monitoring_buffer:'.$tenantId;
        $buffer = Cache::pull($key, []);
        return $buffer;
    }
}
