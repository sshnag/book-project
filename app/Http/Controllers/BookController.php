<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Repositories\BookRepository;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BookController extends Controller
{
    protected $bookrepo;
    protected $bookservice;

    /**
     * Inject the BookRepository and BookService dependencies.
     * @author - SSA
     * @param  \App\Repositories\BookRepository  $bookrepo
     * @param  \App\Services\BookService  $bookservice
     */
    public function __construct(BookRepository $bookrepo, BookService $bookservice)
    {
        $this->bookrepo    = $bookrepo;
        $this->bookservice = $bookservice;
    }

    /**
     * Display a paginated list of books for admin panel view.
     * @author - SSA
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $books = $this->bookrepo->getAllPaginated();
        return view('books.index', compact('books'));
    }

    /**
     * Show the form for creating a new book (admin only).
     * @author - SSA
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Book::class);
        $authors    = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));
    }

    /**
     * Store a newly created book in storage after validation and file handling.
     * @author - SSA
     * @param  \App\Http\Requests\StoreBookRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();
        $fileData  = $this->bookservice->handleFileUploads($request);
        $validated = array_merge($validated, $fileData);
        Book::create($validated);

        return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
    }

    /**
     * Update the specified book's information and files in storage.
     * @author - SSA
     * @param  \App\Http\Requests\UpdateBookRequest  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();
        $fileData  = $this->bookservice->handleFileUploads($request, $book);
        $validated = array_merge($validated, $fileData);
        $book->update($validated);
        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    /**
     * Display detailed book info for admins (with relationships).
     * @author - SSA
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Contracts\View\View
     */
    public function adminShow(Book $book)
    {
        $book = Book::with(['author', 'category'])->findOrFail($book->id);
        return view('books.show', compact('book'));
    }

    /**
     * Display book details to end users with author and category info.
     * @author - SSA
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Contracts\View\View
     */
    public function userShow(Book $book)
    {
        $book = Book::with(['author', 'category'])->findOrFail($book->id);
        return view('user.show', data: compact('book'));
    }

    /**
     * Archive (soft delete) the given book (admin only).
     * @author - SSA
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Book $book)
    {
        $this->authorize('delete', $book);
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book is archived');
    }

    /**
     * Show the form to edit a book’s details.
     * @author - SSA
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Book $book)
    {
        $authors    = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    /**
     * Handle file download and increase the book's download count.
     * Returns the book's PDF file as response.
     * @author - SSA
     * @param  \App\Models\Book  $book
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Book $book)
    {
        $this->bookservice->incrementDownload($book);
        $file = storage_path('app/public/' . $book->file_path);

        if (!file_exists($file)) {
            abort(404, 'File Not Found!');
        }

        return response()->download($file, $book->title . '.pdf');
    }

    /**
     * Search books by title, author, category, or description.
     * Returns a filtered result list to the user.
     * @author - SSA
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $filters = [
            'title'       => $query,
            'author'      => $query,
            'category'    => $query,
            'description' => $query,
        ];

        $books = $this->bookrepo->searchBooks($filters, 8);
        return view('search', compact('books'));
    }
}
