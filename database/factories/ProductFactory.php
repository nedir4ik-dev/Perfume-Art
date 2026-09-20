<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Brand;
use \App\Models\Category;
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
        $name = fake()->firstName() . ' Parfum';

        return [
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => str()->slug($name . '-' . rand(1, 9999)),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(500, 5000),
            'stock_quantity' => fake()->numberBetween(10, 50),
            'gender' => fake()->randomElement(['Men','Women','Unisex']),
            'ml_size' => fake()->randomElement([50, 100, 150, 200, 250]),
            'is_active' => true,
        ];
    }
}
