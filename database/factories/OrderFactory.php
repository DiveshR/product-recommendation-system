<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $quantity = $this->faker->numberBetween(1, 5);
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total' => $quantity * $product->price,
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
        ];
    }
}
