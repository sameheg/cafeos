<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Restaurant\Booking;
use Mockery;

class ReservationWorkflowTest extends TestCase
{
    public function test_reservation_workflow_creates_booking()
    {
        $input = [
            'contact_id' => 1,
            'business_id' => 1,
            'location_id' => 1,
            'created_by' => 1,
            'booking_start' => '2023-01-01 10:00:00',
            'booking_end' => '2023-01-01 11:00:00',
            'booking_note' => 'note',
        ];
        $mock = Mockery::mock('alias:App\\Restaurant\\Booking');
        $mock->shouldReceive('create')->once()->andReturn(new Booking($input));
        $booking = $mock::createBooking($input);
        $this->assertInstanceOf(Booking::class, $booking);
        Mockery::close();
    }
}
