<?php
namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function create(array $data)
    {
        return Category::create($data);
    }

    public function delete(int $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }

    public function findAll()
    {
        return Category::all();
    }

    public function findById(int $id)
    {
        return Category::findOrFail($id);
    }
}
