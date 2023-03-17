<?php

namespace Database\Factories;

use App\Models\Category;
use Database\Factories\Config as FactoriesConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => fake(FactoriesConfig::$locale)->slug(),
            'title' => fake(FactoriesConfig::$locale)->realText(50),
            'description' => fake(FactoriesConfig::$locale)->realText(200)
        ];
    }
}
