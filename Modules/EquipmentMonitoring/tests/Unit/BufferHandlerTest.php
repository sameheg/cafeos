<?php

namespace Modules\EquipmentMonitoring\Tests\Unit;

use Illuminate\Support\Facades\Cache;
use Modules\EquipmentMonitoring\Services\BufferHandler;
use Tests\TestCase;

class BufferHandlerTest extends TestCase
{
    public function test_it_buffers_payloads(): void
    {
        Cache::flush();
        $handler = new BufferHandler();
        $handler->buffer(['tenant_id' => 't1', 'value' => 1]);
        $buffer = $handler->flush('t1');
        $this->assertCount(1, $buffer);
        $this->assertEquals(1, $buffer[0]['value']);
    }
}
