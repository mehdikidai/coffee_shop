<?php

namespace Database\Factories;

use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IngredientProduct>
 */
class IngredientProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'product_id' => Product::inRandomOrder()->first()->id,
            'ingredient_id' => Ingredient::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(1, 2),

        ];
    }
}
