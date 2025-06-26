<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateBookRequest;
class BookController extends Controller
{

    public function index()
    {
        $books = Book::with(['author', 'category'])->latest()->simplePaginate(perPage: 5); // Basic pagination
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors    = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));

    }

    public function store(StoreBookRequest $request)
    {
        $book = Book::create($request->validated());

        // Debug the saved book
        return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
    }

    public function update(UpdateBookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    public function adminShow(Book $book)
    {
        $book = Book::with(['author', 'category'])->findOrFail($book->id);
        return view('books.show', compact('book'));
    }

    public function userShow(Book $book)
    {
        $book = Book::with(['author', 'category'])->findOrFail($book->id);
        return view('user.show', compact('book'));
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book is archived');
    }

    public function edit(Book $book)
    {
        $authors    = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }
    public function download(Book $book)
    {
        //download book and directing path
        $book->increment('download_count');
        $file = storage_path('app/public/' . $book->file_path);
        if (! file_exists($file)) {
            abort(404, 'File not Found!');
        }
        return response()->download($file, $book->title . '.pdf');
    }

    public function search(Request $request)
    {
        //searching
        $categories = Category::all();

        $books = Book::with('author', 'category')
            ->when($request->title, fn($q) => $q->where('title', 'LIKE', '%' . $request->title . '%'))
            ->when($request->author, fn($q) => $q->whereHas('author', fn($q2) => $q2->where('name', 'LIKE', '%' . $request->author . '%')))
            ->when($request->category, fn($q) => $q->whereHas('category', fn($q2) => $q2->where('name', 'LIKE', '%' . $request->category . '%')))
            ->when($request->description, fn($q) => $q->where('description', 'LIKE', '%' . $request->description . '%'))
            ->simplePaginate(5);

        return view('search', compact('books', 'categories'));
    }

}
