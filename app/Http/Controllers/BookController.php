<?php
namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required|string',
            'author_id'    => 'required|exists:authors,id',
            'category_id'  => 'required|exists:categories,id',
            'published_at' => 'nullable|date',
            'cover_image'  => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'file_path'    => 'required|file|mimes:pdf|max:10240',
        ]);

        $imagePath = $request->hasFile('cover_image')
        ? $request->file('cover_image')->store('covers', 'public')
        : null;

        $filePath = $request->file('file_path')->store('books', 'public');

        $book = Book::create([
            'title'        => $validated['title'],
            'description'  => $validated['description'],
            'author_id'    => $validated['author_id'],
            'category_id'  => $validated['category_id'],
            'published_at' => $validated['published_at'] ?? null,
            'cover_image'  => $imagePath,
            'file_path'    => $filePath,
        ]);

        // Debug the saved book
        return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required',
            'author_id'    => 'required|exists:authors,id',
            'category_id'  => 'required|exists:categories,id',
            'published_at' => 'nullable|date',
            'file_path'    => 'nullable|file|mimes:pdf|max:100000',
            'cover_image'  => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // File upload (PDF)
        if ($request->hasFile('file_path')) {
            if ($book->file_path) {
                Storage::disk('public')->delete($book->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('books', 'public');
        }

        // Cover Image upload
        if ($request->hasFile('cover_image')) {
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        } else {
            // If no new image uploaded, preserve old one
            $validated['cover_image'] = $book->cover_image;
        }

        $book->update($validated);

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
        $book->increment('download_count');
        $file = storage_path('app/public/' . $book->file_path);
        if (! file_exists($file)) {
            abort(404, 'File not Found!');
        }
        return response()->download($file, $book->title . '.pdf');
    }

}
