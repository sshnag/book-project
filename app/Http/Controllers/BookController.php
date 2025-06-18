<?php
namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Storage;
class BookController extends Controller
{
public function index(Request $request)
{
      if ($request->ajax()) {
        return DataTables::of(Book::with(['author', 'category']))
            ->addColumn('action', function ($book) {
                return view('books.partials.action', compact('book'))->render();
            })
            ->editColumn('published_at', function ($book) {
                return $book->published_at ? $book->published_at->format('Y-m-d') : 'N/A';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    return view('books.index');
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
            'description'  => 'required',
            'author_id'    => 'required|exists:authors,id',
            'category_id'  => 'required|exists:categories,id',
            'published_at' => 'nullable|date',
            'uploaded_at'  => 'nullable|date',
            'file_path'    => 'required|file|mimes:pdf|max:10240',
            'cover_image'  => 'nullable|image|mimes:jpg,png,jpeg|max:2048', //mimes to identify the type of the file
        ]);
        $book = Book::create($validated);
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');

        }
        if ($request->hasFile('file_path')) {
            $data['file_path'] = $request->file('file_path')->store('books', 'public');
        }
        $book->save();
        return redirect()->route('admin.books.index')->with('success', 'Book creates!');
    }

    public function update(Request $request, Book $book)
    {

        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'required',
            'author_id'    => 'required|exists:authors,id',
            'category_id'  => 'required|exists:categories,id',
            'published_at' => 'nullable|date',
            'uploaded_at'  => 'nullable|date',
            'file_path'    => 'required|file|mimes:pdf|max:10240',
            'cover_image'  => 'nullable|image|mimes:jpg,png,jpeg|max:2048', //mimes to identify the type of the file
        ]);

    if ($request->hasFile('file_path')) {
        // Delete old file if exists
        if ($book->file_path) {
            Storage::disk('public')->delete($book->file_path);
        }
        $validated['file_path'] = $request->file('file_path')->store('books', 'public');
    }

    $book->update($validated);

    return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }
    public function show(Book $book)
    {
        return view('books.show', compact('books'))->with('', $book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book is archived');
    }

    public function edit()
    {
        $authors    = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }
    public function download(Book $book)
    {
        $book->increment('down_count');
        $file = storage_path('app/public/' . $book->file_path);
        if (! file_exists($file)) {
            abort(404, 'File not Found!');
        }
        return response()->download($file, $book->title . '.pdf');
    }
}
