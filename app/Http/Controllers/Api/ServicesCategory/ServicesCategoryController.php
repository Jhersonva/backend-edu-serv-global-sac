<?php

namespace App\Http\Controllers\Api\ServicesCategory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ServicesCategoryService;
use App\Http\Requests\ServicesCategory\StoreServicesCategoryRequest;
use App\Http\Requests\ServicesCategory\UpdateServicesCategoryRequest;

class ServicesCategoryController extends Controller
{
    protected $servicesCategoryService;

    public function __construct(ServicesCategoryService $servicesCategoryService)
    {
        $this->servicesCategoryService = $servicesCategoryService;
    }

    public function index()
    {
        return response()->json($this->servicesCategoryService->getAllServicesCategory());
    }

    public function show($id)
    {
        return response()->json($this->servicesCategoryService->findByIdServicesCategory($id));
    }

    public function store(StoreServicesCategoryRequest $request)
    {
        return response()->json($this->servicesCategoryService->storeServicesCategory($request->validated()), 201);
    }

    public function update(UpdateServicesCategoryRequest $request, $id)
    {
        return response()->json($this->servicesCategoryService->updateServicesCategory($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->servicesCategoryService->deleteServicesCategory($id);
        return response()->json(['message' => 'Service category deleted successfully.']);
    }
}
