<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request):JsonResponse
    {
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $perPage = $request->get('per_page', 5);
        $page = $request->get('page', 1);
        $categoryId = $request->get('category_id');
        
        $products = $this->productService->get_All_Products($sortBy, $sortOrder, $perPage, $page, $categoryId);
        
        return response()->json($products);
    }


    public function store(Request $request):JsonResponse
    {
        // Validation des données envoyées
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Vérifier que l'image est valide
            'categories' => 'required|array', // Validation des catégories
            'categories.*' => 'exists:categories,id', // Chaque catégorie doit exister dans la base de données
        ]);
    
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('product_images', 'public');
            $data['image_url'] = $imagePath; 

        }

        $product = $this->productService->createProduct($data);
        $product->categories()->attach($data['categories']);
    
        return response()->json([
            'message' => 'Produit créé avec succès!',
            'product' => $product
        ]);
    }
    

    public function destroy($id):JsonResponse
    {
        $this->productService->deleteProduct($id);
        return response()->json(['message' => 'Produit supprimé avec succès!']);
    }
}

