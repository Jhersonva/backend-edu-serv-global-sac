<?php

namespace App\Services;

use App\Models\Home;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Service\Image\DeleteImage;
use App\Http\Service\Image\SaveImage;

class HomeServices
{
    use SaveImage, DeleteImage;

    public function getAllHome(): Collection
    {
        return Home::with('image')->get();
    }

    public function getById($id): Home
    {
        return Home::with('image')->findOrFail($id);
    }

    public function createHome($data): Home
    {
        $home = Home::create($data);

        $imagePath = 'default/logo.jpg';

        if (!empty($data['image'])) {
            $imagePath = $this->upload($data['image'], 'home');
        }

        $home->image()->create(['url' => $imagePath]);

        return $home->load('image');
    }

    public function updateHome($data, $id): Home
    {
        $home = Home::findOrFail($id);
        $home->update($data);

        if (!empty($data['image'])) {
            $existingImage = $home->image()->latest()->first();
            if ($existingImage) {
                $this->delete($existingImage->url);
                $existingImage->delete();
            }

            $newImagePath = $this->upload($data['image'], 'home');
            $home->image()->create(['url' => $newImagePath]);
        }

        return $home->load('image');
    }

    public function deleteHome($id): bool
    {
        $home = Home::findOrFail($id);

        if ($home->image) {
            $this->delete($home->image->url);
            $home->image->delete();
        }

        return $home->delete();
    }
}
