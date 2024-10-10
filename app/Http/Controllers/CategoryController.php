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
        $categories = $this->categoryService->getAllCategories(); 
        return response()->json($categories); 
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

