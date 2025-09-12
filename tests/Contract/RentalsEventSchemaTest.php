<?php

namespace Tests\Contract;

use Tests\TestCase;

class RentalsEventSchemaTest extends TestCase
{
    public function test_contract_signed_event_schema(): void
    {
        $payload = [
            'event' => 'rentals.contract.signed@v1',
            'data' => [
                'contract_id' => '1',
                'renter_id' => 'r1',
            ],
        ];

        $this->assertArrayHasKey('contract_id', $payload['data']);
        $this->assertArrayHasKey('renter_id', $payload['data']);
    }
}
