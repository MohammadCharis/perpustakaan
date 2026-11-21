<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    public function definition(): array
    {
        return ['category_id' => Category::factory(), 'isbn' => fake()->unique()->isbn13(), 'title' => fake()->sentence(3), 'author' => fake()->name(), 'published_year' => fake()->numberBetween(1990, 2026), 'stock' => fake()->numberBetween(1, 8), 'description' => fake()->paragraph()];
    }
}
