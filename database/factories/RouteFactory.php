<?php

namespace Database\Factories;

use App\Models\Passenger;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Route>
 */
class RouteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'passenger_id' => Passenger::factory(),
            'school_id' => School::factory(),
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
