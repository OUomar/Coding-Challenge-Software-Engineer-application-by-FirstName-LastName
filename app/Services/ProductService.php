<?php
namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    protected $productRepository;

    // Injecte le repository de produits
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function get_All_Products(string $sortBy, string $sortOrder, int $perPage, int $page, ?int $categoryId): LengthAwarePaginator
    {
        return $this->productRepository->getProducts( $sortBy,  $sortOrder,$perPage, $page,$categoryId);
    }

    // Crée un nouveau produit et gère l'upload d'image
    public function createProduct($data):Product
    {
        // Créer le produit
        $product = Product::create($data);

        // Si une image est téléchargée, enregistrez-la
        if (isset($data['image'])) {
            $path = $data['image']->store('images', 'public');
            $product->image = $path;
            $product->save();
        }

        return $product; 
    }

    // Supprime un produit par son ID
    public function deleteProduct(int $id):void
    {
        $this->productRepository->delete($id);
    }

    // Liste tous les produits
    public function listProducts():Collection
    {
        return $this->productRepository->findAll();
    }

    // Récupère un produit par son ID
    public function getProduct(int $id):Product
    {
        return $this->productRepository->findById($id);
    }

    // Met à jour un produit avec de nouvelles données
    public function updateProduct(int $id, array $data):Product
    {
        return $this->productRepository->update($id, $data);
    }
}
