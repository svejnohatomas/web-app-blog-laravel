<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete all data in the table
        User::query()->delete();

        // Reset AUTO_INCREMENT to 1
        DB::unprepared("ALTER TABLE users AUTO_INCREMENT=1;");

        // TODO: Feel free to hardcode some DB entries

        // Create entries using a factory
        User::factory(Config::$numberOfUsers)->create();
    }
}
