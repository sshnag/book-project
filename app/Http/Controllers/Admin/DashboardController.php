<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\DB;



class DashboardController extends Controller
{

    public function index()
    {
        $books = Book::with(['author', 'category'])
                   ->latest()
                   ->take(10) // Only get 10 recent books for dashboard
                   ->get();

        $books = Book::simplePaginate(5); // Pagination for the books
                   return view('admin.dashboard', compact('books'));
    }
}
