<?php

namespace Modules\FoodSafety\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\FoodSafety\Models\FoodSafetyAction;
use Modules\FoodSafety\Models\FoodSafetyLog;
use Tests\TestCase;

class ActionResolverTest extends TestCase
{
    use RefreshDatabase;

    public function test_log_has_actions(): void
    {
        $log = FoodSafetyLog::create([
            'tenant_id' => 't1',
            'item_id' => 'item',
            'temp' => 3,
            'timestamp' => now(),
            'status' => 'monitored',
        ]);

        FoodSafetyAction::create([
            'tenant_id' => 't1',
            'log_id' => $log->id,
            'action' => 'Chilled',
        ]);

        $this->assertEquals(1, $log->actions()->count());
    }
}
