<?php

namespace Modules\SuperAdmin\Tests\Unit;

use Modules\SuperAdmin\Models\Flag;
use Modules\SuperAdmin\Tests\TestCase;

class FlagToggleTest extends TestCase
{

    public function test_it_can_suspend_and_restore_flag(): void
    {
        $flag = Flag::create(['module' => 'pos', 'tenant_id' => null, 'enabled' => true]);
        $flag->suspend();
        $this->assertFalse($flag->fresh()->enabled);
        $flag->restore();
        $this->assertTrue($flag->fresh()->enabled);
    }
}
