<?php

namespace App\Services;

use App\Http\Service\Image\SaveImage;
use App\Http\Service\Image\DeleteImage;
use App\Models\Service;
use Illuminate\Http\UploadedFile;

class ServiceService
{
    use SaveImage, DeleteImage;

    public function getAllServices()
    {
        return Service::with(['image', 'subCategory.image'])->get();
    }

    public function findServiceById($id)
    {
        return Service::with(['image', 'subCategory.image'])->findOrFail($id);
    }

    public function storeService(array $data)
    {
        $data['benefits'] = is_array($data['benefits']) ? $data['benefits'] : json_decode($data['benefits'], true);

        $imageFile = request()->file('image');

        $service = Service::create([
            //'category_id' => $data['category_id'],
            'sub_category_id' => $data['sub_category_id'] ?? null,
            'title' => $data['title'],
            'description' => $data['description'],
            'benefits' => $data['benefits'],
        ]);

        if ($imageFile instanceof UploadedFile) {
            $path = $this->upload($imageFile, 'service');
            $service->image()->create(['url' => asset('storage/' . $path)]);
        }

        return $service->load(['image', 'subCategory']);
    }


    public function updateService($id, array $data)
    {
        $service = Service::with('image')->findOrFail($id);

        if (isset($data['benefits'])) {
            $data['benefits'] = is_array($data['benefits']) ? $data['benefits'] : json_decode($data['benefits'], true);
        }

        $service->update([
            //'category_id' => $data['category_id'] ?? $service->category_id,
            'sub_category_id' => $data['sub_category_id'] ?? $service->sub_category_id,
            'title' => $data['title'] ?? $service->title,
            'description' => $data['description'] ?? $service->description,
            'benefits' => $data['benefits'] ?? $service->benefits,
        ]);

        if ($imageFile = request()->file('image')) {
            $path = $this->upload($imageFile, 'service');
            $url = asset('storage/' . $path);

            if ($service->image) {
                $this->delete(str_replace(asset('storage') . '/', '', $service->image->url));
                $service->image->update(['url' => $url]);
            } else {
                $service->image()->create(['url' => $url]);
            }
        }

        return $service->load(['image', 'subCategory']);
    }


    public function deleteService($id): bool
    {
        $service = Service::with('image')->findOrFail($id);

        if ($service->image) {
            $this->delete(str_replace(asset('storage') . '/', '', $service->image->url));
            $service->image->delete();
        }

        return $service->delete();
    }

    public function filterServices(?string $type = null, ?string $area = null)
    {
        $query = Service::with(['image', 'category', 'subCategory']);

        if ($type) {
            $query->where('title', 'like', '%' . $type . '%');
        }

        if ($area) {
            $query->whereHas('category', function ($q) use ($area) {
                $q->where('name', 'like', '%' . $area . '%');
            });
        }

        return $query->get();
    }
}


