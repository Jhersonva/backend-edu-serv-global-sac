<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    protected CustomerService $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $customers = $this->service->getAllCustomers();
        return response()->json($customers);
    }

    public function show($id): JsonResponse
    {
        $customer = $this->service->findCustomerById($id);
        return response()->json($customer);
    }

    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = $this->service->storeCustomer($request->validated());
        return response()->json(['message' => 'Customer created', 'data' => $customer], 201);
    }

    public function update(UpdateCustomerRequest $request, $id): JsonResponse
    {
        $customer = $this->service->updateCustomer($id, $request->validated());
        return response()->json($customer);
    }

    public function destroy($id): JsonResponse
    {
        $this->service->deleteCustomer($id);
        return response()->json(['message' => 'Customer deleted']);
    }
}
