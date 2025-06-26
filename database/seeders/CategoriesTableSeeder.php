<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Fiction', 'Non-fiction', 'Science', 'History', 'Technology', 'Fantasy', 'Mystery', 'Romance', 'Horror', 'Biography', 'Self-help', 'Travel', 'Cooking', 'Health', 'Business'];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
