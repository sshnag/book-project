<?php
namespace Database\Seeders;

use App\Models\Contact;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        foreach (range(1, 20) as $index) {
            Contact::create([
                'name'       => $faker->name,
                'email'      => $faker->safeEmail(),
                'message'    => $faker->sentence(12),
                'book_title' => substr($faker->sentence(2), 0, -1),
                'status'     => $faker->randomElement(['new', 'read', 'replied']),

            ]);

        }

    }
}
