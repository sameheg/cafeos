<?php

namespace Tests\Unit;

use Modules\Billing\Models\Invoice;
use Modules\Billing\Services\DunningHandler;
use Tests\TestCase;

class DunningHandlerTest extends TestCase
{
    public function test_overdue_invoice_gets_suspended(): void
    {
        $invoice = Invoice::create([
            'tenant_id' => 't1',
            'amount' => 10,
            'status' => 'overdue',
            'due_date' => now()->subDay(),
        ]);

        $handler = new DunningHandler();
        $handler->handle($invoice);

        $this->assertDatabaseHas('billing_invoices', [
            'id' => $invoice->id,
            'status' => 'suspended',
        ]);
    }
}
