<?php

namespace App\Http\Controllers\Api\Collaborations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Collaborations\StoreCollaborationsRequest;
use App\Http\Requests\Collaborations\UpdateCollaborationsRequest;
use App\Services\CollaborationsService;
use Illuminate\Http\JsonResponse;

class CollaborationsController extends Controller
{
    protected CollaborationsService $CollaborationsService;

    public function __construct(CollaborationsService $CollaborationsService)
    {
        $this->CollaborationsService = $CollaborationsService;
    }

    
    public function index(): JsonResponse
    {
        $Collaborations = $this->CollaborationsService->getAllCollaborations();
        return response()->json($Collaborations);
    }

   
    public function show($id): JsonResponse
    {
        $Collaboration = $this->CollaborationsService->findCollaborationsById($id);
        return response()->json($Collaboration);
    }

    
    public function store(StoreCollaborationsRequest $request): JsonResponse
    {
        $data = $request->validated();  
        $Collaboration = $this->CollaborationsService->storeCollaborations($data);

        return response()->json($Collaboration, 201); 
    }

    public function update(UpdateCollaborationsRequest $request, $id): JsonResponse
    {
        $data = $request->validated();  
        $Collaboration = $this->CollaborationsService->updateLink($id, $data);

        return response()->json($Collaboration);
    }

    
    public function destroy($id): JsonResponse
    {
        $success = $this->CollaborationsService->deleteCollaboration($id);

        if ($success) {
            return response()->json(['message' => 'Colaboración eliminada exitosamente']);
        } else {
            return response()->json(['message' => 'Colaboración no encontrada'], 404);
        }
    }
}
