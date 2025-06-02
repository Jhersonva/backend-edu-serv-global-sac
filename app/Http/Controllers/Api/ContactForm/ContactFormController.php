<?php

namespace App\Http\Controllers\Api\ContactForm;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactForm\StoreContactFormRequest;
use App\Http\Requests\ContactForm\UpdateContactFormRequest;
use App\Services\ContactFormService;
use Illuminate\Http\JsonResponse;

class ContactFormController extends Controller
{
    protected ContactFormService $service;

    public function __construct(ContactFormService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        $contactforms = $this->service->getAllContactForm();
        return response()->json($contactforms);
    }

    public function show($id): JsonResponse
    {
        $contactform = $this->service->findContactFormById($id);
        return response()->json($contactform);
    }

    public function store(StoreContactFormRequest $request): JsonResponse
    {
        $customer = $this->service->storeContactForm($request->validated());
        return response()->json(['message' => 'ContactForm created', 'data' => $customer], 201);
    }

    public function update(UpdateContactFormRequest $request, $id): JsonResponse
    {
        $customer = $this->service->updateContactForm($id, $request->validated());
        return response()->json($customer);
    }

    public function destroy($id): JsonResponse
    {
        $this->service->deleteContactForm($id);
        return response()->json(['message' => 'ContactForm deleted']);
    }
}
