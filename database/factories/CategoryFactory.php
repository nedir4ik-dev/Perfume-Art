<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Classic Dior',
            'Chanel No 5',
            'Tom Ford Luxury',
            'Gucci Bloom',
            'Versace Eros',
            'Armani Code',
            'Creed Aventus',
            'Hermès Paris'
        ]);

        return [
            'name' => $name,
            'slug' => str_replace(' ', '-', strtolower($name)),
            'description' => fake()->sentence(),
        ];
    }
}
