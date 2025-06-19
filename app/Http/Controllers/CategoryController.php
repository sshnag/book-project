<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CategoryController extends Controller
{

    public function index()
    {
        // Force fresh query without caching
        $categories = Category::query()
            ->orderBy('name')
            ->get()
            ->map(function ($category) {
                if (! is_object($category)) {
                    logger()->error('Invalid category found', ['category' => $category]);
                    return null;
                }
                return $category;
            })
            ->filter();
            $categories=Category::simplePaginate(5); //[pagination]
        return view('categories.index', compact('categories'));

    }
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        Category::create($validated);
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
        $category = Category::find($id);
        dd($category);
        return view('categories.edit', compact('category'));
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category is deleted!');
    }

}
