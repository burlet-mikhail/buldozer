<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Region>
 */
class RegionFactory extends Factory {

    protected $model = Region::class;

    public function definition(): array {
        return [
            'name' => fake()->city(),
            'slug' => fake()->unique()->slug(1),
            'active' => true,
            'default' => false,
        ];
    }

    /**
     * Регион по умолчанию.
     */
    public function default(): static {
        return $this->state(fn(array $attributes) => [
            'default' => true,
        ]);
    }

    /**
     * Неактивный регион.
     */
    public function inactive(): static {
        return $this->state(fn(array $attributes) => [
            'active' => false,
        ]);
    }

}
