<?php

namespace Modules\FoodSafety\Tests\Contract;

use Modules\FoodSafety\Events\BreachDetected;
use Modules\FoodSafety\Models\FoodSafetyLog;
use Tests\TestCase;

class SafetyEventSchemaTest extends TestCase
{
    public function test_payload_matches_schema(): void
    {
        $log = new FoodSafetyLog([
            'id' => '01J00000000000000000000000',
            'tenant_id' => 't1',
            'item_id' => 'item',
            'temp' => 10,
            'timestamp' => now(),
            'status' => 'alerted',
        ]);

        $event = new BreachDetected($log);
        $payload = $event->payload();

        $this->assertSame('foodsafety.breach.detected', $payload['event']);
        $this->assertArrayHasKey('item_id', $payload['data']);
        $this->assertArrayHasKey('temp', $payload['data']);
    }
}
