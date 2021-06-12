<?php

namespace Database\Factories;

use App\Enums\SeatNumbers;
use App\Models\Reservation;
use App\Models\Trip;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create()->id,
            'trip_id' => Trip::factory()->create()->id,
            'path_order_start' => 1,
            'path_order_end' => 2,
            'seat_number' => $this->faker->randomElement(SeatNumbers::getValues()),
        ];
    }
}
