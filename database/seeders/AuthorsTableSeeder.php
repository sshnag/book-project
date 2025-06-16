<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use Illuminate\Support\Str;
use Faker\Factory as Faker;



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
