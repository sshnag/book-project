<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $books         = Book::latest()->take(12)->get();
        $featuredBooks = Book::inRandomOrder()->take(6)->get();                   // or use a 'featured' flag
        $popularBooks  = Book::orderBy('download_count', 'desc')->take(6)->get(); // example based on views

        return view('home', compact('books', 'featuredBooks', 'popularBooks'));
    }
}
