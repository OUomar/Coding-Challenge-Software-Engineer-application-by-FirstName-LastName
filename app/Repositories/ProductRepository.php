<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function create(array $data)
    {
        return Product::create($data);
    }

    public function getProducts(string $sortBy, string $sortOrder, int $perPage, int $page, ?int $categoryId)
    {
        $query = Product::query();

        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        $products = $query->orderBy($sortBy, $sortOrder)->paginate($perPage, ['*'], 'page', $page);

        $products->getCollection()->transform(function ($product) {
            if ($product->image) {
                $product->image_url = asset('storage/' . $product->image); 
            }
            return $product;
        });

        return $products;
    }

    public function delete(int $id):void
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

    public function findAll():Collection
    {
        return Product::all();
    }

    public function findById(int $id):Product
    {
        return Product::findOrFail($id);
    }

    public function update(int $id, array $data):void
    {
        $product = Product::findOrFail($id);
        $product->update($data);
    }
}
