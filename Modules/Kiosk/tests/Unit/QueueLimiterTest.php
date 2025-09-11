<?php

namespace Modules\Kiosk\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Kiosk\Models\Kiosk;
use Modules\Kiosk\Models\KioskOrder;
use Modules\Kiosk\Services\QueueLimiter;
use Tests\TestCase;

class QueueLimiterTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_detects_full_queue(): void
    {
        $kiosk = Kiosk::create([
            'tenant_id' => 't1',
            'location' => 'A',
            'status' => 'active',
            'max_queue' => 1,
        ]);

        KioskOrder::create([
            'tenant_id' => 't1',
            'kiosk_id' => $kiosk->id,
            'total' => 1,
            'status' => 'queued',
        ]);

        $limiter = new QueueLimiter();
        $this->assertTrue($limiter->tooMany($kiosk));
    }
}
