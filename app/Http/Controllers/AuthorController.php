<?php
namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreAuthorRequest;
use App\Repositories\AuthorRepository;

class AuthorController extends Controller
{
    protected $authorrepo;
    public function __construct(AuthorRepository $authorrepo){
        $this->authorrepo=$authorrepo;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->authorrepo->getDataTable();
            # code...
        }




    return view('authors.index');
    }

    public function create()
    {
        return view('authors.create');
    }

    public function store(StoreAuthorRequest $request)
    {
        $this->authorrepo->create($request->validated());
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
        $this->authorrepo->delete($author);
        return redirect()->route('admin.authors.index')->with('success', 'Author is Archieved!');
    }

}
