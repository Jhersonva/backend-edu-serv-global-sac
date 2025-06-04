<?php

namespace App\Http\Controllers\Api\SubCategory;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategory\StoreSubCategoryRequest;
use App\Http\Requests\SubCategory\UpdateSubCategoryRequest;
use App\Services\SubCategoryService;

class SubCategoryController extends Controller
{
    protected $service;

    public function __construct(SubCategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAllSubCategories());
    }

    public function store(StoreSubCategoryRequest $request)
    {
        $created = $this->service->storeSubCategory($request->validated());
        return response()->json($created, 201);
    }

    public function show($id)
{
    $service = $this->service->findSubCategoryById($id);

    if (!$service) {
        return response()->json([
            'message' => "El servicio con ID $id ya fue eliminado o no existe."
        ], 404);
    }

    return response()->json($service);
}

    public function update(UpdateSubCategoryRequest $request, $id)
    {
        $updated = $this->service->updateSubCategory($id, $request->validated());
        return response()->json($updated);
    }

    public function destroy($id)
    {
        $deleted = $this->service->deleteSubCategory($id);
        return response()->json(['message' => 'SubCategory deleted']);
    }
}

