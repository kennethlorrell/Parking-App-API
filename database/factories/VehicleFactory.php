<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $plateNumber = 'AA-' . fake()->randomNumber(5);

        return [
            'user_id' => User::inRandomOrder()->first(),
            'plate_number' => $plateNumber,
            'description' => fake()->text
        ];
    }
}
