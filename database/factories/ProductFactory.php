<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'slug' => $this->faker->unique()->slug,
            'short_description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'status' => 1,
        ];
    }
}
