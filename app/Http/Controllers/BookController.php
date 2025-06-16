<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function download(Book $book)
    {
        // Correct authorization check
        // if (!auth()->user()->can('download books')) {
        //     abort(403, 'You are not authorized to download this book');
        // } to put Auth::check()

        // $path = storage_path('app/public/' . $book->file_path);

        // if (!file_exists($path)) {
        //     abort(404, 'Book file not found');
        // }
        // $book->increment('download_count');

        // return response()->download($path);
    }

}
