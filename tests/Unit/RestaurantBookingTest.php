<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Restaurant\Booking;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mockery;

class RestaurantBookingTest extends TestCase
{
    public function test_booking_relations()
    {
        $booking = new Booking();
        $this->assertInstanceOf(BelongsTo::class, $booking->customer());
        $this->assertInstanceOf(BelongsTo::class, $booking->table());
        $this->assertInstanceOf(BelongsTo::class, $booking->correspondent());
        $this->assertInstanceOf(BelongsTo::class, $booking->waiter());
        $this->assertInstanceOf(BelongsTo::class, $booking->location());
        $this->assertInstanceOf(BelongsTo::class, $booking->business());
    }

    public function test_create_booking_utility()
    {
        $input = [
            'contact_id' => 1,
            'res_waiter_id' => 2,
            'res_table_id' => 3,
            'business_id' => 4,
            'location_id' => 5,
            'correspondent' => 6,
            'booking_start' => '2023-01-01 10:00:00',
            'booking_end' => '2023-01-01 12:00:00',
            'created_by' => 7,
            'booking_note' => 'note',
        ];

        $mock = Mockery::mock('alias:App\\Restaurant\\Booking');
        $mock->shouldReceive('create')->once()->andReturn(new Booking($input));

        $booking = $mock::createBooking($input);
        $this->assertInstanceOf(Booking::class, $booking);
        $this->assertEquals(1, $booking->contact_id);
        Mockery::close();
    }
}
