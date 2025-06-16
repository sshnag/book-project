<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        $this->call([
            CategoriesTableSeeder::class,
            AuthorsTableSeeder::class,
            UsersTableSeeder::class,
            BooksTableSeeder::class,
        ]);
    }
}
