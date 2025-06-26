<?php
namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    public function getAllPaginated($perPage = 5)
    {
        return Book::with(['author', 'category'])->latest()->simplePaginate($perPage);

    }
    public function findwithRelation($id)
    {
        return Book::with(['author', 'category'])->findOrFail($id);
    }
    public function searchBooks($filters, $perpage = 5)
    {
        return Book::with('author', 'category')
            ->when(['title'] ?? null, fn($q) => $q->where('title', 'LIKE', '%' . $filters['title'] . '%'))
            ->when(['author'] ?? null, fn($q) => $q->whereHas('author', fn($q2) => $q2->where('name', 'LIKE', '%' . $filters['author'] . '%')))
            ->when(['category'] ?? null, fn($q) => $q->whereHas('category', fn($q2) => $q2->where('name', 'LIKE', '%' . $filters['category'] . '%')))
            ->when(['description'] ?? null, fn($q) => $q->where('description', 'LIKE', '%' . $filters['description'] . '%'))
            ->simplePaginate($perpage);
    }
}
