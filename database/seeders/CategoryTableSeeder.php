<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all data in the table
        Category::query()->delete();

        // Reset AUTO_INCREMENT to 1
        DB::unprepared("ALTER TABLE categories AUTO_INCREMENT=1;");

        // TODO: Feel free to hardcode some DB entries

        // Create entries using a factory
        Category::factory()->count(Config::$numberOfCategories)->create();
    }
}
