<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{
       public function index()
    {
        $bookCount= Book::count(); // Total number of books
        $authorCount = DB::table('authors')->count(); // Total number of authors
        $categoryCount = DB::table('categories')->count(); // Total number of categories
        $books = Book::with(['author', 'category'])
                   ->latest()
                   ->take(10) // Only get 10 recent books for dashboard
                   ->get();

        $books = Book::simplePaginate(5); // Pagination for the books
                   return view('admin.dashboard', compact('books','bookCount', 'authorCount', 'categoryCount'));
    }
}
