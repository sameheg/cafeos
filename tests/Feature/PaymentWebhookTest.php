<?php

namespace Tests\Feature;

use Tests\TestCase;

class PaymentWebhookTest extends TestCase
{
    public function test_issue_invoice_endpoint(): void
    {
        $response = $this->postJson('/api/v1/billing/invoices', [
            'tenant_id' => 'tenant-test',
            'modules' => [
                ['name' => 'core', 'amount' => 50],
                ['name' => 'membership', 'amount' => 25],
            ],
        ]);

        $response->assertStatus(201)->assertJsonStructure(['invoice_id']);
        $this->assertDatabaseHas('billing_invoices', ['tenant_id' => 'tenant-test']);
    }
}
