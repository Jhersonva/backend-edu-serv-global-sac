<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAllCategories());
    }

    public function store(StoreCategoryRequest $request)
    {
        $created = $this->service->storeCategory($request->validated());
        return response()->json($created, 201);
    }

    public function show($id)
    {
        return response()->json($this->service->findCategoryById($id));
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $updated = $this->service->updateCategory($id, $request->validated());
        return response()->json($updated);
    }

    public function destroy($id)
    {
        $deleted = $this->service->deleteCategory($id);
        return response()->json(['deleted' => $deleted]);
    }
}

