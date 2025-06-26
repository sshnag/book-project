<?php
namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BooksTableSeeder extends Seeder
{
    public function run()
    {
        // Optional: use factories instead of hardcoded data if available
        for ($i = 1; $i <= 10; $i++) {
            Book::create([
                'title'          => "Sample Book $i",
                'description'    => "This is a sample description for Book $i.",
                'author_id'      => rand(1, 5), // Assuming 5 authors seeded
                'category_id'    => rand(1, 5), //Input 5 categories seeded
                'published_at'   => now()->subDays(rand(10, 100)),
                'cover_image'    => 'default.jpg',      // Just a placeholder, ensure file exists if using storage
                'file_path'      => 'books/sample.pdf', // Placeholder path
                'download_count' => rand(0, 100),
            ]);
        }
    }
}
