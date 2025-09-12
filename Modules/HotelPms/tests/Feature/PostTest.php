<?php

namespace Modules\HotelPms\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Modules\HotelPms\Events\FolioPosted;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_folio_endpoint_creates_folio_and_emits_event(): void
    {
        Event::fake();

        $response = $this->postJson('/api/v1/pms/folios', [
            'guest_id' => 'g1',
            'amount' => 30,
        ]);

        $response->assertOk()->assertJson(['posted' => true]);
        $this->assertDatabaseHas('pms_folios', ['guest_id' => 'g1', 'total' => 30]);
        Event::assertDispatched(FolioPosted::class);
    }
}
