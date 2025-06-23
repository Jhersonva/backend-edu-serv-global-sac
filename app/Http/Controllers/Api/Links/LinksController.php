<?php

namespace App\Http\Controllers\Api\Links;

use App\Http\Controllers\Controller;
use App\Http\Requests\Links\StoreLinksRequest;
use App\Http\Requests\Links\UpdateLinksRequest;
use App\Services\LinksService;
use Illuminate\Http\JsonResponse;

class LinksController extends Controller
{
    protected LinksService $linksService;

    public function __construct(LinksService $linksService)
    {
        $this->linksService = $linksService;
    }

    /**
     * Obtener todos los links.
     */
    public function index(): JsonResponse
    {
        $links = $this->linksService->getAllLinks();
        return response()->json($links);
    }

    /**
     * Obtener un link por ID.
     */
    public function show($id): JsonResponse
    {
        $link = $this->linksService->findLinkById($id);
        return response()->json($link);
    }

    /**
     * Crear un nuevo link.
     */
    public function store(StoreLinksRequest $request): JsonResponse
    {
        $data = $request->validated();  
        $link = $this->linksService->storeLink($data);

        return response()->json($link, 201); 
    }

    /**
     * Actualizar un link existente.
     */
    public function update(UpdateLinksRequest $request, $id): JsonResponse
    {
        $data = $request->validated();  
        $link = $this->linksService->updateLink($id, $data);

        return response()->json($link);
    }

    /**
     * Eliminar un link.
     */
    public function destroy($id): JsonResponse
    {
        $success = $this->linksService->deleteLink($id);

        if ($success) {
            return response()->json(['message' => 'Link eliminado exitosamente']);
        } else {
            return response()->json(['message' => 'Link no encontrado'], 404);
        }
    }
}
