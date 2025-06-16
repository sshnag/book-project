<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{

    public function index()
    {
        $authors= Author::all();
        return view('authors.index',compact('authors'));
    }


    public function create()
    {
        return view('authors.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
        ]);
        Author::create($request->all());
        return redirect ()->route('authors.index')->with('success','Author Added');
    }
public function show(Author $author)
{
    return view('authors.show', compact('author'));
}

public function update(Request $request, Author $author)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $author->update($request->all());
    return redirect()->route('authors.index')->with('success', 'Author updated!');
}

public function destroy(Author $author)
{
    $author->delete();
    return redirect()->route('authors.index')->with('success', 'Author deleted!');
}




}
