<?php

namespace App\Services;

use App\Models\ServicesCategory;
use Illuminate\Http\UploadedFile;
use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;

class ServicesCategoryService
{
    use SaveImage, DeleteImage;

    public function getAllServicesCategory()
    {
        return ServicesCategory::with(['image', 'project.image'])->get();
    }

    public function findByIdServicesCategory($id)
    {
        return ServicesCategory::with(['image', 'project.image'])->findOrFail($id);
    }

    public function storeServicesCategory(array $data)
    {
        $data['benefits'] = is_array($data['benefits']) ? $data['benefits'] : json_decode($data['benefits'], true);

        $serviceCategory = ServicesCategory::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'benefits' => $data['benefits'] ?? [],
            'id_projects' => $data['id_projects'],
        ]);

        if ($image = request()->file('image')) {
            $path = $this->upload($image, 'services_category');
            $serviceCategory->image()->create(['url' => asset('storage/' . $path)]);
        }

        return $serviceCategory->load('image');
    }

    public function updateServicesCategory($id, array $data)
    {
        $serviceCategory = ServicesCategory::with('image')->findOrFail($id);

        if (isset($data['benefits'])) {
            $data['benefits'] = is_array($data['benefits']) ? $data['benefits'] : json_decode($data['benefits'], true);
        }

        $serviceCategory->update([
            'title' => $data['title'] ?? $serviceCategory->title,
            'description' => $data['description'] ?? $serviceCategory->description,
            'benefits' => $data['benefits'] ?? $serviceCategory->benefits,
            'id_projects' => $data['id_projects'] ?? $serviceCategory->id_projects,
        ]);

        if ($image = request()->file('image')) {
            $path = $this->upload($image, 'services_category');
            $url = asset('storage/' . $path);

            if ($serviceCategory->image) {
                $this->delete(str_replace(asset('storage') . '/', '', $serviceCategory->image->url));
                $serviceCategory->image->update(['url' => $url]);
            } else {
                $serviceCategory->image()->create(['url' => $url]);
            }
        }

        return $serviceCategory->load('image');
    }

    public function deleteServicesCategory($id)
    {
        $serviceCategory = ServicesCategory::with('image')->findOrFail($id);

        if ($serviceCategory->image) {
            $this->delete(str_replace(asset('storage') . '/', '', $serviceCategory->image->url));
            $serviceCategory->image->delete();
        }

        return $serviceCategory->delete();
    }
}

