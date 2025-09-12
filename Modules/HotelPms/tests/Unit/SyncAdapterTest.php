<?php

namespace Modules\HotelPms\Tests\Unit;

use Modules\HotelPms\Adapters\DummyPmsAdapter;
use Tests\TestCase;

class SyncAdapterTest extends TestCase
{
    public function test_sync_returns_int(): void
    {
        $adapter = new DummyPmsAdapter();

        $this->assertSame(0, $adapter->syncReservations());
    }
}
