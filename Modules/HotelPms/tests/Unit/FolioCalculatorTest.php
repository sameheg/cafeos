<?php

namespace Modules\HotelPms\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Modules\HotelPms\Models\Folio;
use Tests\TestCase;

class FolioCalculatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_updates_status_and_total(): void
    {
        $folio = Folio::create([
            'tenant_id' => (string) Str::uuid(),
            'guest_id' => 'g1',
            'total' => 0,
            'status' => Folio::STATUS_OPEN,
        ]);

        $folio->post(30);

        $this->assertEquals(30.0, (float) $folio->total);
        $this->assertEquals(Folio::STATUS_POSTED, $folio->status);
    }
}
