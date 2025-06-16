<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $category= Category::all();
        return view('categories.index',compact('category'));
    }


    public function create()
    {
        return view('categories.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:255',
        ]);
        Category::create($request->all());
        return redirect ()->route('categories.index')->with('success','Category Added');
    }
public function show(Category $category)
{
    return view('categories.show', compact('category'));
}

public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $category->update($request->all());
    return redirect()->route('categories.index')->with('success', 'Category updated!');
}

public function destroy(Category $category)
{
    $category->delete();
    return redirect()->route('categories.index')->with('success', 'Category is deleted!');
}


}
