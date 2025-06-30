<?php
namespace App\Repositories;

use App\Models\Category;
use Yajra\DataTables\Facades\DataTables;

class CategoryRepository
{
    public function getDataTable()
    {
        $categories = Category::withCount('books');

        return DataTables::eloquent($categories)
            ->addColumn('action', function ($category) {
                return view('categories.partials.actions', compact('category'))->render();
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getAllPaginated($perPage = 5)
    {
        return Category::withCount('books')->orderBy('name')->simplePaginate($perPage);
    }

    public function create(array $data)
    {
        return Category::create($data);
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }

    public function find($id)
    {
        return Category::find($id);
    }
}
