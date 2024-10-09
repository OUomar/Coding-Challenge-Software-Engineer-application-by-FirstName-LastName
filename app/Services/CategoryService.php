<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Models\Category;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Collection;
=======
>>>>>>> 3633ae6da165af22c1a7f9dd4e4fce4c2c552e76

class CategoryService
{
    protected $categoryRepository;

    //Constructeur qui injecte le repository de catégories
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    // Récupérer toutes les catégories
<<<<<<< HEAD
    public function getAllCategories():Collection
    {
        return $this->categoryRepository->findAll();
=======
    public function getAllCategories()
    {
        return Category::all();
>>>>>>> 3633ae6da165af22c1a7f9dd4e4fce4c2c552e76
    }

    //Crée une nouvelle catégorie avec les données fournies
    public function createCategory(array $data):Category
    {
        return $this->categoryRepository->create($data);
    }

     //Supprime une catégorie selon l'ID donné
    public function deleteCategory(int $id):void
    {
        $this->categoryRepository->delete($id);
    }
    
    //Récupère une catégorie par son ID
    public function getCategory(int $id):Category
    {
        return $this->categoryRepository->findById($id);
    }
}

