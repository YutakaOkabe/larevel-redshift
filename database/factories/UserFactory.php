<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(0, 80),
            'gender' => $this->faker->randomElement(['men', 'women', 'other']),
        ];
    }
}
