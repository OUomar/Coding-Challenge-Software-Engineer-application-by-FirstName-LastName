<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = Category::all(); // Récupérer toutes les catégories
        \Log::info("reponses: " . json_encode($categories));
        return response()->json($categories); // Retourner les catégories au format JSON
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $this->categoryService->createCategory($data);

        return response()->json(['message' => 'Catégorie créée avec succès!']);
    }

    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);

        return response()->json(['message' => 'Catégorie supprimée avec succès!']);
    }
}

