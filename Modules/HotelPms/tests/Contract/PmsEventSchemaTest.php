<?php

namespace Modules\HotelPms\Tests\Contract;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Modules\HotelPms\Events\FolioPosted;
use Modules\HotelPms\Models\Folio;
use Tests\TestCase;

class PmsEventSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_payload_matches_schema(): void
    {
        $folio = Folio::create([
            'tenant_id' => (string) Str::uuid(),
            'guest_id' => 'guest',
            'total' => 10,
            'status' => Folio::STATUS_POSTED,
        ]);

        $event = new FolioPosted($folio);
        $payload = $event->broadcastWith();

        $this->assertArrayHasKey('folio_id', $payload);
        $this->assertArrayHasKey('amount', $payload);
    }
}
