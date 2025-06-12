<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return response()->json($this->categoryService->getAllCategory());
    }

    public function show($id)
    {
        return response()->json($this->categoryService->findByIdCategory($id));
    }

    public function store(StoreCategoryRequest $request)
    {
        return response()->json($this->categoryService->storeCategory($request->validated()), 201);
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        return response()->json($this->categoryService->updateCategory($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);
        return response()->json(['message' => 'Category deleted successfully.']);
    }
}

