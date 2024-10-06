<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    protected $categoryRepository;

    //Constructeur qui injecte le repository de catégories
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    //Crée une nouvelle catégorie avec les données fournies
    public function createCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

     //Supprime une catégorie selon l'ID donné
    public function deleteCategory(int $id)
    {
        $this->categoryRepository->delete($id);
    }

    //Récupère la liste de toutes les catégories
    public function listCategories()
    {
        return $this->categoryRepository->findAll();
    }
    
    //Récupère une catégorie par son ID
    public function getCategory(int $id)
    {
        return $this->categoryRepository->findById($id);
    }
}

