<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreCategoryRequest;
use App\Repositories\CategoryRepository;
class CategoryController extends Controller
{
    protected $categoryrepo;
    public function __construct(CategoryRepository $categoryrepo){
        $this->categoryrepo=$categoryrepo;

    }
    public function index()
    {
        $categories=$this->categoryrepo->getAllPaginated();
        return view('categories.index',compact('categories'))->with('success','New Category Added!');

    }
    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
       $this->categoryrepo->create($request->validated());
        return redirect()->route('admin.categories.index')->with('success', 'Category Added');
    }
    public function show(Category $categories)
    {
        return view('categories.index', compact('categories'));
    }

    public function update(Request $request, Category $category)
    {
        $category->update($request->validate(['name' => 'required']));
        return redirect()->route('categories.index')->with('success', 'Updated!');
    }
// public function edit(Category $category)
// {
//     return view('categories.edit', compact('category'));
// }
    public function edit($id)
    {

        return view('categories.edit', compact('category'));
    }
    public function destroy(Category $category)
    {
        $this->categoryrepo->delete($category);
            return redirect()->route('admin.categories.index')->with('success', 'Category is archieved!');
    }

}
