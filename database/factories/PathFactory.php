<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Path;
use App\Models\Trip;
use Illuminate\Database\Eloquent\Factories\Factory;

class PathFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Path::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'trip_id'       => Trip::factory()->create()->id,
            'start_city_id' => City::factory()->create()->id,
            'destination_city_id' => City::factory()->create()->id,
            'order' => 1,
        ];
    }
}
