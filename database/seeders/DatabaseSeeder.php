<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category; // これを忘れずに

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CategoriesTableSeeder::class);
        Category::create(['content' => 'ご意見']);
        Category::create(['content' => 'ご質問']);
        Category::create(['content' => 'その他']);
    }
}