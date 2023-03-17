<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all data in the table
        Comment::query()->delete();

        // Reset AUTO_INCREMENT to 1
        DB::unprepared("ALTER TABLE comments AUTO_INCREMENT=1;");

        // TODO: Feel free to hardcode some DB entries

        // Create entries using a factory
        Comment::factory()->count(Config::$numberOfComments)->create();
    }
}
