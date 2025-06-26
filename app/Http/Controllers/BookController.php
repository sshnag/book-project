<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Repositories\BookRepository;
use App\Services\BookService;

class BookController extends Controller
{
    protected $bookrepo;
    protected $bookservice;

    /**
     *
     * Initialize controller with repository and service dependencies.
     * Summary of __construct
     * @param \App\Repositories\BookRepository $bookrepo
     * @param \App\Services\BookService $bookservice
     */
    public function __construct(BookRepository $bookrepo, BookService $bookservice)
    {
        $this->bookrepo    = $bookrepo;
        $this->bookservice = $bookservice;
    }

    /**
     * Display paginated listing of books
     * Summary of index
     * @return \Illuminate\Contracts\View\View
     */

    public function index()
    {
        $books = $this->bookrepo->getAllPaginated();
        return view('books.index', compact('books'));
    }

    /**
     * Summary of create
     * Showing form for creating new book
     * @return \Illuminate\Contracts\View\View
     */

    public function create()
    {
        $authors    = Author::all();
        $categories = Category::all();
        return view('books.create', compact('authors', 'categories'));

    }

    /**
     * Store newly created book in storage
     * Summary of store
     * @param \App\Http\Requests\StoreBookRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreBookRequest $request)
    {

        $validated = $request->validated();
        //file handling through service
        $fileData  = $this->bookservice->handleFileUploads($request);
        $validated = array_merge($validated, $fileData);
        Book::create($validated);

        // Debug the saved book
        return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
    }

    /**
     * Summary of update
     * Updated sepcific books in storage
     * @param \App\Http\Requests\UpdateBookRequest $request
     * @param \App\Models\Book $book
     * @return \Illuminate\Http\RedirectResponse

     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        $validated = $request->validated();

        //file handling through service
        $fileData  = $this->bookservice->handleFileUploads($request, $book);
        $validated = array_merge($validated, $fileData);
        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
    }

    /**
     * Summary of adminShow
     * Display Book details for admin
     * @param \App\Models\Book $book
     * @return \Illuminate\Contracts\View\View
     */

    public function adminShow(Book $book)
    {
        $book = Book::with(['author', 'category'])->findOrFail($book->id);
        return view('books.show', compact('book'));
    }
    /**
     * Summary of userShow
     * Display Book Details for the users
     * @param \App\Models\Book $book
     * @return \Illuminate\Contracts\View\View
     */
        public function userShow(Book $book)
    {
        $book = Book::with(['author', 'category'])->findOrFail($book->id);
        return view('user.show', compact('book'));
    }

    /**
     * Summary of destroy
     * Archieved selected books (Softdelte)
     * @param \App\Models\Book $book
     * @return \Illuminate\Http\RedirectResponse
     */

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book is archived');
    }

    /**
     * Summary of edit
     * Show from to edit the book details
     * @param \App\Models\Book $book
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Book $book)
    {
        $authors    = Author::all();
        $categories = Category::all();
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    /**
     * Summary of download
     * Download Book response and increment download count
     * @param \App\Models\Book $book
     * @return mixed|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */

    public function download(Book $book)
    {
        //download handling through service
        $this->bookservice->incrementDownload($book);
        $file = storage_path('app/public/' . $book->file_path);
        if (! file_exists($file)) {
            abort(404, 'File Not Found!');
        }
        return response()->download($file, $book->title . '.pdf');
    }

}
