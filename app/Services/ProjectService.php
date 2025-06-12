<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Http\UploadedFile;
use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;

class ProjectService
{
    use SaveImage, DeleteImage;

    public function getAllProjects()
    {
        return Project::with('image', 'services')->get();
    }

    public function findProjectById($id)
    {
        return Project::with('image', 'services')->findOrFail($id);
    }

    public function storeProject(array $data)
    {
        $project = Project::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ]);

        if ($image = request()->file('image')) {
            $path = $this->upload($image, 'projects');
            $project->image()->create(['url' => asset('storage/' . $path)]);
        }

        return $project->load('image');
    }

    public function updateProject($id, array $data)
    {
        $project = Project::with('image')->findOrFail($id);

        $project->update([
            'title' => $data['title'] ?? $project->title,
            'description' => $data['description'] ?? $project->description,
        ]);

        if ($image = request()->file('image')) {
            $path = $this->upload($image, 'projects');
            $url = asset('storage/' . $path);

            if ($project->image) {
                $this->delete(str_replace(asset('storage') . '/', '', $project->image->url));
                $project->image->update(['url' => $url]);
            } else {
                $project->image()->create(['url' => $url]);
            }
        }

        return $project->load('image');
    }

    public function deleteProject($id)
    {
        $project = Project::with('image')->findOrFail($id);

        if ($project->image) {
            $this->delete(str_replace(asset('storage') . '/', '', $project->image->url));
            $project->image->delete();
        }

        return $project->delete();
    }
}

