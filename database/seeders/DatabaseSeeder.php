<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Threads;
use App\Models\Board;
use App\Models\Category;
use App\Models\Replies;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(4)->create();
        Board::factory(10)->create();
        Threads::factory(40)->create();
        Replies::factory(40)->create();
    }
}
