<?php

namespace App\Http\Controllers\Api\TeamInformation;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamInformation\StoreTeamInformationRequest;
use App\Http\Requests\TeamInformation\UpdateTeamInformationRequest;
use App\Services\TeamInformationService;
use Illuminate\Http\JsonResponse;

class TeamInformationController extends Controller
{
    protected TeamInformationService $teamInformationService;

    // Inyectamos el servicio de BlogService en el constructor
    public function __construct(TeamInformationService $teamInformationService)
    {
        $this->teamInformationService = $teamInformationService;
    }

    /**
     * Obtener toda la información del equipo.
     */
    public function index(): JsonResponse
    {
        $teams = $this->teamInformationService->getAllTeamInformation();
        return response()->json($teams);
    }

    /**
     * Obtener información del equipo por ID.
     */
    public function show($id): JsonResponse
    {
        $team = $this->teamInformationService->findTeamInformationById($id);
        return response()->json($team);
    }

    /**
     * Crear nueva información de miembro del equipo.
     */
    public function store(StoreTeamInformationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $team = $this->teamInformationService->storeTeamInformation($data);

        return response()->json($team, 201);
    }

    /**
     * Actualizar información existente de un miembro del equipo.
     */
    public function update(UpdateTeamInformationRequest $request, $id): JsonResponse
    {
        $data = $request->validated();
        $team = $this->teamInformationService->updateTeamInformation($id, $data);

        return response()->json($team);
    }

    /**
     * Eliminar información de un miembro del equipo.
     */
    public function destroy($id): JsonResponse
    {
        $success = $this->teamInformationService->deleteTeamInformation($id);

        if ($success) {
            return response()->json(['message' => 'Miembro del equipo eliminado exitosamente.']);
        }

        return response()->json(['message' => 'Miembro del equipo no encontrado.'], 404);
    }
}
