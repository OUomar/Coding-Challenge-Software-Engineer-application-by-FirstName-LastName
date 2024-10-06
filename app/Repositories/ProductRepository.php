<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function create(array $data)
    {
        return Product::create($data);
    }

    public function delete(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    public function findAll()
    {
        return Product::all();
    }

    public function findById(int $id)
    {
        return Product::findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $product = Product::findOrFail($id);
        $product->update($data);
    }
}
