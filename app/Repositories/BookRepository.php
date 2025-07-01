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
    return Book::with('author', 'category')
        ->when($filters['title'] ?? null, fn($q, $value) =>
            $q->where('title', 'LIKE', '%' . $value . '%'))
        ->when($filters['author'] ?? null, fn($q, $value) =>
            $q->whereHas('author', fn($q2) => $q2->where('name', 'LIKE', '%' . $value . '%')))
        ->when($filters['category'] ?? null, fn($q, $value) =>
            $q->whereHas('category', fn($q2) => $q2->where('name', 'LIKE', '%' . $value . '%')))
        ->when($filters['description'] ?? null, fn($q, $value) =>
            $q->where('description', 'LIKE', '%' . $value . '%'))
        ->paginate($perPage);
}

}
