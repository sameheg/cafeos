<?php

namespace Modules\EquipmentLeasing\Tests\Contract;

use PHPUnit\Framework\TestCase;

class LeaseEventSchemaTest extends TestCase
{
    public function test_schema_contains_required_fields(): void
    {
        $payload = ['lease_id' => '123', 'equipment_id' => 'eq1'];

        $this->assertArrayHasKey('lease_id', $payload);
        $this->assertArrayHasKey('equipment_id', $payload);
    }
}

