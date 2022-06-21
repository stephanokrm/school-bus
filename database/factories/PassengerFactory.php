<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Passenger>
 */
class PassengerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'goes' => $this->faker->boolean(),
            'returns' => $this->faker->boolean(),
            'shift' => $this->faker->randomElement(['M', 'A', 'N']),
            'address_id' => Address::factory(),
            'driver_id' => Driver::factory(),
            'responsible_id' => User::factory(),
        ];
    }
}
