<?php
namespace App\Repositories;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;


class CategoryRepository
{
    public function create(array $data):Category
    {
        return Category::create($data);
    }

    public function delete(int $id):void
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }

    public function findAll():Collection
    {
        return Category::all();
    }

    public function findById(int $id):Category
    {
        return Category::findOrFail($id);
    }
}
