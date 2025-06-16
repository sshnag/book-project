<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
class PublicController extends Controller
{
   public function books()
{
    $books = Book::whereNull('deleted_at')->paginate(8); // Adjust number per page
    return view('public.books.index', compact('books'));
}

    public function index()
    {
        return view('welcome'); // or your custom public view
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
