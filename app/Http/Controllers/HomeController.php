<?php
namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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
        $books         = Book::latest('created_at')->paginate(6);
        $featuredCategories = Category::latest('created_at')->paginate(6);
        $featuredBooks = Book::inRandomOrder()->take(6)->get();                   // or use a 'featured' flag
        $popularBooks  = Book::orderBy('download_count', 'desc')->take(6)->get(); // example based on views
        $categories = Category::all();

        return view('home', compact('books', 'featuredBooks', 'popularBooks','categories','featuredCategories'));
    }
}
