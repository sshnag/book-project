<?php
namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    public function run()
    {
        $authors = ['George Orwell', 'Jane Austen', 'Isaac Newton', 'Stephen Hawking', 'Agatha Christie'];

        foreach ($authors as $name) {
            Author::create(['name' => $name]);
        }
    }
}
