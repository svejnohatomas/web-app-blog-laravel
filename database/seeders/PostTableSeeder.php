<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all data in the table
        Post::query()->delete();

        // Reset AUTO_INCREMENT to 1
        DB::unprepared("ALTER TABLE posts AUTO_INCREMENT=1;");

        // TODO: Feel free to hardcode some DB entries

        // Create entries using a factory
        Post::factory()->count(Config::$numberOfPosts)->create();
    }
}
