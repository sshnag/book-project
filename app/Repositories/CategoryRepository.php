<?php
namespace App\Repositories;

use App\Models\Category;
use Illuminate\Pagination\Paginator;

class CategoryRepository
{
    public function getAllPaginated($perPage = 5)
    {
        return Category::orderBy('name')->simplePaginate($perPage);
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
