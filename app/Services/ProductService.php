<?php
namespace App\Services;

use App\Repositories\ProductRepository;
use App\Models\Product;

class ProductService
{
    protected $productRepository;

    // Injecte le repository de produits
    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    // Crée un nouveau produit et gère l'upload d'image
    public function createProduct($data)
    {
        // Créer le produit
        $product = Product::create($data);

        // Si une image est téléchargée, enregistrez-la
        if (isset($data['image'])) {
            $path = $data['image']->store('images', 'public');
            $product->image = $path;
            $product->save();
        }

        return $product; // Retourner l'objet Product créé
    }

    // Supprime un produit par son ID
    public function deleteProduct(int $id)
    {
        $this->productRepository->delete($id);
    }

    // Liste tous les produits
    public function listProducts()
    {
        return $this->productRepository->findAll();
    }

    // Récupère un produit par son ID
    public function getProduct(int $id)
    {
        return $this->productRepository->findById($id);
    }

    // Met à jour un produit avec de nouvelles données
    public function updateProduct(int $id, array $data)
    {
        return $this->productRepository->update($id, $data);
    }
}
