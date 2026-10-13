<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'    => 'PT ' . fake()->unique()->company(),
            'phone'   => fake()->numerify('08##########'),
            'email'   => fake()->unique()->safeEmail(),
            'address' => fake()->address(),
        ];
    }
}
