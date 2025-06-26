<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Models\Author;
use App\Repositories\AuthorRepository;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Summary of authorrepo
     * @var
     */
    protected $authorrepo;

    /**
     * Summary of __construct
     * recalling AuhtorRepository
     * @param \App\Repositories\AuthorRepository $authorrepo
     */
    public function __construct(AuthorRepository $authorrepo)
    {
        $this->authorrepo = $authorrepo;
    }

    /**
     * Summary of index
     * Displaying author list using yajra datatables
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->authorrepo->getDataTable();
            # code...
        }

        return view('authors.index');
    }

    /**
     * Summary of create
     * Adding new Author form
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Summary of store
     * storing new author data
     * @param \App\Http\Requests\StoreAuthorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreAuthorRequest $request)
    {
        $this->authorrepo->create($request->validated());
        return redirect()->route('admin.authors.index')->with('success', 'Author Added');
    }

    /**
     * Summary of show
     * Displaying Author data
     * @param \App\Models\Author $author
     * @return \Illuminate\Contracts\View\View
     */
    public function show(Author $author)
    {
        return view('authors.show', compact('author'));
    }

    /**
     * Summary of update
     * Updating author data
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Author $author
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function update(Request $request, Author $author)
    // {

    // }

    /**
     * Summary of destroy
     * deleting selected auhtor table(Softdelete)
     * @param \App\Models\Author $author
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Author $author)
    {
        //delete
        $this->authorrepo->delete($author);
        return redirect()->route('admin.authors.index')->with('success', 'Author is Archieved!');
    }

}
