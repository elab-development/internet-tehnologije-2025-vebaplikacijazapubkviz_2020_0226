<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TimFactory extends Factory
{
    public function definition(): array
    {
        return [
            'naziv' => $this->faker->unique()->company() . ' Team',
            'logo' => $this->faker->imageUrl(200, 200, 'sports'),
            'user_id' => User::factory(), // Automatski pravi i dodeljuje korisnika
        ];
    }
}