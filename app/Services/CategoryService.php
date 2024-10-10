<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    protected $categoryRepository;

    //Constructeur qui injecte le repository de catégories
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    // Récupérer toutes les catégories
    public function getAllCategories():Collection
    {
        return $this->categoryRepository->findAll();
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

