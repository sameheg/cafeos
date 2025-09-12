<?php

namespace Modules\SuperAdmin\Tests\Contract;

use Illuminate\Support\Facades\Event;
use Modules\SuperAdmin\Events\ModuleDisabled;
use Modules\SuperAdmin\Models\Flag;
use Modules\SuperAdmin\Tests\TestCase;

class SuperEventSchemaTest extends TestCase
{

    public function test_module_disabled_event_schema(): void
    {
        Event::fake();
        $flag = Flag::create(['module' => 'pos', 'tenant_id' => 't-1', 'enabled' => true]);
        $flag->suspend();

        Event::assertDispatched(ModuleDisabled::class, function ($event) {
            return $event->broadcastWith()['data'] === [
                'module' => 'pos',
                'tenant_id' => 't-1',
            ];
        });
    }
}
