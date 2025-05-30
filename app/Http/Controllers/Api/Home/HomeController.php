<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\Home\StoreHomeRequest;
use App\Http\Requests\Home\UpdateHomeRequest;
use App\Services\HomeServices;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    protected $service;

    public function __construct(HomeServices $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $homes = $this->service->getAllHome();
        return response()->json($homes);
    }

    public function store(StoreHomeRequest $request): JsonResponse
    {
        $home = $this->service->createHome($request->validated());
        return response()->json($home, 201);
    }

    public function show($id): JsonResponse
    {
        $home = $this->service->getById($id);
        return response()->json($home);
    }

    public function update(UpdateHomeRequest $request, $id): JsonResponse
    {
        $home = $this->service->updateHome($request->validated(), $id);
        return response()->json($home);
    }

    public function destroy($id): JsonResponse
    {
        $this->service->deleteHome($id);
        return response()->json([
            'message' => 'Home deleted successfully'
        ]);
    }
}
