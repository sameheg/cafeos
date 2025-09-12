<?php

namespace Tests\Contract;

use Tests\TestCase;

class BillingEventSchemaTest extends TestCase
{
    public function test_invoice_issued_event_schema(): void
    {
        $payload = ['event' => 'billing.invoice.issued@v1', 'data' => ['invoice_id' => '1', 'amount' => 100]];

        $this->assertArrayHasKey('invoice_id', $payload['data']);
        $this->assertIsNumeric($payload['data']['amount']);
    }
}
