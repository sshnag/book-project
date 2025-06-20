<?php
namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PublicController extends Controller
{

    public function index()
    {
        $books         = Book::with(['author'])->latest()->take(6)->get();        // latest 6 books
        $featuredBooks = Book::inRandomOrder()->take(5)->get();                   // random featured
        $popularBooks  = Book::orderBy('download_count', 'desc')->take(6)->get(); // example based on views

        return view('home', compact('books', 'featuredBooks', 'popularBooks'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
