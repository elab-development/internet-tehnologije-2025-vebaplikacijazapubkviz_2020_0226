<?php

namespace Database\Factories;

use App\Models\Sezona;
use Illuminate\Database\Eloquent\Factories\Factory;

class DogadjajFactory extends Factory
{
    public function definition(): array
    {
        return [
            'naziv' => $this->faker->sentence(3),
            'datumOdrzavanja' => $this->faker->dateTimeBetween('now', '+1 year'),
            'sezona_id' => Sezona::factory(), 
        ];
    }
}