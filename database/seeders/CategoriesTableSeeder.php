<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Category;





class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Fiction', 'Non-fiction', 'Science', 'History', 'Technology'];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
