<?php

namespace App\Services;

use App\Models\Collaborations;
use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;
use Illuminate\Http\UploadedFile;

class CollaborationsService
{
    use SaveImage, DeleteImage;

    public function getAllCollaborations()
    {
        return Collaborations::with('image')->get();
    }

    public function findCollaborationsById($id)
    {
        return Collaborations::with('image')->findOrFail($id);
    }

    public function storeCollaborations(array $data)
    {
        $imageFile = request()->file('image');

        $collaboration = Collaborations::create([
            'name' => $data['name'],
            'url'  => $data['url'],
        ]);

        if ($imageFile instanceof UploadedFile) {
            $path = $this->upload($imageFile, 'collaborations');
            $publicUrl = asset('storage/' . $path);
            $collaboration->image()->create(['url' => $publicUrl]);
        }

        return $collaboration->load('image');
    }

    public function updateLink($id, array $data)
    {
        $collaboration = Collaborations::with('image')->findOrFail($id);

        $collaboration->update([
            'name' => $data['name'] ?? $collaboration->name,
            'url'  => $data['url'] ?? $collaboration->url,
        ]);

        if ($imageFile = request()->file('image')) {
            if ($collaboration->image) {
                $oldPath = str_replace(asset('storage') . '/', '', $collaboration->image->url);
                $this->delete($oldPath);

                $path = $this->upload($imageFile, 'collaborations');
                $publicUrl = asset('storage/' . $path);
                $collaboration->image->update(['url' => $publicUrl]);
            } else {
                $path = $this->upload($imageFile, 'collaborations');
                $publicUrl = asset('storage/' . $path);
                $collaboration->image()->create(['url' => $publicUrl]);
            }
        }

        return $collaboration->load('image');
    }

    public function deleteCollaboration($id): bool
    {
        $collaboration = Collaborations::findOrFail($id);

        if ($collaboration->image) {
            $relativePath = str_replace(asset('storage') . '/', '', $collaboration->image->url);
            $this->delete($relativePath);
            $collaboration->image->delete();
        }

        return $collaboration->delete();
    }
}
