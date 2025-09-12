<?php

namespace Tests\Feature;

use Illuminate\Support\Str;
use Modules\Rentals\Models\Contract;
use Modules\Rentals\Models\Listing;
use Tests\TestCase;

class DisputeTest extends TestCase
{
    public function test_contract_can_be_marked_disputed(): void
    {
        $listing = Listing::create([
            'id' => (string) Str::ulid(),
            'tenant_id' => (string) Str::uuid(),
            'name' => 'A',
            'status' => 'rented',
        ]);

        $contract = Contract::create([
            'id' => (string) Str::ulid(),
            'tenant_id' => $listing->tenant_id,
            'listing_id' => $listing->id,
            'renter_id' => 'r1',
            'end_date' => now()->addMonth(),
            'status' => 'active',
        ]);

        $contract->markDisputed();

        $this->assertEquals('disputed', $contract->fresh()->status);
    }
}
