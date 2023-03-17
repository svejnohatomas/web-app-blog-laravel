<?php

namespace Database\Factories;

use App\Models\Post;
use Database\Seeders\Config as SeedersConfig;
use Database\Factories\Config as FactoriesConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => fake(FactoriesConfig::$locale)->numberBetween(1, SeedersConfig::$numberOfCategories),
            'user_id' => fake(FactoriesConfig::$locale)->numberBetween(1, SeedersConfig::$numberOfUsers),
            'slug' => fake(FactoriesConfig::$locale)->slug(),
            'title' => fake(FactoriesConfig::$locale)->realText(50),
            'excerpt' => fake(FactoriesConfig::$locale)->realText(200),
            'content' => fake(FactoriesConfig::$locale)->realText(500),
        ];
    }
}
