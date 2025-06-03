<?php

namespace App\Http\Controllers\Api\Servics;

use App\Http\Controllers\Controller;
use App\Http\Requests\Servics\StoreServiceRequest;
use App\Http\Requests\Servics\UpdateServiceRequest;
use App\Services\ServiceService;

class ServiceController extends Controller
{
    protected $service;

    public function __construct(ServiceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return response()->json($this->service->getAllServices());
    }

    public function store(StoreServiceRequest $request)
    {
        $created = $this->service->storeService($request->validated());
        return response()->json($created, 201);
    }

    public function show($id)
    {
        return response()->json($this->service->findServiceById($id));
    }

    public function update(UpdateServiceRequest $request, $id)
    {
        $updated = $this->service->updateService($id, $request->validated());
        return response()->json($updated);
    }

    public function destroy($id)
    {
        $deleted = $this->service->deleteService($id);
        return response()->json(['deleted' => $deleted]);
    }
}
