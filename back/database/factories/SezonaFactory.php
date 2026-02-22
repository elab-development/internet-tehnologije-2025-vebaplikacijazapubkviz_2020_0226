<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SezonaFactory extends Factory
{
    public function definition(): array
    {
        $godina = $this->faker->unique()->numberBetween(2020, 2030);

        return [
            'pocetak' => "$godina-09-01", 
            'kraj' => ($godina + 1) . "-06-01",
        ];
    }
}