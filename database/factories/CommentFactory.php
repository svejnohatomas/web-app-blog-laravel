<?php

namespace Database\Factories;

use App\Models\Comment;
use Database\Seeders\Config as SeedersConfig;
use Database\Factories\Config as FactoriesConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake(FactoriesConfig::$locale)->numberBetween(1, SeedersConfig::$numberOfUsers),
            'post_id' => fake(FactoriesConfig::$locale)->numberBetween(1, SeedersConfig::$numberOfPosts),
            'content' => fake(FactoriesConfig::$locale)->realTextBetween(50, 150),
        ];
    }
}
