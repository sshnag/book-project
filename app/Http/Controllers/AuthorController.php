<?php
namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class AuthorController extends Controller
{

    public function index(Request $request)
    {
        //Author lists using Yajra Datatable
         if ($request->ajax()) {
        $authors = Author::withCount('books');

        return DataTables::eloquent($authors)
            ->addColumn('action', function ($author) {
                return view('authors.partials.action', compact('author'))->render();
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    return view('authors.index');
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(Request $request)
    {
        //storing authors data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Author::create($request->all());
        return redirect()->route('admin.authors.index')->with('success', 'Author Added');
    }
    public function show(Author $author)
    {
        return view('authors.show', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        //Update
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $author->update($request->all());
        return redirect()->route('admin.authors.index')->with('success', 'Author updated!');
    }

    public function destroy(Author $author)
    {
        //delete
        $author->delete();
        return redirect()->route('admin.authors.index')->with('success', 'Author is Archieved!');
    }

}
