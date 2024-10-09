<?php

namespace App\Http\Controllers;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index():JsonResponse
    {
<<<<<<< HEAD
        $categories = $this->categoryService->getAllCategories(); 
        return response()->json($categories); 
=======
        $categories = $this->categoryService->getAllCategories();
        //\Log::info("reponses: " . json_encode($categories));
        return response()->json($categories);
>>>>>>> 3633ae6da165af22c1a7f9dd4e4fce4c2c552e76
    }

    public function store(Request $request):JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string',
            'parent_id' => 'nullable|exists:categories,id'
        ]);
        $this->categoryService->createCategory($data);
        return response()->json(['message' => 'Catégorie créée avec succès!']);
    }

    public function destroy($id):JsonResponse
    {
        $this->categoryService->deleteCategory($id);
        return response()->json(['message' => 'Catégorie supprimée avec succès!']);
    }
}

