<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Modules\Rentals\Models\Listing;
use Tests\TestCase;

class ContractWorkflowTest extends TestCase
{
    public function test_contract_creation_updates_listing_and_emits_event(): void
    {
        Event::fake();

        $listing = Listing::create([
            'id' => (string) Str::ulid(),
            'tenant_id' => (string) Str::uuid(),
            'name' => 'Booth A',
            'status' => 'available',
        ]);

        $response = $this->postJson('/api/v1/rentals/contracts', [
            'space_id' => $listing->id,
        ]);

        $response->assertStatus(200);

        Event::assertDispatched('rentals.contract.signed@v1');
        $this->assertEquals('rented', $listing->fresh()->status);
    }
}
