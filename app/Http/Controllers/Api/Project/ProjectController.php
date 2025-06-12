<?php

namespace App\Http\Controllers\Api\Project;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function index()
    {
        return response()->json($this->projectService->getAllProjects());
    }

    public function show($id)
    {
        return response()->json($this->projectService->findProjectById($id));
    }

    public function store(StoreProjectRequest $request)
    {
        return response()->json($this->projectService->storeProject($request->validated()), 201);
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        return response()->json($this->projectService->updateProject($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->projectService->deleteProject($id);
        return response()->json(['message' => 'Project deleted successfully.']);
    }
}
