<?php

namespace Modules\SuperAdmin\Tests\Feature;

use Modules\SuperAdmin\Listeners\BillingOverdueListener;
use Modules\SuperAdmin\Tests\TestCase;

class SuspendTest extends TestCase
{

    public function test_billing_overdue_disables_module(): void
    {
        $listener = new BillingOverdueListener();
        $listener->handle(['tenant_id' => 'tenant-1', 'module' => 'pos']);
        $this->assertDatabaseHas('superadmin_flags', [
            'tenant_id' => 'tenant-1',
            'module' => 'pos',
            'enabled' => false,
        ]);
    }
}
