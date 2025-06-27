<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $bookCount     = Book::count();
        $authorCount   = Author::count();
        $categoryCount = Category::count();

        $categories = Category::withCount(['books as download_count' => function ($query) {
            $query->select(DB::raw("SUM(download_count)"));
        }])->get();

        $labels    = $categories->pluck('name');
        $downloads = $categories->pluck('download_count');

        $books = Book::latest()->simplePaginate(5);
        $books = Book::simplePaginate(5); // Pagination for the books

        return view('admin.dashboard', compact(
            'bookCount',
            'authorCount',
            'categoryCount',
            'labels',
            'downloads',
            'books'
        ));

    }
}
