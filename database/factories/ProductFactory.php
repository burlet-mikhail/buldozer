<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'slug' => fake()->unique()->slug(3),
            'text' => fake()->paragraph(),
            'region_id' => Region::factory(),
            'active' => true,
            'thumbnail' => null,
            'characteristic' => [],
            'messenger' => [],
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'active' => false,
        ]);
    }

    public function withThumbnail(): static
    {
        return $this->state(fn(array $attributes) => [
            'thumbnail' => ['test-image.jpg'],
        ]);
    }
}
