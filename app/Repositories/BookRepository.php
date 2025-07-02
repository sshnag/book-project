<?php
namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    public function getAllPaginated($perPage = 5)
    {

        return Book::with(['author', 'category'])->latest()->paginate($perPage);

    }
    public function findwithRelation($id)
    {
        return Book::with(['author', 'category'])->findOrFail($id);
    }
   public function searchBooks($filters, $perPage = 5)
{
    $query = Book::with('author', 'category');

    if (!empty($filters['title'])) {
        $searchTerm = $filters['title'];

        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'LIKE', "%{$searchTerm}%")
                ->orWhere('description', 'LIKE', "%{$searchTerm}%")
                ->orWhereHas('author', fn($q2) => $q2->where('name', 'LIKE', "%{$searchTerm}%"))
                ->orWhereHas('category', fn($q2) => $q2->where('name', 'LIKE', "%{$searchTerm}%"));
        });
    }
    return $query->paginate($perPage);
}


}
