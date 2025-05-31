<?php

namespace App\Services;

use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;
use App\Models\TeamInformation;
use Illuminate\Http\UploadedFile;

class TeamInformationService
{
    use SaveImage, DeleteImage;

    public function getAllTeamInformation()
    {
        return TeamInformation::with('image')->get();
    }

    public function findTeamInformationById($id)
    {
        return TeamInformation::with('image')->findOrFail($id);
    }

    public function storeTeamInformation(array $data)
    {
        $imageFile = request()->file('image');

        $teamInformation = TeamInformation::create([
            'full_name' => $data['full_name'],
            'rol' => $data['rol'],
            'description' => $data['description'],
        ]);

        if ($imageFile instanceof UploadedFile) {
            $path = $this->upload($imageFile, 'team-information');
            $publicUrl = asset('storage/' . $path);
            $teamInformation->image()->create(['url' => $publicUrl]);
        }

        return $teamInformation->load('image');
    }

    public function updateTeamInformation($id, array $data)
    {
        $teamInformation = TeamInformation::with('image')->findOrFail($id);

        $teamInformation->update([
            'full_name' => $data['full_name'] ?? $teamInformation->full_name,
            'rol' => $data['rol'] ?? $teamInformation->rol,
            'description' => $data['description'] ?? $teamInformation->description,
        ]);

        if ($imageFile = request()->file('image')) {
            if ($teamInformation->image) {
                
                $oldPath = str_replace(asset('storage') . '/', '', $teamInformation->image->url);
                $this->delete($oldPath);

                
                $path = $this->upload($imageFile, 'team-information');
                $publicUrl = asset('storage/' . $path);

                
                $teamInformation->image->update(['url' => $publicUrl]);
            } else {
                $path = $this->upload($imageFile, 'team-information');
                $publicUrl = asset('storage/' . $path);
                $teamInformation->image()->create(['url' => $publicUrl]);
            }
        }

        return $teamInformation->load('image');
    }

    public function deleteTeamInformation($id): bool
    {
        $teamInformation = TeamInformation::findOrFail($id);

        if ($teamInformation->image) {
            $relativePath = str_replace(asset('storage') . '/', '', $teamInformation->image->url);
            $this->delete($relativePath); 
            $teamInformation->image->delete();   
        }

        return $teamInformation->delete(); 
    }
}
