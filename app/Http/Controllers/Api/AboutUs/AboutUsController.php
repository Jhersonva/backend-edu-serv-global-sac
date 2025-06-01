<?php

namespace App\Http\Controllers\Api\AboutUs;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutUs\StoreAboutUsRequest;
use App\Http\Requests\AboutUs\UpdateAboutUsRequest;
use App\Services\AboutUsService;
use Illuminate\Http\JsonResponse;

class AboutUsController extends Controller
{
    protected $aboutUsService;

     // Inyectamos el servicio de AboutUsService en el constructor
    public function __construct(AboutUsService $aboutUsService)
    {
        $this->aboutUsService = $aboutUsService;
    }

    /**
     * Obtener AboutUs.
     */
    public function index(): JsonResponse
    {
        $data = $this->aboutUsService->getAllAboutUs();
        return response()->json($data);
    }

    /**
     * Crear un nuevo AboutUs.
     */
    public function store(StoreAboutUsRequest $request): JsonResponse
    {
        $data = $this->aboutUsService->storeAboutUs($request->validated());
        return response()->json($data, 201);
    }

    /**
     * Obtener un About por ID.
     */
    public function show($id): JsonResponse
    {
        $data = $this->aboutUsService->findAboutUsById($id);
        return response()->json($data);
    }

    /**
     * Actualizar AboutUs existente.
     */
    public function update(UpdateAboutUsRequest $request, $id): JsonResponse
    {
        $data = $this->aboutUsService->updateAboutUs($id, $request->validated());
        return response()->json($data);
    }

    /**
     * Eliminar AboutUs.
     */
    public function destroy($id): JsonResponse
    {
        $this->aboutUsService->deleteAboutUs($id);
        return response()->json(['message' => 'Eliminado exitosamente']);
    }
}

