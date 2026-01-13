<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->words(2, true),
            'slug' => fake()->unique()->slug(2),
            'description' => fake()->paragraph(),
            'active' => true,
            'show_in_home' => false,
            'show_in_menu' => true,
            'show_in_popular' => false,
            'show_in_not_popular' => false,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'active' => false,
        ]);
    }

    public function showInHome(): static
    {
        return $this->state(fn(array $attributes) => [
            'show_in_home' => true,
        ]);
    }
}
