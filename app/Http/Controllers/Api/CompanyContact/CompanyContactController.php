<?php

namespace App\Http\Controllers\Api\CompanyContact;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyContact\UpdateCompanyContactRequest;
use App\Services\CompanyContactService;
use Illuminate\Http\JsonResponse;

class CompanyContactController extends Controller
{
    protected CompanyContactService $service;

    public function __construct(CompanyContactService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $contacts = $this->service->getAllCompanyContact();
        return response()->json($contacts);
    }

    public function show($id): JsonResponse
    {
        $contact = $this->service->findCompanyContactById($id);
        return response()->json($contact);
    }

    public function update(UpdateCompanyContactRequest $request, $id): JsonResponse
    {
        $contact = $this->service->updateCompanyContact($id, $request->validated());
        return response()->json($contact);
    }
}
