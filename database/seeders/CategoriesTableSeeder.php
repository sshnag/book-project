<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Category;





class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Fiction', 'Non-fiction', 'Science', 'History', 'Technology','Fantasy', 'Mystery', 'Romance', 'Horror', 'Biography', 'Self-help', 'Travel', 'Cooking', 'Health', 'Business'];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
