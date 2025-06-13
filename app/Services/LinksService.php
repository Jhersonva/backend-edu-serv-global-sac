<?php

namespace App\Services;

use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;
use App\Models\Links;
use Illuminate\Http\UploadedFile;

class LinksService
{
    use SaveImage, DeleteImage;

    public function getAllLinks()
    {
        return Links::with('image')->get();
    }

    public function findLinkById($id)
    {
        return Links::with('image')->findOrFail($id);
    }

    public function storeLink(array $data)
    {
        $imageFile = request()->file('image');

        $link = Links::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'url' => $data['url'],
        ]);

        if ($imageFile instanceof UploadedFile) {
            $path = $this->upload($imageFile, 'links');
            $publicUrl = asset('storage/' . $path);
            $link->image()->create(['url' => $publicUrl]);
        }

        return $link->load('image');
    }

    public function updateLink($id, array $data)
    {
        $link = Links::with('image')->findOrFail($id);

        $link->update([
            'name' => $data['name'] ?? $link->name,
            'description' => $data['description'] ?? $link->description,
            'url' => $data['url'] ?? $link->url,
        ]);

        if ($imageFile = request()->file('image')) {
            if ($link->image) {
                $oldPath = str_replace(asset('storage') . '/', '', $link->image->url);
                $this->delete($oldPath);

                $path = $this->upload($imageFile, 'links');
                $publicUrl = asset('storage/' . $path);
                $link->image->update(['url' => $publicUrl]);
            } else {
                $path = $this->upload($imageFile, 'links');
                $publicUrl = asset('storage/' . $path);
                $link->image()->create(['url' => $publicUrl]);
            }
        }

        return $link->load('image');
    }

    public function deleteLink($id): bool
    {
        $link = Links::findOrFail($id);

        if ($link->image) {
            $relativePath = str_replace(asset('storage') . '/', '', $link->image->url);
            $this->delete($relativePath);
            $link->image->delete();
        }

        return $link->delete();
    }
}
