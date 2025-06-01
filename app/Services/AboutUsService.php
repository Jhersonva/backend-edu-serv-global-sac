<?php

namespace App\Services;

use App\Models\AboutUs;
use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;
use Illuminate\Http\UploadedFile;

class AboutUsService
{
    use SaveImage, DeleteImage;

    public function getAllAboutUs()
    {
        return AboutUs::with('image')->get();
    }

    public function findAboutUsById($id)
    {
        return AboutUs::with('image')->findOrFail($id);
    }

    public function storeAboutUs(array $data)
    {
        $data['values'] = is_array($data['values']) ? $data['values'] : json_decode($data['values'], true);

        $aboutUs = AboutUs::create([
            'description' => $data['description'],
            'mission' => $data['mission'],
            'vision' => $data['vision'],
            'history' => $data['history'],
            'values' => $data['values'],
            'video_url' => $data['video_url'],
            'video_description' => $data['video_description'],
        ]);

        if (request()->hasFile('image') && request()->file('image') instanceof UploadedFile) {
            $path = $this->upload(request()->file('image'), 'about-us');
            $aboutUs->image()->create(['url' => asset('storage/' . $path)]);
        }

        return $aboutUs->load('image');
    }

    public function updateAboutUs($id, array $data)
    {
        $aboutUs = AboutUs::with('image')->findOrFail($id);

        if (isset($data['values'])) {
            $data['values'] = is_array($data['values']) ? $data['values'] : json_decode($data['values'], true);
        }

        $aboutUs->update([
            'description' => $data['description'] ?? $aboutUs->description,
            'mission' => $data['mission'] ?? $aboutUs->mission,
            'vision' => $data['vision'] ?? $aboutUs->vision,
            'history' => $data['history'] ?? $aboutUs->history,
            'values' => $data['values'] ?? $aboutUs->values,
            'video_url' => $data['video_url'] ?? $aboutUs->video_url,
            'video_description' => $data['video_description'] ?? $aboutUs->video_description,
        ]);

        if (request()->hasFile('image') && request()->file('image') instanceof UploadedFile) {
            $newPath = $this->upload(request()->file('image'), 'about-us');
            $newUrl = asset('storage/' . $newPath);

            if ($aboutUs->image) {
                $oldRelativePath = str_replace(asset('storage') . '/', '', $aboutUs->image->url);
                $this->delete($oldRelativePath);
                $aboutUs->image->update(['url' => $newUrl]);
            } else {
                $aboutUs->image()->create(['url' => $newUrl]);
            }
        }

        return $aboutUs->load('image');
    }


    public function deleteAboutUs($id)
    {
        $aboutUs = AboutUs::with('image')->findOrFail($id);

        if ($aboutUs->image) {
            $relativePath = str_replace(asset('storage') . '/', '', $aboutUs->image->url);
            $this->delete($relativePath);
            $aboutUs->image->delete();
        }

        return $aboutUs->delete();
    }
}

