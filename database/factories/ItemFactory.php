<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'memo' => Str::random(30),
            'price' => random_int(100, 999) * 10, // Generate 4-digit number ending with 0
            'is_selling' => (bool)random_int(0, 1) // Randomly true or false
        ];
    }
}
