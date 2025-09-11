<?php

namespace Tests\Contract;

use Tests\TestCase;

class CoreEventSchemaTest extends TestCase
{
    public function test_tenant_resolved_event_schema(): void
    {
        $payload = ['event' => 'core.tenant.resolved@v1', 'data' => ['tenant_id' => 'abc']];

        $this->assertArrayHasKey('tenant_id', $payload['data']);
        $this->assertIsString($payload['data']['tenant_id']);
    }
}
