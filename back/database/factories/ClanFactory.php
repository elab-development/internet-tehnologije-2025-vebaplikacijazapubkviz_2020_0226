<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'ime' => $this->faker->firstName(),
            'prezime' => $this->faker->lastName(),
        ];
    }
}