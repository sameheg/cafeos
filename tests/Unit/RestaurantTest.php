<?php

namespace Tests\Unit;

use App\Restaurant\Booking;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    public function test_booking_has_customer_relationship()
    {
        $booking = new Booking();
        $this->assertInstanceOf(BelongsTo::class, $booking->customer());
    }
}
