<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Ingredient;
use App\Models\Receipt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StockLog>
 */
class StockLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ingredient_id' => Ingredient::inRandomOrder()->value('id'),
            'quantity' => fake()->numberBetween(20, 200),
            'user_id' => User::inRandomOrder()->value('id'),
            'receipt_id' => Receipt::inRandomOrder()->value('id')
        ];
    }
}
