<?php
namespace App\Repositories;
use App\Models\Author;
use Yajra\DataTables\Facades\DataTables;

class AuthorRepository
{
    public function getDataTable()
    {
        $authors = Author::withCount('books');
        return DataTables::eloquent($authors)
            ->addColumn('action', function ($author) {
                return view('authors.partials.action', compact('author'))->render();
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function create(array $data)
    {
        return Author::create($data);
    }
    public function delete(Author $author)
    {
        return $author->delete();
    }
    public function getAll()
    {
        return Author::all();
    }
}
