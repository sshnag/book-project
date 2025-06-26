<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        $this->call(RolePermissionSeeder::class);

        $this->call([
            CategoriesTableSeeder::class,
            AuthorsTableSeeder::class,
            UsersTableSeeder::class,
            BooksTableSeeder::class,
            ContactSeeder::class,
        ]);
    }
}
