<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Summary of categoryrepo
     * @var
     */
    protected $categoryrepo;

    /**
     * Initialize controller dependencies.
     *
     * @author - SSA
     * @param CategoryRepository $categoryRepo
     * @param  $categoryService CategoryService
     */
    public function __construct(CategoryRepository $categoryrepo)
    {
        $this->categoryrepo = $categoryrepo;

    }
    /**
     * Display paginated listing of categories.
     *
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = $this->categoryrepo->getAllPaginated();
        return view('categories.index', compact('categories'))->with('success', 'New Category Added!');

    }

    /**
     * Summary of create
     * creating new categories
     * @return \Illuminate\Contracts\View\View
     *
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Summary of store
     * storing new cateogry data
     * @param \App\Http\Requests\StoreCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->categoryrepo->create($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Category Added');
    }

    public function show(Category $categories)
    {
        return view('categories.index', compact('categories'));
    }

    // public function update(Request $request, Category $category)
    // {
    //     $category->update($request->validate(['name' => 'required']));
    //     return redirect()->route('categories.index')->with('success', 'Updated!');
    // }
// public function edit(Category $category)
// {
//     return view('categories.edit', compact('category'));
// }
    public function edit($id)
    {

        return view('categories.edit', compact('category'));
    }

    /**
     * Summary of destroy
     * deleting seleted category data(softdelete)
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Category $category)
    {
        $this->categoryrepo->delete($category);
        return redirect()->route('admin.categories.index')->with('success', 'Category is archieved!');
    }

}
