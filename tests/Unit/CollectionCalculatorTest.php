<?php

namespace Tests\Unit;

use Illuminate\Support\Str;
use Modules\Rentals\Models\Listing;
use Tests\TestCase;

class CollectionCalculatorTest extends TestCase
{
    public function test_occupancy_rate_is_computed_correctly(): void
    {
        Listing::insert([
            [
                'id' => (string) Str::ulid(),
                'tenant_id' => (string) Str::uuid(),
                'name' => 'A',
                'status' => 'rented',
            ],
            [
                'id' => (string) Str::ulid(),
                'tenant_id' => (string) Str::uuid(),
                'name' => 'B',
                'status' => 'available',
            ],
        ]);

        $response = $this->getJson('/api/v1/rentals/occupancy');
        $response->assertStatus(200)->assertJson(['rate' => 0.5]);
    }
}
