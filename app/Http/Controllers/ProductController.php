<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $perPage = $request->get('per_page', 5);
        $page = $request->get('page', 1);
        $categoryId = $request->get('category_id');
        
        $query = Product::query();
        
        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }
    
        $products = $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    
        // Ajouter l'URL complète de l'image pour chaque produit
        $products->getCollection()->transform(function ($product) {
            if ($product->image) {
                $product->image_url = asset('storage/' . $product->image); // Générer l'URL complète de l'image
            }
            return $product;
        });
    
        return response()->json($products);
    }


    public function store(Request $request)
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
    
        // Si une image est envoyée, stockez-la
        if ($request->hasFile('image')) {
            // Stocker l'image dans le dossier 'product_images' dans 'public'
            $imagePath = $request->file('image')->store('product_images', 'public');
            $data['image_url'] = $imagePath; // Utiliser 'image_url' ou un autre champ correspondant dans la base de données
        }
    
        // Créer le produit avec les données
        $product = $this->productService->createProduct($data);
    
        // Attacher les catégories au produit
        $product->categories()->attach($data['categories']);
    
        return response()->json([
            'message' => 'Produit créé avec succès!',
            'product' => $product
        ]);
    }
    

    public function destroy($id)
    {
        $this->productService->deleteProduct($id);

        return response()->json(['message' => 'Produit supprimé avec succès!']);
    }
}

