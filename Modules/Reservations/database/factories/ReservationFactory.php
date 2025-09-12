<?php
namespace Modules\Reservations\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Reservations\App\Models\Reservation;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 hour', '+2 hours');
        $end = (clone $start)->modify('+2 hours');

        return [
            'tenant_id' => 1,
            'table_id' => $this->faker->numberBetween(1, 20),
            'status' => 'confirmed',
            'start_at' => $start,
            'end_at' => $end,
        ];
    }
}
